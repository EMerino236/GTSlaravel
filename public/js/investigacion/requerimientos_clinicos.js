$( document ).ready(function(){

    $("#datetimepicker_requerimiento_ini").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
    	    //minDate: ayer,
    	    //disabledDates: [ayer]
    });

    $("#datetimepicker_requerimiento_fin").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
    	    //minDate: ayer,
    	    //disabledDates: [ayer]
	});

    $("#datetimepicker_requerimiento_ini").on("dp.change", function(e) {
        $('#datetimepicker_requerimiento_fin').data("DateTimePicker").minDate(e.date);
    });
});

function validarReporte()
{
    
    var id_reporte = $('#id_reporte').val();
    $.ajax({
        url: inside_url + 'requerimientos_clinicos/validarReporteAjax',
        type: 'POST',
        data: { 'id_reporte' : id_reporte },
        beforeSend: function(){
            
        },
        complete: function(){

        },
        success: function(response){                
            if(response.success)
            {
                if(response.reporte.length != 0){
                    $('#nombre').val(response.reporte.nombre);
                    $('#categoria').val(response.reporte.id_categoria);
                    $('#departamento').val(response.reporte.id_departamento);
                    getServicios();
                    $('#servicio_clinico').val(response.reporte.id_servicio_clinico);
                    $('#responsable').val(response.reporte.id_responsable);
                }else{
                    limpiaCampos();
                    return BootstrapDialog.alert({
                        title:   'Alerta',
                        message: 'No se encontro el reporte.',
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
}

function limpiaCampos(){
    $('#nombre').val('');
    $('#categoria').val('');
    $('#departamento').val('');
    $('#servicio_clinico').val('');
    $('#responsable').val('');
}

function limpiar_criterios_req_clinico()
{
  $('#search_nombre').val('');
  $('#search_categoria').val('');
  $('#search_servicio_clinico').val('');
  $('#search_responsable').val('');
  $('#search_departamento').val('');
  $('#search_tipo').val('');
  $('#search_estado').val('');
}