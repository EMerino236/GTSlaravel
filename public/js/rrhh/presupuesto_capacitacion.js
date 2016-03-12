function limpiarCriteriosPresupuestoCapacitacion()
{
    $("#search_nombre").val("");
    $("#search_tipo").val("");
    $("#search_modalidad").val("");
    $("#search_servicio_clinico").val("");
    $("#search_departamento").val("");
    $("#search_responsable").val("");
}

function validarCapacitacionExiste()
{
    var id_capacitacion = $('#id_capacitacion').val();
    $.ajax({
        url: inside_url + 'presupuesto_capacitacion/validarCapacitacionExisteAjax',
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

                if(response.reporte.length != 0){
                    $('#nombre').val(response.reporte.nombre);
                    $('#tipo').val(response.reporte.id_tipo);
                    $('#modalidad').val(response.reporte.id_modalidad);
                    $('#responsable').val(response.reporte.id_responsable);
                    $('#departamento').val(response.reporte.id_departamento);
                    getServicios();
                    $('#servicio_clinico').val(response.reporte.id_servicio_clinico);
                }else{
                    limpiaCamposCapacitacion();
                    return BootstrapDialog.alert({
                        title:   'Alerta',
                        message: 'No se encontro la capacitacion.',
                    });
                }
            }
            else
            {
                limpiaCamposCapacitacion();
                return BootstrapDialog.alert({
                    title:   'Alerta',
                    message: response.mensaje,
                });
            }
            
        },
        error: function(){
            limpiaCamposCapacitacion();
            return BootstrapDialog.alert({
                    title:   'Alerta',
                    message: 'La petición no se pudo completar, intentelo nuevamente',
            });
        }
    });
}

function getServicios()
{
    //console.log(el);
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

function limpiaCamposCapacitacion(){
    $('#nombre').val('');
    $('#tipo').val('');
    $('#modalidad').val('');
    $('#departamento').val('');
    $('#servicio_clinico').val('');
    $('#responsable').val('');
}

function agregarInfRH(){
    var actividad = $("#rh_actividad").val();
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


	var str = "<tr><td><input class='cell' name='rh_actividades[]' value='"+actividad+"' readonly/></td>";
	str += "<td><input class='cell' name='rh_descripciones[]' value='"+descripcion+"' readonly/></td>";
	str += "<td><input class='cell' name='rh_unidades[]' value='"+unidad+"' readonly/></td>";
	str += "<td><input class='cell' name='rh_cantidades[]' value='"+cantidad+"' readonly/></td>";
	str += "<td><input class='cell' name='rh_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
	str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
	str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfRH(event,this)'>Eliminar</a></td></tr>";
	$(str).prependTo(".rh_table");


    $("#rh_total").val(total + subtotal);
    $("input[name=rh_actividad]").val('');
    $("input[name=rh_descripcion]").val('');
    $("input[name=rh_unidad]").val('');
    $("input[name=rh_cantidad]").val('');
    $("input[name=rh_costo_unitario]").val('');
};

function deleteRowInfRH(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#rh_total").val());

    $("#rh_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function agregarInfEQ(){
    var actividad = $("#eq_actividad").val();
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


    var str = "<tr><td><input class='cell' name='eq_actividades[]' value='"+actividad+"' readonly/></td>";
    str += "<td><input class='cell' name='eq_descripciones[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input class='cell' name='eq_unidades[]' value='"+unidad+"' readonly/></td>";
    str += "<td><input class='cell' name='eq_cantidades[]' value='"+cantidad+"' readonly/></td>";
    str += "<td><input class='cell' name='eq_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
    str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfEQ(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".eq_table");

    $("#eq_total").val(total + subtotal);
    $("input[name=eq_actividad]").val('');
    $("input[name=eq_descripcion]").val('');
    $("input[name=eq_unidad]").val('');
    $("input[name=eq_cantidad]").val('');
    $("input[name=eq_costo_unitario]").val('');
};

function deleteRowInfEQ(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#eq_total").val());

    $("#eq_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function agregarInfGO(){
    var actividad = $("#go_actividad").val();
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


    var str = "<tr><td><input class='cell' name='go_actividades[]' value='"+actividad+"' readonly/></td>";
    str += "<td><input class='cell' name='go_descripciones[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input class='cell' name='go_unidades[]' value='"+unidad+"' readonly/></td>";
    str += "<td><input class='cell' name='go_cantidades[]' value='"+cantidad+"' readonly/></td>";
    str += "<td><input class='cell' name='go_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
    str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGO(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".go_table");
        
    $("#go_total").val(total + subtotal);
    $("input[name=go_actividad]").val('');
    $("input[name=go_descripcion]").val('');
    $("input[name=go_unidad]").val('');
    $("input[name=go_cantidad]").val('');
    $("input[name=go_costo_unitario]").val('');
};

function deleteRowInfGO(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#go_total").val());

    $("#go_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}

function agregarInfGA(){
    var actividad = $("#ga_actividad").val();
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

    var str = "<tr><td><input class='cell' name='ga_actividades[]' value='"+actividad+"' readonly/></td>";
    str += "<td><input class='cell' name='ga_descripciones[]' value='"+descripcion+"' readonly/></td>";
    str += "<td><input class='cell' name='ga_unidades[]' value='"+unidad+"' readonly/></td>";
    str += "<td><input class='cell' name='ga_cantidades[]' value='"+cantidad+"' readonly/></td>";
    str += "<td><input class='cell' name='ga_costos_unitarios[]' value='"+costo_unitario+"' readonly/></td>";
    str += "<td><input class='cell' value='"+subtotal+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGA(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".ga_table");
    
    $("#ga_total").val(total + subtotal);
    $("input[name=ga_actividad]").val('');
    $("input[name=ga_descripcion]").val('');
    $("input[name=ga_unidad]").val('');
    $("input[name=ga_cantidad]").val('');
    $("input[name=ga_costo_unitario]").val('');
};

function deleteRowInfGA(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var subtotal = parseFloat(parent.children[5].children[0].value);
    var total = parseFloat($("#ga_total").val());

    $("#ga_total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}