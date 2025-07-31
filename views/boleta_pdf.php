<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de compra</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Boleta de Compra - ClothesPlus</h2>
    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i') ?></p>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= $p['nombre'] ?></td>
                    <td><?= $p['descripcion'] ?></td>
                    <td><?= $p['cantidad'] ?></td>
                    <td>S/ <?= number_format($p['precio'], 2) ?></td>
                    <td>S/ <?= number_format($p['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>S/ <?= number_format($total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
