@push('script')

<script>
    var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

function fnc_validate(el){
    el.validate({
    rules: {
      modelo: {
        required: true
      }
    },
    messages: {
      modelo: {
        required: "Informe o modelo do veículo"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
}

$('#modal-replicar').on('show.bs.modal', function (event) {
    let modal = $(this);
    let button = $(event.relatedTarget) ;

    $(this).validate().resetForm();
    $("form[id='reply']")[0].reset();

    modal.find('.modal-body #id').val(button.data('id'));
});

$("form[id='reply']").on('submit', function (e) {
  e.preventDefault();
  fnc_validate($(this));
  var formData = new FormData(this);

    if(!$(this).valid()){
        e.stopPropagation();
    }else{
        $.ajax({
            url: "{{route('veiculos.replicar')}}",
            type: 'POST',
            data: formData,
            success: function (data) {
                // handle success response
                    $('#modal-replicar').modal('hide');
                    $("form[id='reply']").validate().resetForm();
                    $("form[id='reply']")[0].reset();

                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });

                    window.location.href = '/veiculos/configuraratributos/' +  data.id;
            },
            error: function (data) {
                // handle error response
                Toast.fire({
                   type: 'error',
                   title: (data.responseJSON.message) ? data.responseJSON.message : 'Erro ao duplicar o veículo. Contacte o suporte!'
                });
            },
            contentType: false,
            processData: false
        });
    }

});

</script>

@endpush

<div class="modal fade" id="modal-replicar" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" role="form" novalidate="novalidate" id="reply" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Replicar veículo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-xs-6 col-sm-6 col-md-12">
                            <div class="form-group">
                                <strong>Modelo do veículo:</strong>
                                <input type="text" name="modelo" id="modelo" placeholder="Informe o modelo do veículo"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group botao float-right" role="group">
                        <button type="button" class="btn btn-sm btn-danger badge-pill" data-dismiss="modal">
                            <i class="fas fa-times"></i>&nbsp;Cancelar
                        </button>
                    </div>
                    <div class="btn-group botao float-right" role="group">
                        <button type="submit" id="submit" class="btn btn-sm btn-primary badge-pill">
                            <i class="far fa-save"></i>&nbsp;Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
