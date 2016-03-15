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

    if(competencia_generada.length < 1 || indicador.length < 1){
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