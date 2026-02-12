async function fetchJSON(url, opts={}){
  const res = await fetch(url, opts);
  let data = null;
  try{ data = await res.json(); }catch(e){}
  if(!res.ok){
    const msg = (data && data.error) ? data.error : ("HTTP " + res.status);
    throw new Error(msg);
  }
  return data;
}

function escapeHTML(str){
  return (str||"").replace(/[&<>"']/g, m => ({
    "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  }[m]));
}

function adminCard(book){
  const year = book.year ? ` (${book.year})` : "";
  return `<div class="item">
    <h3>${escapeHTML(book.title)}${year}</h3>
    <p><strong>Autor:</strong> ${escapeHTML(book.author)}</p>
    <div class="actions">
      <button class="btn secondary" onclick="editBook(${book.id})">Editar</button>
      <button class="btn danger" onclick="deleteBook(${book.id})">Eliminar</button>
    </div>
  </div>`;
}

async function loadList(){
  const books = await fetchJSON("/api/books");
  document.querySelector("#adminList").innerHTML =
    books.map(adminCard).join("") || "<p class='hint'>Sin datos</p>";
}

window.editBook = async function(id){
  const b = await fetchJSON(`/api/books/${id}`);
  document.querySelector("#id").value = b.id;
  document.querySelector("#title").value = b.title;
  document.querySelector("#author").value = b.author;
  document.querySelector("#year").value = b.year ?? "";
  window.scrollTo({top:0, behavior:"smooth"});
}

window.deleteBook = async function(id){
  if(!confirm("¿Eliminar este registro?")) return;
  await fetchJSON(`/api/admin/books/${id}`, {method:"DELETE"});
  loadList();
}

document.querySelector("#btnCancel").addEventListener("click", ()=>{
  document.querySelector("#form").reset();
  document.querySelector("#id").value = "";
});

document.querySelector("#form").addEventListener("submit", async (e)=>{
  e.preventDefault();
  const id = document.querySelector("#id").value.trim();
  const payload = {
    title: document.querySelector("#title").value.trim(),
    author: document.querySelector("#author").value.trim(),
    year: document.querySelector("#year").value.trim()
  };

  if(id){
    await fetchJSON(`/api/admin/books/${id}`, {
      method:"PUT",
      headers: {"Content-Type":"application/json"},
      body: JSON.stringify(payload)
    });
  }else{
    await fetchJSON("/api/admin/books", {
      method:"POST",
      headers: {"Content-Type":"application/json"},
      body: JSON.stringify(payload)
    });
  }

  document.querySelector("#form").reset();
  document.querySelector("#id").value = "";
  loadList();
});

document.querySelector("#importForm").addEventListener("submit", async (e)=>{
  e.preventDefault();
  const f = document.querySelector("#csvFile").files[0];
  if(!f){ alert("Selecciona un CSV"); return; }
  const fd = new FormData();
  fd.append("file", f);
  await fetchJSON("/api/admin/import", {method:"POST", body: fd});
  document.querySelector("#csvFile").value = "";
  loadList();
  alert("Importación completada");
});

loadList();

