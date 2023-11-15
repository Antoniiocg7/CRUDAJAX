<?php

class ProfesorModel{
    private $PDO;

    public function __construct(){
        require_once("../config/dataBase.php");
        $connection = new DataBase();
        $this->PDO = $connection->conectar_bd();
    }


    public function obtenerProfesoresFiltrado($pagina_actual, $registros_pagina, $dni, $id_departamento) {

        $pagina_inicio = ($pagina_actual - 1) * $registros_pagina;

        $condiciones = "";
        $parametros = array();
        
        if (!empty($dni)) {
            $condiciones .= "dni LIKE :dni";
            $dni = "%$dni%";
            $parametros[':dni'] = $dni;
        }
        
        if (!empty($id_departamento)) {
            if (!empty($condiciones)) {
                $condiciones .= " AND ";
            }
            $condiciones .= "id_departamento LIKE :id_departamento";
            $id_departamento = "%$id_departamento%";
            $parametros[':id_departamento'] = $id_departamento;
        }

        $stmt = $this->PDO->prepare("SELECT COUNT(*) FROM profesor".(!empty($condiciones) ? " WHERE $condiciones" : ""));
        $stmt->execute($parametros);
        $total_registros = $stmt->fetchColumn();


        $stmt = $this->PDO->prepare("SELECT * FROM profesor".(!empty($condiciones) ? " WHERE $condiciones" : "")." LIMIT :pagina_inicio, :registros_pagina");
        $stmt->bindParam(":pagina_inicio", $pagina_inicio, PDO::PARAM_INT);
        $stmt->bindParam(":registros_pagina", $registros_pagina, PDO::PARAM_INT);
        foreach ($parametros as $parametro => $valor) {
            $stmt->bindValue($parametro, $valor);
        }

        $stmt->execute();
        $pagina = $stmt->fetchAll();

        $total_paginas = ceil($total_registros/$registros_pagina);

        $paginador = array(
            "pagina_actual" => $pagina_actual,
            "registros_pagina" => $registros_pagina,
            "pagina" => $pagina,
            "total_registros" => $total_registros,
            "total_paginas" => $total_paginas
        );

        echo json_encode($paginador);
        
        return $paginador;
    }

    public function mostrar($pagina, $registrosPorPagina){
        $inicio = ($pagina - 1) * $registrosPorPagina;
        $stmt = $this->PDO->prepare("SELECT * FROM profesor LIMIT :inicio, :registros");
        $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindParam(':registros', $registrosPorPagina, PDO::PARAM_INT);
        return ($stmt->execute()) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }
    
    public function contarProfesores() {
        $stmt = $this->PDO->prepare("SELECT COUNT(*) FROM profesor");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    

    public function guardarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
        $stmt = $this->PDO->prepare(
            "INSERT INTO profesor (dni,apellido_1,apellido_2,nombre,direccion,localidad,provincia,fecha_ingreso,id_categoria,id_departamento) 
            VALUES (:dni, :apellido_1, :apellido_2, :nombre, :direccion, :localidad, :provincia, :fecha_ingreso, :id_categoria, :id_departamento)"
        );
        $stmt->bindParam(":dni", $dni);
        $stmt->bindParam(":apellido_1", $apellido_1);
        $stmt->bindParam(":apellido_2", $apellido_2);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":localidad", $localidad);
        $stmt->bindParam(":provincia", $provincia);
        $stmt->bindParam(":fecha_ingreso", $fecha_ingreso);
        $stmt->bindParam(":id_categoria", $id_categoria);
        $stmt->bindParam(":id_departamento", $id_departamento);
        return ($stmt->execute()) ? $dni : false;
    }

}