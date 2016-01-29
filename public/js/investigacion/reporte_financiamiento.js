$( document ).ready(function(){
	$('#btnAgregarCrono').click(function(){
        var descripcion = $("input[name=descripcion]").val();
        var fecha_ini = $("input[name=fecha_ini]").val();
        var fecha_fin = $("input[name=fecha_fin]").val();
        if(descripcion.length < 1 || fecha_ini.length<1 || fecha_fin.length<1){
        	return BootstrapDialog.alert({
        		title: 	'Alerta',
        		message: 'Debe llenar todos los campos',
        	});
        }

        var str = "<tr><td><input style=\"border:0\" name='descripciones[]' value='"+descripcion+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='fechas_ini[]' value='"+fecha_ini+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='fechas_fin[]' value='"+fecha_fin+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo(".crono_table");

        $("input[name=descripcion]").val('');
        $("input[name=fecha_ini]").val('');
        $("input[name=fecha_fin]").val('');
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

