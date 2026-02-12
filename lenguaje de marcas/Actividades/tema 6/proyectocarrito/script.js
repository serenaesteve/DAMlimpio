let products = [];
let cart = [];

window.onload = () => {
    fetch('get_products.php')
    .then(res => res.json())
    .then(data => {
        products = data;
        showProducts(products);
    });
};

function showProducts(items) {
    const container = document.getElementById('products');
    container.innerHTML = '';
    items.forEach(p => {
        container.innerHTML += `
            <div class="product">
                <img src="images/${p.imagen}" width="180" height="120">
                <h3>${p.nombre}</h3>
                <p>${p.descripcion}</p>
                <p>$${p.precio}</p>
                <button onclick='addToCart(${JSON.stringify(p)})'>Agregar</button>
            </div>`;
    });
}

function filterCategory(cat) {
    if(cat === '') showProducts(products);
    else showProducts(products.filter(p => p.categoria === cat));
}

function addToCart(product) {
    let item = cart.find(i => i.id === product.id);
    if(item) item.cantidad++;
    else cart.push({...product, cantidad: 1});
    updateCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

function updateCart() {
    const cartItems = document.getElementById('cartItems');
    cartItems.innerHTML = '';
    let total = 0;
    cart.forEach((item, index) => {
        total += item.precio * item.cantidad;
        cartItems.innerHTML += `<li>${item.nombre} x${item.cantidad} - $${item.precio*item.cantidad} 
            <button onclick="removeFromCart(${index})">Eliminar</button></li>`;
    });
    document.getElementById('total').innerText = total;
}


document.getElementById('userForm').addEventListener('submit', e => {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const direccion = document.getElementById('direccion').value;
    const correo = document.getElementById('correo').value;

    fetch('add_order.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({nombre, direccion, correo, cart})
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Pedido realizado! ID: '+data.pedido_id);
            cart = [];
            updateCart();
        }
    });
});

