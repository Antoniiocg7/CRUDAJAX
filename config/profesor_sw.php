<?php
require_once "../controllers/profesorController.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['action']) && $data['action'] == 'fetch_profesores') {
    $profesorController = new ProfesorController();
    $data = $profesorController->mostrar($data['pagina'],$data['registrosPorPagina']);
    $json["data"] = $data;
    echo json_encode($json);
}
//TODO: PASAR LA PAGINA Y TAL POR JSON
?>
