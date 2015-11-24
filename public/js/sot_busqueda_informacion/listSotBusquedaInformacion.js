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

    

});

function limpiar_criterios(){
    $('#search_tipo').val(0);
    $('#search_area').val(0);
    $('#search_encargado').val('');
    $('#search_ini').val('');
    $('#search_ot').val('');
}

function setSotId(event,el){    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_selected = parent.rowIndex - 1;
    idsolicitud = $('#idsot'+index_selected).val();
    $("#idsot").val(idsolicitud);
    create_otm();

}

function create_otm(){
    idsolicitud = $('#idsot').val();
    var url = inside_url + "solicitud_busqueda_informacion/list_busqueda_informacion";
    BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: '¿Está seguro que desea realizar esta acción? Una vez registrada la OTM, no se podrá editar la Solicitud de OTM.', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
        btnOKLabel: 'Aceptar', 
        callback: function(result){
            if(result) {
                $.ajax({
                    url: inside_url+'solicitud_busqueda_informacion/submit_create_ot_busqueda_informacion',
                    type: 'POST',
                    data: { 
                        'idsot' : idsolicitud
                    },
                    beforeSend: function(){
                        $(this).prop('disabled',true);
                    },
                    complete: function(){
                        $(this).prop('disabled',false);
                    },
                    success: function(response){
                        var url = inside_url + "solicitud_busqueda_informacion/list_busqueda_informacion";
                        window.location = url;
                    },
                    error: function(){
                    }
                });
            }
        }
    });      
    
}