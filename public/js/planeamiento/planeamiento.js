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

    var ayer = new Date();
    ayer.setDate(new Date().getDate()-1);
    $("#datetimepicker_cn").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });
    $("#datetimepicker_etes").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });
    $("#datetimepicker_paac").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
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

    $('#idservicio_rp').change(function(){
        var selectServicio = document.getElementById("idservicio_rp");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'reporte_priorizacion/return_area/'+selectedId,
                type: 'POST',
                data: { 'selected_id' : selectedId },
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function(response){
                    if(response.success){
                        var resp = response['servicio']; 
                        document.getElementById("idarea_select_rp").value = resp[0].idarea;    
                        $('#idarea_select_rp').prop('disabled','disabled');
                        $('input[name=idarea_rp]').val(resp[0].idarea);
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
            $('#idarea_select_rp').prop('disabled',false);
        }
    })

    $('#idarea_select_rp').change(function(){
        var selectArea = document.getElementById("idarea_select_rp");
        var selectedId = selectArea.options[selectArea.selectedIndex].value;// will gives u 2
        if(selectedId != ''){   
            $('#idservicio_rp').prop('disabled','disabled');
            $('input[name=idarea_rp]').val(selectedId);
        }
        else{
            $('#idservicio_rp').prop('disabled',false);
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
                        $("#responsable").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);
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
                        $("#responsable").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);
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
                        $("#responsable").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);
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
                        $("#responsable").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);
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
/*
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href") // activated tab
      alert(target);
    });
*/
    $("a[href=#tab_reporte_cn]").click(function()
    {
      document.getElementById("idtipo_reporte_cn").value = '';  
      document.getElementById("idservicio_cn").value = '';
      document.getElementById("idarea_select_cn").value = '';
      $("#idarea_cn").val('');
      $("#nombre_cn").val('');
      $("#fecha_cn").val('');
    });

    $("a[href=#tab_reporte_paac]").click(function()
    {
      document.getElementById("idtipo_reporte_paac").value = '';  
      document.getElementById("idservicio_paac").value = '';
      document.getElementById("idarea_select_paac").value = '';
      $("#idarea_paac").val('');
      $("#nombre_paac").val('');
      $("#fecha_paac").val('');
    });

    $("#label_agregar_etes").click(function(){
        $("#div_etes3").toggle();
        $("#div_etes4").toggle();
        $("#div_etes5").toggle();
        if($("#div_etes3").is(":visible"))
           $("#label_agregar_etes").text("Quitar Reportes ETES vinculados");
        else{
            $("#label_agregar_etes").text("Agregar más Reportes ETES vinculados");
            $("#codigo_reporte_etes3").val("");
            $("#codigo_reporte_etes3").css('color','black');
            $("#codigo_reporte_etes3").css('background-color','white');
            $('input[name=idreporte_etes3]').val(''); 
            $("#codigo_reporte_etes4").val("");
            $("#codigo_reporte_etes4").css('color','black');
            $("#codigo_reporte_etes4").css('background-color','white');
            $('input[name=idreporte_etes4]').val(''); 
            $("#codigo_reporte_etes5").val("");
            $("#codigo_reporte_etes5").css('color','black');
            $("#codigo_reporte_etes5").css('background-color','white');
            $('input[name=idreporte_etes5]').val(''); 
        }
    })

    $("#label_agregar_cn").click(function(){
        $("#div_cn3").toggle();
        $("#div_cn4").toggle();
        $("#div_cn5").toggle();
        if($("#div_cn3").is(":visible"))
           $("#label_agregar_cn").text("Quitar Reportes de Necesidad vinculados");
        else {
            $("#label_agregar_cn").text("Agregar más Reportes de Necesidad vinculados");
            $("#codigo_reporte_cn3").val("");
            $("#codigo_reporte_cn3").css('color','black');
            $("#codigo_reporte_cn3").css('background-color','white');
            $('input[name=idreporte_cn3]').val(''); 
            $("#codigo_reporte_cn4").val("");
            $("#codigo_reporte_cn4").css('color','black');
            $("#codigo_reporte_cn4").css('background-color','white');
            $('input[name=idreporte_cn4]').val(''); 
            $("#codigo_reporte_cn5").val("");
            $("#codigo_reporte_cn5").css('color','black');
            $("#codigo_reporte_cn5").css('background-color','white');
            $('input[name=idreporte_cn5]').val(''); 
        }
    })

    $("#label_agregar_cn_paac").click(function(){
        $("#div_cn_paac3").toggle();
        $("#div_cn_paac4").toggle();
        $("#div_cn_paac5").toggle();
        if($("#div_cn_paac3").is(":visible"))
           $("#label_agregar_cn_paac").text("Quitar Reportes vinculados");
        else{
            $("#label_agregar_cn_paac").text("Agregar más Reportes vinculados");
            $("#codigo_reporte_cn_paac3").val("");
            $("#codigo_reporte_cn_paac3").css('color','black');
            $("#codigo_reporte_cn_paac3").css('background-color','white');
            $('input[name=idreporte_cn_paac3]').val(''); 
            $("#codigo_reporte_cn_paac4").val("");
            $("#codigo_reporte_cn_paac4").css('color','black');
            $("#codigo_reporte_cn_paac4").css('background-color','white');
            $('input[name=idreporte_cn_paac4]').val(''); 
            $("#codigo_reporte_cn_paac5").val("");
            $("#codigo_reporte_cn_paac5").css('color','black');
            $("#codigo_reporte_cn_paac5").css('background-color','white');
            $('input[name=idreporte_cn_paac5]').val(''); 
        }
    })
});

function validar_etes(id){    
    var val = $("#codigo_reporte_etes"+id).val();
        if(val!=""){
            $.ajax({
                url: inside_url+'reporte_cn/return_reporte_etes/'+val,
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
                                $("#codigo_reporte_etes"+id).css('background-color','#5cb85c');
                                $("#codigo_reporte_etes"+id).css('color','white');
                                $("#codigo_reporte_etes"+id).val(resp[0].numero_reporte_abreviatura+resp[0].numero_reporte_correlativo+'-'+resp[0].numero_reporte_anho+" - Código correcto");                                
                                $('input[name=idreporte_etes'+id+']').val(resp[0].idreporte_ETES);
                            }
                            else{
                                $("#codigo_reporte_etes"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_etes"+id).css('color','white');
                                $("#codigo_reporte_etes"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=idreporte_etes'+id+']').val('');                   
                            } 
                        }else{
                            $("#codigo_reporte_etes"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_etes"+id).css('color','white');
                                $("#codigo_reporte_etes"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=idreporte_etes'+id+']').val('');        
                        }               
                    }else{
                          $("#codigo_reporte_etes"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_etes"+id).css('color','white');
                                $("#codigo_reporte_etes"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=idreporte_etes'+id+']').val('');        
                    }
                },
                error: function(){
                                $("#codigo_reporte_etes"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_etes"+id).css('color','white');
                                $("#codigo_reporte_etes"+id).val(val+" - El código es incorrecto");
                                $('input[name=idreporte_etes'+id+']').val('');         
                }
            }); 
        }
}

function limpiar_etes(id){
    $("#codigo_reporte_etes"+id).val("");
    $("#codigo_reporte_etes"+id).css('color','black');
    $("#codigo_reporte_etes"+id).css('background-color','white');
    $('input[name=idreporte_etes'+id+']').val(''); 
}

function validar_cn(id){    
    var val = $("#codigo_reporte_cn"+id).val();
        if(val!=""){
            $.ajax({
                url: inside_url+'reporte_priorizacion/return_reporte_cn/'+val,
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
                                $("#codigo_reporte_cn"+id).css('background-color','#5cb85c');
                                $("#codigo_reporte_cn"+id).css('color','white');
                                $("#codigo_reporte_cn"+id).val(resp[0].numero_reporte_abreviatura+resp[0].numero_reporte_correlativo+'-'+resp[0].numero_reporte_anho+" - Código correcto");                                
                                $('input[name=idreporte_cn'+id+']').val(resp[0].idreporte_CN);
                            }
                            else{
                                $("#codigo_reporte_cn"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn"+id).css('color','white');
                                $("#codigo_reporte_cn"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=idreporte_cn'+id+']').val('');                   
                            } 
                        }else{
                            $("#codigo_reporte_cn"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn"+id).css('color','white');
                                $("#codigo_reporte_cn"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=idreporte_cn'+id+']').val('');        
                        }               
                    }else{
                          $("#codigo_reporte_cn"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn"+id).css('color','white');
                                $("#codigo_reporte_cn"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=idreporte_cn'+id+']').val('');        
                    }
                },
                error: function(){
                                $("#codigo_reporte_cn"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn"+id).css('color','white');
                                $("#codigo_reporte_cn"+id).val(val+" - El código es incorrecto");
                                $('input[name=idreporte_cn'+id+']').val('');         
                }
            }); 
        }
}

function limpiar_cn(id){
    $("#codigo_reporte_cn"+id).val("");
    $("#codigo_reporte_cn"+id).css('color','black');
    $("#codigo_reporte_cn"+id).css('background-color','white');
    $('input[name=idreporte_cn'+id+']').val(''); 
}

function validar_cn_paac(id){
    var val = $("#codigo_reporte_cn_paac"+id).val();
        if(val!=""){
            $.ajax({
                url: inside_url+'documentos_PAAC/return_reporte_cn_paac/'+val,
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
                                $("#codigo_reporte_cn_paac"+id).css('background-color','#5cb85c');
                                $("#codigo_reporte_cn_paac"+id).css('color','white');
                                $("#codigo_reporte_cn_paac"+id).val(resp[0].numero_reporte_abreviatura+resp[0].numero_reporte_correlativo+'-'+resp[0].numero_reporte_anho+" - Código correcto");                                
                                $('input[name=cod_reporte_cn_paac'+id+']').val(resp[0].numero_reporte_abreviatura+resp[0].numero_reporte_correlativo+'-'+resp[0].numero_reporte_anho);
                            }
                            else{
                                $("#codigo_reporte_cn_paac"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn_paac"+id).css('color','white');
                                $("#codigo_reporte_cn_paac"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=cod_reporte_cn_paac'+id+']').val('');                   
                            } 
                        }else{
                            $("#codigo_reporte_cn_paac"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn_paac"+id).css('color','white');
                                $("#codigo_reporte_cn_paac"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=cod_reporte_cn_paac'+id+']').val('');        
                        }               
                    }else{
                          $("#codigo_reporte_cn_paac"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn_paac"+id).css('color','white');
                                $("#codigo_reporte_cn_paac"+id).val(val+" - El código es incorrecto"); 
                                $('input[name=cod_reporte_cn_paac'+id+']').val('');        
                    }
                },
                error: function(){
                                $("#codigo_reporte_cn_paac"+id).css('background-color','#d9534f');
                                $("#codigo_reporte_cn_paac"+id).css('color','white');
                                $("#codigo_reporte_cn_paac"+id).val(val+" - El código es incorrecto");
                                $('input[name=cod_reporte_cn_paac'+id+']').val('');         
                }
            }); 
        }
}

function limpiar_cn_paac(id){
    $("#codigo_reporte_cn_paac"+id).val("");
    $("#codigo_reporte_cn_paac"+id).css('color','black');
    $("#codigo_reporte_cn_paac"+id).css('background-color','white');
    $('input[name=cod_reporte_cn_paac'+id+']').val(''); 
}

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
                            $("#nombre_equipo").val("Número de OT de Baja de Equipo incorrecto");
                            $("#nombre_equipo").css('background-color','#d9534f');
                            $("#nombre_equipo").css('color','white');
                        } 
                    }else{
                        $("#nombre_equipo").val("Número de OT de Baja de Equipo incorrecto");
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
    $("#nombre_equipo").val("");
    $("#nombre_equipo").css('background-color','#eee');
}

function llenar_nombre_responsable_cn(){
    var val = $("#num_doc_responsable_cn").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'reporte_cn/return_num_doc_responsable_cn/'+val,
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
                            $("#nombre_responsable_cn").val("");
                            $("#nombre_responsable_cn").css('background-color','#5cb85c');
                            $("#nombre_responsable_cn").css('color','white');
                            $("#nombre_responsable_cn").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=idresponsable_cn]').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_responsable_cn").val("Número de documento incorrecto");
                            $("#nombre_responsable_cn").css('background-color','#d9534f');
                            $("#nombre_responsable_cn").css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable_cn").val("Número de documento incorrecto");
                        $("#nombre_responsable_cn").css('background-color','#d9534f');
                        $("#nombre_responsable_cn").css('color','white');
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

function limpiar_nombre_responsable_cn(){
    $("#num_doc_responsable_cn").val('');
    $("#nombre_responsable_cn").val('');
    $("#nombre_responsable_cn").css('background-color','#eee');
}

function llenar_nombre_responsable_paac(){
    var val = $("#num_doc_responsable_paac").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'reporte_paac/return_num_doc_responsable_paac/'+val,
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
                            $("#nombre_responsable_paac").val("");
                            $("#nombre_responsable_paac").css('background-color','#5cb85c');
                            $("#nombre_responsable_paac").css('color','white');
                            $("#nombre_responsable_paac").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=idresponsable_paac]').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_responsable_paac").val("Número de documento incorrecto");
                            $("#nombre_responsable_paac").css('background-color','#d9534f');
                            $("#nombre_responsable_paac").css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable_paac").val("Número de documento incorrecto");
                        $("#nombre_responsable_paac").css('background-color','#d9534f');
                        $("#nombre_responsable_paac").css('color','white');
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

function limpiar_nombre_responsable_paac(){
    $("#num_doc_responsable_paac").val('');
    $("#nombre_responsable_paac").val('');
    $("#nombre_responsable_paac").css('background-color','#eee');
}

function llenar_nombre_responsable_priorizacion(){
    var val = $("#num_doc_responsable_priorizacion").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'reporte_priorizacion/return_num_doc_responsable_priorizacion/'+val,
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
                            $("#nombre_responsable_priorizacion").val("");
                            $("#nombre_responsable_priorizacion").css('background-color','#5cb85c');
                            $("#nombre_responsable_priorizacion").css('color','white');
                            $("#nombre_responsable_priorizacion").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=idresponsable_priorizacion]').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_responsable_priorizacion").val("Número de documento incorrecto");
                            $("#nombre_responsable_priorizacion").css('background-color','#d9534f');
                            $("#nombre_responsable_priorizacion").css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable_priorizacion").val("Número de documento incorrecto");
                        $("#nombre_responsable_priorizacion").css('background-color','#d9534f');
                        $("#nombre_responsable_priorizacion").css('color','white');
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

function limpiar_nombre_responsable_priorizacion(){
    $("#num_doc_responsable_priorizacion").val('');
    $("#nombre_responsable_priorizacion").val('');
    $("#nombre_responsable_priorizacion").css('background-color','#eee');
}

function llenar_reporte_etes(){
    var val = $("#codigo_reporte_etes").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'reporte_cn/return_reporte_etes/'+val,
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
                            $('<label for="p_scnts"><input class="form-control" maxlength=8 type="text" id="p_scnt" name="p_scnt_" value=""/></label>').appendTo(div_etes);
                            $('<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_reporte_etes()"><span class="glyphicon glyphicon-refresh"></span> Eliminar</a>').appendTo(div_remove_etes);
                            return false;                      
                        }
                        else{
                            dialog = BootstrapDialog.show({
                                title: 'Advertencia',
                                message: "El código de Reporte ETES no existe",
                                type : BootstrapDialog.TYPE_DANGER,
                                buttons: [{
                                    label: 'Aceptar',
                                    action: function(dialog) {
                                        dialog.close();
                                    }
                                }]
                            });
                        } 
                    }else{
                        dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: "El código de Reporte ETES no existe",
                            type : BootstrapDialog.TYPE_DANGER,
                            buttons: [{
                                label: 'Aceptar',
                                action: function(dialog) {
                                    dialog.close();
                                }
                            }]
                        });
                    }               
                }else{
                      dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: "El código de Reporte ETES no existe",
                            type : BootstrapDialog.TYPE_DANGER,
                            buttons: [{
                                label: 'Aceptar',
                                action: function(dialog) {
                                    dialog.close();
                                }
                            }]
                        });
                }
            },
            error: function(){
                            dialog = BootstrapDialog.show({
                                title: 'Advertencia',
                                message: "El código de Reporte ETES no existe",
                                type : BootstrapDialog.TYPE_DANGER,
                                buttons: [{
                                    label: 'Aceptar',
                                    action: function(dialog) {
                                        dialog.close();
                                    }
                                }]
                            });
            }
        }); 
    }
}

