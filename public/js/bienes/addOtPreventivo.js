$( document ).ready(function(){
	$("#datetimepicker_prog_fecha").datetimepicker({
			defaultDate: false,
			ignoreReadonly: true,
			format: 'DD-MM-YYYY HH:ss',
			sideBySide: true
	});


    $('#cod_pat').change(function(){
        search_equipo_ajax();
    });

});


function search_equipo_ajax(){
	var val = $("#cod_pat").val();
        if(val == null){
            return;
        }
        $.ajax({
            url: inside_url+'mant_preventivo/search_equipo_ajax',
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
                    var equipo = response['equipo'];
                    if(equipo != null){
                        $("#nombre_equipo").val("");
                        $("#nombre_equipo").css('background-color','#5cb85c');
                        $("#nombre_equipo").css('color','white');
                        $("#nombre_equipo").val(equipo.nombre_equipo);
                    }
                    else{                        
                        $("#nombre_equipo").val("Equipo no registrado");
                        $("#nombre_equipo").css('background-color','#d9534f');
                        $("#nombre_equipo").css('color','white');                      
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

function deleteRow(event,el){
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    index_value = parent.rowIndex-1;
    cells = parent.cells;
    clear_calendar(cells[5].innerHTML,cells[2].innerHTML);
    parent.parentNode.removeChild(parent);

}

function clear_calendar(fecha,nombre){
    date_array = fecha.split("-");
    $('.days .day').each(function(){
        element_div = $(this);
        element_div_name = element_div.prop('tagName');
        element = $(this).find("a");
        if(element.attr('data-day')==date_array[0] && element.attr('data-month')==date_array[1] && element.attr('data-year')==date_array[2]){
            $(element_div_name+" p").each(function(){
                if($(this).html()==nombre)
                    $(this).remove();
            });
            
        }    
    })
}s

function addFilaMantenimiento(){
    var codigo_patrimonial = $('#cod_pat').val();
    var nombre_equipo = $('#nombre_equipo').val();
    var cantidad_filas = $("#table_preventivo tr").length-1;
    var fecha = $('#fecha').val();
    var hora = $('#hora').val();
    var mes = parseInt(fecha.split('-')[1]);
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth()+1;

   
    if(nombre_equipo=='Equipo no registrado' || nombre_equipo==''){
        $('#modal_create_text').empty();
        $('#modal_create_text').append('<p>Ingresar equipo correcto</p>');
        $('#modal_create').modal('show');
    }else if(fecha=='' || currentMonth!=mes){
        $('#modal_create_text').empty();
        $('#modal_create_text').append('<p>Ingresar fecha correcta. La fecha debe ser del mes actual.</p>');
        $('#modal_create').modal('show');
    }else if(hora==''){
        $('#modal_create_text').empty();
        $('#modal_create_text').append('<p>Ingresar hora</p>');
        $('#modal_create').modal('show');
    }else{
        $('#modal_create_text').empty();
        $('#table_preventivo').append("<tr><td>"+cantidad_filas+'</td>'
                +"<td>"+codigo_patrimonial+"</td>"
                +"<td>"+nombre_equipo+"</td>"
                +"<td>0</td>"
                +"<td>0</td>"
                +"<td>"+fecha+"</td>"
                +"<td>"+hora+"</td>"
                +"<td><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span>Eliminar</a></td></tr>");
        fill_equipo_tocalendar(fecha,nombre_equipo);
    }

}

function fill_equipo_tocalendar(fecha,nombre_equipo){
    var date_array = fecha.split("-");
    $('.days .day').each(function(){
        element_insert_name = $(this);
        element = $(this).find("a");
        if(element.attr('data-day')==parseInt(date_array[0]) && element.attr('data-month')==parseInt(date_array[1]) && element.attr('data-year')==parseInt(date_array[2])){
            element_insert_name.append('<p>'+nombre_equipo+'</p>');
        }
    
    })
}