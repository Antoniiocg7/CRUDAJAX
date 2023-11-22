<?php

header('Content-Type: application/json');

require_once "../controllers/userController.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['action'])) {
    
    $userController = new UserController();
  
    switch ($data['action']) {

        case 'register':        
            if (isset($data['dni'], $data['correo'], $data['hash_pass'], 
                        $data['nombre'], $data['apellido_1'], $data['apellido_2'], 
                        $data['telefono'], $data['direccion']
                    )
                ){

                $options = [
                    'cost' => 11
                ];
                
                $hashed_pass = password_hash($data['hash_pass'], PASSWORD_BCRYPT, $options);
                
                $userController->insertarUser(
                    $data['dni'],
                    $data['correo'],
                    $hashed_pass,
                    $data['nombre'],
                    $data['apellido_1'],
                    $data['apellido_2'],
                    $data['telefono'],
                    $data['direccion'],
                );
                $response = [
                    'succes' => 'true',
                    'msg' => 'Usuario creado correctamente'
                ];
                
            } else {
                $response = ['error' => 'Faltan campos obligatorios en el formulario.'];
            }
        break;
        
        case 'login':
            if (isset($data['user'], $data['password'])) {
                // Aquí debes verificar las credenciales
                // Por ejemplo, supongamos que tienes un método en tu controlador que se llama verificarCredenciales
                $check = $userController->verificarUser($data['user'], $data['password']);
                //echo $check;

                // El método verificarCredenciales debería devolver algún tipo de respuesta,
                // por ejemplo, si las credenciales son correctas o no.
                $response = ['auth' => $check];
            } else {
                echo "hola";
                $response = [
                    'auth' => false,
                    'error' => 'Faltan campos de usuario o contraseña.'
                ];
            }
            break;
    
        default:

            $response = ['error' => 'Acción no reconocida'];
            break;
    }
    echo json_encode($response);
}


?>
