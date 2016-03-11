$( document ).ready(function(){

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

});