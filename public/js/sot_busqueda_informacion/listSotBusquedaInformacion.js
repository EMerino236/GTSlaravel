$(document).ready(function(){
    
    $('#search_datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $('#search_datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $("#search_datetimepicker1").on("dp.change", function (e) {
        $('#search_datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#search_datetimepicker2").on("dp.change", function (e) {
        $('#search_datetimepicker1').data("DateTimePicker").maxDate(e.date);
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
    $('#search_fin').val('');
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

function eliminar_ot(event,el){
        
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_value = parent.rowIndex-1;
    idot_busqueda = $('#idot_busqueda_info'+index_value).val();
    alert(idot_busqueda);
    BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: '¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
        btnOKLabel: 'Aceptar', 
        callback: function(result){
            if(result) {
                $.ajax({
                    url: inside_url+'busqueda_informacion/submit_disable_busqueda',
                    type: 'POST',
                    data: {                
                            'idot_busqueda_info' : idot_busqueda,
                         },
                    beforeSend: function(){
                        $("#delete-selected-profiles").addClass("disabled");
                        $("#delete-selected-profiles").hide();
                        $(".loader_container").show();
                    },
                    complete: function(){
                        $(".loader_container").hide();
                        $("#delete-selected-profiles").removeClass("disabled");
                        $("#delete-selected-profiles").show();
                        delete_selected_profiles = true;
                    },
                    success: function(response){
                        if(response.success){                    
                            var array_detalle = response["url"];
                            var message = response["message"];
                            var type_message = response["type_message"];
                            var inside_url = array_detalle;
                            if(type_message == "bg-success"){
                               dialog = BootstrapDialog.show({
                                    title: 'Mensaje',
                                    type: BootstrapDialog.TYPE_SUCCESS,
                                    message: 'OT de Búsqueda Anulada',
                                    buttons: [{
                                        label: 'Aceptar',
                                        cssClass: 'btn-default',
                                        action: function() {
                                            var url = inside_url + "solicitud_busqueda_informacion/list_busqueda_informacion";
                                            window.location = url;
                                        }
                                    }]
                                });
                            }
                        }else{
                            alert('La petición no se pudo completar, inténtelo de nuevo.');
                        }
                    },
                    error: function(){
                        alert('La petición no se pudo completar, inténtelo de nuevo.');
                    }
                });
            }
        }
    });
}