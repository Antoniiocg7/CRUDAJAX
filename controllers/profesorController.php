<?php

class ProfesorController{
    private $model;

        public function __construct(){
            require_once "../models/profesorModel.php";
            $this->model = new ProfesorModel();
            
        }

        public function obtenerProfesores($pagina_actual, $registros_pagina, $dni, $id_departamento){
            return ($this->model->obtenerProfesoresFiltrado($pagina_actual, $registros_pagina, $dni, $id_departamento) != false) ? 
            $this->model->obtenerProfesoresFiltrado($pagina_actual, $registros_pagina, $dni, $id_departamento) : false;
        }

        public function mostrar($dni){
            return ($this->model->mostrar($dni) != false) ? $this->model->mostrar($dni) : header("Location: index.php");
        }

        public function pruebaMostrar() {
            $result = $this->model->pruebaMostrar();
            if ($result != false) {
                return $result;
            } else {
                header("Location: ../alumno.html");
                exit;  
            }
        }
        

        public function guardar($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
            $dni = $this->model-> guardarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento);
            return ($dni != false) ? header("Location: show.php?dni=".$dni)  : header("Location: create.php");
        }
}