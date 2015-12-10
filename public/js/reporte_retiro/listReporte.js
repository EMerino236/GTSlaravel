$( document ).ready(function(){
 	$('#btnLimpiar').click(function(){
 		limpiar_criterios();
 	});
});

function limpiar_criterios()
{
	$('#search_cod_pat').val('');
	$('#search_equipo').val('');
	$('#search_motivo').val(0);
	$('#search_marca').val(0);
	$('#search_servicio').val(0);
	$('#search_proveedor').val(0);
}