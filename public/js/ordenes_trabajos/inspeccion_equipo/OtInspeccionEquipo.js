$( document ).ready(function(){
	set_activos_html();

	$("input[name=seleccionar]").click(function () {
		id = $('input:radio[name=seleccionar]:checked').val();
		show_equipo(id);
	});  
	

});

function set_activos_html(){
	size_row = document.getElementById("table_equipos").rows.length;
	for(i=0;i<size_row;i++){
		//seteo de la tabla
		/*
		html_tabla = "<table style=\"visibility:hidden;position:absolute;\" class='table' id=\"element"+i+"\">";
		html_tabla += "<tr class=\"info\"><th>Nombre de Tarea</th><th>Estado</th></tr>";
		//html_tabla += addDataTareas(i);
		html_tabla += "</table>";
		$('#table_tareas').append(html_tabla);
		//seteo de la observacion:
		html_observacion = "<label style=\"visibility:hidden;position:absolute;margin-top:300px\" class=\"form-control\" id=\"element_lbl_obs"+i+"\">Observaciones</label>";	 
		html_observacion +="<textarea style=\"visibility:hidden;position:absolute;margin-top:300px\" class=\"form-control\" rows=\"5\" id=\"element_obs"+i+"\"></textarea>"
		$('#observacion').append(html_observacion);
		//seteo de la imagen:
		html_imagen = "<div style=\"visibility:hidden;position:absolute;margin-left:100px;height:300px;width:300px;border-style:solid;\" id=\"element_img"+i+"\"></div>";
		$('#imagen_equipo').append(html_imagen);*/
		//html = "<div class=\"row\">";		
		//div que engloba las tareas del equipo
		html = "<div style=\"visibility:hidden;position:absolute;width:1000px;\"id=\"element"+i+"\">";
		//row para la tabla
		html += "<div class=\"row\">";
		html += "<div class=\"col-md-6 form-group\">";
		html_tabla = "<table  class='table' id=\"element"+i+"\">";
		html_tabla += "<tr class=\"info\"><th>Nombre de Tarea</th><th>Estado</th></tr>";
		//html_tabla += addDataTareas(i);
		html_tabla += "</table>";
		html += html_tabla;
		html += "</div>";
		//poner div para insertar imagen
		html += "<div class=\"col-md-6 form-group\">";
		html += "<div class=\"row\">";
		html += "<div style=\"height:300px;width:300px;border-style:solid;\" id=\"element_img"+i+"\"></div>";
		html += "</div><div class=\"row\">";
		//html += "<div class=\"input-group\"><span class=\"input-group-btn\"><span class=\"btn btn-primary btn-file\">Browse…<input multiple=\"\" type=\"file\"></span></span><input type=\"text\" class=\"form-control\" readonly=\"\"></div>";
		html += "<input type=\"file\">";
		html += "</div>";

		html +="</div>";
		//fin del row para la tabla
		html += "<div class=\"row\">";
		html += "<div class=\"col-md-6 form-group\">";
		html += "<label >Observaciones</label>";
		html += "<textarea class=\"form-control\" rows=\"5\" id=\"element_obs"+i+"\"></textarea>"
		html += "</div></div></div>";


		$('#body_equipos').append(html);
		

	}
}

function show_equipo(id){
	size_row = document.getElementById("table_equipos").rows.length;
	for(i=0;i<size_row-1;i++){
		if(i!=id){
			$('#element'+i).css('visibility','hidden');			
		}else{
			$('#element'+id).css('visibility','visible');
		}
	}
}

function addDataTareas(id){
	//funcion para extraer las tareas del equipo
}