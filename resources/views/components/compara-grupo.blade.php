@push('script')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/i18n/pt-BR.js')}}"></script>

<link rel="stylesheet" href="{{ asset('plugins/bs-stepper/bs-stepper.min.css') }}">
<script src="{{ asset('plugins/bs-stepper/bs-stepper.min.js') }}"></script>

<script>
    var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

$('select[name="grupos[]"],select[name="atributos[]"],select[name="montadora"],select[name="flg_tipo_chassi"]').select2({
    theme: 'bootstrap4',
    language: 'pt-BR'
});

$('select[name="veiculos[]"]').select2({
    theme: 'bootstrap4',
    language: 'pt-BR',
    maximumSelectionLength: 3
});

$(document).on('change', 'select[name="montadora"]', function (e) {

let id = $(this).val();
let modal = $('#modal-compare');
let tr = $(this).closest('tr');

    $.ajax({
        url:  "/getveiculos",
        type: 'GET',
        data: {
            montadora_id: id,
            flg_tipo_chassi: $('select[name="flg_tipo_chassi"]').val(),
        },
        success: function (data) {
            // handle success response

            tr.find('select[name="veiculos[]"]').html('')
            .select2({
                theme: 'bootstrap4',
                language: 'pt-BR',
                maximumSelectionLength: 3,
                data: data.data
            }).trigger('change');

            tr.find('select[name="veiculos[]"]').val(data.data).change();
        },
        error: function (data) {
            // handle error response
            Toast.fire({
                type: 'error',
                title: 'Erro ao buscar veículos. Contacte o suporte!'
            });
        }
    });
});

$('#modal-files').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) ;
    let modal = $(this);

    let veiculo = button.data('veiculo');
    let atributo = button.data('atributo');
    $.ajax({
        url:  "{{route('midias.get')}}",
        type: 'POST',
        data: {
            veiculos_id: veiculo,
            atributos_id: atributo
        },
        success: function (data) {
            // handle success response
            modal.find('.modal-body').empty().html(data.html);
        },
        error: function (data) {
            // handle error response
            Toast.fire({
                   type: 'error',
                   title: (data.responseJSON.message) ? data.responseJSON.message : 'Erro ao pesquisar atributo. </br>Contacte o suporte!'
                });
        }
    });

});

$(document).on('click', '.add', function (e) {

    let count = $('#list tbody tr').length;

    if(count < 3){
        $.ajax({
            url:  "{{route('comparativo.add')}}",
            type: 'GET',
            success: function (data) {
                // handle success response
                $('#list tbody').append(data.html);
            },
            error: function (data) {
                // handle error response
                Toast.fire({
                    type: 'error',
                    title: 'Erro ao adicionar opção para escolha de veículos. </br>Contacte o suporte!'
                    });
            }
        });
    }

});

$(document).on('click', '.remove', function (e) {
    $(this).closest('tr').remove();
});

$("form[id='search']").on('submit', function (e) {
  e.preventDefault();
  let frm = $(this);

    var formData = new FormData(this);
    $.ajax({
            url:  "{{route('comparativo.comparar')}}",
            type: 'POST',
            data: formData,
            success: function (data) {
                // handle success response
                //frm.validate().resetForm();
                //frm[0].reset();
                    $('#comparativos').empty().html(data.html);
            },
            error: function (data) {
                // handle error response
            },
            contentType: false,
            processData: false
        });
});


// BS-Stepper Init
document.addEventListener('DOMContentLoaded', function() {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
});

(function() {
    'use strict'
    var stepperFormEl = document.querySelector('#stepperForm')
    window.stepperForm = new Stepper(stepperFormEl, {
        linear: false,
        animation: true
    })
    var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
    var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
    var form = stepperFormEl.querySelector('.bs-stepper-content form')
    btnNextList.forEach(function(btn) {
        btn.addEventListener('click', function() {
            window.stepperForm.next()
        })
    })
    stepperFormEl.addEventListener('show.bs-stepper', function(event) {
        form.classList.remove('was-validated')
        var nextStep = event.detail.indexStep
        var currentStep = nextStep
        if (currentStep > 0) {
            currentStep--
        }
        var stepperPan = stepperPanList[currentStep]
        //validation rules
        switch (stepperPan.getAttribute('id')) {
            case 'test-form-1':
            /*if (
            !document.getElementById('nome').value.length ||
            !document.getElementById('cnpj').value.length ||
            !document.getElementById('telefone').value.length ||
            !document.getElementById('cep').value.length ||
            !document.getElementById('rua').value.length ||
            !document.getElementById('numero').value.length ||
            !document.getElementById('bairro').value.length ||
            !document.getElementById('cidade').value.length ||
            !document.getElementById('estado').value.length
            ) {
                event.preventDefault()
                form.classList.add('was-validated')
            }*/
            break;
            case 'test-form-2':
            /*if(!inputPasswordForm.value.length){
                event.preventDefault()
                form.classList.add('was-validated')
            }*/
            break;
            default:
        }
    })
})();

</script>
@endpush


<div class="mb-5 p-4 bg-white table-responsive">
    <div id="stepperForm" class="bs-stepper">
        <div class="bs-stepper-header" role="tablist">
            <div class="step" data-target="#test-form-1">
                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger1"
                    aria-controls="test-form-1" disabled>
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Tipo de chassi</span>
                </button>
            </div>
            <div class="bs-stepper-line"></div>
            <div class="step" data-target="#test-form-2">
                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger2"
                    aria-controls="test-form-2" disabled>
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">Grupo de funções</span>
                </button>
            </div>
            <div class="bs-stepper-line"></div>
            <div class="step" data-target="#test-form-3">
                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger3"
                    aria-controls="test-form-3" disabled>
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">Veículos</span>
                </button>
            </div>
        </div>

        <div class="bs-stepper-content">

            <form id="search" class="needs-validation" method="POST" onsubmit="return false" action="#" novalidate
                autocomplete="off">
                <div id="test-form-1" role="tabpanel" class="bs-stepper-pane fade"
                    aria-labelledby="stepperFormTrigger1">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-12">
                            <div class="form-group">
                                <strong>Tipo de chassi:</strong>
                                <select name="flg_tipo_chassi" id="flg_tipo_chassi" class="form-control">
                                    <option value="C">Cavalo</option>
                                    <option value="R">Rígido</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary float-left"
                        onclick="stepperForm.next()">Próximo</button>
                </div>

                <div id="test-form-2" role="tabpanel" class="bs-stepper-pane fade"
                    aria-labelledby="stepperFormTrigger2">

                    <div class="col-xs-6 col-sm-6 col-md-12">
                        <div class="form-group">
                            @php
                            $grupos = \App\GrupoFuncoes::orderBy('descricao','ASC')->get();
                            @endphp
                            <label>Grupo de funções</label>
                            <select name="grupos[]" id="grupos" class="form-control" multiple="multiple">
                                <option value="">Todos</option>
                                @foreach ($grupos as $item)
                                <option value="{{$item->id}}">{{$item->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary float-left mr-2"
                            onclick="stepperForm.previous()">Anterior</button>
                        <button type="button" class="btn btn-primary float-left"
                            onclick="stepperForm.next()">Próximo</button>
                    </div>

                </div>

                <div id="test-form-3" role="tabpanel" class="bs-stepper-pane fade text-center"
                    aria-labelledby="stepperFormTrigger3">
                    <div class="col-xs-6 col-sm-6 col-md-12">
                        <table class="table table-light" id="list">
                            <thead class="thead-dark">
                                <tr>
                                    <td colspan="3">
                                        <a href="#" class="btn btn-sm btn-secondary float-left add">
                                            <i class="fas fa-plus"></i>&nbsp;Veículos</a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <!--APPENDED CONTENT HERE-->
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary float-left mr-2"
                            onclick="stepperForm.previous()">Anterior</button>
                        <button type="submit" class="btn btn-success float-left">Comparar</button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

<!--<hr style="border-top: 2px dashed #007bff">-->

<div class="row">
    <div class="card-body" id="comparativos">
        <p class="text-center p-4" style="font-size: 25px;">Nenhum comparativo realizado</br><i class="far fa-frown"
                style="font-size: 25px;"></i></p>
    </div>
</div>
