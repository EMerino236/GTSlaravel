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

function agregarProyDesc(){
    var requerimiento = $("input[name=requerimiento]").val();
    var caracteristica = $("input[name=caracteristica]").val();
    if(requerimiento.length < 1 || caracteristica.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='requerimientos[]' value='"+requerimiento+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='caracteristicas[]' value='"+caracteristica+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".desc_table");
    
    $("input[name=requerimiento]").val('');
    $("input[name=caracteristica]").val('');
}

function agregarProyCrit(){
    var criterio = $("input[name=criterio]").val();
    if(criterio.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='criterios[]' value='"+criterio+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".crit_table");
    
    $("input[name=criterio]").val('');
};

function agregarProyEntr(){
    var entregable = $("input[name=entregable]").val();
    if(entregable.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='entregables[]' value='"+entregable+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".ent_table");
    
    $("input[name=entregable]").val('');
};

function agregarProyEx(){
    var exclusion = $("input[name=exclusion]").val();
    if(exclusion.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='exclusiones[]' value='"+exclusion+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".ex_table");
    
    $("input[name=exclusion]").val('');
};

function validaTotalInversion(subtotal){
    var total = parseFloat($("#total_inv").val());
    console.log("Total:"+total+" Subtotal: "+subtotal);
    if(total < subtotal)
        return false
    return true;
}

function agregarProyRH(){
    var actividad = $("input[name=rh_actividad]").val();
    var descripcion = $("input[name=rh_descripcion]").val();
    var unidad = $("input[name=rh_unidad]").val();
    var cantidad = parseInt($("input[name=rh_cantidad]").val());
    var costo_unitario = parseFloat($("input[name=rh_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#rh_total").val());   

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='rh_actividades[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyRH(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".rh_table");
        
        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }

    $("#rh_total").val(total + subtotal);
    $("input[name=rh_actividad]").val('');
    $("input[name=rh_descripcion]").val('');
    $("input[name=rh_unidad]").val('');
    $("input[name=rh_cantidad]").val('');
    $("input[name=rh_costo_unitario]").val('');
};

function agregarProyRH_post(){
    var actividad = $("input[name=rh_actividad_post]").val();
    var descripcion = $("input[name=rh_descripcion_post]").val();
    var unidad = $("input[name=rh_unidad_post]").val();
    var cantidad = parseInt($("input[name=rh_cantidad_post]").val());
    var costo_unitario = parseFloat($("input[name=rh_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#rh_total_post").val());   

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='rh_actividades_post[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyRH_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".rh_table_post");
        
        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }

    $("#rh_total_post").val(total + subtotal);
    $("input[name=rh_actividad_post]").val('');
    $("input[name=rh_descripcion_post]").val('');
    $("input[name=rh_unidad_post]").val('');
    $("input[name=rh_cantidad_post]").val('');
    $("input[name=rh_costo_unitario_post]").val('');
};

function agregarProyEQ(){
    var actividad = $("input[name=eq_actividad]").val();
    var descripcion = $("input[name=eq_descripcion]").val();
    var unidad = $("input[name=eq_unidad]").val();
    var cantidad = parseInt($("input[name=eq_cantidad]").val());
    var costo_unitario = parseFloat($("input[name=eq_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#eq_total").val());  

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='eq_actividades[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyEQ(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".eq_table");

        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }


    $("#eq_total").val(total + subtotal);
    $("input[name=eq_actividad]").val('');
    $("input[name=eq_descripcion]").val('');
    $("input[name=eq_unidad]").val('');
    $("input[name=eq_cantidad]").val('');
    $("input[name=eq_costo_unitario]").val('');
};

function agregarProyEQ_post(){
    var actividad = $("input[name=eq_actividad_post]").val();
    var descripcion = $("input[name=eq_descripcion_post]").val();
    var unidad = $("input[name=eq_unidad_post]").val();
    var cantidad = parseInt($("input[name=eq_cantidad_post]").val());
    var costo_unitario = parseFloat($("input[name=eq_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#eq_total_post").val());  

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='eq_actividades_post[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyEQ_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".eq_table_post");

        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }


    $("#eq_total_post").val(total + subtotal);
    $("input[name=eq_actividad_post]").val('');
    $("input[name=eq_descripcion_post]").val('');
    $("input[name=eq_unidad_post]").val('');
    $("input[name=eq_cantidad_post]").val('');
    $("input[name=eq_costo_unitario_post]").val('');
};

function agregarProyGO(){
    var actividad = $("input[name=go_actividad]").val();
    var descripcion = $("input[name=go_descripcion]").val();
    var unidad = $("input[name=go_unidad]").val();
    var cantidad = parseInt($("input[name=go_cantidad]").val());
    var costo_unitario = parseFloat($("input[name=go_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#go_total").val());
   
    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='go_actividades[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='go_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyGO(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".go_table");
        
        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }

    $("#go_total").val(total + subtotal);
    $("input[name=go_actividad]").val('');
    $("input[name=go_descripcion]").val('');
    $("input[name=go_unidad]").val('');
    $("input[name=go_cantidad]").val('');
    $("input[name=go_costo_unitario]").val('');
};

function agregarProyGO_post(){
    var actividad = $("input[name=go_actividad_post]").val();
    var descripcion = $("input[name=go_descripcion_post]").val();
    var unidad = $("input[name=go_unidad_post]").val();
    var cantidad = parseInt($("input[name=go_cantidad_post]").val());
    var costo_unitario = parseFloat($("input[name=go_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#go_total_post").val());
   
    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='go_actividades_post[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='go_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyGO(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".go_table_post");
        
        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }

    $("#go_total_post").val(total + subtotal);
    $("input[name=go_actividad_post]").val('');
    $("input[name=go_descripcion_post]").val('');
    $("input[name=go_unidad_post]").val('');
    $("input[name=go_cantidad_post]").val('');
    $("input[name=go_costo_unitario_post]").val('');
};

function agregarProyGA(){
    var actividad = $("input[name=ga_actividad]").val();
    var descripcion = $("input[name=ga_descripcion]").val();
    var unidad = $("input[name=ga_unidad]").val();
    var cantidad = parseInt($("input[name=ga_cantidad]").val());
    var costo_unitario = parseFloat($("input[name=ga_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#ga_total").val());

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='ga_actividades[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyGA(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".ga_table");
        
        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }

    $("#ga_total").val(total + subtotal);
    $("input[name=ga_actividad]").val('');
    $("input[name=ga_descripcion]").val('');
    $("input[name=ga_unidad]").val('');
    $("input[name=ga_cantidad]").val('');
    $("input[name=ga_costo_unitario]").val('');
};

function agregarProyGA_post(){
    var actividad = $("input[name=ga_actividad_post]").val();
    var descripcion = $("input[name=ga_descripcion_post]").val();
    var unidad = $("input[name=ga_unidad_post]").val();
    var cantidad = parseInt($("input[name=ga_cantidad_post]").val());
    var costo_unitario = parseFloat($("input[name=ga_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#ga_total_post").val());

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad.length < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    if(validaTotalInversion(subtotal)){

        var str = "<tr><td><input class='cell' name='ga_actividades_post[]' value='"+actividad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyGA_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".ga_table_post");
        
        var total_inv = parseInt($("#total_inv").val());
        $("#total_inv").val(total_inv - subtotal);

    }else{
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Se sobrepaso el presupuesto de inversión',
        });  
    }

    $("#ga_total_post").val(total + subtotal);
    $("input[name=ga_actividad_post]").val('');
    $("input[name=ga_descripcion_post]").val('');
    $("input[name=ga_unidad_post]").val('');
    $("input[name=ga_cantidad_post]").val('');
    $("input[name=ga_costo_unitario_post]").val('');
};

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

function deleteRowProyRH(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + parseFloat($('#total_inv').val()));
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#rh_total").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#rh_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyRH_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#rh_total_post").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#rh_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyEQ(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#eq_total").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#eq_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyEQ_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#eq_total_post").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#eq_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyGO(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#go_total").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#go_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyGO_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#go_total_post").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#go_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyGA(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#ga_total").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#ga_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowProyGA_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#total_inv').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#ga_total_post").val());

    $('#total_inv').val(total_inversion + subtotal);
    $("#ga_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}
