$( document ).ready(function(){

 	$('#datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});
    $('#datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });

    $('#marca').change(function(){
        search_equipos_ajax();
    });

    $('#equipo').prop('disabled',true);

});

function search_equipos_ajax(){       
        var val = $('#marca').val();
        if(val == 0){
            $("#equipo").empty();
            $("#equipo").append('<option value='+0+'>Seleccione</option>');
            $('#equipo').prop('disabled',true);
            return;
        }
        $.ajax({
            url: inside_url+'solicitudes_compra/return_equipos',
            type: 'POST',
            data: { 'selected_id' : val },
            beforeSend: function(){
                $("#delete-selected-profiles").addClass("disabled");
                $("#delete-selected-profiles").hide();
                $(".loader_container").show();
            },
            complete: function(){
                $(".loader_container").hide();
                $("#delete-selected-profiles").removeClass("disabled");
                $("#delete-selected-profiles").show();
                delete_selected_profiles = true;
            },
            success: function(response){
                if(response.success){
                    var list_equipos = response['list_equipos'];
                    var tamano = list_equipos.length;
                    $('#equipo').empty();
                    $('#equipo').prop('disabled',false);
                    for(i = 0;i<tamano;i++){
                        $("#equipo").append('<option value='+list_equipos[i].idfamilia_activo+'>'+list_equipos[i].nombre_equipo+'</option>');
                    }                   
                }else{
                    alert('La petición no se pudo completar, inténtelo de nuevo.');
                }
            },
            error: function(){
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        });

}