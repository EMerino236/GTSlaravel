$( document ).ready(function(){

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

        var duracion_total = parseInt(0 + $('input[name=duracion]').val());
        var duracion = Date.daysBetween($('#datetimepicker_cronograma_ini').data("DateTimePicker").viewDate()._d,$('#datetimepicker_cronograma_fin').data("DateTimePicker").viewDate()._d);
        $('input[name=duracion]').val(duracion_total + duracion);

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
      var costo = $("input[name=costo]").val();
      if(descripcion.length < 1 || costo.length<1){
         return BootstrapDialog.alert({
            title: 	'Alerta',
            message: 'Debe llenar todos los campos',
        });
     }

     var str = "<tr><td><input style=\"border:0\" name='inv_descripciones[]' value='"+descripcion+"' readonly/></td>";
     str += "<td><input style=\"border:0\" name='costos[]' value='"+costo+"' readonly/></td>";
     str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
     $(str).prependTo(".inv_table");

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
    //Get 1 day in milliseconds
    var one_day=1000*60*60*24*30;

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();

    // Calculate the difference in milliseconds
    var difference_ms = date2_ms - date1_ms;

    // Convert back to days and return
    return Math.round(difference_ms/one_day); 
}

function deleteRowCrono(event,el)
{
	event.preventDefault();
	var parent = el.parentNode;
	parent = parent.parentNode;

    var duracion_total = parseInt(0 + $('input[name=duracion]').val());
    var duracion = parent.childNodes[3].children[0].value;
    $('input[name=duracion]').val(duracion_total - duracion);
	
    parent.parentNode.removeChild(parent);
}

function deleteRow(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
}

function getServicios(el)
{
    //console.log(el);
    var id_departamento = el.value;

    $.ajax({
        url: inside_url + 'reporte_financiamiento/getServiciosAjax',
        type: 'POST',
        data: { 'id_departamento' : id_departamento },
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

function limpiar_criterios_reporte_fin()
{
  $('#search_nombre').val('');
  $('#search_categoria').val('');
  $('#search_servicio_clinico').val('');
  $('#search_responsable').val('');
  $('#search_departamento').val('');
  
}