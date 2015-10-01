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
});