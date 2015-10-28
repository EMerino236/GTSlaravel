$( document ).ready(function(){
	$("#search_datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#search_datetimepicker2").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	});
});

function limpiar_criterios(){
	$('#fecha_desde').val('');
	$('#fecha_hasta').val('');
	$('#search_tipo_acta').val(0);
	$('#search_proveedor').val(0);
}
