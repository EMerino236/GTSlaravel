$( document ).ready(function(){
    
	$('#search_datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});
    $('#search_datetimepicker2').datetimepicker({
        //Important! See issue #1075
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

function limpiar_criterios()
{	
	$('#fecha_desde').val("");
	$('#fecha_hasta').val("");
	$('#search_tipo_reporte').prop('selectedIndex','0');
	$('#search_proveedor').prop('selectedIndex','0');
}