$( document ).ready(function(){

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

    $("#datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	})
});

function limpiar_criterios(){
	$('#search_ing').val(null);
	$('#search_ot').val(null);
	$('#search_ubicacion').val(null);
	$('#search_equipo').val(null);
	$('#search_proveedor').val(null);
	$('#search_ini').val(null);
	$('#search_fin').val(null);
	$('#search_cod_pat').val(null);
    $('#search_servicio').val(0);
}

function initialize_calendar(programaciones){
	$('.responsive-calendar').responsiveCalendar({
    	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
    	events: programaciones,
    });
}

function eliminar_ot(event,el){
	    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_value = parent.rowIndex-1;
    idot_vmetrologica = $('#fila'+index_value).val();
    BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: '¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
        btnOKLabel: 'Aceptar', 
        callback: function(result){
            if(result) {
            $.ajax({
                url: inside_url+'verif_metrologica/submit_disable_verif_metrologica',
                type: 'POST',
                data: {                
                        'idot_vmetrologica' : idot_vmetrologica,
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
                            var url = inside_url + "verif_metrologica/list_verif_metrologica";
                            $('#btn_close_modal').click(function(){
                                window.location = url;
                            });
                        }
                    }else{
                        alert('La petición no se pudo completar, inténtelo de nuevo1.');
                    }
                },
                error: function(){
                    alert('La petición no se pudo completar, inténtelo de nuevo2.');
                }
            });
            }
        }
    });
    
        
}

