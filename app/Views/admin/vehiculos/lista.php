<?php $vehiculos = $vehiculos ?? []; ?>

<div class="container my-5">

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Vehículos</h2>
        <a href="<?= base_url('admin/vehiculos/crear') ?>" class="btn btn-primary">+ Nuevo vehículo</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Categoría</th><th>Marca</th><th>Modelo</th>
                <th>Año</th><th>Precio/día</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehiculos as $v): ?>
                <tr class="<?= !$v['activo'] ? 'table-secondary text-muted' : '' ?>">
                    <td><?= $v['id'] ?></td>
                    <td><?= esc($v['categoria']) ?></td>
                    <td><?= esc($v['marca']) ?></td>
                    <td><?= esc($v['modelo']) ?></td>
                    <td><?= $v['anio'] ?></td>
                    <td>$<?= number_format($v['precio_dia'], 2) ?></td>
                    <td>
                        <?php if ($v['activo']): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Baja</span>
                        <?php endif; ?>
                    </td>
                    <td class="d-flex gap-1">
                        <a href="/admin/vehiculos/editar/<?= $v['id'] ?>"
                            class="btn btn-warning btn-sm">Editar</a>
                        <?php if ($v['activo']): ?>
                            <a href="/admin/vehiculos/baja/<?= $v['id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Dar de baja este vehículo?')">Baja</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>