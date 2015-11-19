$(document).ready(function(){
    $('#search_datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $('#search_datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $("#search_datetimepicker1").on("dp.change", function (e) {
        $('#search_datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#search_datetimepicker2").on("dp.change", function (e) {
        $('#search_datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });

     $('#btnLimpiar').click(function(){
        limpiar_criterios();
    });
});

function limpiar_criterios(){
    $('#search_nombre_equipo').val('');
    $('#search_marca').val(0);
    $('#search_modelo').val('');
    $('#search_proveedor').val('');
    $('#search_codigo_patrimonial').val('');
    $('#search_ini').val('');
    $('#search_fin').val('');
    $('#search_serie').val('');
    $('#search_grupo').val('');
}