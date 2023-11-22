function registro_user() {

    var dni = document.getElementById("id_dni").value;
    var correo = document.getElementById("id_email").value;
    var hash_pass = document.getElementById("id_pass").value;
    var nombre = document.getElementById("id_nombre").value;
    var apellido_1 = document.getElementById("id_apellido_1").value;
    var apellido_2 = document.getElementById("id_apellido_2").value;
    var telefono = document.getElementById("id_telefono").value;
    var direccion = document.getElementById("id_direccion").value;


    var url = "../../config/login_sw.php";
    var data = { 
        action: "register",
        dni: dni,
        correo: correo,
        hash_pass: hash_pass,
        nombre: nombre,
        apellido_1: apellido_1,
        apellido_2: apellido_2,
        telefono: telefono,
        direccion: direccion
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
        
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function login() {

    var user = document.getElementById("login_user").value;
    var password = document.getElementById("login_pass").value;
    
    var url = "../../config/login_sw.php";
    var data = { 
        action: "login",
        user: user,
        password: password
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
        if(data.auth){
            window.location.href="../profesores/index.html"
        }else{
            alert("Usuario incorrecto")
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
