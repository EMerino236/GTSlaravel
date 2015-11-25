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

    $('#idservicio').change(function(){
        var selectServicio = document.getElementById("idservicio");
        var selectedId = selectServicio.options[selectServicio.selectedIndex].value;// will gives u 2
        if(selectedId != ''){
            $.ajax({
                url: inside_url+'reporte_cn/return_area/'+selectedId,
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