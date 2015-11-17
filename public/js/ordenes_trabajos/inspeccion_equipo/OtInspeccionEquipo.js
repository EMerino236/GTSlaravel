$( document ).ready(function(){
	$("#input-file0").fileinput({
			language:"es",
	});
	//set_idioma_fileinput();
});

function set_idioma_fileinput(){
	count_activos = $('#count_activos').val();
	for(i=0;i<count_activos;i++){		
		$("#input-file"+i).fileinput({
			language:"es"
		});
		alert($("#input-file"+i).fileinput);
	}
}

