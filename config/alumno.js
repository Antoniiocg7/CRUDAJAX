function profesoresFiltrados(paginaSeleccionada = 1) {
    var url = "../../config/profesor_sw.php";
    var pagina = paginaSeleccionada;
    var registrosPorPaginaInput = document.getElementById('registros');
    var registrosPorPagina = parseInt(registrosPorPaginaInput.value);
    var filtro = document.getElementById("buscador")

    var data = { 
        action: "fetch_profesores",
        filtro: filtro.value,
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
        
        var totalRegistros = response.data.total;
        registrosPorPaginaInput.setAttribute('min', '1');
        registrosPorPaginaInput.setAttribute('max', totalRegistros.toString());

        if (registrosPorPagina < 1 || registrosPorPagina > totalRegistros) {
            alert("El número de registros por página debe estar entre 1 y " + totalRegistros);
            return;
        }

        var theadprofesor = document.getElementById("theadprofesor");
        var tbodyprofesor = document.getElementById("tbodyprofesor");
        const cabeceras = ["DNI", "APELLIDO_1", "APELLIDO_2", "NOMBRE", "DIRECCION", "LOCALIDAD", "PROVINCIA", "FECHA_INGRESO", "ID_CATEGORIA", "ID_DEPARTAMENTO", "ACCIONES"];
        var tr = document.createElement("tr");
        
        theadprofesor.innerHTML = "";
        for (let i = 0; i < cabeceras.length; i++) {
            var th = document.createElement("th");
            th.appendChild(document.createTextNode(cabeceras[i]));
            tr.appendChild(th);
        }


        console.log(response.data.data.length)

        theadprofesor.appendChild(tr);

        var tabla = document.getElementById("profesor");

        tbodyprofesor.innerHTML = "";

        let registro = []
        for (let i = 0; i < response.data.data.length; i++) {
            var tr = document.createElement("tr");

            for (let j = 0; j < cabeceras.length-1; j++) {
                registro[i] = response.data.data[i]
                var val = response.data.data[i][cabeceras[j]]
                var td = document.createElement("td");
                td.appendChild(document.createTextNode(val));
                tr.appendChild(td);
            }
            

            var td = document.createElement("td");
            var buttonEditar = document.createElement("input");
            buttonEditar.type = "button";
            buttonEditar.value = "Editar";
            buttonEditar.className = "btn btn-primary me-2";
            buttonEditar.onclick = function() {
                console.log(registro[i])
                mostrarModalEdicion(registro[i]);
            };
        
            var buttonEliminar = document.createElement("input");
            buttonEliminar.type = "button";
            buttonEliminar.value = "Eliminar";
            buttonEliminar.className = "btn btn-danger";
            buttonEliminar.addEventListener('click', function(){
                var dniEliminar = tabla.rows[i+1].cells[0].textContent;
                
                mostrarModalEliminacion(dniEliminar);
            })

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
    const paginacion = document.querySelector(".pagination");
    paginacion.innerHTML = '';

    if (totalPaginas <= 1) return;

    agregarBoton(paginacion, 'Primera', 1, paginaActual > 1);
    agregarBoton(paginacion, 'Anterior', paginaActual - 1, paginaActual > 1);
    agregarBoton(paginacion, 'Siguiente', paginaActual + 1, paginaActual < totalPaginas);
    agregarBoton(paginacion, 'Última', totalPaginas, paginaActual < totalPaginas);
}

function agregarBoton(paginacion, texto, pagina, habilitado) {
    var li = document.createElement('li');
    li.className = `page-item ${habilitado ? '' : 'disabled'}`;
    
    var a = document.createElement('a');
    a.className = 'page-link bg-dark text-light';
    a.textContent = texto;
    a.style.cursor = 'pointer';

    if (habilitado) {
        a.addEventListener('click', function(event) {
            event.preventDefault();
            profesoresFiltrados(pagina);
        });
    } else {
        a.style.pointerEvents = 'none'; 
        a.style.cursor = 'default'; 
    }

    li.appendChild(a);
    paginacion.appendChild(li);
}

function agregarProfesor() {
    
    var dni = document.getElementById('dni').value
    var apellido1 = document.getElementById('apellido1').value;
    var apellido2 = document.getElementById('apellido2').value;
    var nombre = document.getElementById('nombre').value;
    var direccion = document.getElementById('direccion').value;
    var localidad = document.getElementById('localidad').value;
    var provincia = document.getElementById('provincia').value;
    var fechaIngreso = document.getElementById('fechaIngreso').value;
    var idCategoria = document.getElementById('idCategoria').value;
    var idDepartamento = document.getElementById('idDepartamento').value;


    var url = "../../config/profesor_sw.php";
    var data = { 
        action: "add_profesor",
        dni: dni,
        apellido1: apellido1,
        apellido2: apellido2,
        nombre: nombre,
        direccion: direccion,
        localidad: localidad,
        provincia: provincia,
        fechaIngreso: fechaIngreso,
        idCategoria: idCategoria,
        idDepartamento: idDepartamento
    };
    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data.response);
        cerrarModalInsert();
        actualizarPaginacion();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

}

function eliminarProfesor(dni) {

    var url = "../../config/profesor_sw.php";
    let data = { action: "delete_profesor", dni: dni };

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        cerrarModalEliminar();
        profesoresFiltrados();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function editarProfesor() {

    
    var profesorEditado = {
        dni: dni,
        apellido1: apellido1,
        apellido2: apellido2,
        nombre: nombre,
        direccion: direccion,
        localidad: localidad,
        provincia: provincia,
        fechaIngreso: fechaIngreso,
        idCategoria: idCategoria,
        idDepartamento: idDepartamento
    };

    var url = "../../config/profesor_sw.php";
    var data = { 
        action: "edit_profesor",
        profesor: profesorEditado
    };
    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        
        cerrarModalEdicion();
        profesoresFiltrados();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


function modalAgregarProfesores() {
    const modal = document.getElementById("modalAgregarProfesor")
    modal.classList.add("show")
    modal.style.display = "block"

}

function cerrarModalInsert(){
    const modal = document.getElementById("modalAgregarProfesor")
    modal.classList.remove("show")
    modal.style.display = "none"
}

function mostrarModalEliminacion(dni) {
    var botonConfirmar = document.getElementById("botonConfirmarEliminacion");
    botonConfirmar.addEventListener('click', function() {
        eliminarProfesor(dni);
    }) 

    var modal = document.getElementById("modalConfirmarEliminacion");
    modal.classList.add("show");
    modal.style.display = "block";
}

function cerrarModalEliminar(){
    const modal = document.getElementById("modalConfirmarEliminacion")
    modal.classList.remove("show")
    modal.style.display = "none"
}

function mostrarModalEdicion( registro ) {
    var dni = document.getElementById('edit_dni');
    var apellido1 = document.getElementById('edit_apellido1');
    var apellido2 = document.getElementById('edit_apellido2');
    var nombre = document.getElementById('edit_nombre');
    var direccion = document.getElementById('edit_direccion');
    var localidad = document.getElementById('edit_localidad');
    var provincia = document.getElementById('edit_provincia');
    var fechaIngreso = document.getElementById('edit_fechaIngreso');
    var idCategoria = document.getElementById('edit_idCategoria');
    var idDepartamento = document.getElementById('edit_idDepartamento');

    dni.value = registro.DNI;
    apellido1.value = registro.APELLIDO_1
    apellido2.value = registro.APELLIDO_2
    nombre.value = registro.NOMBRE
    direccion.value = registro.DIRECCION
    localidad.value = registro.LOCALIDAD
    provincia.value = registro.PROVINCIA
    fechaIngreso.value = registro.FECHA_INGRESO
    idCategoria.value = registro.ID_CATEGORIA
    idDepartamento.value = registro.ID_DEPARTAMENTO



    var modal = document.getElementById("modalModificarProfesor");
    modal.classList.add("show");
    modal.style.display = "block";
}

function cerrarModalEdicion(){
    const modal = document.getElementById("modalModificarProfesor")
    modal.classList.remove("show")
    modal.style.display = "none"
}

function agregarProfesor() {
    
    var dni = document.getElementById('dni').value
    var apellido1 = document.getElementById('apellido1').value;
    var apellido2 = document.getElementById('apellido2').value;
    var nombre = document.getElementById('nombre').value;
    var direccion = document.getElementById('direccion').value;
    var localidad = document.getElementById('localidad').value;
    var provincia = document.getElementById('provincia').value;
    var fechaIngreso = document.getElementById('fechaIngreso').value;
    var idCategoria = document.getElementById('idCategoria').value;
    var idDepartamento = document.getElementById('idDepartamento').value;


    var url = "../../config/profesor_sw.php";
    var data = { 
        action: "add_profesor",
        dni: dni,
        apellido1: apellido1,
        apellido2: apellido2,
        nombre: nombre,
        direccion: direccion,
        localidad: localidad,
        provincia: provincia,
        fechaIngreso: fechaIngreso,
        idCategoria: idCategoria,
        idDepartamento: idDepartamento
    };
    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data.response);
        cerrarModalInsert();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

}

function eliminarProfesor(dni) {

    var url = "../../config/profesor_sw.php";
    let data = { action: "delete_profesor", dni: dni };

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        cerrarModalEliminar();
        profesoresFiltrados();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


