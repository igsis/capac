// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

$('.formulario-ajax').submit(function(e){
    e.preventDefault();

    var form=$(this);

    var tipo=form.attr('data-form');
    var action=form.attr('action');
    var method=form.attr('method');
    var resposta=form.children('.resposta-ajax');

    var msgError="<script>Swal.fire('Ocorreu um erro insesperado','Por favor recarregue a pagina','error');</script>";
    var formdata = new FormData(this);


    var textoAlerta;
    if(tipo==="save"){
        textoAlerta="Os dados enviados serão salvos no sistema";
    }else if(tipo==="delete"){
        textoAlerta="Os dados serão eliminados do sistema";
    }else if(tipo==="update"){
        textoAlerta="Os dados serão atualizados no sistema";
    }else{
        textoAlerta="Deseja realmente realizar a operação";
    }


    Swal.fire({
        title: "Tem Certeza?",
        text: textoAlerta,
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: method,
                url: action,
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            if (percentComplete < 100) {
                                resposta.html('<p class="text-center">Procesado... (' + percentComplete + '%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: ' + percentComplete + '%;"></div></div>');
                            } else {
                                resposta.html('<p class="text-center"></p>');
                            }
                        }
                    }, false);
                    return xhr;
                },
                success: function (data) {
                    resposta.html(data);
                },
                error: function () {
                    resposta.html(msgError);
                }
            });
        }
        return false;
    });
});

$(function () {
    $("#tabela").DataTable({
        "language": {
            "url": '../views/plugins/datatables/Portuguese-Brasil.json'
        },
    });
});

/* /telefone */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
/* /.telefone */

function mask(t, mask) {
    let i = t.value.length;
    let saida = mask.substring(1, 0);
    let texto = mask.substring(i);
    if (texto.substring(0, 1) !== saida) {
        t.value += texto.substring(0, 1);
    }
}