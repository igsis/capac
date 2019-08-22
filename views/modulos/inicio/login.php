<?php
    if (isset($_POST['email']) && (isset($_POST['senha']))) {
        require_once "./controllers/UsuarioController.php";
        $login = new UsuarioController();
        echo $login->iniciaSessao();
    }
?>
<!-- Content Header (Page header) -->
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

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <p class="card-text"><span style="text-align: justify; display:block;">
                                    Este sistema tem por objetivo criar um ambiente para credenciamento de artistas e profissionais de arte e cultura a fim de agilizar os processos de contratação artística em eventos realizados pela Secretaria Municipal de Cultura de São Paulo.</span></p>
                                <p class="card-text"><span style="text-align: justify; display:block;">
                                    Uma vez cadastrados, esses artistas poderão atualizar suas informações e enviar a documentação necessária para o processo de contratação. Como o sistema possui ligação direta com o sistema da programação, a medida que o cadastro do artista no IGSIS - CAPAC encontra-se atualizado, o processo de contratação consequentemente é agilizado.</span></p>
                                <p class="card-text">Podem se cadastrar artistas ou grupos artísticos, como pessoa física ou jurídica.</p>
                                <p class="card-text">Dúvidas entre em contato com o setor responsável por sua contratação.</p>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                    <div class="card"><?php if(isset($mensagem)) echo $mensagem ?>
                                        <div class="card-body login-card-body">
                                            <form action="" method="POST">
                                                <label>E-mail</label>
                                                <div class="input-group mb-3">
                                                    <input name="email" type="email" class="form-control" placeholder="Email">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-envelope"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label>Senha</label>
                                                <div class="input-group mb-3">
                                                    <input name="senha" type="password" class="form-control" placeholder="Senha">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-8">

                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-4">
                                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                            </form>
                                            <p class="mb-1">
                                                <a href="#">Esqueci minha senha</a>
                                            </p>
                                            <p class="mb-0">
                                                <a href="cadastro" class="text-center">Não possuí cadastro? Clique aqui</a>
                                            </p>
                                        </div>
                                        <!-- /.login-card-body -->
                                    </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>