$( document ).ready(function(){
    var menor_fecha = -1;
    var mayor_fecha = -1;
	$('#btnAgregarCrono').click(function(){
        var descripcion = $("input[name=crono_descripcion]").val();
        var fecha_ini = $("input[name=fecha_ini]").val();
        var fecha_fin = $("input[name=fecha_fin]").val();
        
        if(descripcion.length < 1 || fecha_ini.length<1 || fecha_fin.length<1){
        	return BootstrapDialog.alert({
        		title: 	'Alerta',
        		message: 'Debe llenar todos los campos',
        	});
        }

        fecha_ini_date = new Date(fecha_ini.split("-")[2],fecha_ini.split("-")[1],fecha_ini.split("-")[0]);
        fecha_fin_date = new Date(fecha_fin.split("-")[2],fecha_fin.split("-")[1],fecha_fin.split("-")[0]);

        if(menor_fecha == -1 && mayor_fecha == -1){
            menor_fecha = fecha_ini_date;
            mayor_fecha = fecha_fin_date;
            //console.log("Inicializa: menor_fecha="+menor_fecha+" y mayor_fecha="+mayor_fecha);
        }else{
            if((menor_fecha > fecha_ini_date) && (mayor_fecha < fecha_fin_date)){
                menor_fecha = fecha_ini_date;
                mayor_fecha = fecha_fin_date;
                //console.log("Ambas fechas sobrepasan lo previo");
            }else if(menor_fecha > fecha_ini_date){
                menor_fecha = fecha_ini;
                //console.log("Nueva fecha menor: "+menor_fecha);
            }else if(mayor_fecha < fecha_fin_date){
                mayor_fecha = fecha_fin_date;
                //console.log("Nueva fecha mayor: "+mayor_fecha);
            }
        }
        var duracion_total = Date.daysBetween(menor_fecha,mayor_fecha);
        //console.log(duracion_total);
        $('input[name=duracion]').val(duracion_total);

        var duracion = Date.daysBetween(fecha_ini_date,fecha_fin_date);
        

        var str = "<tr><td><input style=\"border:0\" name='crono_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='fechas_ini[]' value='"+fecha_ini+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='fechas_fin[]' value='"+fecha_fin+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='duraciones[]' value='"+duracion+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowCrono(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".crono_table");

        $("input[name=crono_descripcion]").val('');
        $("input[name=fecha_ini]").val('');
        $("input[name=fecha_fin]").val('');
        $("input[name=crono_duracion]").val('');
    });

    $('#btnAgregarInv').click(function(){
      var descripcion = $("input[name=inv_descripcion]").val();
      var costo = parseFloat($("input[name=costo]").val());
      var total = parseFloat($("#total").val());

      if(descripcion.length < 1 || costo.length<1){
         return BootstrapDialog.alert({
            title: 	'Alerta',
            message: 'Debe llenar todos los campos',
        });
     }

     var str = "<tr><td><input style=\"border:0\" name='inv_descripciones[]' value='"+descripcion+"' readonly/></td>";
     str += "<td><input style=\"border:0\" name='costos[]' value='"+costo+"' readonly/></td>";
     str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyPre(event,this)'>Eliminar</a></td></tr>";
     $(str).prependTo(".inv_table");

     $("#total").val(total + costo);
     $("input[name=inv_descripcion]").val('');
     $("input[name=costo]").val('');
    });

    $("#datetimepicker_cronograma_ini").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
       //minDate: ayer,
	    //disabledDates: [ayer]
    });

    $("#datetimepicker_cronograma_fin").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        //minDate: ayer,
	    //disabledDates: [ayer]
	});

    $("#datetimepicker_cronograma_ini").on("dp.change", function(e) {
        $('#datetimepicker_cronograma_fin').data("DateTimePicker").minDate(e.date);
    });
});

Date.daysBetween = function( date1, date2 ) {
    //Get 1 month in milliseconds
    var one_month=1000*60*60*24*30;

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();

    // Calculate the difference in milliseconds
    var difference_ms = date2_ms - date1_ms;

    // Convert back to days and return
    return Math.round(difference_ms/one_month); 
}

function deleteRowCrono(event,el)
{
    menor = -1;
    mayor = -1;
	event.preventDefault();
	var parent = el.parentNode;
	parent = parent.parentNode;
    table = parent.parentNode;
    
    parent.parentNode.removeChild(parent);

    if(table.childNodes.length != 1){
        for(i = 0;i < table.childNodes.length - 1; i++){
            //Fechas iniciales
            fecha_ini = table.childNodes[i].childNodes[1].children[0].value;
            fecha_ini_date = new Date(fecha_ini.split("-")[2],fecha_ini.split("-")[1],fecha_ini.split("-")[0]);
            if(menor == -1){
                menor = fecha_ini_date;
            }else{
                if(fecha_ini_date < menor){
                    menor = fecha_ini_date;
                }
            }
            //Fechas finales
            fecha_fin = table.childNodes[i].childNodes[2].children[0].value;
            fecha_fin_date = new Date(fecha_fin.split("-")[2],fecha_fin.split("-")[1],fecha_fin.split("-")[0]);
            if(mayor == -1){
                mayor = fecha_fin_date;
            }else{
                if(fecha_fin_date > mayor){
                    mayor = fecha_fin_date;
                }
            }
        }

        duracion = Date.daysBetween(menor,mayor);

    }else{
        duracion = 0;
    }
    
    $('input[name=duracion]').val(duracion);
    
}

function deleteRow(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
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

function getTodoServicios()
{
    //console.log(el);
    var id_departamento = 1;

    $.ajax({
        url: inside_url + 'reporte_financiamiento/getTodoServiciosAjax',
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

function limpiar_criterios_reporte_des()
{
    $('#search_nombre').val('');
    $('#search_categoria').val('');
    $('#search_servicio_clinico').val('');
    $('#search_responsable').val('');
    $('#search_departamento').val('');
    $('#search_fecha_ini').val('');
    $('#search_fecha_fin').val('');
  
}

function deleteRowProyPre(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;

    var subtotal = parseFloat(parent.children[1].children[0].value);
    var total = parseFloat($("#total").val());

    $("#total").val(total - subtotal);
    
    parent.parentNode.removeChild(parent);
}