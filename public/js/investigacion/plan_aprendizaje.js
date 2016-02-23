$( document ).ready(function(){

    $("#datetimepicker_plan").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
        //minDate: ayer,
        //disabledDates: [ayer]
    });
});

function validarProyectoExiste()
{
    var id_proyecto = $('#id_reporte').val();
    $.ajax({
        url: inside_url + 'proyecto/validarProyectoExisteAjax',
        type: 'POST',
        data: { 'id_proyecto' : id_proyecto },
        beforeSend: function(){
            
        },
        complete: function(){

        },
        success: function(response){
            //console.log(response);
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

function agregarPlanAct(){
    var nombre = $("input[name=actividad]").val();
    var descripcion = $("input[name=descripcion]").val();
    var servicio = $("input[name=servicio]").val();
    var fecha = $("input[name=fecha]").val();
    var duracion = $("input[name=duracion]").val();

    if(nombre.length < 1 || descripcion.length < 1 || servicio.length < 1 || fecha.length < 1 || duracion.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input class='cell' name='act_nombres[]' value='"+nombre+"' readonly/></td>";
    str += "<td><input class='cell' name='act_descripciones[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input class='cell' name='act_servicios[]' value='"+servicio+"' readonly/></td>";
    str += "<td><input class='cell' name='act_fechas[]' value='"+fecha+"' readonly/></td>";
    str += "<td><input class='cell' name='act_duraciones[]' value='"+duracion+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".act_table");
    
    $("input[name=actividad]").val('');
    $("input[name=descripcion]").val('');
    $("input[name=servicio]").val('');
    $("input[name=fecha]").val('');
    $("input[name=duracion]").val('');
}

function agregarPlanRec(){
    var competencia_generada = $("input[name=competencia_generada]").val();
    var indicador = $("input[name=indicador]").val();

    if(nombre.length < 1 || descripcion.length < 1 || servicio.length < 1 || fecha.length < 1 || duracion.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input class='cell' name='competencias_generadas[]' value='"+competencia_generada+"' readonly/></td>";
    str += "<td><input class='cell' name='indicadores[]' value='"+indicador+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".rec_table");
    
    $("input[name=competencia_generada]").val('');
    $("input[name=indicador]").val('');
}