<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>My Car</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/imagenes/logoMini.jpg') ?>" type="image/jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilos.css') ?>">
</head>
<body>

<?php include 'nav.html'; ?>

<!-- CONTENT -->
<div class="container row" id="content">
    <!-- tarjeta de promocion -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img id="promocion" src="<?= base_url('assets/imagenes/promocion.png') ?>" class="card-img-top" alt="Imagen intermedia">
            <div class="card-body text-center">
                <h5 class="card-title">¡Oferta Especial!</h5>
                <p class="card-text">Producto destacado del día</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>

<!-- SCRIPTS -->

<script {csp-script-nonce}>
    document.getElementById("menuToggle").addEventListener('click', toggleMenu);
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

<!-- -->

</body>
</html>
