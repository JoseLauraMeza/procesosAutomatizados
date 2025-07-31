<?php
require_once "Conexion.php";

class Venta {
    public static function registrar($id_cliente, $id_empleado, $carrito) {
        $conn = Conexion::conectar();
        $conn->begin_transaction(); // 🔁 Iniciamos transacción

        try {
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $stmtVenta = $conn->prepare("INSERT INTO ventas (id_cliente, id_empleado, total) VALUES (?, ?, ?)");
            $stmtVenta->bind_param("iid", $id_cliente, $id_empleado, $total);
            $stmtVenta->execute();
            $id_venta = $conn->insert_id;
            $stmtVenta->close();

            foreach ($carrito as $item) {
                $id_producto = $item['id_producto'];
                $cantidad = $item['cantidad'];
                $precio_unitario = $item['precio'];

                // Insertar detalle de venta
                $stmtDetalle = $conn->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario)
                                               VALUES (?, ?, ?, ?)");
                $stmtDetalle->bind_param("iiid", $id_venta, $id_producto, $cantidad, $precio_unitario);
                $stmtDetalle->execute();
                $stmtDetalle->close();

                // Restar stock
                $stmtStock = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
                $stmtStock->bind_param("ii", $cantidad, $id_producto);
                $stmtStock->execute();
                
                // Comprobar si afectó alguna fila
                if ($stmtStock->affected_rows === 0) {
                    throw new Exception("Error: No se pudo actualizar el stock del producto ID $id_producto.");
                }

                $stmtStock->close();
            }

            $conn->commit(); // ✅ Confirmamos cambios
        } catch (Exception $e) {
            $conn->rollback(); // ❌ Deshacemos si hay error
            echo "Error al registrar la venta: " . $e->getMessage();
        }

        $conn->close();
    }
}
