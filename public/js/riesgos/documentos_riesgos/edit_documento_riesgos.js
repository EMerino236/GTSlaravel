$( document ).ready(function(){
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