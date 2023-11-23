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
                      $data['telefono'], $data['direccion']) &&
                !empty($data['dni']) && !empty($data['correo']) && !empty($data['hash_pass']) &&
                !empty($data['nombre']) && !empty($data['apellido_1']) && !empty($data['apellido_2']) &&
                !empty($data['telefono']) && !empty($data['direccion'])) {
        
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

                $resultado = generarToken();
                $tokenId = $resultado[0];
                $hora = $resultado[1];
                $userController->insertarToken($data['correo'],$tokenId,$hora);

                $response = [
                    'success' => true,
                    'msg' => 'Usuario creado correctamente',
                    'token' => $tokenId
                ];
                
            } else {
                $response = [
                    'success' => false,
                    'error' => 'Faltan campos obligatorios en el formulario o algunos están vacíos.'
                ];
            }
        break;
        
        
        case 'login':
            if (isset($data['user'], $data['password'])) {

                $check = $userController->verificarUser($data['user'], $data['password']);
            
                $token = $userController->obtenerToken($data['user']);
                $hora = $userController->obtenerHora($data['user']);
                
                if (esTokenValido($hora)) {
                    
                    $response = [
                        'auth' => $check,
                        'expired' => false,
                        'token' => $token
                    ];
                } else {
                    
                    $response = [
                        'auth' => $check,
                        'expired' => true
                    ];
                }
                
            } else {
                
                $response = [
                    'auth' => false,
                    'error' => 'Faltan campos de usuario o contraseña.'
                ];
            }
            break;
            case 'renovarToken':
                if (isset($data['correo']) && !empty($data['correo'])) {
        
                    $resultado = generarToken();
                    $tokenId = $resultado[0];
                    $hora = $resultado[1];
    
                    $userController->insertarToken($data['correo'], $tokenId, $hora);
    
                    $response = [
                        'success' => true,
                        'newToken' => $tokenId
                    ];
                    
                } else {
                    $response = [
                        'success' => false,
                        'error' => 'No se proporcionó nuevo token'
                    ];
                }
                break;
    
        default:

            $response = ['error' => 'Acción no reconocida'];
            break;
    }
    echo json_encode($response);
}

function generarToken() {
    $tokenId = uniqid('', true);
    $timestamp = time();
    return [$tokenId, $timestamp];
}


function esTokenValido($timestamp) {
    $tiempoActual = time();
    $diferencia = $tiempoActual - $timestamp;
    return $diferencia <= 1800;
}


?>
