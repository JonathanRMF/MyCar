<?php
$categorias = $categorias ?? [];
$vehiculos  = $vehiculos  ?? [];
$busqueda   = $busqueda   ?? [];
?>

<div class="container my-5">

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
    <?php endif; ?>

    <!-- ── BUSCADOR ─────────────────────────────────────── -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="fas fa-search me-2 text-primary"></i>Buscar vehículos</h5>
            <form action="<?= base_url('vehiculos/buscar') ?>" method="get">
                <div class="row g-2 align-items-end">

                    <!-- Texto libre -->
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-semibold">Marca / Modelo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-car"></i></span>
                            <input type="text" name="q" class="form-control"
                                   placeholder="ej: Toyota, Corolla..."
                                   value="<?= esc($busqueda['q'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold">Categoría</label>
                        <select name="categoria" class="form-select">
                            <option value="">Todas</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat ?>"
                                    <?= (($busqueda['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                                    <?= $cat ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Precio mín -->
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold">Precio mín/día ($)</label>
                        <input type="number" name="precio_min" class="form-control" min="0" step="500"
                               placeholder="0"
                               value="<?= esc($busqueda['precio_min'] ?? '') ?>">
                    </div>

                    <!-- Precio máx -->
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold">Precio máx/día ($)</label>
                        <input type="number" name="precio_max" class="form-control" min="0" step="500"
                               placeholder="Sin límite"
                               value="<?= esc($busqueda['precio_max'] ?? '') ?>">
                    </div>

                    <!-- Plazas -->
                    <div class="col-6 col-md-1">
                        <label class="form-label small fw-semibold">Plazas mín</label>
                        <input type="number" name="plazas" class="form-control" min="1" max="12"
                               placeholder="1"
                               value="<?= esc($busqueda['plazas'] ?? '') ?>">
                    </div>

                    <!-- Botones -->
                    <div class="col-12 col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="<?= base_url('vehiculos') ?>" class="btn btn-outline-secondary w-100" title="Limpiar">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

        <!-- ── FILTROS RÁPIDOS POR CATEGORÍA ─────────────────── -->
    <?php
    $iconos = [
        'Auto'       => 'ti-car',
        'Camioneta'  => 'ti-truck',
        'SUV'        => 'ti-car-suv',
        'Deportivo'  => 'ti-steering-wheel',
        'Van'        => 'ti-bus',
    ];
    ?>

    <style>
    .cat-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 1.5rem; }
.cat-card { display: flex; flex-direction: row; align-items: center; gap: 10px; padding: 12px 22px; border: 1px solid #dee2e6; border-radius: 12px; background: #fff; text-decoration: none; color: #6c757d; transition: border-color 0.15s, background 0.15s; white-space: nowrap; }
.cat-card:hover { border-color: #adb5bd; background: #f8f9fa; color: #495057; text-decoration: none; }
.cat-card.activa { border: 2px solid #0d6efd; background: #e7f1ff; color: #0a58ca; }
.cat-card i { font-size: 20px; }
.cat-card span { font-size: 14px; }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <div class="cat-grid">
        <a href="<?= base_url('vehiculos') ?>"
        class="cat-card <?= !isset($categoriaActual) && empty(array_filter($busqueda ?? [])) ? 'activa' : '' ?>">
            <i class="ti ti-layout-grid"></i>
            <span>Todos</span>
        </a>
        <?php foreach ($categorias as $cat): ?>
            <a href="<?= base_url('vehiculos/categoria/' . $cat) ?>"
            class="cat-card <?= (isset($categoriaActual) && $categoriaActual === $cat) ? 'activa' : '' ?>">
                <i class="ti <?= $iconos[$cat] ?? 'ti-car' ?>"></i>
                <span><?= esc($cat) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- ── RESULTADO ──────────────────────────────────────── -->
    <?php if (!empty($busqueda) && array_filter($busqueda)): ?>
        <p class="text-muted small mb-3">
            <i class="fas fa-info-circle me-1"></i>
            <?= count($vehiculos) ?> resultado(s) encontrado(s).
            <a href="<?= base_url('vehiculos') ?>">Ver todos</a>
        </p>
    <?php endif; ?>

    <?php if (empty($vehiculos)): ?>
        <div class="text-center py-5">
            <span style="font-size:3rem;">🔍</span>
            <p class="mt-3 text-muted">No se encontraron vehículos con esos criterios.</p>
            <a href="<?= base_url('vehiculos') ?>" class="btn btn-outline-primary mt-2">Ver todos</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($vehiculos as $v): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if ($v['imagen']): ?>
                            <img src="<?= base_url('assets/imagenes/' . esc($v['imagen'])) ?>"
                                 class="card-img-top" style="height:200px;object-fit:cover;"
                                 alt="<?= esc($v['marca']) ?> <?= esc($v['modelo']) ?>">
                        <?php else: ?>
                            <div class="bg-secondary d-flex align-items-center justify-content-center"
                                 style="height:200px;">
                                <span class="text-white fs-1">🚗</span>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <span class="badge bg-secondary mb-2"><?= esc($v['categoria']) ?></span>
                            <h5 class="card-title"><?= esc($v['marca']) ?> <?= esc($v['modelo']) ?></h5>
                            <p class="text-muted mb-1">Año: <?= esc($v['anio']) ?> · <?= esc($v['plazas']) ?> plazas</p>
                            <p class="fw-bold text-primary fs-5">$<?= number_format($v['precio_dia'], 2) ?>/día</p>
                        </div>

                        <div class="card-footer d-flex gap-2">
                            <a href="<?= base_url('vehiculos/detalle/' . $v['id']) ?>"
                               class="btn btn-outline-primary btn-sm flex-fill">Ver detalle</a>
                            <?php if (session()->get('usuario_id')): ?>
                                <a href="<?= base_url('reservas/nueva/' . $v['id']) ?>"
                                   class="btn btn-primary btn-sm flex-fill">Reservar</a>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>"
                                   class="btn btn-outline-secondary btn-sm flex-fill">
                                    Iniciá sesión para reservar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>