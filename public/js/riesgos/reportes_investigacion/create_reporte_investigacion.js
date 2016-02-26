$( document ).ready(function(){
	
    $('.checkbox-metodo').click(function(){
        val = $(event.target).val();        
        if($('#seleccionado-metodo-'+val).is(":checked")){
            $('#show-browser-'+val).css('display','inline');
        }else
            $('#show-browser-'+val).css('display','none');
    });

  
   

    $('#btnValidate').click(function(){
        codigo_evento = $('#codigo_evento').val();
        validar_evento(codigo_evento);
    });

    $('#btnEnable').click(function(){
         BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById('submit_enable').submit();
                }
            }
        });
    });

    $('#btnDisable').click(function(){
         BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById('submit_disable').submit();
                }
            }
        });
    });

	
});

function validar_evento(codigo_evento){
    if(codigo_evento.length==0)
        return;
    $.ajax({
            url: inside_url+'reportes_investigacion/validate_reporte',
            type: 'POST',
            data: { 'codigo_evento' : codigo_evento,
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
                    evento = response["evento"];
                    if(validate == 2){
                       dialog = BootstrapDialog.show({
                            title: 'Mensaje',
                            type: BootstrapDialog.TYPE_SUCCESS,
                            message: 'Evento Adverso Válido',
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    $('.div_documento').css('display','inline');
                                    $('.checkbox-metodo').prop('disabled',false); 
                                    $('.checkbox-tipo').prop('disabled',false); 
                                    $('#codigo_evento').prop('readonly',true); 
                                    $('#submit-create').prop('disabled',false);
                                    $('#id_evento').val(evento.id);                                 
                                    dialog.close();
                                }
                            }]
                        });
                        $('#flag_evento').val(2);
                    }else if(validate == 0){
                        dialog = BootstrapDialog.show({
                            title: 'Mensaje',                            
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Evento Adverso No Válido',
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    $('.div_documento').css('display','none');  
                                    $('.checkbox-metodo').prop('disabled',true); 
                                    $('.checkbox-tipo').prop('disabled',true);   
                                    $('#codigo_evento').prop('readonly',false);
                                    $('#submit-create').prop('disabled',true); 
                                    $('#id_evento').val(null);
                                    dialog.close();
                                }
                            }]
                        }); 
                        $('#flag_evento').val(1);
                    }else{
                        dialog = BootstrapDialog.show({
                            title: 'Mensaje',                            
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Evento Adverso ya pertenece a otro Reporte de Investigación.',
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    $('.div_documento').css('display','none');  
                                    $('.checkbox-metodo').prop('disabled',true); 
                                    $('.checkbox-tipo').prop('disabled',true);   
                                    $('#codigo_evento').prop('readonly',false);
                                    $('#submit-create').prop('disabled',true); 
                                    $('#id_evento').val(null);
                                    dialog.close();
                                }
                            }]
                        }); 
                        $('#flag_evento').val(1);
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

function clean_evento(){
    $('#codigo_evento').prop('readonly',false);
    $('#codigo_evento').val(null);
    $('.div_documento').css('display','none');  
    $('.checkbox-metodo').prop('disabled',true); 
    $('.checkbox-tipo').prop('disabled',true);
    $('#submit-create').prop('disabled',true); 
    $('#id_evento').val(null);
}