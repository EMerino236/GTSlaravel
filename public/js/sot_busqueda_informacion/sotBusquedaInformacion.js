$( document ).ready(function(){
	init_ot_program();

	$("#submit-delete").click(function(){
		BootstrapDialog.confirm({
	        title: 'Mensaje de Confirmación',
	        message: '¿Está seguro que desea realizar esta acción?', 
	        type: BootstrapDialog.TYPE_INFO,
	        btnCancelLabel: 'Cancelar', 
	        btnOKLabel: 'Aceptar', 
		        callback: function(result){
		            if(result) {
		            	document.getElementById("submitState").submit();
		            }
		        }
       	});
	});
});

function init_ot_program(){
	$("#datetimepicker_prog_fecha").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'DD-MM-YYYY HH:ss',
            sideBySide: true
    });
}