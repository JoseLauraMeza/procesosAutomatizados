<div class="container my-5">
  <h2 class="mb-4">🛒 Carrito de Compras</h2>

  <?php if (empty($carrito)): ?>
    <div class="alert alert-info">Tu carrito está vacío.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php $total = 0; ?>
          <?php foreach ($carrito as $item): ?>
            <tr>
              <td>
                <img src="public/img/<?= htmlspecialchars($item['foto_url']) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>" width="50" height="50" class="rounded shadow-sm">
              </td>
              <td><?= htmlspecialchars($item['nombre']) ?></td>
              <td>S/ <?= number_format($item['precio'], 2) ?></td>
              <td><?= $item['cantidad'] ?></td>
              <td>S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
              <td>
                <a href="rutas.php?r=eliminar&id=<?= $item['id_producto'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
              </td>
            </tr>
            <?php $total += $item['precio'] * $item['cantidad']; ?>
          <?php endforeach; ?>
        </tbody>
        <tfoot class="table-light">
          <tr>
            <td colspan="4" class="text-end"><strong>Total a pagar:</strong></td>
            <td colspan="2"><strong>S/ <?= number_format($total, 2) ?></strong></td>
          </tr>
        </tfoot>
      </table>
    </div>
  <?php endif; ?>
</div>