$( document ).ready(function(){

	$("#datetimepicker1").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker2").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker_create_plan_difusion_ini").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker_create_plan_difusion_fin").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});
});