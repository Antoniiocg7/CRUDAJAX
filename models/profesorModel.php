<?php

class ProfesorModel{
    private $PDO;

    public function __construct(){
        require_once("../config/dataBase.php");
        $connection = new DataBase();
        $this->PDO = $connection->conectar_bd();
    }

    public function mostrar($pagina, $registrosPorPagina, $filtro){
        try {

            $condiciones = "dni LIKE '%".$filtro."%' OR "
            ." apellido_1 LIKE '%".$filtro."%' OR "
            ." apellido_2 LIKE '%".$filtro."%' OR "
            ." nombre LIKE '%".$filtro."%' OR "
            ." direccion LIKE '%".$filtro."%' OR "
            ." localidad LIKE '%".$filtro."%' OR "
            ." provincia LIKE '%".$filtro."%' OR"
            ." fecha_ingreso LIKE '%".$filtro."%' OR"
            ." id_categoria LIKE '%".$filtro."%' OR"
            ." id_departamento LIKE '%".$filtro."%'";
;


            $inicio = ($pagina - 1) * $registrosPorPagina;
            $stmt = $this->PDO->prepare("SELECT * FROM profesor WHERE $condiciones LIMIT :inicio, :registros");
            $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
            $stmt->bindParam(':registros', $registrosPorPagina, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {

                return false;
            }
        } catch (PDOException $e) {
    
            echo "Error: " . $e->getMessage();

        }
        
    }
    
    public function contarProfesores() {
        $stmt = $this->PDO->prepare("SELECT COUNT(*) FROM profesor");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    

    public function insertarProfesor($dni,$apellido_1,$apellido_2,$nombre,$direccion,$localidad,$provincia,$fecha_ingreso,$id_categoria,$id_departamento){
        try {
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
        
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }

    public function eliminarProfesor($dni) {
        try {
            $stmt = $this->PDO->prepare("DELETE FROM profesor WHERE DNI = :dni");
            $stmt->bindParam(":dni", $dni);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
      
    }    

    public function modificarProfesor($dni, $apellido1, $apellido2, $nombre, $direccion, $localidad, $provincia, $fechaIngreso, $idCategoria, $idDepartamento) {
        
        $stmt = $this->PDO->prepare("UPDATE profesor SET 
        
            apellido_1 = :apellido1, 
            apellido_2 = :apellido2, 
            nombre = :nombre, 
            direccion = :direccion, 
            localidad = :localidad, 
            provincia = :provincia, 
            fecha_ingreso = :fechaIngreso, 
            id_categoria = :idCategoria, 
            id_departamento = :idDepartamento 
            WHERE dni = :dni"
            
        );
    
        $stmt->bindParam(":dni", $dni);
        $stmt->bindParam(":apellido1", $apellido1);
        $stmt->bindParam(":apellido2", $apellido2);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":localidad", $localidad);
        $stmt->bindParam(":provincia", $provincia);
        $stmt->bindParam(":fechaIngreso", $fechaIngreso);
        $stmt->bindParam(":idCategoria", $idCategoria);
        $stmt->bindParam(":idDepartamento", $idDepartamento);
    
        return $stmt->execute();
    }

}