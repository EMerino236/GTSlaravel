$( document ).ready(function(){
 	
 	init();

 	$('#tipo_documento_identidad').change(function(){
 		edit_numero_documento();
 	});

 	$('#btnLimpiar_soporte_tecnico').click(function(){
 		limpiar_criterios();
 	});

});

function init()
{
	var idtipo_documento = $('#tipo_documento_identidad').val();

	if(idtipo_documento == ''){
		$('#numero_documento_soporte_tecnico').prop('disabled',true);
	}else{
		$('#numero_documento_soporte_tecnico').prop('disabled',false);
	}
}

function edit_numero_documento()
{
	var idtipo_documento = $('#tipo_documento_identidad').val();

	if(idtipo_documento == ''){
		$('#numero_documento_soporte_tecnico').prop('disabled',true);
		$('#numero_documento_soporte_tecnico').val("");
	}else{
		$('#numero_documento_soporte_tecnico').prop('disabled',false);
	}
}

function limpiar_criterios()
{
	$('#tipo_documento_identidad').prop('selectedIndex',0);
	$('#numero_documento_soporte_tecnico').prop('disabled',true);
	$('#numero_documento_soporte_tecnico').val("");
	$('#nombre_soporte_tecnico').val("");
	$('#apPaterno_soporte_tecnico').val("");
	$('#apMaterno_soporte_tecnico').val("");
}