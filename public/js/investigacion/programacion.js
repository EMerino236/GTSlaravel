$( document ).ready(function(){
    $('#datetimepicker_search_anho3').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY'
    });

    var ayer = new Date();
    ayer.setDate(new Date().getDate()-1);
    $("#datetimepicker_ts").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });
    $("#datetimepicker_etes").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });
    $("#datetimepicker_gpc").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });
});