<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ClothesPlus</title>
    <link rel="stylesheet" href="/public/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
<div class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="rutas.php?r=productos">ClothesPlus</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="rutas.php?r=productos" class="nav-link">Productos</a>
        </li>
        <?php if (isset($_SESSION['id_empleado'])): // Sesión de Empleado ?>
            <li class="nav-item">
                <span class="navbar-text me-3">
                    Empleado: <?= htmlspecialchars($_SESSION['nombres']) ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rutas.php?r=logout">Cerrar Sesión</a>
            </li>
        <?php elseif (isset($_SESSION['id_cliente'])): // Sesión de Cliente ?>
            <li class="nav-item">
                <span class="navbar-text me-3">
                    Hola, <?= htmlspecialchars($_SESSION['nombres_cliente']) ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rutas.php?r=logout">Cerrar Sesión</a>
            </li>
        <?php else: // Sin sesión ?>
            <li class="nav-item">
                <a class="nav-link" href="rutas.php?r=registro">Registrarse</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="rutas.php?r=login">Iniciar Sesión</a></li>
        <?php endif; ?>
        <li class="nav-item">
          <a href="rutas.php?r=carrito" class="btn btn-outline-light ms-2">🛒 Ver carrito</a>
        </li>
      </ul>
    </div>
  </div>
</nav>