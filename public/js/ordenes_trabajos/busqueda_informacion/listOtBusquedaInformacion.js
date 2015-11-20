$(document).ready(function(){
    
    $('#search_datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
     $('#btnLimpiar').click(function(){
        limpiar_criterios();
    });
});

function limpiar_criterios(){
    $('#search_tipo').val(0);
    $('#search_area').val(0);
    $('#search_encargado').val('');
    $('#search_ini').val('');
    $('#search_ot').val('');
}