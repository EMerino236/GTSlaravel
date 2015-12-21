
$( document ).ready(function(){

	

    init_ot_program();
    
    
    $('#cod_pat').change(function(){
        search_equipo_ajax();
    });

    $('#btnAddProgramacion').click(function(){
        addFilaMantenimiento();
    });

    $('#btnLimpiar_create').click(function(){
        limpiar();
    });
    

    $('#submit_create_ots').click(function(){
        sendDataToController_create();
    });
    

});

function ver_programaciones(){
    var trimestre_ini = $('#trimestre_ini').val();
    var trimestre_fin = $('#trimestre_fin').val();
    $.ajax({
        url: inside_url+'mant_preventivo/ver_programaciones',
        type: 'POST',
        data: {'trimestre_ini': trimestre_ini,
                'trimestre_fin':trimestre_fin },
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
                var programaciones = {};
                array = response["programaciones"];
                array_ot = response["ots"];
                array_hora = response["horas"];
                array_estado = response["estados"];
                fecha_anterior = array[0]; 
                for(var i=0;i<array.length;i++){
                    var prog = array[i];
                    if(i==0)
                        dayEvents=[];
                    else{
                        if(prog != fecha_anterior){
                            dayEvents = [];
                            fecha_anterior =prog;
                        }                                                    
                    }
                    dayEvents.push({
                        "title":array_ot[i].ot_tipo_abreviatura+array_ot[i].ot_correlativo+array_ot[i].ot_activo_abreviatura,
                        "time": array_hora[i],
                        "status":array_estado[i].nombre,
                        "id":array_ot[i].idot_preventivo
                    });
                    programaciones[prog] = {dayEvents};
                }
                initialize_calendarX(programaciones);                
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });
}

function search_equipo_ajax(){
	var val = $("#cod_pat").val();
    var mes_ini = $('#mes_ini').val();
    var mes_fin = $('#mes_fin').val();
    var trimestre_ini = $('#trimestre_ini').val();
    var trimestre_fin = $('#trimestre_fin').val();   
    $.ajax({
        url: inside_url+'mant_preventivo/search_equipo_ajax',
        type: 'POST',
        data: { 'selected_id' : val,
                'mes_ini' : mes_ini,
                'mes_fin' : mes_fin,
                'trimestre_ini': trimestre_ini,
                'trimestre_fin':trimestre_fin},
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
                var equipo = response['equipo'];
                if(equipo != null){
                    $("#nombre_equipo").val("");
                    $("#nombre_equipo").val(equipo.nombre_equipo);
                    var count_mes = response['count_mes'];
                    var count_trimestre = response['count_trimestre'];
                    $('#mes').val(count_mes);
                    $('#trimestre').val(count_trimestre);
                }
                else{                        
                    $("#nombre_equipo").val('');
                    $('#mes').val('');
                    $('#trimestre').val('');                         
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

function readTableData(){
    var rowSize = document.getElementById("table_programacion").rows.length;
    var rows = document.getElementById("table_programacion").rows;
    // fill the array with values from the table
    var matrix = new Array;

    for(i = 1; i < rowSize; i++){
        index_value = rows[i].cells[0].id; 
        cells = rows[i].cells;
        clen = cells.length;               
        var arr = new Array();
        for(j = 0; j < clen-1; j++){
            if(j==6){
                arr.push(cells[j].id);
            }else
                arr.push(cells[j].innerHTML);
        }
        matrix.push(arr);
    }
    return matrix;

}

function deleteRow(event,el)
{    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
}

function fadeOutModalBox(num) {
    setTimeout(function(){ $(".responsive-calendar-modal").fadeOut(); }, num);
  }

function removeModalBox() { $(".responsive-calendar-modal").remove(); }


function initialize_calendarX(programaciones){
    $('.responsive-calendar').responsiveCalendar({
        translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
        events:programaciones,
        onActiveDayClick: function(events) {
        var $today, $dayEvents, $i, $isHoveredOver, $placeholder, $output;
        $i = $(this).data('year')+'-'+zero($(this).data('month'))+'-'+zero($(this).data('day'));
        $today= events[$i];
        $dayEvents = $today.dayEvents;
        $output = '<div class="responsive-calendar-modal">';
        $.each($dayEvents, function() {
          $.each( $(this), function( key ){
            $("#modal_text_ot").empty();    
            $('#modal_ot').modal('show');
            $('#modal_header_ot').removeClass();
            $('#modal_header_ot').addClass("modal-header ");
            $('#modal_header_ot').addClass("bg-info");
            url =  inside_url+'mant_preventivo/create_ot_preventivo/'+$(this)[key].id;
            $output += 'OT: <a href="'+url+'" target="_blank">'+$(this)[key].title+'</a>' + '<p>Estado: '+$(this)[key].status+'<br />Hora:'+$(this)[key].time+'</p>';
            $('#modal_text_ot').append($output);
          });
        });
        },
    /* end $cal */
    });
}

function zero(num) {
    if (num < 10) { return "0" + num; }
    else { return "" + num; }
  }


function addFilaMantenimiento(){
    var codigo_patrimonial = $('#cod_pat').val();
    var nombre_equipo = $('#nombre_equipo').val();
    var cantidad_filas = $("#table_programacion tr").length-1;
    var fecha = $('#fecha').val();
    var hora = $('#hora').val();
    var usuario_nombre= $('#solicitantes option:selected').html();
    var usuario_id = $('#solicitantes').val();
    var mes = parseInt(fecha.split('-')[1]);
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth()+1;
    var count_otMes = $('#mes').val();
    var count_otTrimestre = $('#trimestre').val();
   
    if(nombre_equipo=='Equipo no registrado' || nombre_equipo==''){
        dialog = BootstrapDialog.show({
            title: 'Advertencia',
            message: 'Ingresar equipo correcto',
            type : BootstrapDialog.TYPE_DANGER,
            buttons: [{
                label: 'Aceptar',
                action: function(dialog) {
                    dialog.close();
                }
            }]
        });
    }else if(fecha==''){
        dialog = BootstrapDialog.show({
            title: 'Advertencia',
            message: 'Ingresar fecha',
            type : BootstrapDialog.TYPE_DANGER,
            buttons: [{
                label: 'Aceptar',
                action: function(dialog) {
                    dialog.close();
                }
            }]
        });
    }else if(hora==''){
        dialog = BootstrapDialog.show({
            title: 'Advertencia',
            message: 'Ingresar hora',
            type : BootstrapDialog.TYPE_DANGER,
            buttons: [{
                label: 'Aceptar',
                action: function(dialog) {
                    dialog.close();
                }
            }]
        });
    }else{
        $('#modal_create_text').empty();
        $('#table_programacion').append("<tr>"
                +"<td class=\"text-nowrap text-center\">"+codigo_patrimonial+"</td>"
                +"<td class=\"text-nowrap text-center\">"+nombre_equipo+"</td>"
                +"<td class=\"text-nowrap text-center\">"+count_otMes+"</td>"
                +"<td class=\"text-nowrap text-center\">"+count_otTrimestre+"</td>"
                +"<td class=\"text-nowrap text-center\">"+fecha+"</td>"
                +"<td class=\"text-nowrap text-center\">"+hora+"</td>"
                +"<td class=\"text-nowrap text-center\" id=\""+usuario_id+"\">"+usuario_nombre+"</td>"
                +"<td class=\"text-nowrap text-center\"><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span></a></td></tr>");
        limpiar();
    }
}

function init_ot_program(){
    
    $("#datetimepicker_prog_fecha").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'DD-MM-YYYY',
            sideBySide: true,
            minDate: new Date()
    });

    $("#datetimepicker_prog_hora").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'HH:ss',
            sideBySide: true
    });
    $('#fecha').val('');
    ver_programaciones();
}

function limpiar(){
    $('#cod_pat').val('');
    $('#nombre_equipo').val('');
    $('#mes').val('');
    $('#trimestre').val('');
    $('#fecha').val('');
    $('#hora').val('');
}

function sendDataToController_create(){
        var matrix = readTableData();
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    $.ajax({
                        url: inside_url+'mant_preventivo/submit_programacion',
                        type: 'POST',
                        data: {                
                                'matrix_detalle' : matrix,
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
                                
                                if(type_message=="bg-success"){
                                    dialog = BootstrapDialog.show({
                                        title: 'Advertencia',
                                        message: message,
                                        closable: false,
                                        type : BootstrapDialog.TYPE_SUCCESS,
                                        buttons: [{
                                            label: 'Aceptar',
                                            action: function(dialog) {
                                                var url = inside_url + "mant_preventivo/list_mant_preventivo";
                                                window.location = url;
                                            }
                                        }]
                                    });
                                }else{
                                    dialog = BootstrapDialog.show({
                                        title: 'Advertencia',
                                        message: message,
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