<?php
// Centralizamos el inicio de sesión para evitar errores y tener un único punto de control.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "controllers/ProductoController.php";
require_once "controllers/CarritoController.php";
require_once "controllers/LoginController.php";
require_once "controllers/ClienteController.php";

$r = $_GET['r'] ?? 'productos';

switch ($r) {
    case 'login': // Login unificado para Clientes y Empleados
        (new LoginController())->mostrar();
        break;
    // Rutas para el registro de clientes
    case 'registro':
        (new ClienteController())->mostrarRegistro();
        break;
    case 'guardar_cliente':
        (new ClienteController())->guardar();
        break;
    case 'productos':
        (new ProductoController())->index();
        break;
    case 'agregar':
        (new CarritoController())->agregar();
        break;
    case 'eliminar':
        (new CarritoController())->eliminar();
        break;
    case 'carrito':
        (new CarritoController())->mostrar();
        break;
    case 'finalizar':
        (new CarritoController())->finalizar();
        break;
    case 'boleta':
        (new CarritoController())->generarBoleta();
        break;
    case 'autenticar':
        (new LoginController())->autenticar();
        break;
    case 'logout':
        (new LoginController())->logout();
        break;
    default:
        echo "Ruta no válida";
}