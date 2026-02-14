document.addEventListener("DOMContentLoaded", () => {

  if (window.hljs) hljs.highlightAll();


  const btn = document.getElementById("navToggle");
  const menu = document.getElementById("navMenu");
  if (btn && menu) {
    btn.addEventListener("click", () => {
      menu.classList.toggle("active");
    });
  }


  document.querySelectorAll(".code-copy").forEach((b) => {
    b.addEventListener("click", async () => {
      const id = b.dataset.copy;
      const el = document.getElementById(id);
      if (!el) return;

      const text = el.textContent;
      try {
        await navigator.clipboard.writeText(text);
        const old = b.innerHTML;
        b.innerHTML = "✅ Copiado";
        setTimeout(() => (b.innerHTML = old), 1200);
      } catch {
        alert("No se pudo copiar.");
      }
    });
  });


  const idioma = document.getElementById("idioma");
  if (idioma) {
    idioma.addEventListener("change", function () {
      const url = new URL(window.location.href);
      url.searchParams.set("lang", this.value);
      window.location.href = url.toString();
    });
  }
});

