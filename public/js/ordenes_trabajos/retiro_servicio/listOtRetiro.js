$( document ).ready(function(){
    
    
    init_ot_list();

    $('#btnLimpiar').click(function(){
        limpiar_criterios();
    });

});

function init_ot_list(){
    $('#datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $('#datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });
}

function limpiar_criterios(){
    $('#search_ing').val('');
    $('#search_ot').val('');
    $('#search_ubicacion').val('');
    $('#search_equipo').val('');
    $('#search_proveedor').val('');
    $('#search_ini').val('');
    $('#search_fin').val('');
    $('#search_cod_pat').val('');
}