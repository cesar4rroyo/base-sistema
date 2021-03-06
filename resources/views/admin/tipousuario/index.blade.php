@extends("theme.$theme.layout")


@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        @include ('admin.tipousuario.modalAgregar')
        @include ('admin.tipousuario.modalEditar')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tipos Usuario</div>
                <div class="card-body">
                    <button class="btn btn-outline-success" id="btnAddNew" title="Agregar nuevo rol">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </button>
                    <br />
                    <br />
                    <div class="row mb-2" id="btnsReport">
                        <div class="table-responsive mt-4">
                            <table class="table text-center table-hover mt-4" id="tipousuario" class="display"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function(event) {
    //traer los elementos de la tabla
    fetchData();
    //funcion de guardar en la BD el nuevo registro 
    $('#formAgregar').on('submit', function(e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{route('store_tipousuario')}}",
            data: data,
            success: function(data) {
                Hotel.notificaciones(data.message, 'SISTEMA', 'success');
                setTimeout(function() {
                    location.reload();
                }, 1000);
                $('#modalAgregar').modal('toggle');
            },
            error: function(e) {
                if (e.status == 422) {
                    console.log(e.responseJSON.errors);
                    $.each(e.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        //funcion que muestra el error en un toast
                        Hotel.notificaciones(error[0], 'Error!', 'error');
                    });
                } else {
                    Hotel.notificaciones(e.message, 'Error!', 'error');

                }
            }
        })
    });
    //funcion update el registro
    $('#formEditar').on('submit', function(e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{route('update_tipousuario')}}",
            data: data,
            success: function(data) {
                Hotel.notificaciones(data.message, 'SISTEMA', data.type);
                if (data.type != 'error') {
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
                $('#modalEditar').modal('toggle');
            },
            error: function(e) {
                Hotel.notificaciones(e.message, 'Error!', data.type);

            }
        })
    });
    //limpiar el formulario de agregar 
    $('#modalAgregar').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();

    });
    //limpiar el formulario de agregar 
    $('#modalEditar').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .prop("readonly", false)
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        $('#btnActualizar').attr('disabled', false);
    });
    //toggle modal function
    $('#btnAddNew').on('click', function() {
        $('#modalAgregar').modal('toggle');
    });
    //funcion que trae los datos de la tabla  
    function fetchData() {
        fetch("{{route('get_tipo')}}", {
                method: 'GET',
            }).then(res => res.json())
            .then((data) => {
                $('#btnsReport').show();
                var table = $('#tipousuario').DataTable({
                    "language": {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "buttons": {
                            'excel': 'Exportar a Excel',
                            'pdf': 'Exportart a PDF',
                            'print': 'Imprimir'
                        }
                    },
                    "processing": true,
                    'data': data.data,
                    "columns": [{
                            "data": "nombre"
                        },
                        {
                            "data": "acciones"
                        }
                    ],
                    dom: 'lBfrtip',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ],
                    "lengthMenu": [10, 25, 50, 100],
                    "bDestroy": true,
                    "columnDefs": [{
                        "targets": -1,
                        "data": "id",
                        "defaultContent": "<button title='Ver' class='btn btn-outline-secondary btn-sm ver'><i class='fa fa-eye'></i></button><button title='Editar' class='btn btn-outline-primary btn-sm editar'><i class='fas fa-edit'></i></button><button class='btn btn-outline-danger btn-sm eliminar' title='Eliminar'><i class='fas fa-trash-alt'></i></button>"
                    }, ],
                });
                $('#tipousuario tbody').on('click', 'button', function() {
                    var action = this.className;
                    var data = table.row($(this).parents('tr')).data();
                    var id_data = data.id;
                    //opciones ver
                    if (action.includes('ver')) {
                        var urlLocal = "http://localhost/sistema/public/admin/tipousuario/show" +
                            '/' +
                            id_data;
                        location.href = urlLocal;
                        //opcion editar
                    } else if (action.includes('editar')) {
                        $('#modalEditar').modal('toggle');
                        var dataSend = {
                            id: id_data,
                            _token: $('input[name=_token]').val(),
                        };
                        $.ajax({
                            type: 'POST',
                            url: "{{route('edit_tipousuario')}}",
                            data: dataSend,
                            success: function(r) {
                                console.log(r);
                                var rol = r.data;
                                //llenar formulario
                                $.each(rol, function(nombre, data) {
                                    var input = $(document).find('[name="' +
                                        nombre +
                                        '2"]');
                                    input.val(data);
                                });
                                $('#numero_id').val(rol.id);
                            },
                            error: function(e) {
                                console.log(e);
                            }
                        });
                        //opcion eliminar
                    } else if (action.includes('eliminar')) {
                        swal({
                            title: '¿ Está seguro que desea eliminar el registro ?',
                            text: "Si lo elimina ahora ya no lo podrá usar despues!",
                            icon: 'warning',
                            buttons: {
                                cancel: "Cancelar",
                                confirm: "Aceptar"
                            },
                        }).then((value) => {
                            if (value) {
                                var data = {
                                    id: id_data,
                                    _token: $('input[name=_token]').val(),
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: "{{route('destroy_tipousuario')}}",
                                    data: data,
                                    success: function(res) {
                                        Hotel.notificaciones(res.message,
                                            'SISTEMA', res.type);
                                        if (res.type != 'error') {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 1000);
                                        }
                                    },
                                    error: function(e) {
                                        Hotel.notificaciones(e.message, 'ERROR',
                                            'error');
                                    }
                                });
                            }
                        });
                    }
                });
            })
            .catch(e => console.log(e));
    }
});
</script>