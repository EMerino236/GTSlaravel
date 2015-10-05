function fill_select_servicio_clinico(){       
        var val = document.getElementById("departamento").value;
        $.ajax({
            url: inside_url+'solicitudes_compra/return_servicios/'+val,
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
                    var arreglo_servicios = response['servicios'];
                    var tamano = arreglo_servicios.length;
                    $("#servicio_clinico").empty();
                    $("#servicio_clinico").append('<option value='+0+'>Seleccione</option>');
                    for(i = 0;i<tamano;i++){
                        $("#servicio_clinico").append('<option value='+arreglo_servicios[i].idservicio+'>'+arreglo_servicios[i].nombre+'</option>');
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