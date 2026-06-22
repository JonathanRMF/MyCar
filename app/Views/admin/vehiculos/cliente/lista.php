<?php $clientes = $clientes ?? []; ?>

<div class="container my-5">

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Clientes</h2>
        <a href="/admin/clientes/crear" class="btn btn-primary">+ Nuevo cliente</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Apellido</th><th>Nombre</th>
                <th>Teléfono</th><th>Fecha alta</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
                <tr class="<?= !$c['activo'] ? 'table-secondary text-muted' : '' ?>">
                    <td><?= $c['id'] ?></td>
                    <td><?= esc($c['apellido']) ?></td>
                    <td><?= esc($c['nombre']) ?></td>
                    <td><?= esc($c['telefono']) ?></td>
                    <td><?= $c['fecha_alta'] ?></td>
                    <td>
                        <?php if ($c['activo']): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Baja</span>
                        <?php endif; ?>
                    </td>
                    <td class="d-flex gap-1">
                        <a href="/admin/clientes/editar/<?= $c['id'] ?>"
                            class="btn btn-warning btn-sm">Editar</a>
                        <?php if ($c['activo']): ?>
                            <a href="/admin/clientes/baja/<?= $c['id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Dar de baja este cliente?')">Baja</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>