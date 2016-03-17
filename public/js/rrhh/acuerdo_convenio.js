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