$( document ).ready(function(){
 	$('#datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});
    $('#datetimepicker2').datetimepicker({
        //Important! See issue #1075
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });	
});

function fill_responsable_servicio(){       
        var val = document.getElementById("servicio").value;
        $.ajax({
            url: inside_url+'reportes_incumplimiento/return_resp_servicio/'+val,
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
                    var usuario = response['usuarios_resp'];
                    if(usuario != null){
                        $("#servicio_resp").empty();
                        $("#servicio_resp").val(usuario.nombre+" "+usuario.apellido_pat+
                            " "+usuario.apellido_mat);            
                    }
                    else{
                       $("#servicio_resp").val("");
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

function fill_contacto_proveedor(){       
        var val = document.getElementById("proveedor").value;
        $.ajax({
            url: inside_url+'reportes_incumplimiento/return_contacto_proveedor/'+val,
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
                    var prov = response['proveedor'];
                    if(prov != null){
                        $("#contacto_proveedor").val("");
                        $("#contacto_proveedor").val(prov.nombre_contacto);            
                    }
                    else{
                       $("#contacto_proveedor").val("");
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

function fill_name_responsable(id){
        var val = document.getElementById("numero_doc"+id).value;
        if(val=="")
            val = "vacio";
        
        $.ajax({
            url: inside_url+'reportes_incumplimiento/return_name_responsable/'+val,
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
                    var resp = response['responsable'];
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_responsable"+id).val("");
                            $("#nombre_responsable"+id).css('background-color','#5cb85c');
                            $("#nombre_responsable"+id).css('color','white');
                            $("#nombre_responsable"+id).val(resp[0].nombre+" "+resp[0].apellido_pat+" "+resp[0].apellido_mat);

                        }
                        else{
                            $("#nombre_responsable"+id).val("Usuario no registrado");
                            $("#nombre_responsable"+id).css('background-color','#d9534f');
                            $("#nombre_responsable"+id).css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable"+id).val("Usuario no registrado");
                        $("#nombre_responsable"+id).css('background-color','#d9534f');
                        $("#nombre_responsable"+id).css('color','white');
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

function clean_name_responsable(id){
    $("#nombre_responsable"+id).val("");
    $("#numero_doc"+id).val("");
    $("#nombre_responsable"+id).css('background-color','white');
}