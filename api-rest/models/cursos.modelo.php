<?php
require_once "conexion.php";// se incluye el archivo conexion.php
class ModeloCursos{

    static public function index($tabla){
        //ConexionBD::conectar() es una forma de llamar a un metodo estatico
        // de una clase sin necesidad de instanciar la clase
        // es decir, sin necesidad de crear un objeto de la clase

        $stmt=ConexionBD::conectar()->prepare("SELECT * FROM $tabla");
        // prepare es un metodo de PDO
        //este metodo de PDO viene cuando en la clase ConexionBD se creo un objeto PDO
        // que nos permite preparar una sentencia SQL para ser ejecutada por el metodo execute
        $stmt ->execute();
        return $stmt -> fetchAll(PDO::FETCH_CLASS);
        //fetchall es un metodo de PDO
        // que nos trae todas las filas de la tabla
        //PDO::FETCH_CLASS es una constante de PDO
        // que nos permite traer los datos en forma de objeto
        $stmt -> close(); // se cierra la conexion con la base de datos
        $stmt = null; // se libera la memoria

    }
}



?>