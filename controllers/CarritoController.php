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
    // La compra la puede finalizar un cliente logueado o un empleado en nombre de un cliente.
    // Por ahora, priorizaremos al cliente logueado.
    if (!isset($_SESSION['id_cliente']) && !isset($_SESSION['id_empleado'])) {
        // Si nadie está logueado, se redirige al login de clientes como acción por defecto.
        header("Location: rutas.php?r=login");
        return;
    }

    $carrito = $_SESSION['carrito'] ?? [];

    if (empty($carrito)) {
        header("Location: rutas.php?r=carrito");
        return;
    }
    require_once "models/Venta.php";

    // Asignar el cliente y empleado correctos a la venta
    $id_cliente = $_SESSION['id_cliente'] ?? 1; // Si un empleado compra, se asigna al cliente por defecto (ID 1). Idealmente, el empleado seleccionaría un cliente.
    $id_empleado = $_SESSION['id_empleado'] ?? null; // La venta puede no tener un empleado si la hace el cliente directamente.

    // La base de datos requiere un empleado, así que si es un cliente, asignamos uno por defecto.
    if ($id_empleado === null) $id_empleado = 1; // Asignar al empleado 'Carlos Ramírez' por defecto.

    Venta::registrar($id_cliente, $id_empleado, $carrito);

    unset($_SESSION['carrito']);
    header("Location: rutas.php?r=productos");
    }

    public function generarBoleta() {
    // Proteger la ruta, solo para empleados logueados
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