<?php $alquileres = $alquileres ?? []; ?>

<div class="container my-5">
    <a href="<?= base_url('admin/reportes') ?>" class="btn btn-outline-secondary btn-sm mb-4">← Volver</a>

    <h2 class="mb-1">Reporte por vehículo</h2>
    <p class="text-muted mb-4">
        <?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?>
        (<?= $vehiculo['anio'] ?>) — $<?= number_format($vehiculo['precio_dia'], 2) ?>/día
    </p>

    <?php if (empty($alquileres)): ?>
        <div class="alert alert-info">Este vehículo no tiene alquileres registrados.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Fecha desde</th>
                    <th>Días</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alquileres as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= esc($a['apellido']) ?>, <?= esc($a['nombre']) ?></td>
                        <td><?= esc($a['telefono']) ?></td>
                        <td><?= $a['fecha_desde'] ?></td>
                        <td><?= $a['cantidad_dias'] ?></td>
                        <td>$<?= number_format($a['monto_total'], 2) ?></td>
                        <td>
                            <?php if ($a['estado'] === 'reservado'): ?>
                                <span class="badge bg-info text-dark">Reservado</span>
                            <?php elseif ($a['estado'] === 'alquilado'): ?>
                                <span class="badge bg-warning text-dark">Alquilado</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Devuelto</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>