$( document ).ready(function(){

    $("#datetimepicker_desarrollo_ini").on("dp.change", function (e) {
        $('#datetimepicker_desarrollo_fin').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker_desarrollo_fin").on("dp.change", function (e) {
        $('#datetimepicker_desarrollo_ini').data("DateTimePicker").maxDate(e.date);
    });

    $('#datetimepicker_crono_ini').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $('#datetimepicker_crono_fin').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });

    $("#datetimepicker_crono_ini").on("dp.change", function (e) {
        $('#datetimepicker_crono_fin').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker_crono_fin").on("dp.change", function (e) {
        $('#datetimepicker_crono_ini').data("DateTimePicker").maxDate(e.date);
    });

}); 

function agregarProyReq(){
    var requerimiento = $("input[name=requerimiento]").val();
    if(requerimiento.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='requerimientos[]' value='"+requerimiento+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".req_table");
    
    $("input[name=requerimiento]").val('');
}

function agregarProyAsu(){
    var asuncion = $("input[name=asuncion]").val();
    if(asuncion.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='asunciones[]' value='"+asuncion+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".asu_table");
    
    $("input[name=asuncion]").val('');
}

function agregarProyRes(){
    var restriccion = $("input[name=restriccion]").val();
    if(restriccion.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='restricciones[]' value='"+restriccion+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".res_table");
    
    $("input[name=restriccion]").val('');
}

function agregarProyRies(){
    var descripcion = $("input[name=riesgo_desc]").val();
    var tipo = $("input[name=riesgo_tipo]").val();
    if(descripcion.length < 1 || tipo.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='riesgo_descs[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='riesgo_tipos[]' value='"+tipo+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".ries_table");
    
    $("input[name=riesgo_desc]").val('');
    $("input[name=riesgo_tipo]").val('');
}

function agregarProyCrono(){
    var descripcion = $("input[name=crono_desc]").val();
    var fecha_ini = $("input[name=crono_fecha_ini]").val();
    var fecha_fin = $("input[name=crono_fecha_fin]").val();
    if(descripcion.length < 1 || fecha_ini.length < 1 || fecha_fin.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='crono_descs[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='crono_fechas_ini[]' value='"+fecha_ini+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='crono_fechas_fin[]' value='"+fecha_fin+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".crono_table");

    $('#datetimepicker_crono_fin').data("DateTimePicker").minDate(false);
    $('#datetimepicker_crono_fin').data("DateTimePicker").maxDate(false);
    
    $('#datetimepicker_crono_ini').data("DateTimePicker").maxDate(false);
    $('#datetimepicker_crono_ini').data("DateTimePicker").minDate(false);
    
    $("input[name=crono_desc]").val('');
    $("input[name=crono_fecha_ini]").val('');
    $("input[name=crono_fecha_fin]").val('');
}

function agregarProyPre(){
    var descripcion = $("input[name=pre_desc]").val();
    var monto = $("input[name=pre_monto]").val();
    if(descripcion.length < 1 || monto.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='pre_descs[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='pre_montos[]' value='"+monto+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".pre_table");
    
    $("input[name=pre_desc]").val('');
    $("input[name=pre_monto]").val('');
}

function agregarProyPers(){
    var nombre = $("#pers_nombre :selected");
    if(nombre.val().length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" value='"+nombre.text()+"' readonly/><input type='hidden' name='pers_nombres[]' value='"+nombre.val()+"'/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".pers_table");
    
    $("input[name=pers_nombre]").val('');
}

function agregarProyEnt(){
    var entidad = $("input[name=entidad]").val();
    if(entidad.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='entidades[]' value='"+entidad+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".ent_table");
    
    $("input[name=entidad]").val('');
};

function agregarProyApro(){
    var nombre = $("#apro_nombre :selected");
    if(nombre.val().length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" value='"+nombre.text()+"' readonly/><input type='hidden' name='apro_nombres[]' value='"+nombre.val()+"'/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".apro_table");
    
    $("input[name=apro_nombre]").val('');
}

function validarProyecto()
{
    var id_reporte = $('#id_reporte').val();
    $.ajax({
        url: inside_url + 'proyecto/validarProyectoAjax',
        type: 'POST',
        data: { 'id_reporte' : id_reporte },
        beforeSend: function(){
            
        },
        complete: function(){

        },
        success: function(response){
            console.log(response);
            if(response.success)
            {

                if(response.reporte.length != 0){
                    $('#nombre').val(response.reporte.nombre);
                    $('#categoria').val(response.reporte.id_categoria);
                    $('#responsable').val(response.reporte.id_responsable);
                    $('#departamento').val(response.reporte.id_departamento);
                    getServicios();
                    $('#servicio_clinico').val(response.reporte.id_servicio_clinico);
                    //console.log(response.reporte.id_servicio_clinico);
                    $('#fecha_ini').val(response.reporte.fecha_ini);
                    $('#fecha_fin').val(response.reporte.fecha_fin);
                }else{
                    limpiaCamposProyecto();
                    return BootstrapDialog.alert({
                        title:   'Alerta',
                        message: 'No se encontro el proyecto.',
                    });
                }
            }
            else
            {
                limpiaCamposProyecto();
                return BootstrapDialog.alert({
                    title:   'Alerta',
                    message: response.mensaje,
                });
            }
        },
        error: function(){
            limpiaCamposProyecto();
            return BootstrapDialog.alert({
                    title:   'Alerta',
                    message: 'La petición no se pudo completar, intentelo nuevamente',
            });
        }
    });
}

function limpiaCamposProyecto(){
    $('#nombre').val('');
    $('#categoria').val('');
    $('#departamento').val('');
    $('#servicio_clinico').val('');
    $('#responsable').val('');
    $('#fecha_ini').val('');
    $('#fecha_fin').val('');
}

