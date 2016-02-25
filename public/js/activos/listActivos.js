$( document ).ready(function(){
 	
 	$('#btnLimpiar_list_activos').click(function(){
 		limpiar_criterios_list_activos();
 	});
});

function limpiar_criterios_list_activos()
{

	$('#search_grupo').prop('selectedIndex','0');
	$('#search_servicio').prop('selectedIndex','0');
	$('#search_ubicacion').prop('selectedIndex','0');	
	$('#search_marca').prop('selectedIndex','0');
	$('#search_proveedor').prop('selectedIndex','0');

	$('#search_nombre_equipo').val("");
	$('#search_modelo').val("");
	$('#search_serie').val("");
	$('#search_codigo_compra').val("");
	$('#search_codigo_patrimonial').val("");
	$('#search_nombre_siga').val("");
	$('#search_vigencia').prop('selectedIndex','0');
	$('#fecha_adquisicion_ini').val("");
	$('#fecha_adquisicion_fin').val("");
}