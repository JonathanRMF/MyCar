<?php $vehiculos = $vehiculos ?? []; $clientes = $clientes ?? []; ?>

<div class="container my-5">
    <h2 class="mb-4">Reportes</h2>

    <div class="row g-4">

        <!-- Reporte 1: por vehículo -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🚗 Por vehículo</h5>
                    <p class="text-muted small">Clientes que alquilaron un vehículo determinado.</p>
                    <form action="" method="get" id="form-vehiculo">
                        <select name="vehiculo_id" class="form-select mb-3" required>
                            <option value="">Seleccioná un vehículo</option>
                            <?php foreach ($vehiculos as $v): ?>
                                <option value="<?= $v['id'] ?>">
                                    <?= esc($v['marca']) ?> <?= esc($v['modelo']) ?> (<?= $v['anio'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary w-100"
                            onclick="this.form.action='/admin/reportes/vehiculo/'+this.form.vehiculo_id.value; return true;">
                            Ver reporte
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reporte 2: por cliente -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">👤 Por cliente</h5>
                    <p class="text-muted small">Vehículos alquilados por un cliente determinado.</p>
                    <form action="" method="get" id="form-cliente">
                        <select name="cliente_id" class="form-select mb-3" required>
                            <option value="">Seleccioná un cliente</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= esc($c['apellido']) ?>, <?= esc($c['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary w-100"
                            onclick="this.form.action='/admin/reportes/cliente/'+this.form.cliente_id.value; return true;">
                            Ver reporte
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reporte 3: alquileres activos -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📋 Activos ahora</h5>
                    <p class="text-muted small">Vehículos actualmente alquilados y quién los tiene.</p>
                    <a href="/admin/reportes/activos" class="btn btn-primary w-100 mt-3">
                        Ver reporte
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>