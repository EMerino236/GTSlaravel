$( document ).ready(function(){
	init_ot_program();
});

function init_ot_program(){
	$("#datetimepicker_prog_fecha").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'DD-MM-YYYY HH:ss',
            sideBySide: true
    });
}