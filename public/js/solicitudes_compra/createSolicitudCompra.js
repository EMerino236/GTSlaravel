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

    $('#submit_edit_solicitud').click(function(){
        sendDataToController_edit();
    });

    $('#submit_create_solicitud').click(function(){
        sendDataToController_create();
    });
    

    $("#btn_descarga").hide();
    $("input[name=numero_reporte_hidden]").val(null);
    fill_name_reporte();

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
    
});

function search_equipos_ajax(id){       
        var val = $('#marca'+id).val();
        if(val == 0){
            $("#equipo"+id).empty();
            $("#equipo"+id).append('<option value='+0+'>Seleccione</option>');
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
                    $("#equipo"+id).append('<option value='+0+'>Seleccione</option>');
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
    if(descripcion!='' && marca!='' && modelo !='' && serie_parte!='' && cantidad!=''){
        if(!isNaN(cantidad) || cantidad>999999){
            BootstrapDialog.confirm({
                title: 'Mensaje de Confirmación',
                message: '¿Está seguro que desea realizar esta acción?', 
                type: BootstrapDialog.TYPE_INFO,
                btnCancelLabel: 'Cancelar', 
                btnOKLabel: 'Aceptar', 
                callback: function(result){
                    if(result) {
                        $('#table_solicitud').append("<tr><td id="+cantidad_filas+">"+descripcion+"</td>"
                        +"<td>"+marca+"</td>"
                        +"<td>"+modelo+"</td>"
                        +"<td>"+serie_parte+"</td>"
                        +"<td>"+cantidad+"</td>"
                        +"<td><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span>Eliminar</a></td></tr>");
                        refresh();
                    }
                }
            });            
        }else{
            $('#modal_detail_text').html('<p>Campo Cantidad no es un numero entre 0 y 999999</p>');
            $('#myModal').modal('show');     
        }
    }else{
        $('#modal_detail_text').html('<p>Ingresar todos los campos completos.</p>');          
        $('#myModal').modal('show');       
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
        if(val=="")
            val = "vacio";    
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
                    if(val!="vacio"){
                        if(resp[0] != null){
                            $("#nombre_reporte").val("");
                            $("#nombre_reporte").css('background-color','#5cb85c');
                            $("#nombre_reporte").css('color','white');
                            $("#nombre_reporte").val(resp[0].nombre);
                            $("#btn_descarga").show();
                            $("input[name=numero_reporte_hidden]").val(val);                            
                        }
                        else{
                            $("#nombre_reporte").val("Documento no registrado");
                            $("#nombre_reporte").css('background-color','#d9534f');
                            $("#nombre_reporte").css('color','white');
                            $("#btn_descarga").hide();
                            $("input[name=numero_reporte_hidden]").val(null);
                        } 
                    }else{
                        $("#nombre_reporte").val("Documento no registrado");
                        $("#nombre_reporte").css('background-color','#d9534f');
                        $("#nombre_reporte").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_reporte_hidden]").val(null);
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
}

function deleteRow(event,el)
{    
     BootstrapDialog.confirm({
        title: 'Mensaje de Confirmación',
        message: '¿Está seguro que desea realizar esta acción?', 
        type: BootstrapDialog.TYPE_INFO,
        btnCancelLabel: 'Cancelar', 
        btnOKLabel: 'Aceptar', 
        callback: function(result){
            if(result) {
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
            }
        }
    });
   
}

function readTableData(){
    var rowSize = document.getElementById("table_solicitud").rows.length;
    var rows = document.getElementById("table_solicitud").rows;
    // fill the array with values from the table
    var matrix = new Array;

    for(i = 1; i < rowSize; i++){
        index_value = rows[i].cells[0].id; 
        cells = rows[i].cells;
        clen = cells.length;               
        var arr = new Array();
        arr.push($('#iddetalle'+index_value).val());
        for(j = 0; j < clen-1; j++){
            arr.push(cells[j].innerHTML);
        }
        matrix.push(arr);
    }
    return matrix;
}

    function sendDataToController_edit(){
        var idsolicitud = $('#reporte_id').val();
        var matrix = readTableData();    
        var numero_ot = $('#numero_ot').val();
        var servicio = $('#servicio').val();
        var equipo = $('#equipo1').val();
        var usuario_responsable = $('#usuario_responsable').val();
        var tipo_solicitud = $('#tipo').val();
        var fecha = $('#fecha').val();
        var estado = $('#estado').val();
        var sustento = $('#sustento').val();
        var numero_reporte = $('#numero_reporte').val(); 
        var size_delete = matrix_detalle_delete.length;
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                     $.ajax({
                        url: inside_url+'solicitudes_compra/submit_edit_solicitud_compra',
                        type: 'POST',
                        data: { 'idsolicitud' : idsolicitud,                    
                                'matrix_detalle' : matrix,
                                'matrix_detalle_delete': matrix_detalle_delete,
                                'numero_ot': numero_ot,
                                'servicio' : servicio,
                                'equipo':equipo,
                                'usuario_responsable':usuario_responsable,
                                'tipo_solicitud':tipo_solicitud,
                                'fecha':fecha,
                                'estado':estado,
                                'sustento':sustento,
                                'numero_reporte':numero_reporte,
                                'size_delete' : size_delete
                            },
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
                                var array_detalle = response["url"];
                                var message = response["message"];
                                var type_message = response["type_message"];
                                var inside_url = array_detalle;
                                $('#modal_header_edit').removeClass();
                                $('#modal_header_edit').addClass("modal-header");
                                $('#modal_header_edit').addClass(type_message);
                                $('#modal_edit_text').empty();
                                $('#modal_edit_text').append("<p>"+message+"</p>");
                                $('#modal_edit').modal('show');
                                if(type_message == "bg-success"){
                                    var url = inside_url + "/solicitudes_compra/list_solicitudes";
                                    $('#btn_close_modal').click(function(){
                                        window.location = url;
                                    });
                                }else if(type_message == "bg-danger"){
                                    var url = inside_url + "/solicitudes_compra/edit_solicitud_compra/"+idsolicitud;
                                    $('#btn_close_modal').click(function(){
                                        window.location = url;
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
                }
            }
        });
       
    }
    
    function sendDataToController_create(){
        var matrix = readTableData();    
        var numero_ot = $('#numero_ot').val();
        var servicio = $('#servicio').val();    
        var equipo = $('#equipo1').val();
        var usuario_responsable = $('#usuario_responsable').val();
        var tipo_solicitud = $('#tipo').val();
        var fecha = $('#fecha').val();
        var estado = $('#estado').val();
        var sustento = $('#sustento').val();
        var numero_reporte = $('#numero_reporte').val();
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    $.ajax({
                        url: inside_url+'solicitudes_compra/submit_create_solicitud_compra',
                        type: 'POST',
                        data: {                
                                'matrix_detalle' : matrix,
                                'numero_ot': numero_ot,
                                'servicio' : servicio,
                                'equipo':equipo,
                                'usuario_responsable':usuario_responsable,
                                'tipo_solicitud':tipo_solicitud,
                                'fecha':fecha,
                                'estado':estado,
                                'sustento':sustento,
                                'numero_reporte':numero_reporte
                            },
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
                                var array_detalle = response["url"];
                                var message = response["message"];
                                var type_message = response["type_message"];
                                var inside_url = array_detalle;
                                $('#modal_header_edit').removeClass();
                                $('#modal_header_edit').addClass("modal-header");
                                $('#modal_header_edit').addClass(type_message);
                                $('#modal_edit_text').empty();
                                $('#modal_edit_text').append("<p>"+message+"</p>");
                                $('#modal_edit').modal('show');
                                if(type_message == "bg-success"){
                                    var url = inside_url + "/solicitudes_compra/list_solicitudes";
                                    $('#btn_close_modal').click(function(){
                                        window.location = url;
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
                }
            }
        });
        
    }

function clean_criterios(){
    $('#search_tipo_solicitud').val(0);
    $('#search_nombre_equipo').val('');
    $('#servicio_clinico').val(0);
    $('#estados').val(0);
    $('#fecha_desde').val('');
    $('#fecha_hasta').val('');
}