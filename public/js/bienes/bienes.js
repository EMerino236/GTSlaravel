$( document ).ready(function(){
	$("#datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker2").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	});

    var hoy = new Date();
    var ayer = new Date();
    ayer.setDate(hoy.getDate()-1);
	$(".fecha-hora").datetimepicker({
	    useCurrent: false,
	    defaultDate: false,
	    format: 'DD-MM-YYYY HH:ss',
	    ignoreReadonly: true,
	    minDate: ayer,
	    disabledDates: [ayer]
	});
});
