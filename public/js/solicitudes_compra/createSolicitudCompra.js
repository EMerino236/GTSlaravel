var matrix_detalle_delete = null;
$( document ).ready(function(){

 	matrix_detalle_delete = new Array();
    
    

    $('#datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});
    $('#datetimepicker2').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY'
    });
    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });

    $('#marca1').change(function(){
        search_equipos_ajax(1);
    });    

    $('#btnAgregar').click(function(){
        addRowDetalle();
    });

    $('#btnLimpiar').click(function(){
        refresh();
    });

    $('#btnAgregarReporte').click(function(){
        fill_name_reporte();
    });

    $('#btnLimpiarReporte').click(function(){
        clean_name_reporte();
    });

    $('#btnLimpiarCriterios').click(function(){
        clean_criterios();
    });

    $('#btn_submit').click(function(){
         BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById("submit_create_solicitud").submit();
                }
            }
        }); 
    });

     $('#btn_submit_edit').click(function(){
         BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById("submit_edit_solicitud").submit();
                }
            }
        }); 
    });
    
    

    $("#btn_descarga").hide();
    $("input[name=numero_reporte_hidden]").val(null);
    
    if($('#type_solicitud').val()==1){
        //si es tipo edit
        $('#numero_reporte').prop('readonly',true);
        $('#numero_ot').prop('readonly',true);
        fill_name_reporte_edit();
    }else if($('#type_solicitud').val()==0){
        search_equipos_ajax(1);
    }

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
                            closable: false,
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    $('#flag_ot').val(2);
                                    $('#numero_ot').prop('readonly',true);
                                    dialog.close();
                                }
                            }]
                        });
                        
                    }else{
                        dialog = BootstrapDialog.show({
                            title: 'Mensaje',                            
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Orden de Mantenimiento No Válida',
                            closable:false,
                            buttons: [{
                                label: 'Aceptar',
                                cssClass: 'btn-default',
                                action: function() {
                                    $('#flag_ot').val(1);
                                    $('#numero_ot').prop('readonly',false);
                                    dialog.close();
                                }
                            }]
                        }); 
                         
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
    
});

function search_equipos_ajax(id){       
        var val = $('#marca'+id).val();
        if(val == ''){
            $("#equipo"+id).empty();
            $("#equipo"+id).append("<option value=''>Seleccione</option>");
            $('#equipo'+id).prop('disabled',true);
            return;
        }
        $.ajax({
            url: inside_url+'solicitudes_compra/return_equipos',
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
                    var list_equipos = response['list_equipos'];
                    var tamano = list_equipos.length;
                    $('#equipo'+id).prop('disabled',false);
                    $("#equipo"+id).empty();
                    $("#equipo"+id).append("<option value=''>Seleccione</option>");            
                    for(i = 0;i<tamano;i++){
                        $("#equipo"+id).append('<option value='+list_equipos[i].idfamilia_activo+'>'+list_equipos[i].nombre_equipo+'</option>');
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



function addRowDetalle(){
    var descripcion = $('#descripcion').val();
    var marca = $('#marca2').val();
    var modelo = $('#nombre_equipo2').val();
    var serie_parte = $('#serie_parte').val();
    var cantidad = $('#cantidad').val();
    var cantidad_filas = $("#table_solicitud tr").length-1;
    cantidad = parseInt(cantidad);
    var error_str = "";
    var reg = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _]/;
    var regSerie = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _-]/;
    var intRegex = /^\d+$/;
    var is_correct = true;

    $("input[name=descripcion]").parent().removeClass("has-error has-feedback");
    $("input[name=marca2]").parent().removeClass("has-error has-feedback");
    $("input[name=nombre_equipo2]").parent().removeClass("has-error has-feedback");
    $("input[name=serie_parte]").parent().removeClass("has-error has-feedback");
    $("input[name=cantidad]").parent().removeClass("has-error has-feedback");
    
    if(reg.test($("input[name=descripcion]").val())){
        error_str += "La descripción debe ser alfanumérico.\n";
        $("input[name=descripcion]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }
    if($("input[name=descripcion]").val().length < 1 || $("input[name=descripcion]").val().length > 200){
        error_str += "La descripción es obligatorio y debe contener menos de 200 caracteres\n";
        $("input[name=descripcion]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }

    if(reg.test($("input[name=marca2]").val())){
        error_str += "La marca debe ser alfanumérico.\n";
        $("input[name=marca2]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }
    if($("input[name=marca2]").val().length < 1 || $("input[name=marca2]").val().length > 100){
        error_str += "La marca es obligatorio y debe contener menos de 100 caracteres\n";
        $("input[name=marca2]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }

    if(reg.test($("input[name=nombre_equipo2]").val())){
        error_str += "El modelo debe ser alfanumérico.\n";
        $("input[name=nombre_equipo2]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }
    if($("input[name=nombre_equipo2]").val().length < 1 || $("input[name=nombre_equipo2]").val().length > 100){
        error_str += "El modelo es obligatorio y debe contener menos de 100 caracteres\n";
        $("input[name=nombre_equipo2]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }

    

    if(regSerie.test($("input[name=serie_parte]").val())){
        error_str += "El número de serie / parte debe ser alfanumérico.\n";
        $("input[name=serie_parte]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }
    if($("input[name=serie_parte]").val().length < 1 || $("input[name=serie_parte]").val().length > 100){
        error_str += "El número de serie / parte es obligatorio y debe contener menos de 100 caracteres\n";
        $("input[name=serie_parte]").parent().addClass("has-error has-feedback");
        is_correct = false;
    }

    if(!intRegex.test($("input[name=cantidad]").val()) || $("input[name=cantidad]").val().length < 1 || $("input[name=cantidad]").val().length > 10){
        error_str += "La cantidad debe ser un número entero.\n";
        is_correct = false;
        $("input[name=cantidad]").parent().addClass("has-error has-feedback");
    }

    
    if(is_correct){
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    $('#table_solicitud').append("<tr><td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_descripcion[]' value='"+descripcion+"' readonly/></td>"
                    +"<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_marca[]' value='"+marca+"' readonly/></td>"
                    +"<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_modelo[]' value='"+modelo+"' readonly/></td>"
                    +"<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_serie[]' value='"+serie_parte+"' readonly/></td>"
                    +"<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_cantidad[]' value='"+cantidad+"' readonly/></td>"
                    +"<td><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span>Eliminar</a></td></tr>");
                    refresh();
                    count =  $('#count_details').val();
                    new_value = parseInt(count)+1
                    $('#count_details').val(new_value);
                }
            }
        });     
    }else{
        dialog = BootstrapDialog.show({
            title: 'Advertencia',
            message: error_str,
            type : BootstrapDialog.TYPE_DANGER,
            buttons: [{
                label: 'Aceptar',
                action: function(dialog) {
                    dialog.close();
                }
            }]
        });        
    }    
}

function refresh(){
    $('#descripcion').val(null);
    $('#marca2').val(null);
    $('#nombre_equipo2').val(null);
    $('#serie_parte').val(null);
    $('#cantidad').val(null);
}

function fill_name_reporte(){
        var val = $("#numero_reporte").val();
        if(val==""){
            return;
        }              
        $.ajax({
            url: inside_url+'solicitudes_compra/return_name_reporte',
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
                    var resp = response['reporte'];
                    if(resp != null){ // el documento existe
                        var solicitud = response['solicitud'];
                        if(solicitud == null){
                            $("#nombre_reporte").val("");
                            $("#nombre_reporte").css('background-color','#5cb85c');
                            $("#nombre_reporte").css('color','white');
                            $("#nombre_reporte").val(resp.nombre);
                            $("#btn_descarga").show();
                            $("input[name=numero_reporte_hidden]").val(val); 
                            $("#flag_doc").val(1);         
                            $('#numero_reporte').prop('readonly',true);       
                        }else{
                            $("#nombre_reporte").val("Documento ya ha sido tomado");
                            $("#nombre_reporte").css('background-color','#d9534f');
                            $("#nombre_reporte").css('color','white');
                            $("#btn_descarga").hide();
                            $("input[name=numero_reporte_hidden]").val(null);
                            $("#flag_doc").val(0);
                            $('#numero_reporte').prop('readonly',false);
                        }                                  
                    }else{
                        $("#nombre_reporte").val("Documento no es un Reporte de Necesidad");
                        $("#nombre_reporte").css('background-color','#d9534f');
                        $("#nombre_reporte").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_reporte_hidden]").val(null);
                        $("#flag_doc").val(0);
                        $('#numero_reporte').prop('readonly',false);
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
function clean_name_reporte(){
    $("#nombre_reporte").val("");
    $("#nombre_reporte").val("");
    $("#nombre_reporte").css('background-color','white');
    $("#numero_reporte").val("");
    $("#btn_descarga").hide();
    $("#flag_doc").val(0);
    $('#numero_reporte').prop('readonly',false);
}

function deleteRow(event,el){    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_value = parent.rowIndex-1;
    cells = parent.cells;
    array_detalle = new Array();
    array_detalle.push($('#iddetalle'+index_value).val());
    for(i=1;i<cells.length-1;i++)
        array_detalle.push(cells[i].innerHTML);
    matrix_detalle_delete.push(array_detalle);
    parent.parentNode.removeChild(parent);
    count =  $('#count_details').val();
    new_value = parseInt(count)-1
    $('#count_details').val(new_value);        
   
}

function clean_criterios(){
    $('#search_tipo_solicitud').val(0);
    $('#search_nombre_equipo').val('');
    $('#servicio_clinico').val(0);
    $('#estados').val(0);
    $('#fecha_desde').val('');
    $('#fecha_hasta').val('');
}

function clean_ot(){
    $('#numero_ot').prop('readonly',false);
    $('#numero_ot').val('');
    $('#flag_ot').val(1);
}

function fill_name_reporte_edit(){
        var val = $("#numero_reporte").val();
        if(val==""){
            return;
        }              
        $.ajax({
            url: inside_url+'solicitudes_compra/return_name_reporte',
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
                    var resp = response['reporte'];
                    if(resp != null){ // el documento existe
                        var solicitud = response['solicitud'];                        
                        $("#nombre_reporte").val("");
                        $("#nombre_reporte").css('background-color','#5cb85c');
                        $("#nombre_reporte").css('color','white');
                        $("#nombre_reporte").val(resp.nombre);
                        $("#btn_descarga").show();
                        $("input[name=numero_reporte_hidden]").val(val); 
                        $("#flag_doc").val(1);         
                        $('#numero_reporte').prop('readonly',true);       
                                                  
                    }else{
                        $("#nombre_reporte").val("Documento no es un Reporte de Necesidad");
                        $("#nombre_reporte").css('background-color','#d9534f');
                        $("#nombre_reporte").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_reporte_hidden]").val(null);
                        $("#flag_doc").val(0);
                        $('#numero_reporte').prop('readonly',false);
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