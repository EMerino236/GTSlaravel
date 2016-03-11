$( document ).ready(function(){

    $('#form').on('submit', function() {
        $('select').prop('disabled', false);
    });

	$("#datetimepicker1").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker2").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
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