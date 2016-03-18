$( document ).ready(function(){ 

	$("#adjuntar_acuerdo_convenio").hide();

	$('#modalDeleteAcuerdoConvenio').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var value = button.data('value') // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.	  
	  var modal = $(this)
	  modal.find('#id_acuerdo_convenio').val(value);  
	});

});
var alphanumeric_pattern = /[^á-úÁ-Úa-zA-ZñÑüÜ0-9- _.]/;

function limpiarCriteriosAcuerdoConvenio()
{
    $("#search_nombre_convenio").val("");
    $("#search_duracion_convenio").val("");
    $("#fecha_ini_firma_convenio").val("");
    $("#fecha_fin_firma_convenio").val("");
}

function showAdjuntarAcuerdoConvenio()
{
	$("#adjuntar_acuerdo_convenio").toggle();
}

function agregarInstitucion()
{
	var institucion = $("#institucion_convenio").val();

	if(institucion != "")
	{
		BootstrapDialog.confirm({
	            title: 'Mensaje de Confirmación',
	            message: '¿Está seguro que desea agregar ' + institucion.bold() + ' como institución relacionada?', 
	            type: BootstrapDialog.TYPE_INFO,
	            btnCancelLabel: 'Cancelar', 
	            btnOKLabel: 'Aceptar', 
	            callback: function(result){
	                if(result)
	                {   
	                    var str = "<tr><td class=\"text-nowrap\"><input style=\"border:0\" name='instituciones[]' value='"+institucion+"' readonly/></td>";	                    
	                    str += "<td class=\"text-nowrap text-center\"><div class=\"btn btn-danger btn-block btn-sm\" style=\"width:145px; float: right\" onclick=\"deleteRow(event,this)\"><span class=\"glyphicon glyphicon-trash\"></span> Eliminar</a></div></tr>";	                    
	                    $("#institucion_relacionada_table").append(str);	                    
	                    $("#institucion_convenio").val('');	                    
	                }
	            }
	        });		
	}
}

function agregarRepresentanteAsociado()
{
	var nombre = $("#nombre_representante_convenio").val();
	var appat = $("#appat_representante_convenio").val();
	var apmat = $("#apmat_representante_convenio").val();
	var area = $("#area_representante_convenio").val();
	var rol = $("#rol_representante_convenio").val();

	if(nombre != "" && appat != "" && apmat != "" && area != "" && rol != "")
	{
		BootstrapDialog.confirm({
	            title: 'Mensaje de Confirmación',
	            message: '¿Está seguro que desea agregar a ' + appat.bold() + ' ' + apmat.bold() + ', ' + nombre.bold() + ' como representante de una entidad asociada?', 
	            type: BootstrapDialog.TYPE_INFO,
	            btnCancelLabel: 'Cancelar', 
	            btnOKLabel: 'Aceptar', 
	            callback: function(result){
	                if(result)
	                {   
	                    var str = "<tr><td>" + appat + " " + apmat + ", " + nombre +"</td>";
	                    str += "<td class=\"hide\"><input style=\"border:0\" name='representantes_nombre[]' value='"+nombre+"' readonly/></td>";
	                    str += "<td class=\"hide\"><input style=\"border:0\" name='representantes_appat[]' value='"+appat+"' readonly/></td>";
	                    str += "<td class=\"hide\"><input style=\"border:0\" name='representantes_apmat[]' value='"+apmat+"' readonly/></td>";
	                    str += "<td><input style=\"border:0\" name='representantes_area[]' value='"+area+"' readonly/></td>";
	                    str += "<td><input style=\"border:0\" name='representantes_rol[]' value='"+rol+"' readonly/></td>";
	                    str += "<td class=\"text-nowrap text-center\"><div class=\"btn btn-danger btn-block btn-sm\" style=\"width:145px; float: right\" onclick=\"deleteRow(event,this)\"><span class=\"glyphicon glyphicon-trash\"></span> Eliminar</a></div></tr>";	                    
	                    $("#representante_asociado_table").append(str);	                    
	                    $("#nombre_representante_convenio").val('');
						$("#appat_representante_convenio").val('');
						$("#apmat_representante_convenio").val('');
						$("#area_representante_convenio").val('');
						$("#rol_representante_convenio").val('');	                    
	                }
	            }
	        });		
	}
}

function agregarRepresentanteInstitucional()
{
	var val = $("#representante_institucional_convenio").val();

	$.ajax({
	    url: inside_url + 'acuerdo_convenio/getUserAjax',
	    type: 'POST',
	    data: { 'value' : val },
	    beforeSend: function(){
	        
	    },
	    complete: function(){
	        
	    },
	    success: function(response){	    	
	        if(response.success)
	        {	           
	        	var user = response['user'][0];
	            var area = response['area'];
	            var rol = response['rol'];

	            console.log(response['rol']);
	            

	            if(user != null)
	            {
	            	BootstrapDialog.confirm({
			            title: 'Mensaje de Confirmación',
			            message: '¿Está seguro que desea agregar a ' + user.apellido_pat.bold() + ' ' + user.apellido_mat.bold() + ', ' + user.nombre.bold() + ' como representante institucional?', 
			            type: BootstrapDialog.TYPE_INFO,
			            btnCancelLabel: 'Cancelar', 
			            btnOKLabel: 'Aceptar', 
			            callback: function(result){
			                if(result)
			                {   
			                    var str = "<tr><td>" + user.apellido_pat + " " + user.apellido_mat + ", " + user.nombre +"</td>";
			                    str += "<td>"+area+"</td>";
			                    str += "<td>"+rol+"</td>";
			                    str += "<td class=\"hide\"><input style=\"border:0\" name='representantes_institucional[]' value='"+user.id+"' readonly/></td>";
			                    str += "<td class=\"text-nowrap text-center\"><div class=\"btn btn-danger btn-block btn-sm\" style=\"width:145px; float: right\" onclick=\"deleteRow(event,this)\"><span class=\"glyphicon glyphicon-trash\"></span> Eliminar</a></div></tr>";	                    
			                    $("#representante_institucional_convenio_table").append(str);	                    
			                    $("#representante_institucional_convenio").val('');								                    
			                }
			            }
			        });	
	            }else
	            {
	            	dialog = BootstrapDialog.show({
                            title: 'Advertencia',
                            message: 'No existe usuario registrado con el número de documento ingresado',
                            closable: false,
                            type : BootstrapDialog.TYPE_DANGER,
                            buttons: [{
                                label: 'Aceptar',
                                action: function(dialog) {
                                    dialog.close();                        
                                }
                            }]
                    });
	            }
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo. asdasd');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}
