<?php
if (isset($_SESSION)) {
    unset($_SESSION['origem_id_c']);
    unset($_SESSION['pedido_id_c']);
    unset($_SESSION['modulo_c']);
    unset($_SESSION['edital_c']);
}
require_once "./controllers/FomentoController.php";
$fomentoObj = new FomentoController();
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
<div class="content">
    <div class="container-fluid">
        <?php
        foreach ($fomentoObj->listaFomentos() as $fomento){
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="card card-gray-dark card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><?= $fomento['titulo'] ?></h5>
                        </div>
                        <div class="card-body">
                            <?= $fomento['descricao'] ?>
                        </div>
                        <div class="card-footer">
                            <a href="login&modulo=8&edital=<?= MainModel::encryption($fomento['id']) ?>" class="small-box-footer">
                                Inscreva-se <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
            <?php
        }
        ?>
    </div><!-- /.container-fluid -->
</div>