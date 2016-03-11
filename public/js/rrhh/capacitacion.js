function limpiarCriteriosPresupuesto()
{
    $("#search_nombre_capacitacion").val("");
    $("#search_responsable_capacitacion").val("");
    $("#search_departamento_capacitacion").val("");
    $("#search_servicio_capacitacion").val("");
    $("#fecha_ini_capacitacion").val("");
    $("#fecha_fin_capacitacion").val("");
}

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