$( document ).ready(function(){
	
	init_ot_create();

	$("#submit-personal").click(function(e){
		e.preventDefault;
			var error_str = "";
			var reg = /[\w'-]+/;
			var floatRegex = /^\d{1,6}(\.\d{0,2}){0,1}$/;
			var is_correct = true;
			$("input[name=nombre_personal]").parent().removeClass("has-error has-feedback");
			$("input[name=horas_trabajadas]").parent().removeClass("has-error has-feedback");
			$("input[name=costo_personal]").parent().removeClass("has-error has-feedback");
			if(!reg.test($("input[name=nombre_personal]").val())){
				error_str += "El nombre debe ser alfanumérico.\n";
				$("input[name=nombre_personal]").parent().addClass("has-error has-feedback");
				is_correct = false;
			}
			if($("input[name=nombre_personal]").val().length < 1 || $("input[name=nombre_personal]").val().length > 200){
				error_str += "El nombre es obligatorio y debe contener menos de 200 caracteres.\n";
				$("input[name=nombre_personal]").parent().addClass("has-error has-feedback");
				is_correct = false;
			}
			if(!floatRegex.test($("input[name=horas_trabajadas]").val()) || $("input[name=horas_trabajadas]").val().length < 1 || $("input[name=horas_trabajadas]").val().length > 10){
				error_str += "Las horas deben tener un formato fraccionario: 0.5.\n";
				is_correct = false;
				$("input[name=horas_trabajadas]").parent().addClass("has-error has-feedback");
			}
			if(!floatRegex.test($("input[name=costo_personal]").val()) || $("input[name=costo_personal]").val().length < 1 || $("input[name=costo_personal]").val().length > 10){
				error_str += "El costo tiene un formato incorrecto.\n";
				is_correct = false;
				$("input[name=costo_personal]").parent().addClass("has-error has-feedback");
			}
			if(is_correct){
				$.ajax({
					url: inside_url+'verif_metrologica/submit_create_personal_ajax',
					type: 'POST',
					data: { 
						'idot_vmetrologica' : $("input[name=idot_vmetrologica]").val(),
						'nombre_personal' : $("input[name=nombre_personal]").val(),
						'horas_trabajadas' : $("input[name=horas_trabajadas]").val(),
						'costo_personal' : $("input[name=costo_personal]").val()
					},
					beforeSend: function(){
						$(this).prop('disabled',true);
					},
					complete: function(){
						$(this).prop('disabled',false);
					},
					success: function(response){
						var str = "";
						str += '<tr id="personal-row-'+response.personal.idpersonal_ot_preventivo+'"><td>'+response.personal.nombre+'</td>';
						str += "<td>"+response.personal.horas_hombre+"</td>";
						str += "<td>"+response.personal.costo+"</td>";
						str += '<td><button class="btn btn-danger boton-eliminar-personal" onclick="eliminar_personal(event,'+response.personal.idpersonal_ot_preventivo+')" type="button">Eliminar</button></td></tr>';
						$("#personal-table").append(str);
						$("input[name=costo_total]").val(response.costo_total);
					},
					error: function(){
					}
				});
			}else{
				$('#modal_text_ot').html('<p>'+error_str+'</p>');
				$('#modal_header_ot').addClass('bg-danger');
            	$('#modal_info_ot').modal('show');   
			}
		
	});
});


function init_ot_create(){
	array_fecha = $('#fecha_programacion_ot').val().split('-');
	fecha_str = array_fecha[2]+"-"+array_fecha[1]+"-"+array_fecha[0];
	$("#datetimepicker_conformidad_fecha").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY',
		sideBySide: true,
		minDate: fecha_str
	});
	$('#fecha_conformidad').val('');
	
	$("#datetimepicker_conformidad_hora").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'HH:ss',
		sideBySide: true
	});

	$("#datetimepicker_fecha_inicio_ot").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});

	$("#datetimepicker_fecha_fin_ot").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY HH:ss',
		sideBySide: true
	});
}

function eliminar_personal(e,id){
	e.preventDefault();
	if (confirm('¿Está seguro de eliminar el personal de la OT?')){
		$.ajax({
			url: inside_url+'verif_metrologica/submit_delete_personal_ajax',
			type: 'POST',
			data: { 
				'idot_vmetrologica' : $("input[name=idot_vmetrologica]").val(),
				'idpersonal_ot_preventivo' : id,
			},
			beforeSend: function(){
				//$(this).prop('disabled',true);
			},
			complete: function(){
				//$(this).prop('disabled',false);
			},
			success: function(response){
				$("#personal-row-"+id).remove();
				$("input[name=costo_total]").val(response.costo_total);
			},
			error: function(){
			}
		});
	}
}