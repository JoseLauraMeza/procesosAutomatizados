<div class="container mt-4">
    <h2>ClothesPlus</h2>
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