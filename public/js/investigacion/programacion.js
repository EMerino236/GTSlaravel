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

    $('#datetimepicker_search_anho3').datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY'
    });

    var ayer = new Date();
    ayer.setDate(new Date().getDate()-1);
    $("#datetimepicker_ts").datetimepicker({
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
    $("#datetimepicker_gpc").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        minDate: ayer,
        disabledDates: [ayer]
    });

    $("#datetimepicker_fecha").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY',
        //minDate: ayer,
        //disabledDates: [ayer]
    });

    $("#datetimepicker_create_gpc").datetimepicker({
        useCurrent: false,
        defaultDate: false,
        ignoreReadonly: true,
        format: 'YYYY',
        //minDate: ayer,
        //disabledDates: [ayer]
    });

    $('#btnLlimpiar_criterios_list_reporte_cn').click(function(){
        $("#search_usuario").val('');
        $("#search_fecha").val('');
    });

    $('#idprogramacion_reporte_etes').ready(function(){
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
            document.getElementById("nombre").value = '';
        }
    })
});

function llenar_nombre_responsable_etes(){
    var val = $("#num_doc_responsable_etes").val();
    if(val!=""){
        $.ajax({
            url: inside_url+'reporte_etes/return_num_doc_responsable_etes/'+val,
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
                            $("#nombre_responsable_etes").val("");
                            $("#nombre_responsable_etes").css('background-color','#5cb85c');
                            $("#nombre_responsable_etes").css('color','white');
                            $("#nombre_responsable_etes").val(resp[0].apellido_pat+' '+resp[0].apellido_mat+' '+resp[0].nombre);  
                            $('input[name=idresponsable_etes]').val(resp[0].id);           
                        }
                        else{
                            $("#nombre_responsable_etes").val("Número de documento incorrecto");
                            $("#nombre_responsable_etes").css('background-color','#d9534f');
                            $("#nombre_responsable_etes").css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable_etes").val("Número de documento incorrecto");
                        $("#nombre_responsable_etes").css('background-color','#d9534f');
                        $("#nombre_responsable_etes").css('color','white');
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

function limpiar_nombre_responsable_etes(){
    $("#num_doc_responsable_etes").val('');
    $("#nombre_responsable_etes").val('');
    $("#nombre_responsable_etes").css('background-color','#eee');
}