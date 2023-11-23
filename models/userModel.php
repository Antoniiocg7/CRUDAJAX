<?php
class UserModel{

    private $PDO;

    public function __construct(){
        require_once("../config/dataBase.php");
        $connection = new DataBase();
        $this->PDO = $connection->conectar_bd();
    }

    public function verificarUser($correo, $password){
        try {
            $stmt = $this->PDO->prepare("SELECT * FROM users WHERE correo = :correo");
            $stmt->bindParam(":correo", $correo);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (password_verify($password, $user[0]['hash_pass'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function insertarUser($dni,$correo,$hash_pass,$nombre,$apellido_1,$apellido_2,$telefono,$direccion){
        try {
            $stmt = $this->PDO->prepare(
                "INSERT INTO users (dni,correo,hash_pass,nombre,apellido_1,apellido_2,telefono,direccion) 
                VALUES (:dni, :correo, :hash_pass, :nombre, :apellido_1, :apellido_2, :telefono, :direccion)"
            );
            $stmt->bindParam(":dni", $dni);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":hash_pass", $hash_pass);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":apellido_1", $apellido_1);
            $stmt->bindParam(":apellido_2", $apellido_2);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":direccion", $direccion);
        
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }

    public function obtenerToken($correo){
        try {

            $stmt = $this->PDO->prepare("SELECT token_id, hora FROM users WHERE correo = :correo");
            $stmt->bindParam(":correo", $correo);

            
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {

                return false;
            }
        } catch (PDOException $e) {
    
            echo "Error: " . $e->getMessage();

        }
    }

    public function obtenerHora($correo){
        try {

            $stmt = $this->PDO->prepare("SELECT hora FROM users WHERE correo = :correo");
            $stmt->bindParam(":correo", $correo);

            
            if ($stmt->execute()) {
                $hora = $stmt->fetch(PDO::FETCH_ASSOC);
                return $hora['hora'];
            } else {

                return false;
            }
        } catch (PDOException $e) {
    
            echo "Error: " . $e->getMessage();

        }
    }

    public function insertarToken($correo, $token_id, $hora){
        try {

            $stmt = $this->PDO->prepare("UPDATE users SET token_id = :token_id, hora = :hora WHERE correo = :correo");
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":token_id", $token_id);
            $stmt->bindParam(":hora",$hora);
            return $stmt->execute();
            
        } catch (PDOException $e) {
    
            echo "Error: " . $e->getMessage();

        }
    }
}


?>