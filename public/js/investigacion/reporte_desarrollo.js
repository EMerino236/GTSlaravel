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

    $('#btnAgregarInd').click(function(){
        var nombre = $("input[name=ind_nombre]").val();
        var base = $("input[name=ind_base]").val();
        var unidad = $("input[name=ind_unidad]").val();
        var definicion = $("input[name=ind_definicion]").val();
        var verificacion = $("input[name=ind_verificacion]").val();
        
        if(nombre.length < 1 || base.length<1 || unidad.length<1 || definicion.length<1 || verificacion.length<1){
            return BootstrapDialog.alert({
                title:  'Alerta',
                message: 'Debe llenar todos los campos',
            });
        }

        var str = "<tr><td><input class='cell' name='ind_nombres[]' value='"+nombre+"' readonly/></td>";
        str += "<td><input class='cell' name='ind_bases[]' value='"+base+"' readonly/></td>";
        str += "<td><input class='cell' name='ind_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ind_definiciones[]' value='"+definicion+"' readonly/></td>";
        str += "<td><input class='cell' name='ind_verificaciones[]' value='"+verificacion+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".ind_table");

        $("input[name=ind_nombre]").val('');
        $("input[name=ind_base]").val('');
        $("input[name=ind_unidad]").val('');
        $("input[name=ind_definicion]").val('');
        $("input[name=ind_verificacion]").val('');
    });

});

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
                    console.log(response.reporte.id_servicio_clinico);
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