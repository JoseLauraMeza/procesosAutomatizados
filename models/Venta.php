<?php
require_once "Conexion.php";

class Venta {
    public static function registrar($id_cliente, $id_empleado, $carrito) {
        $conn = Conexion::conectar();
        $conn->begin_transaction();

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

            $conn->commit();
            $conn->close();
            return $id_venta; // Devolvemos el ID de la venta en caso de éxito
        } catch (Exception $e) {
            $conn->rollback();
            error_log("Error al registrar la venta: " . $e->getMessage());
            $conn->close();
            return false; // Devolvemos false si hay error
        }
    }

    public static function obtenerPorId($id_venta) {
        $conn = Conexion::conectar();
        $venta = [];

        // Obtener datos principales de la venta y del cliente/empleado
        $stmtVenta = $conn->prepare("
            SELECT v.id_venta, v.fecha, v.total, 
                   c.nombres as cliente_nombres, c.apellidos as cliente_apellidos,
                   e.nombres as empleado_nombres, e.apellidos as empleado_apellidos
            FROM ventas v
            JOIN clientes c ON v.id_cliente = c.id_cliente
            JOIN empleados e ON v.id_empleado = e.id_empleado
            WHERE v.id_venta = ?
        ");
        $stmtVenta->bind_param("i", $id_venta);
        $stmtVenta->execute();
        $venta['datos'] = $stmtVenta->get_result()->fetch_assoc();
        $stmtVenta->close();

        if (!$venta['datos']) return null;

        // Obtener el detalle de productos de la venta
        $stmtDetalle = $conn->prepare("
            SELECT dv.cantidad, dv.precio_unitario, p.nombre, p.descripcion
            FROM detalle_venta dv
            JOIN productos p ON dv.id_producto = p.id_producto
            WHERE dv.id_venta = ?
        ");
        $stmtDetalle->bind_param("i", $id_venta);
        $stmtDetalle->execute();
        $venta['detalles'] = $stmtDetalle->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmtDetalle->close();
        
        $conn->close();
        return $venta;
    }

    /**
     * Obtiene todas las ventas de un cliente específico.
     *
     * @param int $id_cliente El ID del cliente.
     * @return array Un array con el historial de ventas.
     */
    public static function obtenerPorCliente($id_cliente) {
        $conn = Conexion::conectar();
        $stmt = $conn->prepare("
            SELECT id_venta, fecha, total 
            FROM ventas 
            WHERE id_cliente = ? 
            ORDER BY fecha ASC
        ");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
