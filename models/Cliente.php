<?php
require_once "Conexion.php";

class Cliente {
    /**
     * Registra un nuevo cliente en la base de datos.
     *
     * @param array $datos Los datos del cliente.
     * @return bool True si se registró correctamente, false en caso de error.
     */
    public static function crear($datos) {
        $conn = Conexion::conectar();
        
        // Ciframos la contraseña antes de guardarla
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

    /**
     * Busca un cliente por su nombre de usuario.
     *
     * @param string $usuario El nombre de usuario a buscar.
     * @return array|null Los datos del cliente o null si no se encuentra.
     */
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