<div class="container my-5" style="max-width:480px;">
    <div class="card shadow-sm text-center p-4">

        <div class="mb-3">
            <span style="font-size:3rem;">✅</span>
        </div>

        <h2 class="mb-1">¡Reserva confirmada!</h2>
        <p class="text-muted mb-4">Tu reserva fue registrada correctamente.</p>

        <div class="list-group list-group-flush text-start mb-4">
            <div class="list-group-item d-flex justify-content-between">
                <span class="text-muted">Vehículo</span>
                <strong><?= esc($reserva['vehiculo']) ?></strong>
            </div>
            <div class="list-group-item d-flex justify-content-between">
                <span class="text-muted">Fecha desde</span>
                <strong><?= $reserva['fecha_desde'] ?></strong>
            </div>
            <div class="list-group-item d-flex justify-content-between">
                <span class="text-muted">Días</span>
                <strong><?= $reserva['cantidad_dias'] ?></strong>
            </div>
            <div class="list-group-item d-flex justify-content-between">
                <span class="text-muted">Total</span>
                <strong class="text-primary fs-5">$<?= number_format($reserva['monto_total'], 2) ?></strong>
            </div>
        </div>

        <a href="/vehiculos" class="btn btn-outline-primary">Ver más vehículos</a>
    </div>
</div>