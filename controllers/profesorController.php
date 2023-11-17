<?php

class ProfesorController{
    private $model;

        public function __construct(){
            require_once "../models/profesorModel.php";
            $this->model = new ProfesorModel();
            
        }
        
        //TODO: CAMBIAR ESTO PARA QUE NO SEA FIJO
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
        

        public function guardar($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
            $dni = $this->model-> guardarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento);
            return ($dni != false) ? header("Location: show.php?dni=".$dni)  : header("Location: create.php");
        }
}