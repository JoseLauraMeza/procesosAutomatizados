<?php
require_once "models/Cliente.php";

class ClienteController {

    public function mostrarRegistro() {
        include "views/header.php";
        include "views/registro.php";
        include "views/footer.php";
    }

    public function guardar() {
        // Validar que los datos POST no estén vacíos
        $campos_requeridos = ['nombres', 'apellidos', 'dni', 'correo', 'usuario', 'password'];
        foreach ($campos_requeridos as $campo) {
            if (empty($_POST[$campo])) {
                header('Location: rutas.php?r=registro&error=Todos los campos son obligatorios');
                return;
            }
        }

        $resultado = Cliente::crear($_POST);

        if ($resultado) {
            header('Location: rutas.php?r=login&exito=¡Registro exitoso! Ahora puedes iniciar sesión.'); // Redirige al login unificado
        } else {
            header('Location: rutas.php?r=registro&error=El usuario o DNI ya existe. Intenta con otros datos.');
        }
    }
}