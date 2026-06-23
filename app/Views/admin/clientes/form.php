<?php $cliente = $cliente ?? null; ?>
<div class="container my-5" style="max-width:560px;">

    <h2 class="mb-4"><?= $cliente ? 'Editar cliente' : 'Nuevo cliente' ?></h2>

    <?php $errores = session()->getFlashdata('errores') ?? []; ?>
    <?php if ($errores): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php
        $accion = $cliente
            ? base_url("admin/clientes/editar/{$cliente['id']}")
            : base_url('admin/clientes/crear');
    ?>

    <form action="<?= $accion ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-control"
                       value="<?= old('nombre', $cliente['nombre'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Apellido *</label>
                <input type="text" name="apellido" class="form-control"
                       value="<?= old('apellido', $cliente['apellido'] ?? '') ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono *</label>
            <input type="text" name="telefono" class="form-control"
                   value="<?= old('telefono', $cliente['telefono'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control"
                   value="<?= old('direccion', $cliente['direccion'] ?? '') ?>">
        </div>

        <?php if (!$cliente): ?>
        <hr class="my-4">
        <h6 class="text-muted mb-3">Credenciales de acceso</h6>

        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control"
                   value="<?= old('email') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña *</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <?php endif; ?>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <?= $cliente ? 'Guardar cambios' : 'Crear cliente' ?>
            </button>
            <a href="<?= base_url('admin/clientes') ?>" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>