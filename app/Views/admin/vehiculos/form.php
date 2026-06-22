<?php $vehiculo = $vehiculo ?? []; ?>
<div class="container my-5" style="max-width:620px;">

    <h2 class="mb-4"><?= $vehiculo ? 'Editar vehículo' : 'Nuevo vehículo' ?></h2>

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
        $accion = $vehiculo ? "/admin/vehiculos/editar/{$vehiculo['id']}" : '/admin/vehiculos/crear';
    ?>

    <form action="<?= $accion ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Marca *</label>
                <input type="text" name="marca" class="form-control"
                        value="<?= old('marca', $vehiculo['marca'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Modelo *</label>
                <input type="text" name="modelo" class="form-control"
                        value="<?= old('modelo', $vehiculo['modelo'] ?? '') ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Categoría *</label>
                <select name="categoria" class="form-select" required>
                    <?php foreach (['Auto','Camioneta','SUV','Deportivo','Van'] as $cat): ?>
                        <option value="<?= $cat ?>"
                            <?= old('categoria', $vehiculo['categoria'] ?? '') === $cat ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Año *</label>
                <input type="number" name="anio" class="form-control"
                    value="<?= old('anio', $vehiculo['anio'] ?? '') ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Plazas *</label>
                <input type="number" name="plazas" class="form-control"
                        value="<?= old('plazas', $vehiculo['plazas'] ?? '') ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Motor</label>
                <input type="text" name="motor" class="form-control"
                       value="<?= old('motor', $vehiculo['motor'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kilometraje</label>
                <input type="number" name="kilometraje" class="form-control"
                       value="<?= old('kilometraje', $vehiculo['kilometraje'] ?? '') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio por día ($) *</label>
            <input type="number" step="0.01" name="precio_dia" class="form-control"
                   value="<?= old('precio_dia', $vehiculo['precio_dia'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"><?= old('descripcion', $vehiculo['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label">Nombre de imagen</label>
            <input type="text" name="imagen" class="form-control" placeholder="auto.jpg"
                   value="<?= old('imagen', $vehiculo['imagen'] ?? '') ?>">
            <div class="form-text">El archivo debe estar en /assets/imagenes/</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <?= $vehiculo ? 'Guardar cambios' : 'Crear vehículo' ?>
            </button>
            <a href="/admin/vehiculos" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>