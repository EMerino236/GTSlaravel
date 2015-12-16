$( document ).ready(function(){
	$("#datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true
	});

	$('#submit-enable-user').click(function(){
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
					document.getElementById("enable_user").submit();
				}
			}
		});
	});

	$('#submit-disable-user').click(function(){
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
					document.getElementById("disable_user").submit();
				}
			}
		});
	});

	$('#btnLimpiar').click(function(){
		$('#search').val('');
		$('#search_area').val(0);
	});
});