<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/nav.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
</head>
<body>

<?php
    $rol      = session()->get('rol');
    $logueado = session()->get('usuario_id');
    $nombre   = session()->get('nombre');
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-mycar">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/imagenes/logo.jpg') ?>" alt="My Car Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarMyCar" aria-controls="navbarMyCar"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMyCar">

                <?php if ($rol === 'admin'): ?>
                <!-- MENÚ ADMIN -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/vehiculos') ?>">
                            <i class="fas fa-car me-1"></i> Vehículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/clientes') ?>">
                            <i class="fas fa-users me-1"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/alquileres') ?>">
                            <i class="fas fa-key me-1"></i> Alquileres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/reportes') ?>">
                            <i class="fas fa-chart-bar me-1"></i> Reportes
                        </a>
                    </li>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-white small">
                        <i class="fas fa-user-shield me-1"></i><?= esc($nombre) ?>
                    </span>
                    <a href="<?= base_url('logout') ?>" class="btn-login">
                        <i class="fas fa-sign-out-alt me-1"></i> Salir
                    </a>
                </div>

                <?php elseif ($rol === 'cliente'): ?>
                <!-- MENÚ CLIENTE -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('vehiculos') ?>">
                            <i class="fas fa-search me-1"></i> Buscar autos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('mis-reservas') ?>">
                            <i class="fas fa-calendar-alt me-1"></i> Mis reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('historial') ?>">
                            <i class="fas fa-history me-1"></i> Historial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#promociones">
                            <i class="fas fa-gift me-1"></i> Promociones
                        </a>
                    </li>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-white small">
                        <i class="fas fa-user me-1"></i><?= esc($nombre) ?>
                    </span>
                    <a href="<?= base_url('logout') ?>" class="btn-login">
                        <i class="fas fa-sign-out-alt me-1"></i> Salir
                    </a>
                </div>

                <?php else: ?>
                <!-- MENÚ VISITANTE -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('vehiculos') ?>">
                            <i class="fas fa-search me-1"></i> Buscar autos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#promociones">
                            <i class="fas fa-gift me-1"></i> Promociones
                        </a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('login') ?>" class="btn-login">
                        <i class="fas fa-sign-in-alt me-1"></i> Iniciar sesión
                    </a>
                    <a href="<?= base_url('register') ?>" class="btn-register">
                        <i class="fas fa-user-plus me-1"></i> Registrarse
                    </a>
                </div>

                <?php endif; ?>

            </div>
        </div>
    </nav>
</header>