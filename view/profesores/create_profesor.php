<?php
    require_once "../header_footer/header.php";
?>


<form action="store.php" method="POST" >
    <div class="mb-3 ms-3 me-5">

        <div class="row ms-0 me-0">
            <label for="id_dni" class="form-label">DNI</label>
            <input type="text" name="dni" class="form-control mb-2" id="id_dni" required>
        </div>

        <div class="row g-5">
            <div class="col">
                <label for="id_email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control mb-2" id="id_email" required>
            </div>

            <div class="col">
                <label for="id_pass" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control mb-2" id="id_pass" required>
            </div>
        </div>

        
        <div class="row g-5">

            <div class="col">
                <label for="id_nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control mb-2" id="id_nombre" required>
            </div>
            
            <div class="col">
                <label for="id_apellido_1" class="form-label">Primer Apellido</label>
                <input type="text" name="apellido_1" class="form-control mb-2" id="id_apellido_1" required>
            </div>
            
            <div class="col ml-5">
                <label for="id_apellido_2" class="form-label">Segundo Apellido</label>
                <input type="text" name="apellido_2" class="form-control mb-2" id="id_apellido_2" required>
            </div>
        </div>

        <label for="id_telefono" class="form-label">Telefono</label>
        <input type="text" name="telefono" class="form-control mb-2" id="id_telefono" required>

        <label for="id_direccion" class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control mb-2" id="id_direccion" required>
    </div>
    <div class="ms-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a class="btn btn-danger" href="index.php">Cancelar</a>
    </div>
</form>

<?php
  require_once "../header_footer/footer.php";
?>