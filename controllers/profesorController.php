<?php

class ProfesorController{
    private $model;

    public function __construct(){
        require_once "../models/profesorModel.php";
        $this->model = new ProfesorModel();
        
    }
    
    public function mostrar($pagina, $registrosPorPagina) {
        $totalRegistros = $this->model->contarProfesores();
        $result = $this->model->mostrar($pagina, $registrosPorPagina);
    
        if ($result != false) {
            return [
                'data' => $result,
                'total' => $totalRegistros
            ];
        } else {
            header("Location: ../view/profesores/index.html");
            exit;  
        }
    }


    public function insertarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
        return $this->model-> insertarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento);
    }

    public function eliminarProfesor($dni) {
       
        return $this->model->eliminarProfesor($dni);
    }

    public function modificarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
        return $this->model-> modificarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento);
    }
        
}