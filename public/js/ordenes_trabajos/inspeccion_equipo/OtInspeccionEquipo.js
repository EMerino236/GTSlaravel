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

	$('#buscar').click(function(){
		value_activo = $('#value_activo').val();
		id = $('#numero_fila').val();
	 	div = document.getElementById(id);
	 	if(div!=null){
	 		if(value_activo == 0){ //primera vez
				$('#value_activo').val(id);			
				div.style.visibility = "visible";
			}else{
				div_anterior = document.getElementById(value_activo);
				div_anterior.style.visibility = "hidden";			
				div.style.visibility = "visible";
				$('#value_activo').val(id);
			}	
	 	}else{
	 		dialog = BootstrapDialog.show({
	            title: 'Advertencia',
	            message: 'Fila no existe',
	            type : BootstrapDialog.TYPE_DANGER,
	            buttons: [{
	                label: 'Aceptar',
	                action: function(dialog) {
	                    dialog.close();
	                }
	            }]
       		});
	 	}
		
	});

	$('#limpiar').click(function(){
		value_activo = $('#value_activo').val();
		$('#numero_fila').val('');
		div = document.getElementById(value_activo);
		div.style.visibility = "hidden";
		$('#value_activo').val(0);
	})
});


function set_idioma_fileinput(){
	count_activos = $('#count_activos').val();
	for(i=0;i<count_activos;i++){		
		$("#input-file"+i).fileinput({
			language:"es",
			allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp"]
		});
	}
}



