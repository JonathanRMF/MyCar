<div class="container my-5" style="max-width:760px;">
    <a href="/vehiculos" class="btn btn-outline-secondary btn-sm mb-4">← Volver</a>

    <div class="card shadow-sm">
        <?php if ($vehiculo['imagen']): ?>
            <img src="/assets/imagenes/<?= esc($vehiculo['imagen']) ?>"
                class="card-img-top" style="height:320px;object-fit:cover;"
                alt="<?= esc($vehiculo['marca']) ?>">
        <?php endif; ?>

        <div class="card-body">
            <span class="badge bg-secondary mb-2"><?= esc($vehiculo['categoria']) ?></span>
            <h2 class="card-title"><?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?></h2>

            <div class="row mt-3">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li><strong>Año:</strong> <?= esc($vehiculo['anio']) ?></li>
                        <li><strong>Plazas:</strong> <?= esc($vehiculo['plazas']) ?></li>
                        <li><strong>Motor:</strong> <?= esc($vehiculo['motor']) ?></li>
                        <li><strong>Kilometraje:</strong> <?= number_format($vehiculo['kilometraje']) ?> km</li>
                    </ul>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="fw-bold text-primary fs-3">$<?= number_format($vehiculo['precio_dia'], 2) ?>/día</p>
                </div>
            </div>

            <?php if ($vehiculo['descripcion']): ?>
                <p class="mt-3"><?= esc($vehiculo['descripcion']) ?></p>
            <?php endif; ?>
        </div>

        <div class="card-footer">
            <?php if (session()->get('usuario_id')): ?>
                <a href="/reservas/nueva/<?= $vehiculo['id'] ?>" class="btn btn-primary w-100">
                    Reservar este vehículo
                </a>
            <?php else: ?>
                <a href="/login" class="btn btn-outline-primary w-100">
                    Iniciá sesión para reservar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>