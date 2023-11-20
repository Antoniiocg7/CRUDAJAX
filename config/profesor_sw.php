<?php

header('Content-Type: application/json');

require_once "../controllers/profesorController.php";

$data = json_decode(file_get_contents("php://input"), true);


if (isset($data['action'])) {
    $profesorController = new ProfesorController();

    switch ($data['action']) {
        case 'fetch_profesores':

            $filtro = $data['filtro']?? null;
        
        
            $response = $profesorController->mostrar($data['pagina'], $data['registrosPorPagina']);
        break;
        
        case 'add_profesor':        
            if (isset($data['dni'], $data['apellido1'], $data['apellido2'], 
                        $data['nombre'], $data['direccion'], $data['localidad'], 
                        $data['provincia'], $data['fechaIngreso'], 
                        $data['idCategoria'], $data['idDepartamento']
                    )
                ){
                
                $response = $profesorController->insertarProfesor(
                    $data['dni'],
                    $data['apellido1'],
                    $data['apellido2'],
                    $data['nombre'],
                    $data['direccion'],
                    $data['localidad'],
                    $data['provincia'],
                    $data['fechaIngreso'],
                    $data['idCategoria'],
                    $data['idDepartamento']
                );
                
            } else {
                $response = ['error' => 'Faltan campos obligatorios en el formulario.'];
            }
        break;

        case 'delete_profesor':
            if (isset($data['dni'])) {
            
                $dni = $data['dni'];
            
                $response = $profesorController->eliminarProfesor($dni);
            } else {
                $response = ['error' => 'Falta el DNI para la eliminación.'];
            }
        break;

        case 'edit_profesor':
            if (isset($data['profesor'])) {
                
                $profesor = $data['profesor'];

                $response = $profesorController->modificarProfesor(
                    $profesor['dni'],
                    $profesor['apellido1'],
                    $profesor['apellido2'],
                    $profesor['nombre'],
                    $profesor['direccion'],
                    $profesor['localidad'],
                    $profesor['provincia'],
                    $profesor['fechaIngreso'],
                    $profesor['idCategoria'],
                    $profesor['idDepartamento']
                );
            } else {
                $response = ['error' => 'Falta el DNI para la edición.'];
            }
            break;
        default:

            $response = ['error' => 'Acción no reconocida'];
            break;
    }

    echo json_encode(['data' => $response]);
}


?>
