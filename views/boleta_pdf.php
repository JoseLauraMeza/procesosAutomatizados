<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Venta - ClothesPlus</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header, .footer { text-align: center; }
        .info { margin-bottom: 20px; }
        .info p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; }
        h2 { text-align: center; border-bottom: 1px solid #333; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Boleta de Venta - ClothesPlus</h2>
    </div>

    <?php if (isset($venta)): // CASO 1: Es una venta histórica (desde el historial) ?>
        <div class="info">
            <p><strong>N° de Venta:</strong> #<?= htmlspecialchars($venta['datos']['id_venta']) ?></p>
            <p><strong>Fecha:</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($venta['datos']['fecha']))) ?></p>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($venta['datos']['cliente_nombres'] . ' ' . $venta['datos']['cliente_apellidos']) ?></p>
            <p><strong>Atendido por:</strong> <?= htmlspecialchars($venta['datos']['empleado_nombres'] . ' ' . $venta['datos']['empleado_apellidos']) ?></p>
        </div>
    <?php else: // CASO 2: Es una vista previa del carrito en sesión ?>
        <div class="info">
            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i') ?></p>
            <p><strong>Estado:</strong> VISTA PREVIA (no es un comprobante final)</p>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($venta)): // Iterar sobre detalles de una venta guardada ?>
                <?php foreach ($venta['detalles'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= htmlspecialchars($item['cantidad']) ?></td>
                        <td class="text-right">S/ <?= number_format($item['precio_unitario'], 2) ?></td>
                        <td class="text-right">S/ <?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php elseif (isset($productos)): // Iterar sobre el carrito en sesión ?>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['cantidad']) ?></td>
                        <td class="text-right">S/ <?= number_format($p['precio'], 2) ?></td>
                        <td class="text-right">S/ <?= number_format($p['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>S/ <?= number_format(isset($venta) ? $venta['datos']['total'] : $total, 2) ?></strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
