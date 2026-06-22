<?php $alquileres = $alquileres ?? []; ?>

<div class="container my-5">
    <a href="/admin/reportes" class="btn btn-outline-secondary btn-sm mb-4">← Volver</a>

    <h2 class="mb-1">Reporte por cliente</h2>
    <p class="text-muted mb-4">
        <?= esc($cliente['apellido']) ?>, <?= esc($cliente['nombre']) ?>
        — Tel: <?= esc($cliente['telefono']) ?>
    </p>

    <?php if (empty($alquileres)): ?>
        <div class="alert alert-info">Este cliente no tiene alquileres registrados.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Vehículo</th>
                    <th>Categoría</th>
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
                        <td><?= esc($a['marca']) ?> <?= esc($a['modelo']) ?></td>
                        <td><?= esc($a['categoria']) ?></td>
                        <td><?= $a['fecha_desde'] ?></td>
                        <td><?= $a['cantidad_dias'] ?></td>
                        <td>$<?= number_format($a['monto_total'], 2) ?></td>
                        <td>
                            <?php if ($a['devuelto']): ?>
                                <span class="badge bg-secondary">Devuelto</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Activo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>