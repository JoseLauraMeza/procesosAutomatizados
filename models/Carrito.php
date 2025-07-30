<?php
require_once "Producto.php";

class Carrito {
    public static function agregar($id) {
        session_start();
        if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];

        if (!isset($_SESSION['carrito'][$id])) {
            $producto = Producto::obtenerPorId($id);
            $producto['cantidad'] = 1;
            $_SESSION['carrito'][$id] = $producto;
        } else {
            $_SESSION['carrito'][$id]['cantidad']++;
        }
    }

    public static function eliminar($id) {
        session_start();
        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    public static function obtener() {
        session_start();
        return $_SESSION['carrito'] ?? [];
    }
}