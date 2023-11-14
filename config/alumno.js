function getProfesor(){

    var select = document.getElementById("departamentos");
    var selected = select.value;
    var url = "../view/alumno_sw.php";
    var data = {table: "profesor", selected: selected};
    console.log(selected);
    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json"
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function(response){
        var p = document.getElementById("msg")
        var select = document.getElementById("profesores")
        p.innerHTML = response.msg
        select.innerHTML = "";
        var opt2 = document.createElement('option');
        opt2.innerHTML = "--seleccionar";
        select.appendChild(opt2);
        for (var i = 0; i < response.data.length; i++){
            var opt = document.createElement('option');
            opt.value = response.data[i].DNI;
            opt.innerHTML = response.data[i].NOMBRE+" "+response.data[i].APELLIDO_1+" "+response.data[i].APELLIDO_2;
            select.appendChild(opt);
        }
    })
}

function profesoresFiltrados() {
    var url = "../../config/profesor_sw.php";  
    var data = { action: "fetch_profesores" };

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

        for (let i = 0; i < cabeceras.length; i++) {
            var th = document.createElement("th");
            th.appendChild(document.createTextNode(cabeceras[i]));
            tr.appendChild(th);
        }
        
        theadprofesor.appendChild(tr);

        for (let i = 0; i < response.data.length; i++) {
            var tr = document.createElement("tr");
            Object.values(response.data[i]).forEach(val => {
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
    })
    .catch((error) => console.error("Error:", error));
}




//CARGA DE DEPARTAMENTOS

function getDepartamentos(){
    var url = "../view/alumno_sw.php";
    var data = {table: "departamentos"};
    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json"
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function(response){
        var p = document.getElementById("msg")
        var select = document.getElementById("departamentos")
        p.innerHTML = response.msg
        for (var i = 0; i < response.data.length; i++){
            var opt = document.createElement('option');
            opt.value = response.data[i].CODIGO;
            opt.innerHTML = response.data[i].NOMBRE;
            select.appendChild(opt);
        }
    })
}