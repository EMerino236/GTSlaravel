function validarProyectoInfExiste()
{
    var id_proyecto = $('#id_reporte').val();
    $.ajax({
        url: inside_url + 'informacion_economica/validarProyectoExisteAjax',
        type: 'POST',
        data: { 'id_proyecto' : id_proyecto },
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
                    d = new Date(response.reporte.fecha_ini);
                    $('#fecha_ini').val(d.getDate()+'-'+d.getMonth()+'-'+d.getFullYear());
                    d = new Date(response.reporte.fecha_fin);
                    $('#fecha_fin').val(d.getDate()+'-'+d.getMonth()+'-'+d.getFullYear());

                    $('#rh_inversion').val(response.presupuestos.rh_inversion);
                    $('#eq_inversion').val(response.presupuestos.eq_inversion);
                    $('#go_inversion').val(response.presupuestos.go_inversion);
                    $('#ga_inversion').val(response.presupuestos.ga_inversion);
                    $('#rh_inversion_post').val(response.presupuestos.rh_inversion_post);
                    $('#eq_inversion_post').val(response.presupuestos.eq_inversion_post);
                    $('#go_inversion_post').val(response.presupuestos.go_inversion_post);
                    $('#ga_inversion_post').val(response.presupuestos.ga_inversion_post);

                    var select = document.getElementById("rh_actividad");
                    select.options.length = 0;
                    for(actividad in response.actividades.rh_inversion){
                        select.options[select.options.length] = new Option(response.actividades.rh_inversion[actividad].nombre, response.actividades.rh_inversion[actividad].id);
                    }

                    select = document.getElementById("eq_actividad");
                    select.options.length = 0;
                    for(actividad in response.actividades.eq_inversion){
                        select.options[select.options.length] = new Option(response.actividades.eq_inversion[actividad].nombre, response.actividades.eq_inversion[actividad].id);
                    }

                    select = document.getElementById("go_actividad");
                    select.options.length = 0;
                    for(actividad in response.actividades.go_inversion){
                        select.options[select.options.length] = new Option(response.actividades.go_inversion[actividad].nombre, response.actividades.go_inversion[actividad].id);
                    }

                    select = document.getElementById("ga_actividad");
                    select.options.length = 0;
                    for(actividad in response.actividades.ga_inversion){
                        select.options[select.options.length] = new Option(response.actividades.ga_inversion[actividad].nombre, response.actividades.ga_inversion[actividad].id);
                    }

                    select = document.getElementById("rh_actividad_post");
                    select.options.length = 0;
                    for(actividad in response.actividades.rh_inversion_post){
                        select.options[select.options.length] = new Option(response.actividades.rh_inversion_post[actividad].nombre, response.actividades.rh_inversion_post[actividad].id);
                    }

                    select = document.getElementById("eq_actividad_post");
                    select.options.length = 0;
                    for(actividad in response.actividades.eq_inversion_post){
                        select.options[select.options.length] = new Option(response.actividades.eq_inversion_post[actividad].nombre, response.actividades.eq_inversion_post[actividad].id);
                    }

                    select = document.getElementById("go_actividad_post");
                    select.options.length = 0;
                    for(actividad in response.actividades.go_inversion){
                        select.options[select.options.length] = new Option(response.actividades.go_inversion_post[actividad].nombre, response.actividades.go_inversion_post[actividad].id);
                    }

                    select = document.getElementById("ga_actividad_post");
                    select.options.length = 0;
                    for(actividad in response.actividades.ga_inversion_post){
                        select.options[select.options.length] = new Option(response.actividades.ga_inversion_post[actividad].nombre, response.actividades.ga_inversion_post[actividad].id);
                    }
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

function validaTotalInversionInf(subtotal,disponible){
    console.log("Total:"+disponible+" Subtotal: "+subtotal);
    if(disponible < subtotal)
        return false
    return true;
}

function agregarInfRH(){
    var actividad = $("#rh_actividad :selected");
    var descripcion = $("input[name=rh_descripcion]").val();
    var unidad = $("input[name=rh_unidad]").val();
    var cantidad = parseInt(0+$("input[name=rh_cantidad]").val());
    var costo_unitario = parseFloat(0+$("input[name=rh_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#rh_total").val());   
    
    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#rh_inversion").val());

    if(validaTotalInversionInf(subtotal,disponible)){

        var str = "<tr><td><input class='cell' name='rh_actividades[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfRH(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".rh_table");
        
        var total_inv = parseInt($("#rh_inversion").val());
        $("#rh_inversion").val(total_inv - subtotal);

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

function agregarInfRH_post(){
    var actividad = $("#rh_actividad_post :selected");
    var descripcion = $("input[name=rh_descripcion_post]").val();
    var unidad = $("input[name=rh_unidad_post]").val();
    var cantidad = parseInt(0+$("input[name=rh_cantidad_post]").val());
    var costo_unitario = parseFloat(0+$("input[name=rh_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#rh_total_post").val());   

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#rh_inversion_post").val());

    if(validaTotalInversionInf(subtotal,disponible)){

        var str = "<tr><td><input class='cell' name='rh_actividades_post[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='rh_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfRH_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".rh_table_post");
        
        var total_inv = parseInt($("#rh_inversion_post").val());
        $("#rh_inversion_post").val(total_inv - subtotal);

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

function agregarInfEQ(){
    var actividad = $("#eq_actividad :selected");
    var descripcion = $("input[name=eq_descripcion]").val();
    var unidad = $("input[name=eq_unidad]").val();
    var cantidad = parseInt(0+$("input[name=eq_cantidad]").val());
    var costo_unitario = parseFloat(0+$("input[name=eq_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#eq_total").val());  

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#eq_inversion").val());

    if(validaTotalInversionInf(subtotal,disponible)){

        var str = "<tr><td><input class='cell' name='eq_actividades[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfEQ(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".eq_table");

        var total_inv = parseInt($("#eq_inversion").val());
        $("#eq_inversion").val(total_inv - subtotal);

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

function agregarInfEQ_post(){
    var actividad = $("#eq_actividad_post :selected");
    var descripcion = $("input[name=eq_descripcion_post]").val();
    var unidad = $("input[name=eq_unidad_post]").val();
    var cantidad = parseInt(0+$("input[name=eq_cantidad_post]").val());
    var costo_unitario = parseFloat(0+$("input[name=eq_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#eq_total_post").val());  

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#eq_inversion_post").val());

    if(validaTotalInversionInf(subtotal,disponible)){

        var str = "<tr><td><input class='cell' name='eq_actividades_post[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='eq_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfEQ_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".eq_table_post");

        var total_inv = parseInt($("#eq_inversion_post").val());
        $("#eq_inversion_post").val(total_inv - subtotal);

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

function agregarInfGO(){
    var actividad = $("#go_actividad :selected");
    var descripcion = $("input[name=go_descripcion]").val();
    var unidad = $("input[name=go_unidad]").val();
    var cantidad = parseInt(0+$("input[name=go_cantidad]").val());
    var costo_unitario = parseFloat(0+$("input[name=go_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#go_total").val());
   
    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#go_inversion").val());

    if(validaTotalInversionInf(subtotal,disponible)){

        var str = "<tr><td><input class='cell' name='go_actividades[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='go_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='go_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGO(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".go_table");
        
        var total_inv = parseInt($("#go_inversion").val());
        $("#go_inversion").val(total_inv - subtotal);

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

function agregarInfGO_post(){
    var actividad = $("#go_actividad_post :selected");
    var descripcion = $("input[name=go_descripcion_post]").val();
    var unidad = $("input[name=go_unidad_post]").val();
    var cantidad = parseInt(0+$("input[name=go_cantidad_post]").val());
    var costo_unitario = parseFloat(0+$("input[name=go_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#go_total_post").val());
   
    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#go_inversion_post").val());

    if(validaTotalInversionInf(subtotal,disponible)){

        var str = "<tr><td><input class='cell' name='go_actividades_post[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='go_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='go_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='go_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGO_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".go_table_post");
        
        var total_inv = parseInt($("#go_inversion_post").val());
        $("#go_inversion_post").val(total_inv - subtotal);

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

function agregarInfGA(){
    var actividad = $("#ga_actividad :selected");
    var descripcion = $("input[name=ga_descripcion]").val();
    var unidad = $("input[name=ga_unidad]").val();
    var cantidad = parseInt(0+$("input[name=ga_cantidad]").val());
    var costo_unitario = parseFloat(0+$("input[name=ga_costo_unitario]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#ga_total").val());

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#ga_inversion").val());

    if(validaTotalInversionInf(subtotal, disponible)){

        var str = "<tr><td><input class='cell' name='ga_actividades[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_unidades[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_cantidades[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGA(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".ga_table");
        
        var total_inv = parseInt($("#ga_inversion").val());
        $("#ga_inversion").val(total_inv - subtotal);

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

function agregarInfGA_post(){
    var actividad = $("#ga_actividad_post :selected");
    var descripcion = $("input[name=ga_descripcion_post]").val();
    var unidad = $("input[name=ga_unidad_post]").val();
    var cantidad = parseInt(0+$("input[name=ga_cantidad_post]").val());
    var costo_unitario = parseFloat(0+$("input[name=ga_costo_unitario_post]").val()).toFixed(2);
    var subtotal = costo_unitario*cantidad;
    var total = parseFloat($("#ga_total_post").val());

    if(actividad.length < 1 || descripcion.length < 1 || unidad.length < 1 || cantidad < 1 || costo_unitario < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var disponible = parseFloat($("#ga_inversion_post").val());

    if(validaTotalInversionInf(subtotal, disponible)){

        var str = "<tr><td><input class='cell' name='ga_actividades_post[]' value='"+actividad.text()+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_descripciones_post[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_unidades_post[]' value='"+unidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_cantidades_post[]' value='"+cantidad+"' readonly/></td>";
        str += "<td><input class='cell' name='ga_costos_unitarios_post[]' value='"+costo_unitario+"' readonly/></td>";
        str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGA_post(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".ga_table_post");
        
        var total_inv = parseInt($("#ga_inversion_post").val());
        $("#ga_inversion_post").val(total_inv - subtotal);

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


function deleteRowInfRH(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + parseFloat($('#rh_inversion').val()));
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#rh_total").val());

    $('#rh_inversion').val(total_inversion + subtotal);
    $("#rh_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfRH_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#rh_inversion_post').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#rh_total_post").val());

    $('#rh_inversion_post').val(total_inversion + subtotal);
    $("#rh_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfEQ(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#eq_inversion').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#eq_total").val());

    $('#eq_inversion').val(total_inversion + subtotal);
    $("#eq_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfEQ_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#eq_inversion_post').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#eq_total_post").val());

    $('#eq_inversion_post').val(total_inversion + subtotal);
    $("#eq_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfGO(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#go_inversion').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#go_total").val());

    $('#go_inversion').val(total_inversion + subtotal);
    $("#go_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfGO_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#go_inversion_post').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#go_total_post").val());

    $('#go_inversion_post').val(total_inversion + subtotal);
    $("#go_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfGA(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#ga_inversion').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#ga_total").val());

    $('#ga_inversion').val(total_inversion + subtotal);
    $("#ga_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function deleteRowInfGA_post(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var total_inversion = parseFloat(0 + $('#ga_inversion_post').val());
    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#ga_total_post").val());

    $('#ga_inversion_post').val(total_inversion + subtotal);
    $("#ga_total_post").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}