<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ClothesPlus</title>
    <link rel="stylesheet" href="/public/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body>
<div class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-primary" href="rutas.php?r=productos">
      <img src="public/img/1.png" alt="Clothes Plus" style="height: 40px;">
    </a>

    <!-- Menu -->
    <div class="mx-auto">
      <ul class="navbar-nav flex-row gap-4">
        <li class="nav-item"><a href="rutas.php?r=productos" class="nav-link text-dark">Inicio</a></li>
        <li class="nav-item"><a href="rutas.php?r=carrito" class="nav-link text-dark">Compra</a></li>
        <li class="nav-item"><a href="rutas.php?r=historial" class="nav-link text-dark">Pedidos</a></li>
      </ul>
    </div>

    <!-- Usuario -->
    <div class="dropdown">
      <?php if (isset($_SESSION['id_cliente'])): ?>
        <a href="#" class="nav-link dropdown-toggle text-primary" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Hola, <?= htmlspecialchars($_SESSION['nombres_cliente']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="rutas.php?r=historial">Mis Pedidos</a></li>
          <li><a class="dropdown-item" href="rutas.php?r=carrito">Mi Carrito</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="rutas.php?r=logout">Cerrar Sesión</a></li>
        </ul>
      <?php elseif (isset($_SESSION['id_empleado'])): ?>
        <a href="#" class="nav-link dropdown-toggle text-primary" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Empleado: <?= htmlspecialchars($_SESSION['nombres']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="rutas.php?r=logout">Cerrar Sesión</a></li>
        </ul>
      <?php else: ?>
        <a class="btn btn-outline-primary btn-sm me-2" href="rutas.php?r=registro">Registrarse</a>
        <a class="btn btn-primary btn-sm" href="rutas.php?r=login">Iniciar Sesión</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
