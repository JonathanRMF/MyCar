<?php $alquileres = $alquileres ?? []; ?>

<div class="container my-5">

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Alquileres</h2>
        <a href="/admin/reportes" class="btn btn-outline-secondary">Ver reportes</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Desde</th>
                <th>Días</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($alquileres)): ?>
                <tr><td colspan="8" class="text-center text-muted">No hay alquileres registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($alquileres as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= esc($a['apellido']) ?>, <?= esc($a['nombre']) ?></td>
                        <td><?= esc($a['marca']) ?> <?= esc($a['modelo']) ?></td>
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
                        <td>
                            <?php if (!$a['devuelto']): ?>
                                <a href="/admin/alquileres/devolucion/<?= $a['id'] ?>"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('¿Confirmar devolución?')">
                                    Devolver
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>