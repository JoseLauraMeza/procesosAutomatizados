<div class="container my-5 text-center">
    <div class="alert alert-success">
        <h4 class="alert-heading">¡Compra realizada con éxito!</h4>
        <p>Gracias por tu compra. Tu boleta se está generando en una nueva pestaña.</p>
        <hr>
        <p class="mb-0">Serás redirigido a la página de productos en unos segundos.</p>
    </div>
</div>

<script>
    (function() {
        const id_venta = <?= json_encode($id_venta ?? 0) ?>;

        window.open(`rutas.php?r=boleta&id_venta=${id_venta}`, '_blank');

        setTimeout(function() {
            window.location.href = 'rutas.php?r=productos';
        }, 3000);
    })();
</script>