$( document ).ready(function(){
	init_list();
	$('#btnLimpiar').click(function(){
        limpiar_criterios();
    })
});

function init_list(){
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