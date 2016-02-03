$( document ).ready(function(){

	$('#btnAgregarCrono').click(function(){
        var descripcion = $("input[name=crono_descripcion]").val();
        var fecha_ini = $("input[name=fecha_ini]").val();
        var fecha_fin = $("input[name=fecha_fin]").val();
        var duracion = $("input[name=crono_duracion]").val();
        if(descripcion.length < 1 || fecha_ini.length<1 || fecha_fin.length<1 || duracion.length<1){
        	return BootstrapDialog.alert({
        		title: 	'Alerta',
        		message: 'Debe llenar todos los campos',
        	});
        }

        var str = "<tr><td><input style=\"border:0\" name='crono_descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='fechas_ini[]' value='"+fecha_ini+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='fechas_fin[]' value='"+fecha_fin+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='duraciones[]' value='"+duracion+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
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
});

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