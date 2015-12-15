$( document ).ready(function(){
	$('#btnAgregarFila').click(function(){
        var tarea = $("input[name=nombre_tarea]").val();
        var usuario = $("#usuario").val();
        var nombre_usuario = $("#usuario option:selected").text();
        if(tarea.length < 1){
        	return BootstrapDialog.alert({
        		title: 	'Alerta',
        		message: 'Debe ingresar el nombre de una tarea',
        	});
        }

        var str = "<tr><td><input style=\"border:0\" name='tareas[]' value='"+tarea+"' readonly/></td>";
        str += "<td><input style=\"border:0\" value='"+nombre_usuario+"' readonly/><input type=hidden style=\"border:0\" name='usuarios[]' value='"+usuario+"'/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
        $(str).prependTo("table > tbody");

        
        $("input[name=nombre_tarea]").val('');
	});

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	});
});

function deleteRow(event,el,idTarea)
{
	console.log(idTarea);
	event.preventDefault();
	if(idTarea!=null){
		var objTareas = $('input[name=tareas_borradas]').val();
		if(objTareas == ""){
			tareas = [];
		}else{
			tareas = JSON.parse($('input[name=tareas_borradas]').val());
		}
		tareas.push(idTarea);
		
		tareas = JSON.stringify(tareas);
		$('input[name=tareas_borradas]').val(tareas);
	}
	var parent = el.parentNode;
	parent = parent.parentNode;
	parent.parentNode.removeChild(parent);
}

function limpiar_criterios()
{
	$('#search_nombre').val('');
	$('#search_grupo').val('');
	$('#search_departamento').val('');
	$('#search_usuario').val('');
	$('#search_servicio_clinico').val('');
}

function limpiar_criterios_ins_serv()
{
	$('#search_nombre').val('');
	$('#search_marca').val(0);
	
}
