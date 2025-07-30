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
}