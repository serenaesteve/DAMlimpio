async function fetchJSON(url){
  const res = await fetch(url);
  if(!res.ok) throw new Error("HTTP " + res.status);
  return await res.json();
}

function escapeHTML(str){
  return (str||"").replace(/[&<>"']/g, m => ({
    "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  }[m]));
}

function card(book){
  const year = book.year ? ` (${book.year})` : "";
  return `<div class="item">
    <h3>${escapeHTML(book.title)}${year}</h3>
    <p><strong>Autor:</strong> ${escapeHTML(book.author)}</p>
    <p class="hint">ID: ${book.id}</p>
  </div>`;
}

async function load(){
  const q = document.querySelector("#q").value.trim();
  const url = q ? `/api/books?q=${encodeURIComponent(q)}` : "/api/books";
  const books = await fetchJSON(url);
  document.querySelector("#list").innerHTML =
    books.map(card).join("") || "<p class='hint'>Sin datos</p>";
}

document.querySelector("#btnBuscar").addEventListener("click", load);
document.querySelector("#btnReset").addEventListener("click", ()=>{
  document.querySelector("#q").value = "";
  load();
});

load();

