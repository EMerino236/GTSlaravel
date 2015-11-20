$(document).ready(function(){
    
    $('#search_datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $('#search_datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $('#btnLimpiar').click(function(){
        limpiar_criterios();
    }); 

    $('#btnCreate').click(function(){
        create_otm();
    });

});

function limpiar_criterios(){
    $('#search_tipo').val(0);
    $('#search_area').val(0);
    $('#search_encargado').val('');
    $('#search_ini').val('');
    $('#search_ot').val('');
}

function showModal(event,el){    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_selected = parent.rowIndex - 1;
    idsolicitud = $('#idsot'+index_selected).val();
    $('#idsot_modal').val(idsolicitud);
    $('#modal_create_ot').modal('show');
    
}

function create_otm(){
    idsolicitante = $('#solicitantes').val();
    fecha_programacion = $('#fecha_programacion').val();
    idsolicitud = $('#idsot_modal').val();
    $.ajax({
        url: inside_url+'solicitud_busqueda_informacion/submit_create_ot_busqueda_informacion',
        type: 'POST',
        data: { 
            'idsot' : idsolicitud,
            'fecha_programacion' : fecha_programacion,
            'idsolicitante' : idsolicitante
        },
        beforeSend: function(){
            $(this).prop('disabled',true);
        },
        complete: function(){
            $(this).prop('disabled',false);
        },
        success: function(response){
            var url = inside_url + "solicitud_busqueda_informacion/list_busqueda_informacion/";
            window.location = url;
        },
        error: function(){
        }
    });
}