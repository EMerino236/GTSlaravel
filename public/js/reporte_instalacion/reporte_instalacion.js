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
        var tarea = $("input[name=nombre_tarea]").val();
        var selects = document.getElementById("tarea_realizada");
        var selectedId = selects.options[selects.selectedIndex].value;// will gives u 2
        var estado = selects.options[selects.selectedIndex].text;// gives u value2

        if(tarea.length < 1){
            return alert("Ingrese el nombre de la tarea.");
        }

        var str = "<tr><td><input style=\"border:0\" name='details_tarea[]' value='"+tarea+"' readonly/></td>";
        str += "<td><input style=\"border:0\" name='details_estado[]' value='"+estado+"' readonly/></td>";
        str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
        $("table").append(str);
        
        $("input[name=nombre_tarea]").val('');
        document.getElementById("tarea_realizada").value = 1;
    });
});

function llenar_nombre_responsable(id){
        var val = $("#numero_documento"+id).val();
        if(val=="")
            val = "vacio";
        
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
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_responsable"+id).val("");
                            $("#nombre_responsable"+id).css('background-color','#5cb85c');
                            $("#nombre_responsable"+id).css('color','white');
                            $("#nombre_responsable"+id).val(resp[0].nombre+" "+resp[0].apellido_pat+" "+resp[0].apellido_mat);

                        }
                        else{
                            $("#nombre_responsable"+id).val("Usuario no registrado");
                            $("#nombre_responsable"+id).css('background-color','#d9534f');
                            $("#nombre_responsable"+id).css('color','white');
                        } 
                    }else{
                        $("#nombre_responsable"+id).val("Usuario no registrado");
                        $("#nombre_responsable"+id).css('background-color','#d9534f');
                        $("#nombre_responsable"+id).css('color','white');
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
        if(val=="")
            val = "vacio";    
        $.ajax({
            url: inside_url+'rep_instalacion/return_name_doc_relacionado/'+val,
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
                    var resp = response['contrato'];
                    if(resp!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_doc_relacionado"+id).val("");
                            $("#nombre_doc_relacionado"+id).css('background-color','#5cb85c');
                            $("#nombre_doc_relacionado"+id).css('color','white');
                            $("#nombre_doc_relacionado"+id).val(resp[0].nombre);                            
                        }
                        else{
                            $("#nombre_doc_relacionado"+id).val("Documento no registrado");
                            $("#nombre_doc_relacionado"+id).css('background-color','#d9534f');
                            $("#nombre_doc_relacionado"+id).css('color','white');
                        } 
                    }else{
                        $("#nombre_doc_relacionado"+id).val("Documento no registrado");
                        $("#nombre_doc_relacionado"+id).css('background-color','#d9534f');
                        $("#nombre_doc_relacionado"+id).css('color','white');
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
            val = "vacio";    
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
                    if(resp!="vacio"){
                        if(resp[0] != null){
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
}

function limpiar_nombre_doc_relacionado(id){
    $("#nombre_doc_relacionado"+id).val("");
    $("#num_doc_relacionado"+id).val("");
    $("#nombre_doc_relacionado"+id).css('background-color','white');
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