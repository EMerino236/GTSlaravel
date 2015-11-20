$( document ).ready(function(){
    
    $('#cod_pat').change(function(){
        search_equipo_ajax();
    });

    $('#btnLimpiar').click(function(){
        limpiar_criterios();
    })
});

function search_equipo_ajax(){
    var val = $("#cod_pat").val(); 
    $.ajax({
        url: inside_url+'retiro_servicio/search_equipo_ajax',
        type: 'POST',
        data: { 'selected_id' : val},
        beforeSend: function(){
            $(".loader_container").show();
        },
        complete: function(){
            $(".loader_container").hide();
        },
        success: function(response){
                console.log(response);
            if(response.success){
                var equipo = response['equipo'];
                if(equipo != null){
                    $("#nombre_equipo").val(equipo.nombre_equipo);
                    $("#servicio_clinico").val(equipo.nombre_servicio);
                    $("#modelo").val(equipo.nombre_modelo);
                    $("#serie").val(equipo.numero_serie);
                    $("#proveedor").val(equipo.razon_social);
                }
                else{
                    $("#nombre_equipo").val("");
                    $("#servicio_clinico").val("");
                    $("#modelo").val("");
                    $("#serie").val("");
                    $("#proveedor").val("");                    
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

function limpiar_criterios(){
    $('#search_ing').val('');
    $('#search_ot').val('');
    $('#search_ubicacion').val('');
    $('#search_equipo').val('');
    $('#search_proveedor').val('');
    $('#search_ini').val('');
    $('#search_fin').val('');
    $('#search_cod_pat').val('');
}