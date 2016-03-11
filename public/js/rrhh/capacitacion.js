

function habilitaCampos(){
	var valor = $('#tipo_capacitacion :selected').val();

	if(valor == 1 || valor == 2){
		$('#collapseCampos').slideDown();
	}else{
		$('#collapseCampos').slideUp();
		limpiaCollapseCampos();
	}

	
}

function limpiaCollapseCampos(){
	$('#codigo_patrimonial').val('');
	$('#equipo_relacionado').val('');
}