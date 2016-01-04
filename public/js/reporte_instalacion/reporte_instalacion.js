$( document ).ready(function(){

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

    $('#type_report').val($('#idtipo_reporte_instalacion').val());
    if($('#type_submit').val()==1){
        $('#num_doc_relacionado1').prop('readonly',true);
        $('#num_doc_relacionado2').prop('readonly',true);
        $('#num_doc_relacionado3').prop('readonly',true);
        $('#num_doc_relacionado4').prop('readonly',true);
    }
    
    var alphanumeric_pattern = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _.]/;

    var select = document.getElementById('idtipo_reporte_instalacion');
        select.addEventListener('change', function(){
            //this.form.submit();
        }, false);

    var select = document.getElementById('idtipo_reporte_instalacion');
        select.onchange = function(){
            //this.form.submit();
        };

    $('#idtipo_reporte_instalacion').ready(function(){
        var selectTipoReporte = document.getElementById("idtipo_reporte_instalacion");
        var selectedId = selectTipoReporte.options[selectTipoReporte.selectedIndex].value;// will gives u 2
        if(selectedId == 1 || selectedId==0){
            if($("#panel-documentos-relacionados").is(":visible"))
                $("#panel-documentos-relacionados").toggle();
                limpiar_nombre_doc_relacionado(1);
                limpiar_nombre_doc_relacionado(2);
                limpiar_nombre_doc_relacionado(3);
                limpiar_nombre_doc_relacionado(4);
        }
        else{
            if($("#panel-documentos-relacionados").is(":hidden"))
                $("#panel-documentos-relacionados").toggle();
        }
    });

    $('#idtipo_reporte_instalacion').on('change', function(e){
        var selectTipoReporte = document.getElementById("idtipo_reporte_instalacion");
        var selectedId = selectTipoReporte.options[selectTipoReporte.selectedIndex].value;// will gives u 2
        if(selectedId == 1 || selectedId==0){
            if($("#panel-documentos-relacionados").is(":visible"))
                $("#panel-documentos-relacionados").toggle();
                limpiar_nombre_doc_relacionado(1);
                limpiar_nombre_doc_relacionado(2);
                limpiar_nombre_doc_relacionado(3);
                limpiar_nombre_doc_relacionado(4);
        }
        else{
            if($("#panel-documentos-relacionados").is(":hidden"))
                $("#panel-documentos-relacionados").toggle();
        }
    });

    $('#btnAgregarFila').click(function(){
        
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    var tarea = $("input[name=nombre_tarea]").val();
                    var selects = document.getElementById("tarea_realizada");
                    var selectedId = selects.options[selects.selectedIndex].value;// will gives u 2
                    var estado = selects.options[selects.selectedIndex].text;// gives u value2

                    if(tarea.length < 1  || tarea.length >100  || alphanumeric_pattern.test(tarea)){
                        //return alert("Ingrese el nombre de la tarea.");
                        $("input[name=nombre_tarea]").parent().addClass("has-error has-feedback");
                        dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: 'Ingrese una tarea válida',
                            closable: false,
                            type : BootstrapDialog.TYPE_DANGER,
                            buttons: [{
                                label: 'Aceptar',
                                action: function(dialog) {
                                    dialog.close();                        
                                }
                            }]
                        });
                        return;
                    }

                    var str = "<tr><td class=\"text-nowrap\"><input style=\"border:0\" name='details_tarea[]' value='"+tarea+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='details_estado[]' value='"+estado+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-trash\"></span></a></td></tr>";
                    $("table").append(str);
                    
                    $("input[name=nombre_tarea]").val('');
                    document.getElementById("tarea_realizada").value = 1;
                }
            }
        });

        
    });

    $('#btnLimpiarFila').click(function(){
        $("input[name=nombre_tarea]").val(null);
        document.getElementById("tarea_realizada").value = 1;
    });

    $('#idtipo_reporte_instalacion').change(function(){
        $('#type_report').val($('#idtipo_reporte_instalacion').val());
    })
});

function llenar_nombre_responsable(id){
        var val = $("#numero_documento"+id).val();
        if(val=="") return;
        
        $.ajax({
            url: inside_url+'rep_instalacion/return_name_responsable/'+val,
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
                    if(resp != null){
                        $("#nombre_responsable"+id).val("");
                        $("#nombre_responsable"+id).css('background-color','#5cb85c');
                        $("#nombre_responsable"+id).css('color','white');
                        $("#nombre_responsable"+id).val(resp.nombre+" "+resp.apellido_pat+" "+resp.apellido_mat);
                        $("#numero_documento"+id).prop('readonly',true);
                    }
                    else{
                        $("#nombre_responsable"+id).val("Usuario no registrado");
                        $("#nombre_responsable"+id).css('background-color','#d9534f');
                        $("#nombre_responsable"+id).css('color','white');
                        $("#numero_documento"+id).prop('readonly',false);
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

function llenar_nombre_doc_relacionado(id){
        var val = $("#num_doc_relacionado"+id).val();
        var tipo_doc;
        var nombre_doc;
        if(val=="")
            return;
        switch(id){
            case 1:
                tipo_doc = 6;
                nombre_doc = "Certificado de Funcionalidad";
                break;
            case 2:
                tipo_doc = 1;
                nombre_doc = "Contrato de Proveedor";
                break;
            case 3:
                tipo_doc = 2;
                nombre_doc = "Manual";
                break;
            case 4:
                tipo_doc = 7;
                nombre_doc = "Término de Referencia";
                break;
        }

        $.ajax({
            url: inside_url+'rep_instalacion/return_name_doc_relacionado/'+val,
            type: 'POST',
            data: { 'selected_id' : val,
                    'tipo_doc' : tipo_doc },
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
                        var reporte_instalacion = response['reporte_instalacion'];
                        if(reporte_instalacion == null){
                            $("#nombre_doc_relacionado"+id).val("");
                            $("#nombre_doc_relacionado"+id).css('background-color','#5cb85c');
                            $("#nombre_doc_relacionado"+id).css('color','white');
                            $("#nombre_doc_relacionado"+id).val(resp.nombre);
                            $("#num_doc_relacionado"+id).prop('readonly',true);
                            $("#flag_doc"+id).val(1);   
                        }else{
                            $("#nombre_doc_relacionado"+id).val("Documento ya fue tomado");
                            $("#nombre_doc_relacionado"+id).css('background-color','#d9534f');
                            $("#nombre_doc_relacionado"+id).css('color','white');                        
                            $("#num_doc_relacionado"+id).prop('readonly',false);  
                            $("#flag_doc"+id).val(0);
                        }                                                  
                    }
                    else{
                        $("#nombre_doc_relacionado"+id).val("Documento no es un "+nombre_doc);
                        $("#nombre_doc_relacionado"+id).css('background-color','#d9534f');
                        $("#nombre_doc_relacionado"+id).css('color','white');                        
                        $("#num_doc_relacionado"+id).prop('readonly',false);  
                        $("#flag_doc"+id).val(0);                      
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

function validar_num_rep_entorno_concluido(){
        var val = $("#numero_reporte_entorno_concluido").val();
        if(val=="")
            return;  
        $.ajax({
            url: inside_url+'rep_instalacion/return_num_rep_entorno_concluido/'+val,
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
                    if(resp != null){
                        $("#mensaje_validacion").val("");
                        $("#mensaje_validacion").css('background-color','#5cb85c');
                        $("#mensaje_validacion").css('color','white');
                        $("#mensaje_validacion").val("Número de reporte correcto");                            
                    }
                    else{
                        $("#mensaje_validacion").val("Número de reporte incorrecto");
                        $("#mensaje_validacion").css('background-color','#d9534f');
                        $("#mensaje_validacion").css('color','white');
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

function limpiar_nombre_responsable(id){
    $("#nombre_responsable"+id).val("");
    $("#numero_documento"+id).val("");
    $("#nombre_responsable"+id).css('background-color','white');
    $("#numero_documento"+id).prop('readonly',false);
}

function limpiar_nombre_doc_relacionado(id){
    $("#nombre_doc_relacionado"+id).val("");
    $("#num_doc_relacionado"+id).val("");
    $("#nombre_doc_relacionado"+id).css('background-color','white');
    $("#num_doc_relacionado"+id).prop('readonly',false);
    $("#flag_doc"+id).val(0);
    if($('#type_submit').val()==1){
        $('#doc'+id).hide();      
    }
}

function limpiar_num_rep_entorno_concluido(){
    $("#mensaje_validacion").val("");
    $("#numero_reporte_entorno_concluido").val("");
    $("#mensaje_validacion").css('background-color','white');
}

function deleteRow(event,el)
{
    event.preventDefault();
    console.log(el);
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
}