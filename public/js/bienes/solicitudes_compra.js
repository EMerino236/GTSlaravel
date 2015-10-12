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

    $('#marca1').change(function(){
        search_equipos_ajax(1);
    });

    $('#btnAgregar').click(function(){
        addRowDetalle();
    });

    $('#equipo1').prop('disabled',true);

});

function search_equipos_ajax(id){       
        var val = $('#marca'+id).val();
        if(val == 0){
            $("#equipo"+id).empty();
            $("#equipo"+id).append('<option value='+0+'>Seleccione</option>');
            $('#equipo'+id).prop('disabled',true);
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
                    $('#equipo'+id).prop('disabled',false);
                    $("#equipo"+id).empty();
                    $("#equipo"+id).append('<option value='+0+'>Seleccione</option>');
                    for(i = 0;i<tamano;i++){
                        $("#equipo"+id).append('<option value='+list_equipos[i].idfamilia_activo+'>'+list_equipos[i].nombre_equipo+'</option>');
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

function addRowDetalle(){
    var descripcion = $('#descripcion').val();
    var marca = $('#marca2').val();
    var modelo = $('#nombre_equipo2').val();
    var serie_parte = $('#serie_parte').val();
    var cantidad = $('#cantidad').val();
    var cantidad_filas = $("#table_solicitud tr").length;
    $('#table_solicitud').append("<tr id=\"idRow\">"+
                        '<td>'+descripcion+'</td>'+
                        '<td>'+marca+'</td>'+
                        '<td>'+modelo+'</td>'+
                        '<td>'+serie_parte+'</td>'+
                        '<td>'+cantidad+'</td>'+
                        '<td><a class="btn btn-danger btn-block"  onClick="$(this).closest(\'tr\').remove();" id="btnRemove">Quitar</a></td>'
                        +"</tr>");
}