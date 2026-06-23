<div class="container mt-5" style="max-width: 480px;">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4 text-center">Crear cuenta</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php $errores = session()->getFlashdata('errores') ?? []; ?>
        <?php if ($errores): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errores as $e): ?><li><?= $e ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                        value="<?= old('nombre') ?>" required autofocus>
                </div>
                <div class="col">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control"
                        value="<?= old('apellido') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?= old('email') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control"
                    value="<?= old('telefono') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Dirección <span class="text-muted">(opcional)</span></label>
                <input type="text" name="direccion" class="form-control"
                    value="<?= old('direccion') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="confirmar" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>

        <p class="text-center mt-3 mb-0">
            ¿Ya tenés cuenta? <a href="<?= base_url('login') ?>">Iniciá sesión</a>
        </p>
    </div>
</div>