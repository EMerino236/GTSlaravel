$( document ).ready(function(){


 	$('#datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});

    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").minDate(new Date());
    });

    
    

    $('#submit-delete').click(function(){
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById("submitState").submit();
                }
                else{
                    aprobar_postulantes = true;
                }
            }
        }); 
    });


    $('#btnValidate').click(function(){
        numero_ot = $('#numero_ot').val();
        $.ajax({
            url: inside_url+'reportes_incumplimiento/validate_ot',
            type: 'POST',
            data: { 'numero_ot' : numero_ot,
                },
            beforeSend: function(){
                $(".loader_container").show();
            },
            complete: function(){
                $(".loader_container").hide();
            },
            success: function(response){
                if(response.success){
                    validate = response["existe"];
                    if(validate == true){
                        dialog = BootstrapDialog.show({
                            title: 'Mensaje',
                            type: BootstrapDialog.TYPE_SUCCESS,
                            message: 'Orden de Mantenimiento Válida',
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    $('#numero_ot').prop('readonly',true);
                                    dialog.close();
                                }
                            }]
                        });
                        $('#flag_ot').val(2);
                    }else{
                        dialog = BootstrapDialog.show({
                            title: 'Mensaje',                            
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Orden de Mantenimiento No Válida',
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    dialog.close();
                                }
                            }]
                        }); 
                         $('#flag_ot').val(1);
                    }

                }else{
                    alert('La petición no se pudo completar, inténtelo de nuevo.');
                }
            },
            error: function(){
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        });
    });

    $('#btnAddDoc').click(function(){
        var val = $("#numero_contrato").val();
        if(val=="")
            return;  
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
                    if(resp != null){
                        var reporte = response['reporte'];
                        if(reporte == null){
                            $("#nombre_contrato").val("");
                            $("#nombre_contrato").css('background-color','#5cb85c');
                            $("#nombre_contrato").css('color','white');
                            $("#nombre_contrato").val(resp.nombre);
                            $("#btn_descarga").show();
                            $("input[name=numero_contrato_hidden]").val(val);
                            $("#flag_doc").val(1);         
                            $('#numero_contrato').prop('readonly',true); 
                        }else{
                            $("#nombre_contrato").val("Documento ya ha sido tomado");
                            $("#nombre_contrato").css('background-color','#d9534f');
                            $("#nombre_contrato").css('color','white');
                            $("#btn_descarga").hide();
                            $("input[name=numero_contrato_hidden]").val(null);                                
                            $("#flag_doc").val(0);         
                            $('#numero_contrato').prop('readonly',false); 
                        }                       
                    }
                    else{
                        $("#nombre_contrato").val("Documento no es un Contrato de Proveedor");
                        $("#nombre_contrato").css('background-color','#d9534f');
                        $("#nombre_contrato").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_contrato_hidden]").val(null);                                
                        $("#flag_doc").val(0);         
                            $('#numero_contrato').prop('readonly',false); 
                    }                         
                    
                }else{
                    alert('La petición no se pudo completar, inténtelo de nuevo.');
                }
            },
            error: function(){
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        });
    });
    $('#btn_descarga').hide();
    $("input[name=numero_contrato_hidden]").val(null);

    if($('#type_solicitud').val()==1){
        //si es tipo edit
        $('#numero_contrato').prop('readonly',true);
        $('#numero_ot').prop('readonly',true);
        fill_name_contrato_edit();
        fill_responsable_servicio();
        fill_contacto_proveedor();
        fill_name_responsable(1);
        fill_name_responsable(2);
        fill_name_responsable(3);
    }

    

});


function fill_responsable_servicio(){   
        var val = $("#servicio").val();
        if(val == ''){
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
        if(val == ''){
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
            return;
        
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
                    if(resp!=null){
                        if(resp[0] != null){
                            $("#nombre_responsable"+id).val("");
                            $("#nombre_responsable"+id).css('background-color','#5cb85c');
                            $("#nombre_responsable"+id).css('color','white');
                            $("#nombre_responsable"+id).val(resp[0].nombre+" "+resp[0].apellido_pat+" "+resp[0].apellido_mat);
                            $("#numero_doc"+id).prop('readonly',true);
                        }
                        else{
                            $("#nombre_responsable"+id).val("Usuario no registrado");
                            $("#nombre_responsable"+id).css('background-color','#d9534f');
                            $("#nombre_responsable"+id).css('color','white');
                            $("#numero_doc"+id).prop('readonly',false);
                        } 
                    }else{
                        $("#nombre_responsable"+id).val("Usuario no registrado");
                        $("#nombre_responsable"+id).css('background-color','#d9534f');
                        $("#nombre_responsable"+id).css('color','white');
                        $("#numero_doc"+id).prop('readonly',false);
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
    $("#numero_doc"+id).prop('readonly',false);
    $("#nombre_responsable"+id).css('background-color','white');
}

function clean_name_contrato(){
    $("#nombre_contrato").val("");
    $("#numero_contrato").val("");
    $("#nombre_contrato").css('background-color','white');
    $("#btn_descarga").hide();
    $("#flag_doc").val(0);
    $('#numero_contrato').prop('readonly',false);

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

function clean_ot(){
    $('#numero_ot').prop('readonly',false);
    $('#numero_ot').val('');
    $('#flag_ot').val(1);
}

function fill_name_contrato_edit(){
        var val = $("#numero_contrato").val();
        if(val=="")
            return;  
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
                    if(resp != null){
                        $("#nombre_contrato").val("");
                        $("#nombre_contrato").css('background-color','#5cb85c');
                        $("#nombre_contrato").css('color','white');
                        $("#nombre_contrato").val(resp.nombre);
                        $("#btn_descarga").show();
                        $("input[name=numero_contrato_hidden]").val(val);
                        $("#flag_doc").val(1);         
                        $('#numero_contrato').prop('readonly',true);                                             
                    }
                    else{
                        $("#nombre_contrato").val("Documento no es un Contrato de Proveedor");
                        $("#nombre_contrato").css('background-color','#d9534f');
                        $("#nombre_contrato").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_contrato_hidden]").val(null);                                
                        $("#flag_doc").val(0);         
                        $('#numero_contrato').prop('readonly',false); 
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