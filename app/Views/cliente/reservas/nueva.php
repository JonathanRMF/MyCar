<div class="container my-5" style="max-width:560px;">

    <a href="/vehiculos" class="btn btn-outline-secondary btn-sm mb-4">← Volver</a>
    <h2 class="mb-4">Nueva reserva</h2>

    <?php $errores = session()->getFlashdata('errores') ?? []; ?>
    <?php if ($errores): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $e): ?><li><?= $e ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Resumen del vehículo -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-secondary mb-1"><?= esc($vehiculo['categoria']) ?></span>
                <h5 class="mb-0"><?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?></h5>
                <small class="text-muted"><?= $vehiculo['anio'] ?> · <?= $vehiculo['plazas'] ?> plazas</small>
            </div>
            <div class="text-end">
                <p class="fw-bold text-primary fs-4 mb-0">$<?= number_format($vehiculo['precio_dia'], 2) ?></p>
                <small class="text-muted">por día</small>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <form action="/reservas/guardar" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="vehiculo_id" value="<?= $vehiculo['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Fecha de inicio</label>
            <input type="date" name="fecha_desde" class="form-control"
                    min="<?= date('Y-m-d') ?>"
                    value="<?= old('fecha_desde', date('Y-m-d')) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad de días</label>
            <input type="number" name="cantidad_dias" id="cantidad_dias" class="form-control"
                    min="1" value="<?= old('cantidad_dias', 1) ?>" required>
        </div>

        <!-- Cálculo en tiempo real -->
        <div class="alert alert-light border mb-4">
            <div class="d-flex justify-content-between">
                <span>Precio por día</span>
                <span>$<?= number_format($vehiculo['precio_dia'], 2) ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Días</span>
                <span id="dias-display">1</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Total estimado</span>
                <span id="total-display" class="text-primary">
                    $<?= number_format($vehiculo['precio_dia'], 2) ?>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Confirmar reserva</button>
    </form>
</div>

<script>
    // Calcula el total en tiempo real mientras el usuario escribe
    const precioDia  = <?= $vehiculo['precio_dia'] ?>;
    const inputDias  = document.getElementById('cantidad_dias');
    const diasDisplay  = document.getElementById('dias-display');
    const totalDisplay = document.getElementById('total-display');

    inputDias.addEventListener('input', function() {
        const dias  = parseInt(this.value) || 0;
        const total = dias * precioDia;
        diasDisplay.textContent  = dias;
        totalDisplay.textContent = '$' + total.toLocaleString('es-AR', {minimumFractionDigits: 2});
    });
</script>