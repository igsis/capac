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
        <div class="row mb-1">
            <div class="col-sm-10">
                <h1 class="m-0 text-dark"><b>CAPAC - Cadastro de Artistas e Profissionais de Arte e Cultura</b></h1>
            </div>
            <div class="col-sm-2" align="right">
                <img src="<?= SERVERURL ?>views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png" alt="logo cultura">
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="login-page">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-text"><span style="text-align: justify; display:block;">
                                        Este sistema tem por objetivo criar um ambiente para credenciamento de artistas e profissionais de arte e cultura a fim de agilizar os processos de contratação artística em eventos realizados pela Secretaria Municipal de Cultura de São Paulo.</span></p>
                                    <p class="card-text"><span style="text-align: justify; display:block;">
                                        Uma vez cadastrados, esses artistas poderão atualizar suas informações e enviar a documentação necessária para o processo de contratação. Como o sistema possui ligação direta com o sistema da programação, a medida que o cadastro do artista no CAPAC encontra-se atualizado, o processo de contratação consequentemente é agilizado.</span></p>
                                    <p class="card-text">Podem se cadastrar artistas ou grupos artísticos, como pessoa física ou jurídica.</p>
                                    <p class="card-text">Dúvidas entre em contato com o setor responsável por sua contratação.</p>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mt-2">
                                                
                                            </div>

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
</div>