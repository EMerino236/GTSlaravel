$( document ).ready(function(){
    $("#fecha_solicitud").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY'
    });
});