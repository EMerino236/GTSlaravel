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

    $("#datetimepicker1").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY HH:ss',
        sideBySide: true
    });

    $("#datetimepicker_cn").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        sideBySide: true
    });
    $("#datetimepicker_etes").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        sideBySide: true
    });
    $("#datetimepicker_paac").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        sideBySide: true
    });

    var ayer = new Date();
    ayer.setDate(new Date().getDate() +1);
    $('#datetimepicker_cotizacion').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY',
        maxDate: ayer
    });

    var ayer = new Date();
    ayer.setDate(new Date().getDate() +1);
    $('#datetimepicker_search_anho1').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY',
        maxDate: ayer
    });
    var ayer = new Date();
    ayer.setDate(new Date().getDate() +1);
    $('#datetimepicker_search_anho2').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY',
        maxDate: ayer
    });

    $('#datetimepicker_search_anho3').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY'
    });
    $('#tipo_referencia').ready(function(){
        $("#enlace_seace").prop('readonly',true);
        $("#codigo_cotizacion").prop('readonly',true);
    });
    
    $('#tipo_referencia').on('change', function(e){
        var selectTipoReporte = document.getElementById("tipo_referencia");
        var selectedId = selectTipoReporte.options[selectTipoReporte.selectedIndex].value;// will gives u 2
        if(selectedId == 1){
            $("#enlace_seace").prop('readonly',true);
            $("#codigo_cotizacion").prop('readonly',false);
        }
        if(selectedId == 2){
            $("#enlace_seace").prop('readonly',false);
            $("#codigo_cotizacion").prop('readonly',true);
        }
        if(selectedId == 0){
            $("#enlace_seace").prop('readonly',true);
            $("#codigo_cotizacion").prop('readonly',true);
        }
    });

    $('#nombre_equipo').on('change', function(e){
        var selectTipoReporte = document.getElementById("nombre_equipo");
        $('#nombre_equipo_string').val(selectTipoReporte.options[selectTipoReporte.selectedIndex].text);        
    });

    $('#idservicio_cn').change(function(){
        var selectServicio = document.getElementById("idservicio_cn");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_area/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['servicio']; 
                        document.getElementById("idarea_select_cn").value = resp[0].idarea;    
                        $('#idarea_select_cn').prop('disabled','disabled');
                        $('input[name=idarea_cn]').val(resp[0].idarea);
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
            $('#idarea_select_cn').prop('disabled',false);
        }
    })

    $('#idarea_select_cn').change(function(){
        var selectArea = document.getElementById("idarea_select_cn");
        var selectedId = selectArea.options[selectArea.selectedIndex].value;// will gives u 2
        if(selectedId != ''){   
            $('#idservicio_cn').prop('disabled','disabled');
            $('input[name=idarea_cn]').val(selectedId);
        }
        else{
            $('#idservicio_cn').prop('disabled',false);
               }
    })

    $('#idservicio_paac').change(function(){
        var selectServicio = document.getElementById("idservicio_paac");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_area/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['servicio']; 
                        document.getElementById("idarea_select_paac").value = resp[0].idarea;    
                        $('#idarea_select_paac').prop('disabled','disabled');
                        $('input[name=idarea_paac]').val(resp[0].idarea);
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
            $('#idarea_select_paac').prop('disabled',false);
        }
    })

    $('#idarea_select_paac').change(function(){
        var selectArea = document.getElementById("idarea_select_paac");
        var selectedId = selectArea.options[selectArea.selectedIndex].value;// will gives u 2
        if(selectedId != ''){   
            $('#idservicio_paac').prop('disabled','disabled');
            $('input[name=idarea_paac]').val(selectedId);
        }
        else{
            $('#idservicio_paac').prop('disabled',false);
        }
    })

    $('#idtipo_reporte').change(function(){
        var selectArea = document.getElementById("idtipo_reporte");
        var selectedId = selectArea.options[selectArea.selectedIndex].value;// will gives u 2
        if(selectedId == 3){   
            $('#codigo_ot_retiro').toggle();
            $('#nombre_equipo').toggle();
            $('#codigo_ot_retiro_label').toggle();
            $('#nombre_equipo_label').toggle();
            $('#btn_agregar').toggle();
            $('#btn_limpiar').toggle();
        }else{
            if($("#codigo_ot_retiro").is(":hidden")){
                $('#codigo_ot_retiro').toggle();
                $('#nombre_equipo').toggle();
                $('#codigo_ot_retiro_label').toggle();
                $('#nombre_equipo_label').toggle();
                $('#btn_agregar').toggle();
                $('#btn_limpiar').toggle();
            }
        }

    })

    $('#idprogramacion_reporte_cn').ready(function(){
        var selectServicio = document.getElementById("idprogramacion_reporte_cn");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_programacion_cn/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['programacion_reporte_cn']; 
                        document.getElementById("idtipo_reporte_select").value = resp[0].idtipo_reporte_CN; 
                        $('input[name=idtipo_reporte]').val(resp[0].idtipo_reporte_CN);   
                        document.getElementById("idservicio").value = resp[0].idservicio;
                        document.getElementById("idarea_select").value = resp[0].idarea;
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
            document.getElementById("idtipo_reporte").value = '';    
            document.getElementById("idservicio").value = '';
            document.getElementById("idarea_select").value = '';
        }
    })

    $('#idprogramacion_reporte_cn').change(function(){
        var selectServicio = document.getElementById("idprogramacion_reporte_cn");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_programacion_cn/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['programacion_reporte_cn']; 
                        document.getElementById("idtipo_reporte_select").value = resp[0].idtipo_reporte_CN; 
                        $('input[name=idtipo_reporte]').val(resp[0].idtipo_reporte_CN);   
                        document.getElementById("idservicio").value = resp[0].idservicio;
                        document.getElementById("idarea_select").value = resp[0].idarea;
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
            document.getElementById("idtipo_reporte").value = '';    
            document.getElementById("idservicio").value = '';
            document.getElementById("idarea_select").value = '';
        }
    })

    $('#idprogramacion_reporte_etes').ready(function(){
        alert("hola");
        var selectServicio = document.getElementById("idprogramacion_reporte_etes");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_programacion_etes/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['programacion_reporte_etes']; 
                        document.getElementById("idtipo_reporte_select").value = resp[0].idtipo_reporte_ETES; 
                        $('input[name=idtipo_reporte]').val(resp[0].idtipo_reporte_ETES);  
                        document.getElementById("nombre").value = resp[0].nombre_reporte;
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
            document.getElementById("idtipo_reporte").value = '';    
            document.getElementById("nombre").value = '';
        }
    })
    
    $('#idprogramacion_reporte_etes').change(function(){
        var selectServicio = document.getElementById("idprogramacion_reporte_etes");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_programacion_etes/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['programacion_reporte_etes']; 
                        document.getElementById("idtipo_reporte_select").value = resp[0].idtipo_reporte_ETES; 
                        $('input[name=idtipo_reporte]').val(resp[0].idtipo_reporte_ETES);  
                        document.getElementById("nombre").value = resp[0].nombre_reporte;
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
            document.getElementById("idtipo_reporte").value = '';    
            document.getElementById("nombre").value = '';
        }
    })

    $('#idprogramacion_reporte_paac').ready(function(){
        var selectServicio = document.getElementById("idprogramacion_reporte_paac");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_programacion_paac/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['programacion_reporte_paac']; 
                        document.getElementById("idtipo_reporte_select").value = resp[0].idtipo_reporte_PAAC; 
                        $('input[name=idtipo_reporte]').val(resp[0].idtipo_reporte_PAAC);   
                        document.getElementById("idservicio").value = resp[0].idservicio;
                        document.getElementById("idarea_select").value = resp[0].idarea;
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
            document.getElementById("idtipo_reporte").value = '';    
            document.getElementById("idservicio").value = '';
            document.getElementById("idarea_select").value = '';
        }
    })

    $('#idprogramacion_reporte_paac').change(function(){
        var selectServicio = document.getElementById("idprogramacion_reporte_paac");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'programacion_reportes/return_programacion_paac/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['programacion_reporte_paac']; 
                        document.getElementById("idtipo_reporte_select").value = resp[0].idtipo_reporte_PAAC; 
                        $('input[name=idtipo_reporte]').val(resp[0].idtipo_reporte_PAAC);   
                        document.getElementById("idservicio").value = resp[0].idservicio;
                        document.getElementById("idarea_select").value = resp[0].idarea;
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
            document.getElementById("idtipo_reporte").value = '';    
            document.getElementById("idservicio").value = '';
            document.getElementById("idarea_select").value = '';
        }
    })    

    $('#btnLlimpiar_criterios_list_cotizaciones').click(function(){
        $("#search_nombre_equipo").val('');
        $("#search_nombre_detallado").val('');
        $("#search_marca").val('');
        $("#search_modelo").val('');
    });

    $('#btnLlimpiar_criterios_list_documentos').click(function(){
        $("#search_tipo_documento").val('');
        $("#search_fecha_ini").val('');
        $("#search_fecha_fin").val('');
    });

    $('#btnLlimpiar_criterios_list_reporte_cn').click(function(){
        $("#search_tipo_reporte_cn").val('');
        $("#search_numero_reporte").val('');
        $("#search_usuario").val('');
        $("#search_fecha").val('');
        $("#search_nombre_equipo").val('');
        $("#search_servicio").val('');
        $("#search_area").val('');
        $("#search_fecha_ini").val('');
        $("#search_fecha_fin").val('');
    });

    $('#btnLlimpiar_criterios_list_reporte_etes').click(function(){
        $("#search_tipo_reporte_etes").val('');
        $("#search_numero_reporte").val('');
        $("#search_usuario").val('');
        $("#search_fecha_ini").val('');
        $("#search_fecha_fin").val('');
    });

    $('#btnLlimpiar_criterios_list_reporte_paac').click(function(){
        $("#search_tipo_reporte_paac").val('');
        $("#search_numero_reporte").val('');
        $("#search_usuario").val('');
        $("#search_servicio").val('');
        $("#search_area").val('');
        $("#search_fecha_ini").val('');
        $("#search_fecha_fin").val('');
    });
});

function llenar_nombre_equipo(){
    var val = $("#codigo_ot_retiro").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'reporte_cn/return_num_ot_retiro/'+val,
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
                            $("#nombre_equipo").val("");
                            $("#nombre_equipo").css('background-color','#5cb85c');
                            $("#nombre_equipo").css('color','white');
                            $("#nombre_equipo").val(resp[0].nombre_equipo);  
                            $('input[name=idot_retiro]').val(resp[0].idot_retiro);                          
                        }
                        else{
                            $("#nombre_equipo").val("Número de reporte incorrecto");
                            $("#nombre_equipo").css('background-color','#d9534f');
                            $("#nombre_equipo").css('color','white');
                        } 
                    }else{
                        $("#nombre_equipo").val("Número de reporte incorrecto");
                        $("#nombre_equipo").css('background-color','#d9534f');
                        $("#nombre_equipo").css('color','white');
                    }               
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

function limpiar_nombre_equipo(){
    $("#codigo_ot_retiro").val('');
}
