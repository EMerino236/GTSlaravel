$( document ).ready(function(){

    $('#search_datetimepicker1').datetimepicker({
 		defaultDate: false,
        ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});
    $('#search_datetimepicker2').datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $("#search_datetimepicker1").on("dp.change", function (e) {
        $('#search_datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#search_datetimepicker2").on("dp.change", function (e) {
        $('#search_datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });

    $("#datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

    $('#btnLimpiar').click(function(){
		limpiar_criterios();
	});
});

function limpiar_criterios(){
    $('#search_ing').val('');
    $('#search_ot').val('');
    $('#search_ini').val('');
    $('#search_fin').val('');
}

function eliminar_ot(event,el){
        
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_value = parent.rowIndex-1;
    idot_inspec_equipo = $('#fila'+index_value).val();
    BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: '¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
        btnOKLabel: 'Aceptar', 
        callback: function(result){
            if(result) {
                $.ajax({
                url: inside_url+'inspec_equipos/submit_disable_inspeccion',
                type: 'POST',
                data: {                
                        'idot_inspec_equipo' : idot_inspec_equipo,
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
                        $('#modal_list_header_ot').removeClass();
                        $('#modal_list_header_ot').addClass("modal-header ");
                        $('#modal_list_header_ot').addClass(type_message);
                        $('#modal_text_list_ot').empty();
                        $('#modal_text_list_ot').append("<p>"+message+"</p>");
                        $('#modal_list_ot').modal('show');
                        if(type_message == "bg-success"){
                            var url = inside_url + "inspec_equipos/list_inspec_equipos";
                            $('#btn_close_modal').click(function(){
                                window.location = url;
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