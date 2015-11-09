$( document ).ready(function(){


 	$('#datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});



    fill_responsable_servicio();
    fill_contacto_proveedor();
    fill_name_responsable(1);
    fill_name_responsable(2);
    fill_name_responsable(3);
    fill_name_contrato();
    $('#btn_descarga').hide();

});


function fill_responsable_servicio(){   
        var val = $("#servicio").val();
        if(val == null){
            return;
        }
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
        var val = $("#proveedor").val();
        if(val == null){
            return;
        }
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
        var val = $("#numero_doc"+id).val();
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

function fill_name_contrato(){
        var val = $("#numero_contrato").val();
        if(val=="")
            val = "vacio";    
        $.ajax({
            url: inside_url+'reportes_incumplimiento/return_name_contrato/'+val,
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
                    var resp = response['contrato'];
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_contrato").val("");
                            $("#nombre_contrato").css('background-color','#5cb85c');
                            $("#nombre_contrato").css('color','white');
                            $("#nombre_contrato").val(resp[0].nombre);
                            $("#btn_descarga").show();
                            $("input[name=numero_contrato_hidden]").val(val);
                        }
                        else{
                            $("#nombre_contrato").val("Documento no registrado");
                            $("#nombre_contrato").css('background-color','#d9534f');
                            $("#nombre_contrato").css('color','white');
                            $("#btn_descarga").hide();
                            $("input[name=numero_contrato_hidden]").val(null);

                        } 
                    }else{
                        $("#nombre_contrato").val("Documento no registrado");
                        $("#nombre_contrato").css('background-color','#d9534f');
                        $("#nombre_contrato").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_contrato_hidden]").val(null);
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

function clean_name_contrato(){
    $("#nombre_contrato").val("");
    $("#numero_contrato").val("");
    $("#nombre_contrato").css('background-color','white');
    $("#btn_descarga").hide();
}

function export_pdf(){
    val = 1;
    $.ajax({
            url: inside_url+'reportes_incumplimiento/export_pdf',
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
                    var resp = response['html'];
                    alert(resp);                                   
                }else{
                    alert('La petición no se pudo completar, inténtelo de nuevo.');
                }
            },
            error: function(){
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        });
}

