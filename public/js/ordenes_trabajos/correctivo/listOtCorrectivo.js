$( document ).ready(function(){
	init_list();
	
    $('#btnLimpiar').click(function(){
        limpiar_criterios();
    })

});

function init_list(){
	
    if($('#search_datetimepicker1').length && $('#search_datetimepicker2').length){
        $('#search_datetimepicker1').datetimepicker({
     		ignoreReadonly: true,
     		format:'DD-MM-YYYY'
     	});
        $('#search_datetimepicker2').datetimepicker({
            ignoreReadonly: true,
            format:'DD-MM-YYYY'
        });
        $("#search_datetimepicker1").on("dp.change", function (e) {
            $('#search_datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#search_datetimepicker2").on("dp.change", function (e) {
            $('#search_datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    }    
}

function limpiar_criterios(){
    $('#search_ing').val(null);
    $('#search_ot').val(null);
    $('#search_ubicacion').val(null);
    $('#search_equipo').val(null);
    $('#search_proveedor').val(null);
    $('#search_ini').val(null);
    $('#search_fin').val(null);
    $('#search_cod_pat').val(null);
}