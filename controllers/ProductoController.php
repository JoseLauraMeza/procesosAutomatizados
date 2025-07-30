<?php
require_once "models/Producto.php";

class ProductoController {
    public function index() {
        $productos = Producto::obtenerTodos();
        include "views/header.php";
        include "views/productos.php";
        include "views/footer.php";
    }
}