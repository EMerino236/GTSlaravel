
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
            $output += '<a href="'+url+'">OT: '+$(this)[key].title+'</a>' + '<p>Estado: '+$(this)[key].status+'<br />Hora:'+$(this)[key].time+'</p>';
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
        $('#modal_create_text').empty();
        $('#modal_create_text').append('<p>Ingresar equipo correcto</p>');
        $('#modal_create').modal('show');
    }else if(fecha==''){
        $('#modal_create_text').empty();
        $('#modal_create_text').append('<p>Ingresar fecha.');
        $('#modal_create').modal('show');
    }else if(hora==''){
        $('#modal_create_text').empty();
        $('#modal_create_text').append('<p>Ingresar hora</p>');
        $('#modal_create').modal('show');
    }else{
        $('#modal_create_text').empty();
        $('#table_programacion').append("<tr>"
                +"<td>"+codigo_patrimonial+"</td>"
                +"<td>"+nombre_equipo+"</td>"
                +"<td>"+count_otMes+"</td>"
                +"<td>"+count_otTrimestre+"</td>"
                +"<td>"+fecha+"</td>"
                +"<td>"+hora+"</td>"
                +"<td id=\""+usuario_id+"\">"+usuario_nombre+"</td>"
                +"<td><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span>Eliminar</a></td></tr>");
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
                    $('#modal_header_confirm').removeClass();
                    $('#modal_header_confirm').addClass("modal-header ");
                    $('#modal_header_confirm').addClass(type_message);
                    $('#modal_text_confirm').empty();
                    $('#modal_text_confirm').append("<p>"+message+"</p>");
                    $('#modal_confirm').modal('show');
                    if(type_message == "bg-success"){
                        var url = inside_url + "mant_preventivo/list_mant_preventivo";
                        $('#btn_close_modal_confirm').click(function(){
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