$(document).ready(function(){

	$('.btnEliminarAccesorio').click(function(){
		var idaccesorio = $(this).attr('data-value');
		
		submit_delete_accesorio_ajax(idaccesorio);

	});

});

function submit_delete_accesorio_ajax(idaccesorio)
{
	var idmodelo_equipo = $("#idmodelo_equipo").val();

	$.ajax({
	    url: inside_url+'familia_activos/submit_delete_accesorio_ajax',
	    type: 'POST',
	    data: { 'idmodelo_equipo' : idmodelo_equipo, 'idaccesorio': idaccesorio },
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
	    }/*,
	    success: function(response){	    	
	        if(response.success)
	        {	            
	            
	        }
	        else
	        {
            	alert('La petición no se pudo completar, inténtelo de nuevo. asdasd');
	        }
	    },
	    error: function(){
	        alert('La petición no se pudo completar, inténtelo de nuevo.');
		}*/
	});
}