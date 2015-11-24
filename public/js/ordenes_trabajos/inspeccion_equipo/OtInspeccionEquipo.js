$( document ).ready(function(){
	
	set_idioma_fileinput();
	
	$(".boton-tarea").click(function(e){
		idot_inspec_equipo = $('#idot_inspec_equipo').val();
		e.preventDefault;
		if (confirm('¿Está seguro de esta acción?')){
			$.ajax({
				url: inside_url+'inspec_equipos/submit_marcar_tarea_ajax',
				type: 'POST',
				data: { 'idtareasxactivoxinspeccion' : $(this).data('id') },
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
	});
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



