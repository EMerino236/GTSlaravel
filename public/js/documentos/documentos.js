$( document ).ready(function(){
 	
 	$('#btnLimpiar').click(function(){
 		$('#search_nombre').val("");
 		$('#search_autor').val("");
 		$('#search_codigo_archivamiento').val("");
 		$('#search_ubicacion').val("");
 		$('#search_tipo_documento').val(0);
 	});

 	$('#btnEnable').click(function(){
 		 BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                	document.getElementById('submit_enable').submit();
                }
            }
        });
 	});

 	$('#btnDisable').click(function(){
		 BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                	document.getElementById('submit_disable').submit();
                }
            }
        });
 	});
});