<?= view('layout/nav') ?>

<div class="container mt-5" style="max-width: 420px;">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4 text-center">Iniciar sesión</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('exito')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('exito') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?= old('email') ?>" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <p class="text-center mt-3 mb-0">
            ¿No tenés cuenta? <a href="/register">Registrate</a>
        </p>
    </div>
</div>

<?= view('layout/footer') ?>