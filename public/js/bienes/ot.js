$( document ).ready(function(){

	$("#datetimepicker3").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	var idactivo = $("input[name=idactivo]").val();
	$.ajax({
		url: inside_url+'mant_correctivo/calendario_ot_mant_correctivo',
		type: 'POST',
		data: { 'idactivo' : idactivo },
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(response){
			var programaciones = {};
			for(var i=0;i<response.programaciones.length;i++){
				var prog = response.programaciones[i];
				programaciones[prog] = {};
			}
			console.log(response);
			console.log(programaciones);
			initialize_calendar(programaciones);
		},
		error: function(){
		}
	});
    
});


function initialize_calendar(programaciones){
	$('.responsive-calendar').responsiveCalendar({
    	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
    	events: programaciones,
    });
}