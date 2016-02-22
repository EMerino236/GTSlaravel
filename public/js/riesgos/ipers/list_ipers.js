$( document ).ready(function(){
	
	$('#search_datetimepicker1').datetimepicker({
 		ignoreReadonly: true,
 		format:'YYYY'
 	});

	$('#btnLimpiar').click(function(){
 		$('#search_codigo_reporte').val(null);
 		$('#search_anho').val(null);
 		$('#search_usuario').val(null);
 		
 		if($('#search_servicio').length) 			
 			$('#search_servicio').val(null);
 		
 		if($('#search_entorno').length)
 			$('#search_entorno').val(null);

 	});

});
