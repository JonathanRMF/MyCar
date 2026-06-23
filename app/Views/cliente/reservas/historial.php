<div class="container my-5">

    <h2 class="mb-4"><i class="fas fa-history me-2 text-primary"></i> Historial de Alquileres</h2>

    <?php if (empty($historial)): ?>
        <div class="text-center py-5">
            <span style="font-size:3rem;">🕐</span>
            <p class="mt-3 text-muted">Todavía no tenés alquileres finalizados.</p>
            <a href="<?= base_url('vehiculos') ?>" class="btn btn-primary mt-2">
                <i class="fas fa-search me-1"></i> Buscar vehículos
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Vehículo</th>
                        <th>Categoría</th>
                        <th>Fecha desde</th>
                        <th>Días</th>
                        <th>Monto total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $h): ?>
                        <tr>
                            <td class="text-muted small">#<?= esc($h['id']) ?></td>
                            <td><strong><?= esc($h['marca']) ?> <?= esc($h['modelo']) ?></strong></td>
                            <td><?= esc($h['categoria']) ?></td>
                            <td><?= esc($h['fecha_desde']) ?></td>
                            <td><?= esc($h['cantidad_dias']) ?></td>
                            <td class="text-primary fw-bold">$<?= number_format($h['monto_total'], 2) ?></td>
                            <td><span class="badge bg-secondary">Finalizado</span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>