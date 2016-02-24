function setLimite(){
	var actividad_previa = $("#actividad_previa :selected").val();
	if(actividad_previa != 0){
		
		$.ajax({
	        url: inside_url + 'trabajo_cronograma/getActividadAjax',
	        type: 'POST',
	        data: { 'id_actividad' : actividad_previa },
	        beforeSend: function(){
	            
	        },
	        complete: function(){

	        },
	        success: function(response){
	            if(response.success)
	            {
	                if(response.actividad.length != 0){
	                	resetDate();
	                	var tomorrow = new Date(response.actividad.fecha_fin);
                        tomorrow.setDate(tomorrow.getDate() + 1);
	                	$('#datetimepicker_crono_act_ini').data("DateTimePicker").minDate(new Date(tomorrow));
	                	console.log(proy_fin);
	                	$('#datetimepicker_crono_act_fin').data("DateTimePicker").maxDate(new Date(proy_fin));
	                }else{
    	                return BootstrapDialog.alert({
		                    title:   'Alerta',
		                    message: 'No se encontro esa actividad.',
		                });
	                }
	            }
	            else
	            {
	                return BootstrapDialog.alert({
	                    title:   'Alerta',
	                    message: 'La petición no se pudo completar, intentelo nuevamente',
	                });
	            }
	        },
	        error: function(){
	            return BootstrapDialog.alert({
	                    title:   'Alerta',
	                    message: 'La petición no se pudo completar, intentelo nuevamente',
	            });
	        }
	    });
	}else{
		resetDate();

		$('#datetimepicker_crono_act_ini').data("DateTimePicker").minDate(new Date(proy_ini));

    	$('#datetimepicker_crono_act_fin').data("DateTimePicker").maxDate(new Date(proy_fin));
	}
}

function resetDate(){
	$('#datetimepicker_crono_act_ini').data("DateTimePicker").minDate(false);
	$('#datetimepicker_crono_act_ini').data("DateTimePicker").maxDate(false);
	$('#datetimepicker_crono_act_fin').data("DateTimePicker").minDate(false);
	$('#datetimepicker_crono_act_fin').data("DateTimePicker").maxDate(false);	
}