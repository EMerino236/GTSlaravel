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
    $('#search_ing').val(null);
    $('#search_ot').val(null);
    $('#search_ubicacion').val(null);
    $('#search_equipo').val(null);
    $('#search_proveedor').val(null);
    $('#search_ini').val(null);
    $('#search_fin').val(null);
    $('#search_cod_pat').val(null);
}