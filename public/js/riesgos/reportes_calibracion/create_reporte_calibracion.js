$( document ).ready(function(){
    
    $('#btnLimpiar').click(function(){
        $('#codigo_patrimonial').val(null);
        $('#nombre_equipo').val(null);
        $('#area').val(null);
        $('#servicio').val(null);
        $('#grupo').val(null);
    });

    generar_detail_activos();

    $('#btnLimpiarResultados').click(function(){
        limpiar_resultados();
    });

    $('.input-group').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });


});

function save_modal(idactivo){
    //se verifica si se agregaron documentos 
    vacio = true;
    for(i=0;i<10;i++){
        if($('#input-file-'+idactivo+'-'+i).val().length>0){
            vacio = false;
            break;
        }
    }

    message = "";

    if(vacio == true){
        message = 'No se han adjuntado archivos.\n';
    }

    if($('#fecha_calibracion_'+idactivo).val().length==0)
        message += 'El campo Fecha de Calibración es obligatoria.\n';

    if($('#fecha_proximo_'+idactivo).val().length==0)
        message += 'El campo Fecha Próxima de Calibración es obligatoria.\n';

    if(message.length>0){       
        $('#btn_close_'+idactivo).popover("destroy");
        $('#btn_close_'+idactivo).attr("data-content",message);
        $('#btn_close_'+idactivo).popover("show");
    }else{
        $('#modal_'+idactivo).modal('hide');
    }

}

function close_modal(idactivo){
    $('#fecha_calibracion_'+idactivo).val(null);
    $('#fecha_proximo_'+idactivo).val(null);
    $('#input-file-69-0').fileinput({ uploadUrl: "  ",});
    $('#modal_'+idactivo).modal('hide');
   
}

function show_files(event,idactivo){
    event.preventDefault();
    for(i=0;i<10;i+=2){
        if($('#div_file_'+idactivo+'_'+i).css('display') == "none"){
            $('#div_file_'+idactivo+'_'+i).css('display','block');
            $('#div_file_'+idactivo+'_'+(i+1)).css('display','block');
            break;
        }
    }
}

function limpiar_resultados(){
    $("#table_activos tr:not(:first)").remove();
    $(".modal").remove();
    $('.invisible-input').remove();
    $('#cantidad_activos').val(0);
}

function generar_detail_activos(){
    size = document.getElementById('table_activos').rows.length;
    for(i=1;i<size;i++){
        idactivo = document.getElementById('table_activos').rows[i].cells[0].id;
        $('#activos_hidden_inputs').append("<input id=\"input-"+idactivo+"\" style=\"display:inline\" class=\"invisible-input\" name='details_activos[]' value='"+idactivo  +"' readonly/>");
        $('#activos_hidden_inputs').append("<input id=\"input-posicion-"+idactivo+"\" style=\"display:inline\" class=\"invisible-input\" name='details_posiciones[]' value='"+i  +"' readonly/>");
    }
}

function add_modal_documentos(event,idactivo){
    event.preventDefault();
    if($('#modal_'+idactivo).length){
        $('#modal_'+idactivo).modal('show');
    }    
}

function deleteRow(event,el)
{    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    cells = parent.cells;  
    idactivo = cells[0].id;
    parent.parentNode.removeChild(parent);
    /*borramos el modal*/
    //siempre y cuando exista
    if($('#modal_'+idactivo).length){
        element_modal = document.getElementById("modal_"+idactivo);
        element_modal.parentNode.removeChild(element_modal);
    }
    element_input = document.getElementById("input-"+idactivo);
    element_input.parentNode.removeChild(element_input);

    element_input = document.getElementById("input-posicion-"+idactivo);
    element_input.parentNode.removeChild(element_input);

    cantidad_activos = $('#cantidad_activos').val();
    cantidad_activos = parseInt(cantidad_activos)-1;
    $('#cantidad_activos').val(cantidad_activos);
}

function hide_div(event,idactivo,i){
    event.preventDefault();
    $('#div_file_'+idactivo+'_'+i).css('display','none');
}