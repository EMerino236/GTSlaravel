$( document ).ready(function(){
	
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
 		$('#search_tipo').val(null);
 		$('#search_usuario').val(null);
 		$('#search_numero_reporte').val(null);
 		$('#search_fecha_ini').val(null);
 		$('#search_fecha_fin').val(null);
 	});
});