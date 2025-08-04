<?php
require_once "models/Producto.php";

class ProductoController {
    public function index() {
    $categoria_id = $_GET['categoria'] ?? null;
    $productos = $categoria_id 
        ? Producto::obtenerPorCategoria($categoria_id) 
        : Producto::obtenerTodos();

    $categorias = Producto::obtenerCategorias();
    
    include "views/header.php";
    include "views/productos.php";
    include "views/footer.php";
    }
    
}