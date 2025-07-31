<?php
require_once "controllers/ProductoController.php";
require_once "controllers/CarritoController.php";

$r = $_GET['r'] ?? 'productos';

switch ($r) {
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
    default:
        echo "Ruta no válida";
}