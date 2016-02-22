$( document ).ready(function(){
	
	$('#fecha_reporte_datetimepicker').datetimepicker({
 		ignoreReadonly: true,
 		format:'DD-MM-YYYY'
 	});
    $('#fecha_incidente_datetimepicker').datetimepicker({
        ignoreReadonly: true,
        format:'DD-MM-YYYY HH:ss'
    });

    if($('#flag_edit').val()==1){
        //se renderiza un editar
        $('#tipo_incidente').val($('#tipoincidente_id').val());
        show_subtiposPadre($('#tipoincidente_id').val());
        show_subtiposHijo($('#subtipopadre_id').val());

        $('#subtipopadre').val($('#subtipopadre_id').val());
        if($('#subtipopadre_id').val() == 33){ //es caidas
            $('#flag_tipoHijo').val(1);
            $('#subtipohijo_lbl').text('Tipo Caidas');
            show_subtiposNietos(192,1);
            $('#div_elemento_caida').css('display','inline');
            show_subtiposNietos(193,2);
            $("#subtipohijo").val($('#subtiponieto1_id').val());
            $("#subtipohijo2").val($('#subtiponieto2_id').val());
        }else{
            $('#subtipohijo').val($('#subtipohijo_id').val());
        }


        $('#entorno_asistencial').val($('#identorno_asistencial').val());
        if($('#identorno_asistencial').val()==6 || $('#identorno_asistencial').val()==8 || $('#identorno_asistencial').val()==49 ){
            //mostramos el comentario
            $('#flag_entornoAsistencial').val(1);
            $('#div_tipo_servicio').css('display','none');
            $('#div_etapa_servicio').css('display','none');
            $('#div_comentario').css('display','inline');
            $('#comentario').val($('#comentario_entorno').val());
        }else{
            //mostramos el tipo de servicio y la etapa de servicio
            $('#flag_entornoAsistencial').val(0);
            $('#div_tipo_servicio').css('display','display');
            $('#div_etapa_servicio').css('display','display');
            $('#div_comentario').css('display','none');
            identorno_asistencial = $('#identorno_asistencial').val();            
            show_tiposServicios(identorno_asistencial);
            idtipo_servicio = $('#idtipo_servicio').val();
            $('#tipo_servicio').val(idtipo_servicio);            
            show_etapasServicios(idtipo_servicio);
            idetapa_servicio = $('#idetapa_servicio').val();
            $('#etapa_servicio').val(idetapa_servicio);
            

        }

    }   

	$('#tipo_incidente').change(function(){
        val = $('#tipo_incidente').val();
        //limpieza total
        $("#subtipopadre").empty();
        $("#subtipopadre").append('<option value=\'\'>Seleccione</option>');
        $("#subtipohijo").empty();
        $("#subtipohijo").append('<option value=\'\'>Seleccione</option>');
        $('#subtipohijo_lbl').text('Subclasificación 2 de Tipo de Incidente:');  
        $('#div_elemento_caida').css('display','none');
        $("#subtipohijo2").empty();
        $("#subtipohijo2").append('<option value=\'\'>Seleccione</option>');
        $('#flag_tipoHijo').val(0);
        if(val.length>0)
            show_subtiposPadre(val);
    });

    $('#subtipopadre').change(function(){
        val = $('#subtipopadre').val();
        //limpieza de la subcategoria 2            
        $('#flag_tipoHijo').val(0);
        $("#subtipohijo").empty();
        $("#subtipohijo").append('<option value=\'\'>Seleccione</option>');
        $('#subtipohijo_lbl').text('Subclasificación 2 de Tipo de Incidente:');
        $('#div_elemento_caida').css('display','none');  
        $("#subtipohijo2").empty();
        $("#subtipohijo2").append('<option value=\'\'>Seleccione</option>');
        if(val.length>0){
            if(val != 33){
                show_subtiposHijo(val);
            }                
            else{
                $('#flag_tipoHijo').val(1);
                $('#subtipohijo_lbl').text('Tipo Caidas');
                show_subtiposNietos(192,1);
                $('#div_elemento_caida').css('display','inline');
                show_subtiposNietos(193,2);
            }
        }            
    });
    $('#codigo_patrimonial').change(function(){
        val = $('#codigo_patrimonial').val();
        if(val.length==0){
            $('#servicio').val(null);
            $('#ubicacion_fisica').val(null);
            $('#nombre_equipo').val(null);
            $('#serie').val(null);
            $('#modelo').val(null);
            $('#proveedor').val(null);
        }else
            fill_activo_infos(val);
    });

    $('#tipo_documento').change(function(){
        val = $('#tipo_documento').val();
        if(val == 0){
            $('#numero_documento').attr('maxlength','12');
        }else if(val == 1){
            $('#numero_documento').attr('maxlength','8');
        }else{
            $('#numero_documento').attr('maxlength','12');
        }       
    });

    $('#entorno_asistencial').change(function(){
        val = $('#entorno_asistencial').val();
        $('#flag_entornoAsistencial').val(0);
        $("#tipo_servicio").empty();
        $("#tipo_servicio").append('<option value=\'\'>Seleccione</option>');
        $("#etapa_servicio").empty();
        $("#etapa_servicio").append('<option value=\'\'>Seleccione</option>');
        if(val.length>0){
            //en caso que eliga otros:
            if(val ==49 || val == 6 || val == 8){
                //TODO
                $('#flag_entornoAsistencial').val(1);
                $('#comentario').val(null);
                $('#div_comentario').css('display','inline');
                $('#div_tipo_servicio').css('display','none');
                $('#div_etapa_servicio').css('display','none');
            }else{
                $('#div_comentario').css('display','none');
                $('#comentario').val(null);
                $('#div_tipo_servicio').css('display','inline');
                $('#div_etapa_servicio').css('display','inline');
                show_tiposServicios(val);
            }                
        } 
    });

    $('#tipo_servicio').change(function(){
        val = $('#tipo_servicio').val();
        $('#etapa_servicio').empty();
        $("#etapa_servicio").append('<option value=\'\'>Seleccione</option>');
        if(val.length>0){
            show_etapasServicios(val);
        }
    })

    $('#btnAgregar').click(function(){
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    var implicancia = $("#implicancia").val();
                    nombre_tipo = $("#implicancia option[value=\""+implicancia+"\"]").html();
                    cantidad = $('#cantidad_personas').val();
                    if(implicancia.length==0 ){
                        dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: 'Seleccione un tipo',
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
                    if(cantidad <=0 ){
                        dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: 'Ingrese una cantidad',
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
                    var str = "<tr><td class=\"text-nowrap\"><input style=\"border:0;text-align:center\" name='personas_implicadas[]' value='"+nombre_tipo+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><input style=\"border:0;text-align:center\" name='cantidades[]' value='"+cantidad+"' readonly/></td>";
                    str += "<td class=\"text-nowrap text-center\"><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-trash\"></span></a></td></tr>";
                    $("table").append(str);
                    //incrementar cantidad de personas
                    cantidad_personas_hidden = $('#cantidad_tipo_implicados').val();
                    cantidad_personas_hidden = parseInt(cantidad_personas_hidden)+1;
                    $('#cantidad_tipo_implicados').val(cantidad_personas_hidden);
                    refresh_table();
                }
            }
        });
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
});

function refresh_table(){
    $('#implicancia').val('');
    $('#cantidad_personas').val(null);
}

function deleteRow(event,el)
{
    event.preventDefault();
    console.log(el);
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
    cantidad_personas_hidden = $('#cantidad_tipo_implicados').val();
    cantidad_personas_hidden = parseInt(cantidad_personas_hidden)-1;
    $('#cantidad_tipo_implicados').val(cantidad_personas_hidden);
}

function show_subtiposPadre(val){
    $.ajax({
        url: inside_url+'eventos_adversos/show_subtipospadre',
        type: 'POST',
        async: false,
        data: { 'idtipo_incidente' : val },
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
                var array_subtipos = response["array_subtipos"];
                size_array = array_subtipos.length;
                for(i=0;i<size_array;i++){
                    $("#subtipopadre").append('<option value='+array_subtipos[i].id+'>'+array_subtipos[i].nombre+'</option>');
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

function show_subtiposHijo(val){
    $.ajax({
        url: inside_url+'eventos_adversos/show_subtiposhijo',
        type: 'POST',
        async: false,
        data: { 'idsubtipopadre' : val },
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
                var array_subtipos = response["array_subtipos"];
                size_array = array_subtipos.length;               
                for(i=0;i<size_array;i++){
                    $("#subtipohijo").append('<option value='+array_subtipos[i].id+'>'+array_subtipos[i].nombre+'</option>');
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

function show_subtiposNietos(val,id_combobox){
    
    $.ajax({
        url: inside_url+'eventos_adversos/show_subtiposnieto',
        type: 'POST',
        async: false,
        data: { 'idsubtipohijo' : val },
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
                var array_subtipos = response["array_subtipos"];
                size_array = array_subtipos.length;
                if(id_combobox==1){
                    for(i=0;i<size_array;i++){
                        $("#subtipohijo").append('<option value='+array_subtipos[i].id+'>'+array_subtipos[i].nombre+'</option>');
                    }
                }else{
                    for(i=0;i<size_array;i++){
                        $("#subtipohijo2").append('<option value='+array_subtipos[i].id+'>'+array_subtipos[i].nombre+'</option>');
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

function show_tiposServicios(val){
    $.ajax({
        url: inside_url+'eventos_adversos/show_tiposServicios',
        type: 'POST',
        async: false,
        data: { 'identorno_asistencial' : val },
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
                var array_subtipos = response["array_subtipos"];
                size_array = array_subtipos.length;               
                for(i=0;i<size_array;i++){
                    $("#tipo_servicio").append('<option value='+array_subtipos[i].id+'>'+array_subtipos[i].nombre+'</option>');
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

function show_etapasServicios(val){
    entorno_asistencial = $('#entorno_asistencial').val();
    $.ajax({
        url: inside_url+'eventos_adversos/show_etapasServicios',
        type: 'POST',
        async: false,
        data: { 'idtipo_servicio' : val,
                'identorno_asistencial': entorno_asistencial },
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
                var array_subtipos = response["array_subtipos"];
                size_array = array_subtipos.length; 
                for(i=0;i<size_array;i++){
                    $("#etapa_servicio").append('<option value='+array_subtipos[i].id+'>'+array_subtipos[i].nombre+'</option>');
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

function fill_activo_infos(val){
    $.ajax({
        url: inside_url+'eventos_adversos/fill_activo_info',
        type: 'POST',
        data: { 'codigo_patrimonial' : val },
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
                activo = response["activo"];
                if(activo==null){
                    $('#servicio').val(null);
                    $('#ubicacion_fisica').val(null);
                    $('#nombre_equipo').val(null);
                    $('#serie').val(null);
                    $('#modelo').val(null);
                    $('#proveedor').val(null);
                }else{
                    $('#servicio').val(activo.nombre_servicio);
                    $('#ubicacion_fisica').val(activo.nombre_ubicacion_fisica);
                    $('#nombre_equipo').val(activo.nombre_equipo);
                    $('#serie').val(activo.numero_serie);
                    $('#modelo').val(activo.nombre_modelo);
                    $('#proveedor').val(activo.razon_social);
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