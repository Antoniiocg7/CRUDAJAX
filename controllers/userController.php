<?php
class UserController{

    private $model;

    public function __construct(){
        require_once "../models/userModel.php";
        $this->model = new UserModel();
    
    }

    public function verificarUser($correo, $password){
        return $this->model->verificarUser($correo, $password);
    }

    public function insertarUser($dni,$correo,$hash_pass,$nombre,$apellido_1,$apellido_2,$telefono,$direccion){
        return $this->model->insertarUser($dni,$correo,$hash_pass,$nombre,$apellido_1,$apellido_2,$telefono,$direccion);
    }

    
}

?>