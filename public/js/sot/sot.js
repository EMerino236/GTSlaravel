$( document ).ready(function(){
    $("#datetimepicker1").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY'
    });

    $("#datetimepicker2").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY'
    });

    
    
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
        url: inside_url+'sot/search_equipo_ajax',
        type: 'POST',
        data: { 'selected_id' : val,
            },
        beforeSend: function(){
            $(".loader_container").show();
        },
        complete: function(){
            $(".loader_container").hide();
        },
        success: function(response){
            if(response.success){
                var equipo = response['equipo'];
                if(equipo != null){
                    $("#marca_equipo").val("");
                    $("#marca_equipo").val(equipo.nombre_equipo);
                }
                else{                        
                    $("#marca_equipo").val('');                       
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
    $('#search').val('');
    $('#search_ini').val('');
    $('#search_fin').val('');
    $('#search_estado').val(0);
}