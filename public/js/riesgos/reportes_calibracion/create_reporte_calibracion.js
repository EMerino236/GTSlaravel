$( document ).ready(function(){
    
    $('#btnLimpiar').click(function(){
        $('#codigo_patrimonial').val(null);
        $('#nombre_equipo').val(null);
        $('#area').val(null);
        $('#servicio').val(null);
        $('#grupo').val(null);
    });

    $('#btnBuscar').click(function(){
        search_activos();
    });

    $('#btnLimpiarResultados').click(function(){
        limpiar_resultados();
    });

});

function limpiar_resultados(){
    $("#table_activos tr:not(:first)").remove();
    $(".modal").remove();
    $('.invisible-input').remove();
    $('#cantidad_activos').val(0);
}

function search_activos(){
    //lectura de los campos
    codigo_patrimonial = $('#codigo_patrimonial').val();
    nombre_equipo = $('#nombre_equipo').val();
    area = $('#area').val();
    servicio = $('#servicio').val();
    grupo = $('#grupo').val();

    limpiar_resultados();
    if(codigo_patrimonial.length==0 && nombre_equipo.length==0 && area=='' &&
        servicio=='' && grupo==''){
        return;
    }

    $.ajax({
        url: inside_url+'reportes_calibracion/search_activos',
        type: 'POST',
        data: { 'codigo_patrimonial' : codigo_patrimonial,
                'nombre_equipo' : nombre_equipo,
                'area': area,
                'servicio': servicio,
                'grupo': grupo
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
                activos = response["activos"];

                if(activos.length>0){
                    tamanho = activos.length;
                    $('#cantidad_activos').val(tamanho);
                    for(i=0;i<tamanho;i++){
                        $('#table_activos').append("<tr>"
                        +"<td class=\"text-nowrap text-center\">"+activos[i].nombre_grupo+"</td>"
                        +"<td class=\"text-nowrap text-center\">"+activos[i].nombre_servicio+"</td>"
                        +"<td class=\"text-nowrap text-center\">"+activos[i].nombre_equipo+"</td>"
                        +"<td class=\"text-nowrap text-center\">"+activos[i].nombre_marca+"</td>"
                        +"<td class=\"text-nowrap text-center\">"+activos[i].modelo+"</td>"
                        +"<td class=\"text-nowrap text-center\" id= \""+activos[i].idactivo+"\">"+activos[i].codigo_patrimonial+"</td>"
                        +"<td class=\"text-nowrap text-center\">"+activos[i].nombre_proveedor+"</td>"
                        +"<td class=\"text-nowrap text-center\"><a href='' class='btn btn-success' onclick='add_modal_documentos(event,"+activos[i].idactivo+")'><span class=\"glyphicon glyphicon-plus\"> </span>Agregar Documentos</a></td>"
                        +"<td class=\"text-nowrap text-center\"><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span></a></td>"
                        +"</tr>");
    
                        $('#activos_hidden_inputs').append("<input class=\"invisible-input\" style=\"display:none;\" name=\""+activos[i].idactivo+"\" type=\"text\" value=\""+activos[i].idactivo+"\" id=\"input-"+activos[i].idactivo+"\">");
                    }                    
                }
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });   
}

function add_modal_documentos(event,idactivo){
    event.preventDefault();
    if($('#modal_'+idactivo).length){
        $('#modal_'+idactivo).modal('show');
    }else{
        var html_modal = '<div class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" id=\"modal_'+idactivo+'\">'+
              "<div class=\"modal-dialog\">"+
                "<div class=\"modal-content\">"+
                  "<div class=\"modal-header bg-primary\">"+
                   " <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+
                    "<h4 class=\"modal-title\">Certificados Anexos</h4>"+
                  "</div>"+
                  "<div class=\"modal-body\"  style=\"width:1000px; overflow: auto;\">"+
                    "<p> Adjunte los documentos relacionados:</p>";
                    for(i=0;i<5;i++){
                        html_docs = "<div class=\"row form-group\">"+
                            "<div class=\"col-md-6\">"+
                            "<label class=\"control-label\">Documento (Certificado,Constancia) N°"+(i+1)+"</label>"+
                            "<input name=\"archivo\" id=\"input-file-"+idactivo+"-"+i+"\" type=\"file\" data-show-upload=\"true\">"+
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
        $('#modal_'+idactivo).modal('show');     
    }
}

function deleteRow(event,el)
{    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    cells = parent.cells;  
    idactivo = cells[5].id;
    parent.parentNode.removeChild(parent);
    /*borramos el modal*/
    //siempre y cuando exista
    if($('#modal_'+idactivo).length){
        element_modal = document.getElementById("modal_"+idactivo);
        element_modal.parentNode.removeChild(element_modal);
    }
    element_input = document.getElementById("input-"+idactivo);
    element_input.parentNode.removeChild(element_input);

    cantidad_activos = $('#cantidad_activos').val();
    cantidad_activos = parseInt(cantidad_activos)-1;
    $('#cantidad_activos').val(cantidad_activos);
}