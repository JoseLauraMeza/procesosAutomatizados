<?php
require_once "Conexion.php";

class Producto {
    public static function obtenerTodos() {
        $conn = Conexion::conectar();
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        $productos = [];
        while($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        return $productos;
    }

    public static function obtenerPorCategoria($categoria_id) {
    $conn = Conexion::conectar();
    $sql = "SELECT * FROM productos WHERE id_categoria = $categoria_id";
    $result = $conn->query($sql);
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    return $productos;
}

public static function obtenerCategorias() {
    $conn = Conexion::conectar();
    $sql = "SELECT * FROM categorias";
    $result = $conn->query($sql);
    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
    return $categorias;
}


    public static function obtenerPorId($id) {
        $conn = Conexion::conectar();
        $sql = "SELECT * FROM productos WHERE id_producto = $id";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }
}