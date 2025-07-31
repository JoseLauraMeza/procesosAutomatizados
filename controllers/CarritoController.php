<?php
require_once "models/Carrito.php";

class CarritoController {
    public function agregar() {
        $id = $_GET['id'];
        Carrito::agregar($id);
        header("Location: rutas.php?r=productos");
    }

    public function eliminar() {
        $id = $_GET['id'];
        Carrito::eliminar($id);
        header("Location: rutas.php?r=carrito");
    }

    public function mostrar() {
        $carrito = Carrito::obtener();
        include "views/header.php";
        include "views/carrito.php";
        include "views/footer.php";
    }

    public function finalizar() {
    session_start();
    $carrito = $_SESSION['carrito'] ?? [];

    if (empty($carrito)) {
        header("Location: rutas.php?r=carrito");
        return;
    }

    require_once "models/Venta.php";

    $id_cliente = 1; 
    $id_empleado = 1;
    Venta::registrar($id_cliente, $id_empleado, $carrito);

    unset($_SESSION['carrito']);
    header("Location: rutas.php?r=productos");
    }
}