$( document ).ready(function(){
 	
 	$('#btnLimpiar').click(function(){
 		$('#search_nombre').val("");
 		$('#search_autor').val("");
 		$('#search_codigo_archivamiento').val("");
 		$('#search_ubicacion').val("");
 		$('#search_tipo_documento').val(0);
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

    var ayer = new Date();
    ayer.setDate(new Date().getDate()-1);
    $("#datetimepicker_fecha_inicio_evaluacion").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });

    $("#datetimepicker_fecha_aproximada_adquisicion").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });

    $('#idservicio').change(function(){
        var selectServicio = document.getElementById("idservicio");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_compra/return_area/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['servicio']; 
                        document.getElementById("idarea_select").value = resp[0].idarea;    
                        $('#idarea_select').prop('disabled','disabled');
                        $('input[name=idarea]').val(resp[0].idarea);
                    }else{
                        alert('La petición no se pudo completar, inténtelo de nuevo1.');
                    }
                },
                error: function(){
                    alert('La petición no se pudo completar, inténtelo de nuevo2.');
                }
            }); 
        }
        else{
            $('#idarea_select').prop('disabled',false);
        }
    })

    $('#idarea_select').change(function(){
        var selectArea = document.getElementById("idarea_select");
        var selectedId = selectArea.options[selectArea.selectedIndex].value;// will gives u 2
        if(selectedId != ''){   
            $('#idservicio').prop('disabled','disabled');
            $('input[name=idarea]').val(selectedId);
        }
        else{
            $('#idservicio').prop('disabled',false);
               }
    })
});

function llenar_nombre_responsable(){
    var val = $("#num_doc_responsable").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'programacion_compra/return_num_doc_responsable/'+val,
            type: 'POST',
            data: { 'selected_id' : val },
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(response){
                if(response.success){
                    var resp = response['reporte']; 
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_responsable").val("");
                            $("#nombre_responsable").css('background-color','#5cb85c');
                            $("#nombre_responsable").css('color','white');
                            $("#nombre_responsable").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=idresponsable]').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_responsable").val("Número de documento incorrecto");
                            $("#nombre_responsable").css('background-color','#d9534f');
                            $("#nombre_responsable").css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable").val("Número de documento incorrecto");
                        $("#nombre_responsable").css('background-color','#d9534f');
                        $("#nombre_responsable").css('color','white');
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
}

function limpiar_nombre_responsable(){
    $("#num_doc_responsable").val('');
    $("#nombre_responsable").val('');
    $("#nombre_responsable").css('background-color','#eee');
}

function llenar_nombre_usuario(){
    var val = $("#num_doc_usuario").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'programacion_compra/return_num_doc_usuario/'+val,
            type: 'POST',
            data: { 'selected_id' : val },
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(response){
                if(response.success){
                    var resp = response['reporte']; 
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_usuario").val("");
                            $("#nombre_usuario").css('background-color','#5cb85c');
                            $("#nombre_usuario").css('color','white');
                            $("#nombre_usuario").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=idusuario]').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_usuario").val("Número de documento incorrecto");
                            $("#nombre_usuario").css('background-color','#d9534f');
                            $("#nombre_usuario").css('color','white');
                        } 
                    }else{
                        $("#nombre_usuario").val("Número de documento incorrecto");
                        $("#nombre_usuario").css('background-color','#d9534f');
                        $("#nombre_usuario").css('color','white');
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
}

function limpiar_nombre_usuario(){
    $("#num_doc_usuario").val('');
    $("#nombre_usuario").val('');
    $("#nombre_usuario").css('background-color','#eee');
}