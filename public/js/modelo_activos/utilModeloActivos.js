$(document).ready(function(){

	$('.btnEliminarAccesorio').click(function(){
		var idaccesorio = $(this).attr('data-value');		
		
		$('#modal_delete_accesorio').modal('toggle');
		$('.modal_btnEliminarAccesorio').attr('data-value',idaccesorio);
	});

	$('.modal_btnEliminarAccesorio').click(function(){
		var idaccesorio = $(this).attr('data-value');
		
		submit_delete_accesorio_ajax(idaccesorio);
	});

	$('.btnEliminarComponente').click(function(){
		var idcomponente = $(this).attr('data-value');

		$('#modal_delete_componente').modal('toggle');
		$('.modal_btnEliminarComponente').attr('data-value',idcomponente);		
	});

	$('.modal_btnEliminarComponente').click(function(){
		var idcomponente = $(this).attr('data-value');
		
		submit_delete_componente_ajax(idcomponente);
	});


	$('.btnEliminarConsumible').click(function(){
		var idconsumible = $(this).attr('data-value');
		
		$('#modal_delete_consumible').modal('toggle');
		$('.modal_btnEliminarConsumible').attr('data-value',idconsumible);
	});

	$('.modal_btnEliminarConsumible').click(function(){
		var idconsumible = $(this).attr('data-value');
		
		submit_delete_consumible_ajax(idconsumible);
	});

});

function submit_delete_accesorio_ajax(idaccesorio)
{	
	$.ajax({
	    url: inside_url+'familia_activos/submit_delete_accesorio_ajax',
	    type: 'POST',
	    data: { 'idaccesorio': idaccesorio },
	    beforeSend: function(){
	        $("#delete-selected-profiles").addClass("disabled");
	        $("#delete-selected-profiles").hide();
	        $(".loader_container").show();
	    },
	    complete: function(){
	        $(".loader_container").hide();
	        $("#delete-selected-profiles").removeClass("disabled");
	        $("#delete-selected-profiles").show();
	        delete_selected_profiles = true;
	    },
	    success: function(response){	    	
	        if(response.success)
	        {    
	         	location.reload();
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo.');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}

function submit_delete_componente_ajax(idcomponente)
{
	$.ajax({
	    url: inside_url+'familia_activos/submit_delete_componente_ajax',
	    type: 'POST',
	    data: { 'idcomponente': idcomponente },
	    beforeSend: function(){
	        $("#delete-selected-profiles").addClass("disabled");
	        $("#delete-selected-profiles").hide();
	        $(".loader_container").show();
	    },
	    complete: function(){
	        $(".loader_container").hide();
	        $("#delete-selected-profiles").removeClass("disabled");
	        $("#delete-selected-profiles").show();
	        delete_selected_profiles = true;
	    },
	    success: function(response){	    	
	        if(response.success)
	        {    
	         	location.reload();
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo.');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}

function submit_delete_consumible_ajax(idconsumible)
{	
	$.ajax({
	    url: inside_url+'familia_activos/submit_delete_consumible_ajax',
	    type: 'POST',
	    data: { 'idconsumible': idconsumible },
	    beforeSend: function(){
	        $("#delete-selected-profiles").addClass("disabled");
	        $("#delete-selected-profiles").hide();
	        $(".loader_container").show();
	    },
	    complete: function(){
	        $(".loader_container").hide();
	        $("#delete-selected-profiles").removeClass("disabled");
	        $("#delete-selected-profiles").show();
	        delete_selected_profiles = true;
	    },
	    success: function(response){	    	
	        if(response.success)
	        {    
	         	location.reload();
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo.');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}
	});
}