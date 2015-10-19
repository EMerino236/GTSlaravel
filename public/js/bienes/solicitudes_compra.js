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

    $('#equipo1').prop('disabled',true);

    $('#numero_ot').on('change',function(){
        validate_ot();
    });

    $('#submit-edit').click(function(){
        getTableDetallesSolicitudHTML();
    })

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
    if(descripcion!='' && marca!='' && modelo !='' && serie_parte!='' && cantidad!=''){
        $('#table_solicitud').append("<tr id=\"idRow"+cantidad_filas+"\">"+
                        '<td id="descripcion'+cantidad_filas+'\">'+descripcion+'</td>'+
                        '<td id="marca_detalle'+cantidad_filas+'\">'+marca+'</td>'+
                        '<td id="modelo'+cantidad_filas+'\">'+modelo+'</td>'+
                        '<td id="serie_parte'+cantidad_filas+'\">'+serie_parte+'</td>'+
                        '<td id="cantidad'+cantidad_filas+'\">'+cantidad+'</td>'+
                        '<td><a class="btn btn-danger btn-block"  onClick="$(this).closest(\'tr\').remove();" id="btnRemove">Quitar</a></td>'
                        +"</tr>");
        refresh();
    }else{
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
                    if(resp!="vacio"){
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

function validate_ot(){
    var id_ot = $("#numero_ot").val();
    if(id_ot=="")
            id_ot = "vacio"; 
    $.ajax({
            url: inside_url+'solicitudes_compra/validate_ot',
            type: 'POST',
            data: { 'selected_id' : id_ot },
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
                    var resp = response['ot'];
                    if(resp[0] != null){
                        $("#numero_ot").css('background-color','#5cb85c');
                        $("#numero_ot").css('color','white');                                                       
                    }
                    else{
                        $('#modalOT').modal('show'); 
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

function getTableDetallesSolicitudHTML(){
    var table = document.getElementById('table_solicitud');
    var rowLength = table.rows.length;
    var matriz_detalle = [];
    for(var i=1; i<rowLength; i++){
      var row = table.rows[i];
      var cellLength = row.cells.length; 
      var arrayDetalle = [];
      for(var y=0; y<cellLength-1; y++){
        var cell = row.cells[y].innerHTML;        
        //do something with every cell here
        arrayDetalle.push(cell);
      }
      matriz_detalle.push(arrayDetalle);
    }

    return matriz_detalle;
}

//realizar un ajax para regresar en el controlador todo lo realizado anteriormente y registrarlo
//en la BD, luego hacer que el ajax retorne una redireccion con un resultado.