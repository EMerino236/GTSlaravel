$( document ).ready(function(){

	$('#btnLimpiar_list_ire').click(function(){
		limpiar_criterios();
	});

});

function limpiar_criterios()
{
	$('#search_departamento').prop('selectedIndex','0');
	$('#search_servicio').prop('selectedIndex','0');
}