$( document ).ready(function(){
	$('#btnAgregarFila').click(function(){
        var tarea = $("input[name=nombre_tarea]").val();

        if(tarea.length < 1){
            return alert("Ingrese el nombre de la tarea");
        }

        var str = "<tr><td><input style=\"border:0\" name='tareas[]' value='"+tarea+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
        $("table").append(str);
        
        $("input[name=nombre_tarea]").val('');
	});

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	});
});

function deleteRow(event,el)
{
	event.preventDefault();
	//console.log(el);
	var parent = el.parentNode;
	parent = parent.parentNode;
	parent.parentNode.removeChild(parent);
}

function searchEquipo(el)
{
	cod_patrimonial = el.value;

	$.ajax({
		url: inside_url+'plantillas_servicios/search_equipo_ajax',
		type: 'POST',
		data: { 'selected_id' : cod_patrimonial },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			if(response.equipo){
				$('#nombre').val(response.equipo.nombre_equipo);
				$('#departamento').val(response.equipo.departamento);
				$('#servicio_clinico').val(response.equipo.servicio_clinico);
				$('#grupo').val(response.equipo.grupo);
			}else{
				limpiar_criterios_create();
			}
		},
		error: function(){
		}
	});
}

function limpiar_criterios_create()
{
	$('#nombre').val('');
	$('#departamento').val('');
	$('#servicio_clinico').val('');
	$('#grupo').val('');
}

function limpiar_criterios()
{
	$('#search_nombre').val('');
	$('#search_grupo').val('');
	$('#search_departamento').val('');
	$('#search_usuario').val('');
	$('#search_servicio_clinico').val('');
}

