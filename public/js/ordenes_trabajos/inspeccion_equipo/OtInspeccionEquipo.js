$( document ).ready(function(){
	set_activos_html();

});

function set_activos_html(){
	size_row = document.getElementById("table_equipos").rows.length;
	for(i=0;i<size_row-1;i++){
		html = "<div style=\"display: none;\" id=\"element"+i+"\"""></div>";
		alert(html);
		$('#body_equipos').append(html);
	}
}