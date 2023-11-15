function profesoresFiltrados() {
    var url = "../../config/profesor_sw.php";
    var pagina;
    var registrosPorPagina;
    var data = { 
        action: "fetch_profesores",
        pagina: pagina,
        registrosPorPagina: registrosPorPagina
    };
    
    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json"
        },
    })
    .then((res) => res.json())
    .then(function(response){
        var theadprofesor = document.getElementById("theadprofesor");
        var tbodyprofesor = document.getElementById("tbodyprofesor");
        const cabeceras = ["DNI", "APELLIDO_1", "APELLIDO_2", "NOMBRE", "DIRECCION", "LOCALIDAD", "PROVINCIA", "FECHA_NACIMIENTO", "ID_CATEGORIA", "ID_DEPARTAMENTO", "ACCIONES"];
        var tr = document.createElement("tr");

        theadprofesor.innerHTML = "";
        for (let i = 0; i < cabeceras.length; i++) {
            var th = document.createElement("th");
            th.appendChild(document.createTextNode(cabeceras[i]));
            tr.appendChild(th);
        }
        
        theadprofesor.appendChild(tr);

        tbodyprofesor.innerHTML = "";
        for (let i = 0; i < response.data.data.length; i++) {
            var tr = document.createElement("tr");
            Object.values(response.data.data[i]).forEach(val => {
                var td = document.createElement("td");
                td.appendChild(document.createTextNode(val));
                tr.appendChild(td);
            });

            var td = document.createElement("td");
            var buttonEditar = document.createElement("input");
            buttonEditar.type = "button";
            buttonEditar.value = "Editar";
            buttonEditar.className = "btn btn-primary me-2";

            var buttonEliminar = document.createElement("input");
            buttonEliminar.type = "button";
            buttonEliminar.value = "Eliminar";
            buttonEliminar.className = "btn btn-danger";

            td.appendChild(buttonEditar);
            td.appendChild(buttonEliminar);
            tr.appendChild(td);

            tbodyprofesor.appendChild(tr);
        }

        var totalPaginas = Math.ceil(response.data.total / registrosPorPagina);
        actualizarPaginacion(totalPaginas, pagina);

    })
    .catch((error) => console.error("Error:", error));
}

function actualizarPaginacion(totalPaginas, paginaActual) {
    var paginacion = document.querySelector(".pagination");
    paginacion.innerHTML = '';

    // Agregar 'Primera' y 'Anterior' si no estamos en la primera página
    if (paginaActual > 1) {
        paginacion.innerHTML += `<li class="page-item"><a class="page-link bg-dark text-light" href="#" onclick="profesoresFiltrados(1)">Primera</a></li>`;
        paginacion.innerHTML += `<li class="page-item"><a class="page-link bg-dark text-light" href="#" onclick="profesoresFiltrados(${paginaActual - 1})">Anterior</a></li>`;
    }

    // Generar números de página
    for (let i = 1; i <= totalPaginas; i++) {
        paginacion.innerHTML += `<li class="page-item ${i === paginaActual ? 'active' : ''}"><a class="page-link bg-dark text-light" href="#" onclick="profesoresFiltrados(${i})">${i}</a></li>`;
    }

    // Agregar 'Siguiente' y 'Última' si no estamos en la última página
    if (paginaActual < totalPaginas) {
        paginacion.innerHTML += `<li class="page-item"><a class="page-link bg-dark text-light" href="#" onclick="profesoresFiltrados(${paginaActual + 1})">Siguiente</a></li>`;
        paginacion.innerHTML += `<li class="page-item"><a class="page-link bg-dark text-light" href="#" onclick="profesoresFiltrados(${totalPaginas})">Última</a></li>`;
    }
}
