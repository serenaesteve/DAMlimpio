let boton = document.querySelector("footer button");

boton.onclick = function () {

    let usuario = document.querySelector("#usuario").value;
    let contrasena = document.querySelector("#contrasena").value;

    if (usuario === "jocarsa" && contrasena === "jocarsa") {

        document.querySelector("footer").style.display = "none";
        document.querySelector("header").style.display = "block";
        document.querySelector("main").style.display = "flex";

    } else {
        document.querySelector("#advertencia").textContent =
            "Usuario y o contrasena incorrectos";
    }
};

