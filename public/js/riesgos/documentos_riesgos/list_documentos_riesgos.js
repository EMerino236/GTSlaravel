$( document ).ready(function(){
	$('#btnLimpiar').click(function(){
	 		$('#search_nombre').val("");
	 		$('#search_autor').val("");
	 		$('#search_codigo_archivamiento').val("");
	 		$('#search_ubicacion').val("");
	 		$('#search_tipo_documento').val(0);
	 	});
});