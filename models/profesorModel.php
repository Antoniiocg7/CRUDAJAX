<?php

class ProfesorModel{
    private $PDO;

    public function __construct(){
        require_once("../config/dataBase.php");
        $connection = new DataBase();
        $this->PDO = $connection->conectar_bd();
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
    

    public function insertarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
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
        return ($stmt->execute());
    }

}