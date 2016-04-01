$( document ).ready(function(){

 	$('#search_datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $('#search_datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });    
    $("#search_datetimepicker1").on("dp.change", function (e) {
        $('#search_datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#search_datetimepicker2").on("dp.change", function (e) {
        $('#search_datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });

 	$('#btnLimpiar').click(function(){
 		$('#search_nombre').val("");
 		$('#search_autor').val("");
 		$('#search_codigo_archivamiento').val("");
 		$('#search_ubicacion').val("");
 		$('#search_tipo_documento').val(0);
 	});

    $('#btnLlimpiar_criterios_list_expediente_tecnico').click(function(){
        $('#search_codigo_compra').val("");
        $('#search_usuario').val("");
        $('#search_fecha_ini').val("");
        $('#search_fecha_fin').val("");
        $('#search_area').val("");
        $('#search_servicio').val("");
    });

    $('#btnLlimpiar_criterios_list_oferta_expediente').click(function(){
        $('#search_codigo_compra').val("");
        $('#search_usuario').val("");
        $('#search_fecha_ini').val("");
        $('#search_fecha_fin').val("");
        $('#search_area').val("");
        $('#search_servicio').val("");
    });

    $('#btnLlimpiar_criterios_list_observacion_expediente').click(function(){
        $('#search_codigo_compra').val("");
        $('#search_usuario').val("");
        $('#search_fecha_ini').val("");
        $('#search_fecha_fin').val("");
        $('#search_area').val("");
        $('#search_servicio').val("");
    });

     $('#btnLlimpiar_criterios_list_oferta_evaluada_expediente').click(function(){
        $('#search_codigo_compra').val("");
        $('#search_usuario').val("");
        $('#search_fecha_ini').val("");
        $('#search_fecha_fin').val("");
        $('#search_area').val("");
        $('#search_servicio').val("");
    });

     $('#btnLlimpiar_criterios_list_cotizaciones').click(function(){
        $('#search_nombre_equipo').val("");
        $('#search_nombre_detallado').val("");
        $('#search_marca').val("");
        $('#search_modelo').val("");
    });

     $('#btnLlimpiar_criterios_list_adjudicacion_expediente').click(function(){
        $('#search_codigo_compra').val("");
        $('#search_usuario').val("");
        $('#search_fecha_ini').val("");
        $('#search_fecha_fin').val("");
        $('#search_area').val("");
        $('#search_servicio').val("");
    });

     $('#btnLlimpiar_criterios_list_especificacion_tecnica').click(function(){
        $('#search_familia_activo').val("");
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

    $('#idservicio').ready(function(){
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
    });

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
    });

    $('#idarea_select').ready(function(){
        var selectArea = document.getElementById("idarea_select");
        var selectedId = selectArea.options[selectArea.selectedIndex].value;// will gives u 2
        if(selectedId != ''){   
            $('#idservicio').prop('disabled','disabled');
            $('input[name=idarea]').val(selectedId);
        }
        else{
            $('#idservicio').prop('disabled',false);
               }
    });

    $('#idtipo_adquisicion_expediente').change(function(){
        var selectTipoAdquisicion = document.getElementById("idtipo_adquisicion_expediente");
        var selectedId = selectTipoAdquisicion.options[selectTipoAdquisicion.selectedIndex].value;// will gives u 2
        if(selectedId != 1){   
            $('#select_nombre_equipo').prop('disabled','disabled');
        }
        else{
            $('#select_nombre_equipo').prop('disabled',false);
               }
    });

    $('#idtipo_adquisicion_expediente').ready(function(){
        var selectTipoAdquisicion = document.getElementById("idtipo_adquisicion_expediente");
        var selectedId = selectTipoAdquisicion.options[selectTipoAdquisicion.selectedIndex].value;// will gives u 2
        if(selectedId != 1){   
            $('#select_nombre_equipo').prop('disabled','disabled');
        }
        else{
            $('#select_nombre_equipo').prop('disabled',false);
               }
    });

    $('#select_nombre_equipo').change(function(){        
        var selectFamiliaActivo = document.getElementById("select_nombre_equipo");        
        var selectedId = selectFamiliaActivo.options[selectFamiliaActivo.selectedIndex].value;// will gives u 2
        if(selectedId != -1 || selectedId == ''){   
            $('#otros_equipos').prop('disabled','disabled');
            $('input[name=nombre_equipo]').val(selectFamiliaActivo.options[selectFamiliaActivo.selectedIndex].text);
        }
        else{
            $('#otros_equipos').prop('disabled',false);
            $('input[name=nombre_equipo]').val('xxxx');
               }
    });

    $('#select_nombre_equipo').ready(function(){        
        var selectFamiliaActivo = document.getElementById("select_nombre_equipo");               
        var selectedId = selectFamiliaActivo.options[selectFamiliaActivo.selectedIndex].value;// will gives u 2
        if(selectedId != -1 || selectedId == ''){   
            $('#otros_equipos').prop('disabled','disabled');
            $('input[name=nombre_equipo]').val(selectFamiliaActivo.options[selectFamiliaActivo.selectedIndex].text);
        }
        else{
            $('#otros_equipos').prop('disabled',false);
            $('input[name=nombre_equipo]').val('xxxx');
               }
    });

     $('#datetimepicker_search_anho').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY'
    });

     $("#submit_finalizar_evaluacion_ofertas").click(function(e){
        e.preventDefault();
        BootstrapDialog.confirm({
                title: 'Mensaje de Confirmación',
                message: '¿Está seguro que desea realizar esta acción? No se podrá agregar más evaluaciones de oferta posteriormente.', 
                type: BootstrapDialog.TYPE_INFO,
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Aceptar', 
                    callback: function(result){
                        if(result){
                            $.ajax({
                                url: inside_url+'oferta_evaluada_expediente/submit_finalizar_evaluacion',
                                type: 'POST',
                                data: { 
                                    'idexpediente_tecnico' : $("input[name=idexpediente_tecnico]").val(),
                                },
                                beforeSend: function(){
                                    //$(this).prop('disabled',true);
                                },
                                complete: function(){
                                    //$(this).prop('disabled',false);
                                },
                                success: function(response){
                                    if(response.success){                                        
                                        BootstrapDialog.alert({
                                            title: 'Mensaje de confirmación',
                                            message: 'Se ha finalizado correctamente la evaluación de Ofertas para este Expediente Técnico.',
                                            callback: function(result){
                                                if(result)
                                                    location.reload();
                                            }
                                        })
                                    }else{
                                        alert('La petición no se pudo completar, inténtelo de nuevo1.');
                                    }
                                },
                                error: function(){
                                    alert('La petición no se pudo completar, inténtelo de nuevo2.');
                                }
                            });
                        }
                    }
        });
    });

    $("#submit_reabrir_evaluacion_ofertas").click(function(e){
        e.preventDefault();
        BootstrapDialog.confirm({
                title: 'Mensaje de Confirmación',
                message: '¿Está seguro que desea realizar esta acción? Se podrá agregar más evaluaciones de oferta posteriormente.', 
                type: BootstrapDialog.TYPE_INFO,
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Aceptar', 
                    callback: function(result){
                        if(result){
                            $.ajax({
                                url: inside_url+'oferta_evaluada_expediente/submit_reabrir_evaluacion',
                                type: 'POST',
                                data: { 
                                    'idexpediente_tecnico' : $("input[name=idexpediente_tecnico]").val(),
                                },
                                beforeSend: function(){
                                    //$(this).prop('disabled',true);
                                },
                                complete: function(){
                                    //$(this).prop('disabled',false);
                                },
                                success: function(response){
                                    if(response.success){                                        
                                        BootstrapDialog.alert({
                                            title: 'Mensaje de confirmación',
                                            message: 'Se ha reabierto correctamente la evaluación de Ofertas para este Expediente Técnico.',
                                            callback: function(result){
                                                if(result)
                                                    location.reload();
                                            }
                                        })                                        
                                    }else{
                                        alert('La petición no se pudo completar, inténtelo de nuevo1.');
                                    }
                                },
                                error: function(){
                                    alert('La petición no se pudo completar, inténtelo de nuevo2.');
                                }
                            });
                        }
                    }
        });
    });

    

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

function llenar_nombre_miembro_comite(tipo_miembro){
    var tipo_miembro_usuario="";
    var val="";
    switch (tipo_miembro) {
        case 1:
            val = $("#usuario_presidente").val();
            tipo_miembro_usuario = "presidente";
            break;
        case 2:
            val = $("#usuario_miembro1").val();
            tipo_miembro_usuario = "miembro1";
            break;
        case 3:
            val = $("#usuario_miembro2").val();
            tipo_miembro_usuario = "miembro2";
            break;
        case 4:
            val = $("#usuario_miembro3").val();
            tipo_miembro_usuario = "miembro3";
            break;
    }

    if(val!=""){
        $.ajax({
            url: inside_url+'miembro_comite/return_nombre_usuario/'+val,
            type: 'POST',
            data: { 'selected_id' : val },
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(response){
                if(response.success){
                    var resp = response['usuario']; 
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_"+tipo_miembro_usuario).val("");
                            $("#nombre_"+tipo_miembro_usuario).css('background-color','#5cb85c');
                            $("#nombre_"+tipo_miembro_usuario).css('color','white');
                            $("#nombre_"+tipo_miembro_usuario).val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=id'+tipo_miembro_usuario+']').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_"+tipo_miembro_usuario).val("Nombre de Usuario incorrecto");
                            $("#nombre_"+tipo_miembro_usuario).css('background-color','#d9534f');
                            $("#nombre_"+tipo_miembro_usuario).css('color','white');
                            $('input[name=id'+tipo_miembro_usuario+']').val('');
                        } 
                    }else{
                        $("#nombre_"+tipo_miembro_usuario).val("Nombre de Usuario incorrecto");
                        $("#nombre_"+tipo_miembro_usuario).css('background-color','#d9534f');
                        $("#nombre_"+tipo_miembro_usuario).css('color','white');
                        $('input[name=id'+tipo_miembro_usuario+']').val('');
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

function limpiar_nombre_miembro_comite(tipo_miembro){    
    var tipo_miembro_usuario="";
    var val="";
    switch (tipo_miembro) {
        case 1:
            val = $("#usuario_presidente").val();
            tipo_miembro_usuario = "presidente";
            break;
        case 2:
            val = $("#usuario_miembro1").val();
            tipo_miembro_usuario = "miembro1";
            break;
        case 3:
            val = $("#usuario_miembro2").val();
            tipo_miembro_usuario = "miembro2";
            break;
        case 4:
            val = $("#usuario_miembro3").val();
            tipo_miembro_usuario = "miembro3";
            break;
    }
    $("#usuario_"+tipo_miembro_usuario).val('');
    $("#nombre_"+tipo_miembro_usuario).val('');
    $("#nombre_"+tipo_miembro_usuario).css('background-color','#eee');
    $('input[name=id'+tipo_miembro_usuario+']').val('');
}

var currentValue = 0;
function handleClick(myRadio) {
    currentValue = myRadio.value;
    $('input[name=idoferta_ganador]').val(currentValue);
}