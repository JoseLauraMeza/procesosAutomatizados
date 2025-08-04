<?php
require_once "Conexion.php";

class Cliente {
    public static function crear($datos) {
        $conn = Conexion::conectar();
        
        // cifrador de contraseña
        $password_hashed = password_hash($datos['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO clientes (nombres, apellidos, dni, correo, usuario, password) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param("ssssss", 
            $datos['nombres'], $datos['apellidos'], $datos['dni'], 
            $datos['correo'], $datos['usuario'], $password_hashed
        );

        $resultado = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $resultado;
    }

    public static function obtenerPorUsuario($usuario) {
        $conn = Conexion::conectar();
        $stmt = $conn->prepare("SELECT id_cliente, nombres, apellidos, usuario, password FROM clientes WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $cliente = $resultado->fetch_assoc();
        return $cliente;
    }
}