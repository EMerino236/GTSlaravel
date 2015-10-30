
$( document ).ready(function(){

	$("#datetimepicker_prog_fecha").datetimepicker({
			defaultDate: false,
			ignoreReadonly: true,
			format: 'DD-MM-YYYY',
			sideBySide: true
	});

    $("#datetimepicker_prog_hora").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'HH:ss',
            sideBySide: true
    });


    $('#cod_pat').change(function(){
        search_equipo_ajax();
    });

    $('#btnAddProgramacion').click(function(){
        addFilaMantenimiento();
    });

    $('#btnLimpiar').click(function(){
        limpiar();
    });

    ver_programaciones();

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
                for(var i=0;i<array.length;i++){
                    var prog = array[i];
                    programaciones[prog] = {};
                }
                initialize_calendar(programaciones);                
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
                    var count_mes = response['count_month'];
                    var count_trimestre = response['count_trimester'];
                    $('#mes').val(count_mes);
                    $('#trimestre').val(count_trimestre);
                }
                else{                        
                    $("#nombre_equipo").val('');
                    $('#mes').val('');
                    $('#trimestre').val('');
                    $('.days .day').each(function(){
                        element_div = $(this);
                        element_div.removeClass('active');                                     
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



function initialize_calendarX(programaciones){
    $('.responsive-calendar').responsiveCalendar({
        translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
        events: programaciones,
    });
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
        $('#modal_create_text').append('<p>Ingresar fecha correcta. La fecha debe ser del mes actual.</p>');
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
                    $('#modal_header_edit').removeClass();
                    $('#modal_header_edit').addClass("modal-header");
                    $('#modal_header_edit').addClass(type_message);
                    $('#modal_edit_text').empty();
                    $('#modal_edit_text').append("<p>"+message+"</p>");
                    $('#modal_edit').modal('show');
                    if(type_message == "bg-success"){
                        alert("ole");
                        var url = inside_url + "/mant_preventivo/list_mant_preventivo";
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