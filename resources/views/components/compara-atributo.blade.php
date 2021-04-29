@push('script')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/i18n/pt-BR.js')}}"></script>

<link rel="stylesheet" href="{{ asset('plugins/bs-stepper/bs-stepper.min.css') }}">
<script src="{{ asset('plugins/bs-stepper/bs-stepper.min.js') }}"></script>

<script>
    $('select[name="grupos[]"],select[name="atributos[]"],select[name="montadora[]"],select[name="flg_tipo_chassi"]').select2({
    theme: 'bootstrap4',
    language: 'pt-BR'
});

$('select[name="veiculos[]"]').select2({
    theme: 'bootstrap4',
    language: 'pt-BR',
    maximumSelectionLength: 3
});

$('select[name="montadora[]"]').on('change', function (e) {
    let id =$(this).val();
    //let modal = $('#modal-compare');

    $.ajax({
        url:  "/getveiculos",
        type: 'GET',
        data: {
            montadora_id: id,
            flg_tipo_chassi: $('select[name="flg_tipo_chassi"]').val(),
        },
        success: function (data) {
            // handle success response

            $('select[name="veiculos[]"]').html('')
            .select2({
                theme: 'bootstrap4',
                language: 'pt-BR',
                maximumSelectionLength: 3,
                data: data.data
            }).trigger('change');

            $('select[name="veiculos[]"]').val(data.data).change();
        },
        error: function (data) {
            // handle error response
            Toast.fire({
                type: 'error',
                title: 'Erro ao buscar atributos. Contacte o suporte!'
            });
        }
    });
});

$('select[id="grupos"]').on('change', function (e) {
    let id =$(this).val();
    //let modal = $('#modal-compare');

    $.ajax({
        url:  "/getatributosgrupo",
        type: 'GET',
        data: {
            grupo_funcoes_id: id
        },
        success: function (data) {
            // handle success response
            $('select[name="atributos[]"]').html('')
            .select2({
                theme: 'bootstrap4',
                language: 'pt-BR',
                data: data.data
            }).trigger('change');

            $('select[name="atributos[]"]').val(data.data).change();
        },
        error: function (data) {
            // handle error response
            Toast.fire({
                type: 'error',
                title: 'Erro ao buscar atributos. Contacte o suporte!'
            });
        }
    });
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
            //$('#modal-compare').modal('hide');
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
                    <span class="bs-stepper-label">Montadora</span>
                </button>
            </div>
            <div class="bs-stepper-line"></div>
            <div class="step" data-target="#test-form-3">
                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger3"
                    aria-controls="test-form-3" disabled>
                    <span class="bs-stepper-circle">3</span>
                    <span class="bs-stepper-label">Grupo de funções</span>
                </button>
            </div>
            <div class="bs-stepper-line"></div>
            <div class="step" data-target="#test-form-4">
                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger4"
                    aria-controls="test-form-4" disabled>
                    <span class="bs-stepper-circle">4</span>
                    <span class="bs-stepper-label">Atributos</span>
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
                        @php
                        $montadoras = \App\Montadora::select('id','nome')->orderBy('nome','ASC')
                        ->whereIn('id', function ($query){
                        $query->selectRaw('DISTINCT montadora_id as id')
                        ->from(with(new \App\Veiculos)->getTable());
                        })
                        ->get();
                        @endphp
                        <div class="form-group">
                            @php $montadora_id = \Request::get('montadora_id') @endphp
                            <strong>Montadora:</strong>
                            <select class="form-control" name="montadora[]" id="montadora" multiple="multiple">
                                <option value="">Todas</option>
                                @foreach ($montadoras as $montadora)
                                <option value="{{$montadora->id}}"
                                    {{ ($montadora_id == $montadora->id) ? 'selected' : '' }}>{{$montadora->nome}}
                                </option>
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

                <div id="test-form-3" role="tabpanel" class="bs-stepper-pane fade"
                    aria-labelledby="stepperFormTrigger3">

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

                <div id="test-form-4" role="tabpanel" class="bs-stepper-pane fade text-center"
                    aria-labelledby="stepperFormTrigger4">
                    <div class="col-xs-6 col-sm-6 col-md-12">
                        <div class="form-group">
                            <strong>Atributos:</strong>
                            <select name="atributos[]" id="atributos" class="form-control" multiple="multiple">
                                <!--APPENDED CONTENT HERE-->
                            </select>
                        </div>
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
