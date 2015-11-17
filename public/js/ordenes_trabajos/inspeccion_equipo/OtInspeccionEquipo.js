$( document ).ready(function(){
	set_activos_html(document.getElementById("table_equipos").rows.length-1);					
	

	$("input[name=seleccionar]").click(function () {
		id = $('input:radio[name=seleccionar]:checked').val();
		show_equipo(id);
	});  
	
	$("#file-0").fileinput({
        'allowedFileExtensions' : ['jpg', 'png','gif'],
    });
});

function set_activos_html(max){	
	i = 0;
	//funcion para extraer las tareas del equipo
	//for(i=0;i<size_row-1;i++){		
		function getTareas(){
			codigo_patrimonial_selected = $('#cod_pat'+i).html();
			idot_inspeccion_equipo = $('#idot_inspec_equipo').val();
			if(i<max){
				$.ajax({
			        url: inside_url+'inspec_equipos/getTareasInspeccionEquipo',
			        type: 'POST',
			        async: true,	        
			        data: {'codigo_patrimonial_selected': codigo_patrimonial_selected,
			    			'idot_inspec_equipo': idot_inspeccion_equipo},
			        beforeSend: function(){
			            $("#delete-selected-profiles").addClass("disabled");
			            $("#delete-selected-profiles").hide();
			            $(".loader_container").show();
			        },
			        complete: function(){
			            $(".loader_container").hide();
			            $("#delete-selected-profiles").removeClass("disabled");
			            $("#delete-selected-profiles").show();
			            delete_selected_profiles = true;
			        },
			        success: function(response){
			            if(response.success && i<max){
			                         
							html = "<div style=\"visibility:hidden;position:absolute;width:1000px;\"id=\"element"+i+"\">";
							//row para la tabla
							html += "<div class=\"row\">";
							html += "<div class=\"col-md-6 form-group\">";
							html_tabla = "<table  class='table' id=\"element"+i+"\">";
							html_tabla += "<tr class=\"info\"><th>Nombre de Tarea</th><th>Estado</th></tr>";			
							array_tareas = response.tareas;
				            size = array_tareas.length;
				            ajax_html = "";
				            for(j=0;j<size;j++){
				           		ajax_html += "<tr>";
				           		ajax_html += "<td>"+array_tareas[j].nombre+"</td>";
				           		ajax_html += "</tr>";             		
				            }
				            html_tabla +=ajax_html;
				            html_tabla += "</table>";
				            html += html_tabla;
							html += "</div>";
							//poner div para insertar imagen
							html += "<div class=\"col-md-6 form-group\">";
							html += "<div class=\"row form-group\">";
							html += "<div style=\"margin-left:50px;height:300px;width:400px;border-style:solid;\" id=\"element_img"+i+"\">";
							html += "<img id=\"myimage"+i+"\" style=\"height:100%;width:100%;\">";
							html += "</div></div><div class=\"row  form-group\">";
							html += "<div class=\"col-md-8\">";
							//html += "<input id=\"file-0a\" class=\"file\" type=\"file\" multiple data-min-file-count=\"3\" onchange=\"onFileSelected(event,"+i+")\">";
							html += "<form enctype=\"multipart/form-data\"><input id=\"file-0a\" class=\"file\" type=\"file\" multiple data-min-file-count=\"1\"></form>";
							html += "</div></div>";
							html +="</div></div>";
							//fin del row para la tabla
							html += "<div class=\"row\">";
							html += "<div class=\"col-md-6 form-group\">";
							html += "<label >Observaciones</label>";
							html += "<textarea class=\"form-control\" rows=\"5\" id=\"element_obs"+i+"\"></textarea>"
							html += "</div></div></div>";
							$('#body_equipos').append(html);
							i++;
							getTareas();
				                             
			            }else{
			                alert('La petición no se pudo completar, inténtelo de nuevo.');
			            }
			        },
			        error: function(){
			            alert('La petición no se pudo completar, inténtelo de nuevo.');
			        }
			    });
			}
		}
		getTareas();
	
}

function onFileSelected(event,i) {
  var selectedFile = event.target.files[0];
  var reader = new FileReader();

  var imgtag = document.getElementById("myimage"+i);
  imgtag.title = selectedFile.name;

  reader.onload = function(event) {
    imgtag.src = event.target.result;
  };

  reader.readAsDataURL(selectedFile);
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




function addDataTareas(){
	
	
}