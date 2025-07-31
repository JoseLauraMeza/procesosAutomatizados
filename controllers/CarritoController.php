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
    session_start();
    $carrito = $_SESSION['carrito'] ?? [];

    if (empty($carrito)) {
        header("Location: rutas.php?r=carrito");
        return;
    }

    require_once "models/Venta.php";

    $id_cliente = 1; 
    $id_empleado = 1;
    Venta::registrar($id_cliente, $id_empleado, $carrito);

    unset($_SESSION['carrito']);
    header("Location: rutas.php?r=productos");
    }

    public function generarBoleta()
    {
    session_start();

    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
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

    // Usa ob_start() para capturar el contenido de la vista
    ob_start();
    include 'views/boleta_pdf.php'; // Aquí se usa $productos y $total
    $html = ob_get_clean();

    // Generar el PDF
    require 'libs/dompdf/autoload.inc.php';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("boleta.pdf", array("Attachment" => false));
    exit;
    }
}