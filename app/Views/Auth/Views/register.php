<?= $this->extend('layout/layoutLogin') ?>

<?= $this->section('content') ?>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= url_to('register') ?>" class="h1"><?= lang('Auth.register') ?></a>
            </div>
            <div class="card-body">
                <?= view('Myth\Auth\Views\_message_block') ?>
                <p class="login-box-msg">Register a new membership</p>

                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <hr>

                <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <?= $this->endSection() ?>