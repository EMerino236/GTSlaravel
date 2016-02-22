$( document ).ready(function(){

	updateFM();

	$('#fe').bind('keyup mouseup',function(){
		updateGE();
		updateFM();
	});

	$('#ac').bind('keyup mouseup',function(){
		updateGE();
		updateFM();
	});

	$('#rm').bind('keyup mouseup',function(){
		updateGE();
		updateFM();
	});

	$('#hie').bind('keyup mouseup',function(){
		updateGE();
		updateFM();
	});

});

function updateGE()
{
	var fe = $('#fe').val();
	var ac = $('#ac').val();
	var rm = $('#rm').val();
	var hie = $('#hie').val();

	var ge = +fe + +ac + +rm + +hie;

	$('#ge').val(ge);

}

function updateFM()
{
	var val = $('#ge').val();

	if(val < 12)
		$('#fm').val("NINGUNA")

	if(val >= 12 && val <16)
		$('#fm').val("ANUAL")

	if(val >= 16 && val <19)
		$('#fm').val("SEMESTRAL")

	if(val > 18)
		$('#fm').val("TRIMESTRAL")
}