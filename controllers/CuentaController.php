<?php
require_once "models/Venta.php";

class CuentaController {

    /**
     * Muestra el historial de pedidos del cliente logueado.
     */
    public function verHistorial() {
        // 1. Proteger la ruta: solo para clientes logueados
        if (!isset($_SESSION['id_cliente'])) {
            header('Location: rutas.php?r=login');
            return;
        }

        // 2. Obtener el historial de ventas del cliente
        $id_cliente = $_SESSION['id_cliente'];
        $ventas = Venta::obtenerPorCliente($id_cliente);

        // 3. Cargar la vista con los datos
        include "views/header.php";
        include "views/historial.php";
        include "views/footer.php";
    }
}