<?php
require_once "models/Usuario.php";
require_once "models/Cliente.php";

class LoginController {

    public function mostrar() {
        // Si ya hay una sesión activa, redirigir a productos
        if (isset($_SESSION['id_empleado'])) {
            header('Location: rutas.php?r=productos');
            return;
        }
        include "views/header.php";
        include "views/login.php";
        include "views/footer.php";
    }

    public function autenticar() {
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($usuario) || empty($password)) {
            $error = "El usuario y la contraseña son obligatorios.";
            include "views/header.php";
            include "views/login.php";
            include "views/footer.php";
            return;
        }

        // 1. Intentar autenticar como cliente
        $cliente = Cliente::obtenerPorUsuario($usuario);
        if ($cliente && password_verify($password, $cliente['password'])) {
            // Autenticación de cliente exitosa
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nombres_cliente'] = $cliente['nombres'];
            header('Location: rutas.php?r=productos');
            return;
        }

        // 2. Si no es cliente, intentar como empleado
        $empleado = Usuario::obtenerPorUsuario($usuario);
        if ($empleado && password_verify($password, $empleado['password'])) {
            // Autenticación de empleado exitosa
            $_SESSION['id_empleado'] = $empleado['id_empleado'];
            $_SESSION['nombres'] = $empleado['nombres'];
            $_SESSION['cargo'] = $empleado['cargo'];
            header('Location: rutas.php?r=productos');
            return;
        } else {
            // 3. Falla de autenticación para ambos
            $error = "Usuario o contraseña incorrectos.";
            include "views/header.php";
            include "views/login.php";
            include "views/footer.php";
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: rutas.php?r=login'); // Redirige al login unificado
    }
}