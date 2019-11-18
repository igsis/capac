<?php
$url = 'http://' . $_SERVER['HTTP_HOST'] . '/capac/api/verificadorEmail.php';
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0 text-dark">CAPAC - Cadastro de Artistas e Profissionais de Arte e Cultura</h1>
            </div>
            <div class="col-sm-2">
                <img src="<?= SERVERURL ?>views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png" alt="logo cultura">
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="login-page">

    <div class="card">
        <div class="card-body register-card-body">
            <h5 class="login-box-msg">Efetue seu Cadastro</h5>
            <p class="card-text"><span style="text-align: justify; display:block;"> Confira seus dados antes de clicar no botão "Cadastrar".</span></p>
            <form class="needs-validation formulario-ajax" data-form="save"
                  action="<?= SERVERURL ?>ajax/usuarioAjax.php" method="post">
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
                <div class="input-group mb-3" id="divEmail">
                    <input type="email" class="form-control" name="email" placeholder="Email" required id="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Email já cadastrado</strong>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="telefone" placeholder="Telefone"
                           onkeyup="mascara( this, mtel );" maxlength="15" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira um Telefone Válido</strong>
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
                    <button type="submit" class="btn btn-primary btn-block btn-flat" id="cadastra">Cadastrar</button>
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

<script>
    const url = `<?= $url ?>`;
    var email = $('#email');

    email.blur(function () {
        $.ajax({
            url: url,
            type: 'POST',
            data: {"email": email.val()},

            success: function (data) {
                let divEmail = document.querySelector('#divEmail');
                let emailCampo = document.querySelector('#email');

                if (data.ok) {
                    emailCampo.classList.remove("is-invalid");
                    $("#cadastra").attr('disabled', false);
                } else {
                    emailCampo.classList.add("is-invalid");
                    $("#cadastra").attr('disabled', true);
                }
            }
        })
    })
</script>