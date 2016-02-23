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

	$('#btnLimpiar').click(function(){
 		$('#search_codigo_reporte_investigacion').val(null);
 		$('#search_codigo_reporte_evento').val(null);
 		$('#search_usuario').val(null);
 		$('#search_entorno_asistencial').val(null);
 		$('#search_fecha_ini').val(null);
 		$('#search_fecha_fin').val(null);
 	});


});

function show_modal(event,idEvento){
    event.preventDefault();
    $.ajax({
        url: inside_url+'reportes_investigacion/show_toma_acciones',
        type: 'POST',
        async: false,
        data: { 'idEvento' : idEvento },
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
                texto = response["texto"];
                dialog = BootstrapDialog.show({
                            title: 'Toma de Acciones del Evento',                            
                            type: BootstrapDialog.TYPE_INFO,
                            message: texto,
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {                                    
                                    dialog.close();
                                }
                            }]
                        }); 
                
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });
}