$( document ).ready(function(){

    $("#datetimepicker_desarrollo_ini").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
    	    //minDate: ayer,
    	    //disabledDates: [ayer]
    });

    $("#datetimepicker_desarrollo_fin").datetimepicker({
       useCurrent: false,
       defaultDate: false,
       ignoreReadonly: true,
       format: 'DD-MM-YYYY',
    	    //minDate: ayer,
    	    //disabledDates: [ayer]
	});
});