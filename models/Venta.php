<?php
require_once "Conexion.php";

class Venta {
    public static function registrar($id_cliente, $id_empleado, $carrito) {
        $conn = Conexion::conectar();

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $conn->query("INSERT INTO ventas (id_cliente, id_empleado, total) VALUES ($id_cliente, $id_empleado, $total)");
        $id_venta = $conn->insert_id;

        foreach ($carrito as $item) {
            $id_producto = $item['id_producto'];
            $cantidad = $item['cantidad'];
            $precio_unitario = $item['precio'];
            $conn->query("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario)
                          VALUES ($id_venta, $id_producto, $cantidad, $precio_unitario)");

            // Opcional: descontar stock
            $conn->query("UPDATE productos SET stock = stock - $cantidad WHERE id_producto = $id_producto");
        }
    }
}
