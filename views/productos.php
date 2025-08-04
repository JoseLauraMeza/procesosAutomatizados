<div class="container mt-4">
    <?php if (!empty($productos)): 
    // Producto destacado (el primero)
    $destacado = $productos[0]; 
?>
<div class="bg-light rounded-4 p-5 mb-5 d-flex align-items-center justify-content-between flex-wrap">
    <div>
        <p class="text-danger fw-semibold">¡Novedades de temporada!</p>
        <h1 class="fw-bold text-dark">Luce con estilo<br> con <?= htmlspecialchars($destacado['nombre']) ?></h1>
        <div class="mt-4">
            <a href="rutas.php?r=agregar&id=<?= $destacado['id_producto'] ?>" class="btn btn-warning me-3">Compra ahora</a>
        </div>
    </div>
    <img src="public/img/<?= $destacado['foto_url'] ?>" alt="Producto Destacado" style="max-height: 280px; border-radius: 12px;">
</div>
<?php endif; ?>


    <!-- Filtros de categoría -->
    <div class="mb-4">
        <h4 class="fw-bold mb-3">Categorías</h4>
        <div class="d-flex flex-wrap gap-2">
            <a href="rutas.php?r=productos" class="btn btn-outline-dark <?= !isset($_GET['categoria']) ? 'active' : '' ?>">VER TODO</a>
            <?php foreach ($categorias as $cat): ?>
                <a href="rutas.php?r=productos&categoria=<?= $cat['id_categoria'] ?>" class="btn btn-outline-dark <?= (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['nombre_categoria']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Productos -->
    <h4 class="fw-bold mb-3">Productos populares</h4>
    <div class="row g-4">
        <?php foreach ($productos as $p): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <img src="public/img/<?= $p['foto_url'] ?>" class="card-img-top rounded-top-4" alt="Producto" height="300">
                    <div class="card-body">
                        <h5 class="card-title"><?= $p['nombre'] ?></h5>
                        <p class="card-text small text-muted"><?= $p['descripcion'] ?></p>
                        <p class="fw-semibold text-primary">S/ <?= $p['precio'] ?></p>
                        <a href="rutas.php?r=agregar&id=<?= $p['id_producto'] ?>" class="btn btn-primary w-100">Agregar al carrito</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
