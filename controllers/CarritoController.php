<?php
require_once "models/Carrito.php";
use Dompdf\Dompdf;
use Dompdf\Options;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    // Log
    if (!isset($_SESSION['id_cliente']) && !isset($_SESSION['id_empleado'])) {
        header("Location: rutas.php?r=login");
        return;
    }

    $carrito = $_SESSION['carrito'] ?? [];

    if (empty($carrito)) {
        header("Location: rutas.php?r=carrito");
        return;
    }
    require_once "models/Venta.php";

    $id_cliente = $_SESSION['id_cliente'] ?? 1;
    $id_empleado = $_SESSION['id_empleado'] ?? null;

    if ($id_empleado === null) $id_empleado = 1;

    Venta::registrar($id_cliente, $id_empleado, $carrito);

    unset($_SESSION['carrito']);
    header("Location: rutas.php?r=productos");
    }

    public function generarBoleta() {
        // historial
        if (isset($_GET['id_venta'])) {
            require_once "models/Venta.php";
            $id_venta = (int)$_GET['id_venta'];
            $venta = Venta::obtenerPorId($id_venta);

            if (!$venta) {
                echo "Venta no encontrada.";
                return;
            }

            ob_start();
            include 'views/boleta_pdf.php'; 
            $html = ob_get_clean();

        } else {
            // actual
            if (!isset($_SESSION['id_empleado']) && !isset($_SESSION['id_cliente'])) {
                header("Location: rutas.php?r=login");
                return;
            }

            if (empty($_SESSION['carrito'])) {
                echo "No hay productos en el carrito.";
                return;
            }

            $productos = $_SESSION['carrito'];
            $total = 0;
            foreach ($productos as &$producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $producto['subtotal'] = $subtotal;
                $total += $subtotal;
            }

            ob_start();
            include 'views/boleta_pdf.php';
            $html = ob_get_clean();
        }

        // Generar el PDF 
        require 'libs/dompdf/autoload.inc.php';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("boleta.pdf", ["Attachment" => false]);
        exit;
    }
}