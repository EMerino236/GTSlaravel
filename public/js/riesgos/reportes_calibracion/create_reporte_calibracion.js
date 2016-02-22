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

});

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

    cantidad_activos = $('#cantidad_activos').val();
    cantidad_activos = parseInt(cantidad_activos)-1;
    $('#cantidad_activos').val(cantidad_activos);
}