<div class="register-box">
    <div class="register-logo">
        <a href="login"><?= NOMESIS ?></a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Efetue seu Cadastro</p>

            <form class="needs-validation formulario-ajax" data-form="save" action="<?=SERVERURL?>ajax/usuarioAjax.php" method="post">
                <input type="hidden" name="_method" value="insereNovoUsuario">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nome" placeholder="Nome Completo" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira seu Nome Completo</strong>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira um Email Válido</strong>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira sua Senha</strong>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="senha2" placeholder="Confirme sua Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Confirme sua Senha</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Cadastrar</button>
                </div>
                <div class="resposta-ajax">

                </div>
            </form>

            <div class="mb-0 text-center">
                <a href="login" class="text-center">Já possuo Cadastro</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->