$( document ).ready(function(){

	$('#btnLimpiar').click(function(){
		limpiar_criterios();
	});

});

function limpiar_criterios()
{
	$('#search_nombre_equipo').val("");
	$('#search_nombre_siga').val("");
	$('#search_marca').prop('selectedIndex','0');
}