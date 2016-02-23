$( document ).ready(function(){
	
	$('#btnLimpiar').click(function(){
 		$('#search_codigo_reporte').val(null);
 		$('#search_codigo_patrimonial').val(null);
 		$('#search_grupo').val(null);
 		$('#search_area').val(null);
 		$('#search_servicio').val(null);
        $('#search_nombre_equipo').val(null);
 	});

});

function show_modal_documentos(event,el)
{        
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    cells = parent.cells;
    id_reporte = cells[0].id;
    
    if($('#modal_'+id_reporte).length == 0){

	     $.ajax({
	        url: inside_url+'reportes_calibracion/search_documentos',
	        type: 'POST',
	        data: { 'id_reporte' : id_reporte,
	              },        
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
	            if(response.success){
	                documentos = response["documentos"];
	                size = documentos.length;
	            	var html_modal = '<div class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" id=\"modal_'+id_reporte+'\">'+
	                              "<div class=\"modal-dialog\">"+
	                                "<div class=\"modal-content\">"+
	                                  "<div class=\"modal-header bg-primary\">"+
	                                   " <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+
	                                    "<h4 class=\"modal-title\">Certificados Anexos</h4>"+
	                                  "</div>"+
	                                  "<div class=\"modal-body\"  style=\"width:1000px; overflow: auto;\">"+
	                                    "<p> Documentos relacionados al certificado:</p>";
	                                  for(i=0;i<size;i++){
	                                     html_docs = "<div class=\"row form-group\">"+
	                                            "<div class=\"col-md-5\">"+
	                                            "<label class=\"control-label\">Documento (Certificado o Reporte de Calibración) N°"+(i+1)+"</label>"+
	                                            "<input class=\"form-control text\" value=\""+documentos[i].nombre+"\" readonly></input>"+
	                                            "</div>"+
	                                            "<div class=\"col-md-2\" style=\"margin-top:25px;\">"+	                                            
	                                            "<a class=\"btn btn-success btn-block\" href=\""+inside_url+"reportes_calibracion/download_documento_anexo/"+documentos[i].id+"\" ><span class=\"glyphicon glyphicon-download\"></span> Descargar</a>"+
	                                            "</div>"+
	                                        "</div>"; 
	                                        html_modal += html_docs;
	                                    }
	                                    html_modal += "</div>"+
	                                  "<div class=\"modal-footer\">"+
	                                    "<div class=\"col-md-4 col-md-offset-8\">"+
	                                        "<button type=\"button\" class=\"btn btn-danger btn-block\" data-dismiss=\"modal\"><span class=\"glyphicon glyphicon-remove\"></span>Cerrar</button>"+                    
	                                    "</div>"
	                                  "</div>"+
	                                "</div><!-- /.modal-content -->"+
	                              "</div><!-- /.modal-dialog -->"+
	                            "</div><!-- /.modal -->";
	                    $('#modals').append(html_modal);
	                    $('#modal_'+id_reporte).modal('show');
	            }else{
	                alert('La petición no se pudo completar, inténtelo de nuevo.');
	            }
	        },
	        error: function(){
	            alert('La petición no se pudo completar, inténtelo de nuevo.');
	        }
	    }); 
	}else{
		$('#modal_'+id_reporte).modal('show');
	}  	
}