<?php
class Conexion {
    public static function conectar() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "TiendaRopa";

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        return $conn;
    }
}
