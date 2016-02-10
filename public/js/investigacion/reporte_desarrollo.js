$( document ).ready(function(){

    $("#datetimepicker_desarrollo_ini").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
        //minDate: ayer,
    	//disabledDates: [ayer]
    });

    $("#datetimepicker_desarrollo_fin").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
    	//minDate: ayer,
    	//disabledDates: [ayer]
	});

    $("#datetimepicker_desarrollo_ini").on("dp.change", function(e) {
        $('#datetimepicker_desarrollo_fin').data("DateTimePicker").minDate(e.date);
    });

});

function agregaFila(el,id)
{
    str = "input[name=ind_nombre"+id+"]";
    var nombre = $(str).val();
    str = "input[name=ind_base"+id+"]";
    var base = $(str).val();
    str = "input[name=ind_unidad"+id+"]";
    var unidad = $(str).val();
    str = "input[name=ind_definicion"+id+"]";
    var definicion = $(str).val();
    str = "input[name=ind_verificacion"+id+"]";
    var verificacion = $(str).val();
    
    if(nombre.length < 1 || base.length < 1 || unidad.length < 1 || definicion.length < 1 || verificacion.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });
    }

    var str = "<tr><td><input class='cell' name='ind_nombres["+id+"][]' value='"+nombre+"' readonly/></td>";
    str += "<td><input class='cell' name='ind_bases["+id+"][]' value='"+base+"' readonly/></td>";
    str += "<td><input class='cell' name='ind_unidades["+id+"][]' value='"+unidad+"' readonly/></td>";
    str += "<td><input class='cell' name='ind_definiciones["+id+"][]' value='"+definicion+"' readonly/></td>";
    str += "<td><input class='cell' name='ind_verificaciones["+id+"][]' value='"+verificacion+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".ind_table"+id);

    str = "input[name=ind_nombre"+id+"]";
    $(str).val('');
    str = "input[name=ind_base"+id+"]";
    $(str).val('');
    str = "input[name=ind_unidad"+id+"]";
    $(str).val('');
    str = "input[name=ind_definicion"+id+"]";
    $(str).val('');
    str = "input[name=ind_verificacion"+id+"]";
    $(str).val('');
}

function limpiar_criterios_reporte_fin()
{
  $('#search_nombre').val('');
  $('#search_categoria').val('');
  $('#search_servicio_clinico').val('');
  $('#search_responsable').val('');
  $('#search_departamento').val('');
  
}

function validarReporteDesarrollo()
{
    
    var id_reporte = $('#id_reporte').val();
    $.ajax({
        url: inside_url + 'reporte_desarrollo/validarReporteAjax',
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
                    //console.log(response.reporte.id_servicio_clinico);
                    $('#fecha_ini').val(response.reporte.fecha_ini);
                    $('#fecha_fin').val(response.reporte.fecha_fin);
                }else{
                    limpiaCampos();
                    return BootstrapDialog.alert({
                        title:   'Alerta',
                        message: 'No se encontro el proyecto.',
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