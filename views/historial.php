<div class="container my-5">
    <h2 class="mb-4">Mi Historial de Pedidos</h2>

    <?php if (empty($ventas)): ?>
        <div class="alert alert-info">
            Aún no has realizado ninguna compra. ¡Explora nuestros <a href="rutas.php?r=productos" class="alert-link">productos</a>!
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($venta['fecha']))) ?></td>
                            <td>S/ <?= number_format($venta['total'], 2) ?></td>
                            <td>
                                <a href="rutas.php?r=boleta&id_venta=<?= $venta['id_venta'] ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                                    Ver Boleta
                                </a>
                            </td>
                        </tr>
                        <?php $contador++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>