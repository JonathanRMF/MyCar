<div class="container my-5">

    <!-- Mensajes flash -->
    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
    <?php endif; ?>

    <!-- Filtro por categorías -->
    <div class="mb-4 d-flex gap-2 flex-wrap">
        <a href="/vehiculos" class="btn <?= !isset($categoriaActual) ? 'btn-primary' : 'btn-outline-primary' ?>">
            Todos
        </a>
        <?php if (isset($categorias) && !empty($categorias)): ?>
            <?php foreach ($categorias as $cat): ?>
                <a href="/vehiculos/categoria/<?= $cat ?>"
                    class="btn <?= (isset($categoriaActual) && $categoriaActual === $cat) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= $cat ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Grid de vehículos -->
    <?php if (empty($vehiculos)): ?>
        <div class="alert alert-info">No hay vehículos disponibles en esta categoría.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php 
            $contador = 0;
            $totalVehiculos = count($vehiculos);
            $posicionPromocion = round($totalVehiculos / 2); // Mitad de los vehículos
            $promocionMostrada = false;
            ?>
            
            <?php foreach ($vehiculos as $v): ?>
                <?php $contador++; ?>
                
                <!-- Tarjeta del vehículo -->
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if ($v['imagen']): ?>
                            <img src="/assets/imagenes/<?= esc($v['imagen']) ?>"
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
                            <a href="/vehiculos/detalle/<?= $v['id'] ?>"
                                class="btn btn-outline-primary btn-sm flex-fill">Ver detalle</a>
                            <?php if (session()->get('usuario_id')): ?>
                                <a href="/reservas/nueva/<?= $v['id'] ?>"
                                    class="btn btn-primary btn-sm flex-fill">Reservar</a>
                            <?php else: ?>
                                <a href="/login" class="btn btn-outline-secondary btn-sm flex-fill">
                                    Iniciá sesión para reservar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Tarjeta de Promoción (se muestra después del vehículo en la posición central) -->
                <?php if ($contador == $posicionPromocion && !$promocionMostrada && $contador < $totalVehiculos): ?>
                    <?php $promocionMostrada = true; ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm border-warning" id="promocionCard" style="background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);">
                                <img id="promocion" src="assets/imagenes/promocion.png" class="card-img-top" style="height:200px;object-fit:cover;" alt="Imagen intermedia">
                                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                                    <h5 class="card-title text-warning fw-bold">🎉 ¡Oferta Especial!</h5>
                                    <div class="mt-2">
                                        <span class="badge bg-danger fs-6">🔥 Ofertas imperdibles</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endif; ?>
                
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>