fetch("/api")
    .then(response => response.json())
    .then(data => {

        let nav = document.querySelector("nav");

        for (let tabla in data) {
            let boton = document.createElement("button");
            boton.textContent = tabla;
            nav.appendChild(boton);
        }

        nav.addEventListener("click", function (event) {

            if (event.target.tagName === "BUTTON") {

                let nombreTabla = event.target.textContent;
                let registros = data[nombreTabla];

                let thead = document.querySelector("thead tr");
                let tbody = document.querySelector("tbody");

                thead.innerHTML = "";
                tbody.innerHTML = "";

                if (registros.length > 0) {

                    for (let campo in registros[0]) {
                        let th = document.createElement("th");
                        th.textContent = campo;
                        thead.appendChild(th);
                    }

                    registros.forEach(registro => {
                        let tr = document.createElement("tr");

                        for (let valor in registro) {
                            let td = document.createElement("td");
                            td.textContent = registro[valor];
                            tr.appendChild(td);
                        }

                        tbody.appendChild(tr);
                    });
                }
            }
        });
    });

