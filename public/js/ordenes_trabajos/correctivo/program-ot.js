$( document ).ready(function(){
     init_ot_program();
});

function ver_programaciones(){
    var trimestre_ini = $('#trimestre_ini').val();
    var trimestre_fin = $('#trimestre_fin').val();
    $.ajax({
        url: inside_url+'mant_correctivo/ver_programaciones',
        type: 'POST',
        data: {'trimestre_ini': trimestre_ini,
                'trimestre_fin':trimestre_fin },
        beforeSend: function(){
            $(".loader_container").show();
        },
        complete: function(){
            $(".loader_container").hide();
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
                        "id":array_ot[i].idot_correctivo
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

function initialize_calendarX(programaciones){
    $('.responsive-calendar').responsiveCalendar({
        translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
        events:programaciones,
        onActiveDayClick: function(events){	        
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
	            $('#modal_header_ot').addClass("modal-header");
	            $('#modal_header_ot').addClass("bg-info");
	            url =  inside_url+'mant_correctivo/create_ot/'+$(this)[key].id;
                $output += 'OT: <a href="'+url+'" target="_blank">'+$(this)[key].title+'</a>' + '<p>Estado: '+$(this)[key].status+'<br />Hora: '+$(this)[key].time+'</p>';
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

function fadeOutModalBox(num) {
    setTimeout(function(){ $(".responsive-calendar-modal").fadeOut(); }, num);
  }

function removeModalBox() { $(".responsive-calendar-modal").remove(); }

function init_ot_program(){

    $("#datetimepicker_prog_fecha").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'DD-MM-YYYY HH:mm',
            sideBySide: true
    });
    
    $("#datetimepicker_prog_fecha").on("dp.change", function (e) {
        $('#datetimepicker_prog_fecha').data("DateTimePicker").minDate(e.date);
    });
    ver_programaciones();
}