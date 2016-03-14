function limpiarCriteriosProgramacionInternado()
{
    $("#search_nombre").val("");
    $("#search_servicio_clinico").val("");
    $("#search_departamento").val("");
    $("#search_responsable").val("");
    $("#search_fecha_ini").val("");
    $("#search_fecha_fin").val("");
}

function limpiarCriteriosAgregarProgramacionInternado()
{
    $("#nombre").val('');
    $("#departamento").val('');
    $("#servicio_clinico").val('');
    $("#responsable").val('');
    $("#fecha_ini").val('');
    $("#fecha_fin").val('');
    $("#numero_horas").val('');
    $("#numero_internados").val('');
}

function getServiciosProgInter()
{
    var id_departamento = $('#departamento').val();

    $.ajax({
        url: inside_url + 'reporte_financiamiento/getServiciosAjax',
        type: 'POST',
        data: { 'id_departamento' : id_departamento },
        async: false,
        beforeSend: function(){

        },
        complete: function(){

        },
        success: function(response){                
            if(response.success)
            {
                var select = document.getElementById("servicio_clinico");
                select.options.length = 0;
                for(servicio in response.servicios){
                    select.options[select.options.length] = new Option(response.servicios[servicio], servicio);
                }

                getNumeroInternados();
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


function getNumeroInternados()
{
    var servicio = $('#servicio_clinico :selected').val();

    $.ajax({
        url: inside_url + 'programacion_internado/getNumeroInternadosAjax',
        type: 'POST',
        data: { 'id_servicio' : servicio },
        //async: false,
        beforeSend: function(){

        },
        complete: function(){

        },
        success: function(response){                
            if(response.success)
            {
                $('#numero_internados').val(response.numero);
            }
            else
            {
                $('#numero_internados').val(0);
                return BootstrapDialog.alert({
                    title:   'Alerta',
                    message: 'La petición no se pudo completar, intentelo nuevamente',
                });
            }
        },
        error: function(){
            $('#numero_internados').val(0);
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