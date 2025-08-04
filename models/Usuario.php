<?php
require_once "Conexion.php";

class Usuario {
    /**
     * Busca un empleado por su nombre de usuario.
     *
     * @param string $usuario El nombre de usuario a buscar.
     * @return array|null Los datos del empleado o null si no se encuentra.
     */
    public static function obtenerPorUsuario($usuario) {
        $conn = Conexion::conectar();
        $stmt = $conn->prepare("SELECT id_empleado, nombres, apellidos, usuario, cargo, password FROM empleados WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $empleado = $resultado->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $empleado;
    }
}