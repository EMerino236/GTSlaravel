$( document ).ready(function(){
    
    $('#btnLimpiar').click(function(){
        $('#codigo_patrimonial').val(null);
        $('#nombre_equipo').val(null);
        $('#area').val(null);
        $('#servicio').val(null);
        $('#grupo').val(null);
    });

    if($('#type_form').val() == 0)
        generar_detail_activos();

    $('#btnLimpiarResultados').click(function(){
        limpiar_resultados();
    });

    if($('#type_form').val() == 0)
        $('.input-group').datetimepicker({
            ignoreReadonly: true,
            format:'DD-MM-YYYY'
        });

    if($('#type_form').val()==1){
        $('#fecha_calibracion_datetimepicker').datetimepicker({
            ignoreReadonly: true,
            format:'DD-MM-YYYY'
        });
        $('#fecha_proximo_datetimepicker').datetimepicker({
            ignoreReadonly: true,
            format:'DD-MM-YYYY'
        });
    }

    $('.checkbox-metodo').change(function(){
        val = $(event.target).val();     
        if($('.checkbox-metodo').is(':checked')){
            $('#file-'+val).prop('readonly',true);
            $('#input-file-'+val).fileinput('enable');
            $('#input-file-'+val).fileinput('clear');   
        }else{
            $('#file-'+val).prop('readonly',false);            
            $('#input-file-'+val).fileinput('clear');
            $('#input-file-'+val).fileinput('disable');
        }
    });

    $('#cb_nuevos_documentos').change(function(){
        if($('#cb_nuevos_documentos').is(':checked')){
            $('#div_nuevos_documentos').css('display','inline');
            cantidad = $('#cantidad_detalle').val();
            for(i=cantidad;i<10;i++){
                $('#file-input-'+i).fileinput('clear');
            }
        }else{
            $('#div_nuevos_documentos').css('display','none');
            cantidad = $('#cantidad_detalle').val();            
            for(i=cantidad;i<10;i++){
                $('#file-input-'+i).fileinput('clear');
            }
        }
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

     $('#btnTerminado').click(function(){
         BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById('submit_terminado').submit();
                }
            }
        });
    });


});

function save_modal(idactivo){
    //se verifica si se agregaron documentos 
    vacio = true;
    for(i=0;i<10;i++){
        if($('#input-file-'+idactivo+'-'+i).val().length>0){
            vacio = false;
            break;
        }
    }

    message = "";

    if(vacio == true){
        message = 'No se han adjuntado archivos.\n';
    }

    if($('#fecha_calibracion_'+idactivo).val().length==0)
        message += 'El campo Fecha de Calibración es obligatoria.\n';

    if($('#fecha_proximo_'+idactivo).val().length==0)
        message += 'El campo Fecha Próxima de Calibración es obligatoria.\n';

    if(message.length>0){       
        $('#btn_close_'+idactivo).popover("destroy");
        $('#btn_close_'+idactivo).attr("data-content",message);
        $('#btn_close_'+idactivo).popover("show");
    }else{
        $('#modal_'+idactivo).modal('hide');
    }

}

function close_modal(idactivo){
    $('#fecha_calibracion_'+idactivo).val(null);
    $('#fecha_proximo_'+idactivo).val(null);
    $('#input-file-69-0').fileinput({ uploadUrl: "  ",});
    $('#modal_'+idactivo).modal('hide');
   
}

function show_files(event,idactivo){
    event.preventDefault();
    for(i=0;i<10;i+=2){
        if($('#div_file_'+idactivo+'_'+i).css('display') == "none"){
            $('#div_file_'+idactivo+'_'+i).css('display','block');
            $('#div_file_'+idactivo+'_'+(i+1)).css('display','block');
            break;
        }
    }
}

function show_files_edit(event){
    event.preventDefault();
    for(i=0;i<10;i++){
        if($('#div_file_'+i).css('display') == "none"){
            $('#div_file_'+i).css('display','block');
            break;
        }
    }
}

function limpiar_resultados(){
    $("#table_activos tr:not(:first)").remove();
    $(".modal").remove();
    $('.invisible-input').remove();
    $('#cantidad_activos').val(0);
}

function generar_detail_activos(){
    size = document.getElementById('table_activos').rows.length;
    for(i=1;i<size;i++){
        idactivo = document.getElementById('table_activos').rows[i].cells[0].id;
        $('#activos_hidden_inputs').append("<input id=\"input-"+idactivo+"\" style=\"display:inline\" class=\"invisible-input\" name='details_activos[]' value='"+idactivo  +"' readonly/>");
        $('#activos_hidden_inputs').append("<input id=\"input-posicion-"+idactivo+"\" style=\"display:inline\" class=\"invisible-input\" name='details_posiciones[]' value='"+i  +"' readonly/>");
    }
}

function add_modal_documentos(event,idactivo){
    event.preventDefault();
    /*aca se verifica si se muestra el modal para agregar documentos o no
    dependiendo si lo puede agregar*/
    $.ajax({
        url: inside_url+'reportes_calibracion/verify_reporte_calibracion',
        type: 'POST',
        async: false,
        data: { 'idactivo' : idactivo },
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
                var reporte = response["reporte"];
                if(reporte == null){
                    // si no ha habido ningun reporte activo ultimo como pendiente
                    // se muestra el modal
                    if($('#modal_'+idactivo).length){
                        $('#modal_'+idactivo).modal('show');
                    } 
                }else{
                    fecha_proximo_reporte = reporte.fecha_proxima_calibracion;
                    array_fecha = fecha_proximo_reporte.split('-');
                    fecha_proximo = new Date(array_fecha[0],(array_fecha[1]-1),array_fecha[2]);
                    fecha_actual = new Date();  
                    fecha_actual.setHours(0,0,0,0);     
                    idestado = reporte.idestado;
                    if(fecha_actual < fecha_proximo){
                         dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: 'La fecha próxima de calibración es: '+array_fecha[2]+"-"+array_fecha[1]+"-"+array_fecha[0],
                            closable: false,
                            type : BootstrapDialog.TYPE_INFO,
                            buttons: [{
                                label: 'Aceptar',
                                action: function(dialog) {
                                    dialog.close();                        
                                }
                            }]
                        });
                    }else if(+fecha_actual >= +fecha_proximo){
                        if(idestado == 27 || idestado == 29){
                            dialog = BootstrapDialog.show({
                                title: 'Advertencia',
                                message: 'La última calibración sigue pendiente.\nDebe actualizar el reporte '+reporte.codigo_abreviatura+'-'+reporte.codigo_correlativo+'-'+
                                reporte.codigo_anho+' como Terminado para poder registrar la siguiente calibración.',
                                closable: false,
                                type : BootstrapDialog.TYPE_DANGER,
                                buttons: [{
                                    label: 'Aceptar',
                                    action: function(dialog) {
                                        dialog.close();                        
                                    }
                                }]
                            });
                        }else{
                            if($('#modal_'+idactivo).length){
                                $('#modal_'+idactivo).modal('show');
                            }
                        }                             
                    }

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

function deleteRow(event,el)
{    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    cells = parent.cells;  
    idactivo = cells[0].id;
    parent.parentNode.removeChild(parent);
    /*borramos el modal*/
    //siempre y cuando exista
    if($('#modal_'+idactivo).length){
        element_modal = document.getElementById("modal_"+idactivo);
        element_modal.parentNode.removeChild(element_modal);
    }
    element_input = document.getElementById("input-"+idactivo);
    element_input.parentNode.removeChild(element_input);

    element_input = document.getElementById("input-posicion-"+idactivo);
    element_input.parentNode.removeChild(element_input);

    cantidad_activos = $('#cantidad_activos').val();
    cantidad_activos = parseInt(cantidad_activos)-1;
    $('#cantidad_activos').val(cantidad_activos);
}

function hide_div_edit(event,i){
    event.preventDefault();
    $('#div_file_'+i).css('display','none');
}