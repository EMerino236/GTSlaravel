$( document ).ready(function(){

	$("#datetimepicker1").datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$('#idAgregarActa').click(function(){
		fill_name_acta();
	});


    fill_name_acta();
    $('#btn_descarga').hide();

    $('#submit-create').click(function(){
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                    document.getElementById("submitForm").submit();
                }
            }
        });
    });

    $('#idRemoveActa').click(function(){
        $('#numero_acta').val('');
        $("#nombre_acta").css('background-color','white');
        $("#nombre_acta").css('color','black');
        $("#nombre_acta").val('');
        $("#btn_descarga").hide();
        $("input[name=numero_acta_hidden]").val(null);

    });
	
});

function fill_name_acta(){
    var val = $("#numero_acta").val();
    if(val=="")
        val = "vacio";    
    $.ajax({
        url: inside_url+'actas_conformidad/return_name_acta',
        type: 'POST',
        data: { 'selected_id' : val },
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
            if(response.success){
                var resp = response['reporte'];
                if(val!="vacio"){
                    if(resp != 2 && resp != 1){
                        $("#nombre_acta").val("");
                        $("#nombre_acta").css('background-color','#5cb85c');
                        $("#nombre_acta").css('color','white');
                        $("#nombre_acta").val(resp.nombre);
                        $("#btn_descarga").show();
                        $("input[name=numero_acta_hidden]").val(val);                            
                    }else if(resp==1){
                        $("#nombre_acta").val("Documento no es un Acta");
                        $("#nombre_acta").css('background-color','#d9534f');
                        $("#nombre_acta").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_acta_hidden]").val(null);
                    }
                    else if(resp==2){
                        $("#nombre_acta").val("Documento no registrado");
                        $("#nombre_acta").css('background-color','#d9534f');
                        $("#nombre_acta").css('color','white');
                        $("#btn_descarga").hide();
                        $("input[name=numero_acta_hidden]").val(null);
                    } 
                }else{
                    $("#nombre_acta").val("Documento no registrado");
                    $("#nombre_acta").css('background-color','#d9534f');
                    $("#nombre_acta").css('color','white');
                    $("#btn_descarga").hide();
                    $("input[name=numero_acta_hidden]").val(null);
                }               
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });

}
