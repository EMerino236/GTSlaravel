function limpiarCriteriosProgramacionDocente()
{
    $("#search_nombre").val("");
    $("#search_servicio_clinico").val("");
    $("#search_departamento").val("");
    $("#search_responsable").val("");
    $("#search_fecha_ini").val("");
    $("#search_fecha_fin").val("");
}

function validarCapacitacion()
{
    var id_capacitacion = $('#id_capacitacion').val();
    $.ajax({
        url: inside_url + 'programacion_docente/validarCapacitacionAjax',
        type: 'POST',
        data: { 'id_capacitacion' : id_capacitacion },
        beforeSend: function(){
            
        },
        complete: function(){

        },
        success: function(response){
            //console.log(response);
            if(response.success)
            {
                if(response.arr_capacitacion){
                    $('#nombre').val(response.arr_capacitacion.capacitacion.nombre);
                    $('#departamento').val(response.arr_capacitacion.id_departamento);
                    getServicios();
                    $('#servicio_clinico').val(response.arr_capacitacion.capacitacion.id_servicio_clinico);
                    //console.log(response.reporte.id_servicio_clinico);
                    
                    var select = document.getElementById("numero_sesion");
                    select.options.length = 0;
                    for(sesion in response.sesiones){
                        
                        str = response.sesiones[sesion].numero_sesion+" - "+response.sesiones[sesion].fecha;
                        select.options[select.options.length] = new Option(str, response.sesiones[sesion].id);
                    }
                }else{
                    return BootstrapDialog.alert({
                        title:   'Alerta',
                        message: 'No se encontro la capacitación.',
                    });
                }
            }
            else
            {
                return BootstrapDialog.alert({
                    title:   'Alerta',
                    message: response.mensaje,
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

function zero(num) {
    if (num < 10) { return "0" + num; }
    else { return "" + num; }
}