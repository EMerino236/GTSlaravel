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

    $("#datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	})
});

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

function initialize_calendar(programaciones){
	$('.responsive-calendar').responsiveCalendar({
    	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
    	events: programaciones,
    });
}

