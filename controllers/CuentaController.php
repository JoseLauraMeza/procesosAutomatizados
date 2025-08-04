<?php
require_once "models/Venta.php";

class CuentaController {

    public function verHistorial() {
        // solo para clientes logueados
        if (!isset($_SESSION['id_cliente'])) {
            header('Location: rutas.php?r=login');
            return;
        }

        // historial de ventas del cliente
        $id_cliente = $_SESSION['id_cliente'];
        $ventas = Venta::obtenerPorCliente($id_cliente);

        // cargar la vista con los datos
        include "views/header.php";
        include "views/historial.php";
        include "views/footer.php";
    }
}