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
                                <div class="col-md-3">
                                    <a href="#">
                                        <div class="info-box mb-3 bg-blue">
                                            <div class="card-body">
                                                <span class="info-box-text" style="text-align: center"><b>Sou contratado</b></span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- /.info-box -->
                                    <div class="info-box mb-3 bg-success">
                                        <div class="card-body">
                                            <span class="info-box-text" style="text-align: center"><b>Quero inscrever meu evento</b></span>
                                        </div>
                                    </div>
                                    <!-- /.info-box -->
                                    <div class="info-box mb-3 bg-danger">
                                        <div class="card-body">
                                            <span class="info-box-text" style="text-align: center"><b>Emenda parlamentar</b></span>
                                        </div>
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box mb-3 bg-info">
                                        <div class="card-body">
                                            <span class="info-box-text" style="text-align: center"><b>Fomentos</b></span>
                                        </div>
                                    </div>
                                    <!-- /.info-box -->
                                    <div class="info-box mb-3 bg-maroon">
                                        <div class="card-body">
                                            <span class="info-box-text" style="text-align: center"><b>Oficineiros</b></span>
                                        </div>
                                    </div>
                                    <!-- /.info-box -->
                                    <div class="info-box mb-3 bg-purple">
                                        <div class="card-body">
                                            <span class="info-box-text" style="text-align: center"><b>Formação</b></span>
                                        </div>
                                    </div>
                                    <!-- /.info-box -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>