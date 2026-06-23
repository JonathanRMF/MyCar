<div class="container my-5">

    <h2 class="mb-4"><i class="fas fa-calendar-alt me-2 text-primary"></i> Mis Reservas</h2>

    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
    <?php endif; ?>

    <?php if (empty($reservas)): ?>
        <div class="text-center py-5">
            <span style="font-size:3rem;">📋</span>
            <p class="mt-3 text-muted">No tenés reservas activas en este momento.</p>
            <a href="<?= base_url('vehiculos') ?>" class="btn btn-primary mt-2">
                <i class="fas fa-search me-1"></i> Buscar vehículos
            </a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($reservas as $r): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0"><?= esc($r['marca']) ?> <?= esc($r['modelo']) ?></h5>
                                <?php
                                    $badgeClass = match($r['estado']) {
                                        'reservado'  => 'bg-warning text-dark',
                                        'alquilado'  => 'bg-success',
                                        default      => 'bg-secondary',
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= ucfirst(esc($r['estado'])) ?>
                                </span>
                            </div>
                            <p class="text-muted small mb-3"><?= esc($r['categoria']) ?></p>

                            <ul class="list-unstyled small mb-3">
                                <li class="d-flex justify-content-between border-bottom py-1">
                                    <span class="text-muted">Fecha desde</span>
                                    <strong><?= esc($r['fecha_desde']) ?></strong>
                                </li>
                                <li class="d-flex justify-content-between border-bottom py-1">
                                    <span class="text-muted">Cantidad de días</span>
                                    <strong><?= esc($r['cantidad_dias']) ?></strong>
                                </li>
                                <li class="d-flex justify-content-between py-1">
                                    <span class="text-muted">Monto total</span>
                                    <strong class="text-primary">$<?= number_format($r['monto_total'], 2) ?></strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>