#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import torch
from transformers import AutoTokenizer, AutoModelForCausalLM

MODEL_PATH = "Qwen/Qwen2.5-0.5B-Instruct"

FALLBACK_EXACT = "No lo sé basándome en mi entrenamiento."

_TOKENIZER = None
_MODEL = None


def build_prompt_qa(user_question: str) -> str:
    instruction = (
        "Responde de forma clara y breve.\n"
        "Si no sabes la respuesta, di exactamente:\n"
        f"{FALLBACK_EXACT}\n\n"
    )
    return f"{instruction}Pregunta: {user_question}\nRespuesta:"


def clean_answer(text: str) -> str:
    if not text:
        return FALLBACK_EXACT

    t = text.strip()

    if FALLBACK_EXACT in t:
        return FALLBACK_EXACT

    for line in t.splitlines():
        line = line.strip()
        if line:
            return line

    return FALLBACK_EXACT


def load_model():
    global _TOKENIZER, _MODEL
    if _TOKENIZER is not None and _MODEL is not None:
        return _TOKENIZER, _MODEL

    _TOKENIZER = AutoTokenizer.from_pretrained(MODEL_PATH)

    use_cuda = torch.cuda.is_available()
    _MODEL = AutoModelForCausalLM.from_pretrained(
        MODEL_PATH,
        device_map="auto" if use_cuda else None,
        torch_dtype=torch.float16 if use_cuda else torch.float32
    )

    if not use_cuda:
        _MODEL.to("cpu")

    _MODEL.eval()
    return _TOKENIZER, _MODEL


def infer(question: str, max_new_tokens: int = 80) -> str:
    tokenizer, model = load_model()

    prompt_text = build_prompt_qa(question)
    inputs = tokenizer(prompt_text, return_tensors="pt")
    inputs = {k: v.to(model.device) for k, v in inputs.items()}
    input_len = inputs["input_ids"].shape[-1]

    with torch.no_grad():
        output_ids = model.generate(
            **inputs,
            max_new_tokens=max_new_tokens,
            do_sample=False,
            num_beams=1,
            repetition_penalty=1.05,
            eos_token_id=tokenizer.eos_token_id,
            pad_token_id=tokenizer.eos_token_id,
        )

    gen_ids = output_ids[0, input_len:]
    raw = tokenizer.decode(gen_ids, skip_special_tokens=True)
    return clean_answer(raw)


def main():
    if len(sys.argv) < 2:
        print("No prompt provided")
        sys.exit(1)

    question = " ".join(sys.argv[1:])
    print(infer(question))


if __name__ == "__main__":
    main()

