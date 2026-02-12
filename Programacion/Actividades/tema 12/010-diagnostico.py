#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import torch
from transformers import AutoTokenizer, AutoModelForCausalLM

MODEL_PATH = "Qwen/Qwen2.5-0.5B-Instruct"

QUESTION = "¿Qué es MongoDB?"
ANSWER_OK = "MongoDB es una base de datos no relacional orientada a documentos."
ANSWER_BAD = "MongoDB es un sistema operativo."

def load():
    tokenizer = AutoTokenizer.from_pretrained(MODEL_PATH)

    use_cuda = torch.cuda.is_available()
    model = AutoModelForCausalLM.from_pretrained(
        MODEL_PATH,
        device_map="auto" if use_cuda else None,
        torch_dtype=torch.float16 if use_cuda else torch.float32
    )

    if not use_cuda:
        model.to("cpu")

    model.eval()
    return tokenizer, model


@torch.no_grad()
def generate(model, tokenizer, prompt, max_new_tokens=80):
    inputs = tokenizer(prompt, return_tensors="pt")
    inputs = {k: v.to(model.device) for k, v in inputs.items()}
    input_len = inputs["input_ids"].shape[-1]

    out = model.generate(
        **inputs,
        do_sample=False,
        num_beams=1,
        max_new_tokens=max_new_tokens,
        repetition_penalty=1.05,
        eos_token_id=tokenizer.eos_token_id,
        pad_token_id=tokenizer.eos_token_id,
    )

    gen_ids = out[0, input_len:]
    return tokenizer.decode(gen_ids, skip_special_tokens=True).strip()


@torch.no_grad()
def neg_loglik_of_continuation(model, tokenizer, prompt, continuation):
    full = prompt + continuation

    full_ids = tokenizer(full, return_tensors="pt")["input_ids"].to(model.device)
    prompt_ids = tokenizer(prompt, return_tensors="pt")["input_ids"].to(model.device)

    labels = full_ids.clone()
    labels[:, :prompt_ids.shape[1]] = -100

    outputs = model(full_ids, labels=labels)
    loss = outputs.loss

    cont_len = full_ids.shape[1] - prompt_ids.shape[1]
    total_nll = float(loss) * cont_len

    return total_nll, cont_len, float(loss)


def main():
    tokenizer, model = load()

    print("\n=== GENERATION TEST ===")
    prompt = f"Pregunta: {QUESTION}\nRespuesta:"
    gen = generate(model, tokenizer, prompt)
    print("Generated answer:\n", gen, "\n")

    print("=== NLL SCORING ===")
    score_prompt = f"Pregunta: {QUESTION}\nRespuesta: "

    nll_ok, len_ok, mean_ok = neg_loglik_of_continuation(
        model, tokenizer, score_prompt, ANSWER_OK
    )

    nll_bad, len_bad, mean_bad = neg_loglik_of_continuation(
        model, tokenizer, score_prompt, ANSWER_BAD
    )

    print(f"OK  tokens={len_ok} mean_loss={mean_ok:.4f} total_nll={nll_ok:.2f}")
    print(f"BAD tokens={len_bad} mean_loss={mean_bad:.4f} total_nll={nll_bad:.2f}")

    if nll_ok < nll_bad:
        print("\nRESULT: El modelo prefiere la respuesta correcta.")
    else:
        print("\nRESULT: El modelo prefiere la respuesta incorrecta.")


if __name__ == "__main__":
    main()

