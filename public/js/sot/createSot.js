$( document ).ready(function(){
    $("#fecha_solicitud").datetimepicker({
        defaultDate: false,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY'
    });

    $('#submit-delete').click(function(){
    	BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
					document.getElementById("disable_sot").submit();
				}
			}
		});
    });

    $('#submit-delete-false-alarm').click(function(){
    	BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
					document.getElementById("disable_sot_false_alarm").submit();
				}
			}
		});
    });

    $('#submit-edit').click(function(){
    	BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
					document.getElementById("submit_program_ot").submit();
				}
			}
		});
    });
});