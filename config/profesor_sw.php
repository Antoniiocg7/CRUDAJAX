<?php
require_once "../controllers/profesorController.php";

$data = json_decode(file_get_contents("php://input"), true);


if (isset($data['action'])) {
    $profesorController = new ProfesorController();

    switch ($data['action']) {
        case 'fetch_profesores':
            $response = $profesorController->mostrar($data['pagina'], $data['registrosPorPagina']);
            break;
        
        case 'add_profesor':
            $dataProfesor = $data['profesor'];
        
            if (isset($dataProfesor['dni'], $dataProfesor['apellido1'], $dataProfesor['apellido2'], 
                        $dataProfesor['nombre'], $dataProfesor['direccion'], $dataProfesor['localidad'], 
                        $dataProfesor['provincia'], $dataProfesor['fechaIngreso'], 
                        $dataProfesor['idCategoria'], $dataProfesor['idDepartamento']
                    )
                ){
                
                
                $response = $profesorController->insertarProfesor(
                    $dataProfesor['dni'],
                    $dataProfesor['apellido1'],
                    $dataProfesor['apellido2'],
                    $dataProfesor['nombre'],
                    $dataProfesor['direccion'],
                    $dataProfesor['localidad'],
                    $dataProfesor['provincia'],
                    $dataProfesor['fechaIngreso'],
                    $dataProfesor['idCategoria'],
                    $dataProfesor['idDepartamento']
                );
                
            } else {
                $response = ['error' => 'Faltan campos obligatorios en el formulario.'];
            }
            break;
        default:
            $response = ['error' => 'Acción no reconocida'];
            break;
    }

    echo json_encode(['data' => $response]);
}


?>
