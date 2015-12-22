$( document ).ready(function(){
	
	set_idioma_fileinput();
	
	$(".boton-tarea").click(function(e){
		idot_inspec_equipo = $('#idot_inspec_equipo').val();
		idtareasxactivoxinspeccion = $(this).data('id');
		e.preventDefault;
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
		        	$.ajax({
						url: inside_url+'inspec_equipos/submit_marcar_tarea_ajax',
						type: 'POST',
						data: { 'idtareasxactivoxinspeccion' :idtareasxactivoxinspeccion },
						beforeSend: function(){
						},
						complete: function(){
						},
						success: function(response){
							console.log(response);
							$(this).prop('disabled',true);
							var url = inside_url + "inspec_equipos/create_ot_inspeccion_equipos/"+idot_inspec_equipo;
							window.location = url;
						},
						error: function(){
						}
					});
				}
	        }
       });
	});

	$('#submit_ot').click(function(){
		BootstrapDialog.confirm({
			title: 'Mensaje de Confirmación',
			message: '¿Está seguro que desea realizar esta acción?\n (Si el campo "Estado OT" no se encuentra en estado pendiente, la presente ficha no podrá volver a ser editada)', 
			type: BootstrapDialog.TYPE_INFO,
			btnCancelLabel: 'Cancelar', 
	    	btnOKLabel: 'Aceptar', 
			callback: function(result){
		        if(result) {
		        	document.getElementById('submit_ot_inspeccion').submit();
		        }
		    }
		});
	});
	
});


function set_idioma_fileinput(){
	count_activos = $('#count_activos').val();
	for(i=0;i<count_activos;i++){		
		$("#input-file"+i).fileinput({
			language:"es",
			allowedFileExtensions: ["png","jpe","jpeg","jpg"]
		});
	}
}



