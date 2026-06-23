<?php $alquileres = $alquileres ?? []; ?>

<div class="container my-5">
    <a href="<?= base_url('admin/reportes') ?>" class="btn btn-outline-secondary btn-sm mb-4">← Volver</a>

    <h2 class="mb-4">Vehículos actualmente alquilados</h2>

    <?php if (empty($alquileres)): ?>
        <div class="alert alert-info">No hay vehículos alquilados en este momento.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Vehículo</th>
                    <th>Categoría</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Fecha desde</th>
                    <th>Días</th>
                    <th>Vence</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alquileres as $a): ?>
                    <?php
                        $fechaVence = date('Y-m-d', strtotime($a['fecha_desde'] . ' +' . $a['cantidad_dias'] . ' days'));
                        $vencido    = $fechaVence < date('Y-m-d');
                    ?>
                    <tr class="<?= $vencido ? 'table-danger' : '' ?>">
                        <td><?= esc($a['marca']) ?> <?= esc($a['modelo']) ?></td>
                        <td><?= esc($a['categoria']) ?></td>
                        <td><?= esc($a['apellido']) ?>, <?= esc($a['nombre']) ?></td>
                        <td><?= esc($a['telefono']) ?></td>
                        <td><?= $a['fecha_desde'] ?></td>
                        <td><?= $a['cantidad_dias'] ?></td>
                        <td>
                            <?= $fechaVence ?>
                            <?php if ($vencido): ?>
                                <span class="badge bg-danger ms-1">Vencido</span>
                            <?php endif; ?>
                        </td>
                        <td>$<?= number_format($a['monto_total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>