<div class="container mt-4">
    <h2>ClothesPlus</h2>

    <!-- Filtros de categoría -->
    <div class="container mb-4">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="rutas.php?r=productos" class="btn btn-outline-dark <?= !isset($_GET['categoria']) ? 'active' : '' ?>">VER TODO</a>
            <?php foreach ($categorias as $cat): ?>
                <a href="rutas.php?r=productos&categoria=<?= $cat['id_categoria'] ?>" class="btn btn-outline-dark <?= (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['nombre_categoria']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Productos -->
    <div class="row">
        <?php foreach ($productos as $p): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="public/img/<?= $p['foto_url'] ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $p['nombre'] ?></h5>
                        <p><?= $p['descripcion'] ?></p>
                        <p><strong>S/ <?= $p['precio'] ?></strong></p>
                        <a href="rutas.php?r=agregar&id=<?= $p['id_producto'] ?>" class="btn btn-primary">Agregar al carrito</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
