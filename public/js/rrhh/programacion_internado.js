$( document ).ready( function() {
  $('.responsive-calendar').responsiveCalendar({
  	translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
  });
});

function limpiarCriteriosProgramacionInternado()
{
    $("#search_nombre").val("");
    $("#search_servicio_clinico").val("");
    $("#search_departamento").val("");
    $("#search_responsable").val("");
    $("#search_fecha_ini").val("");
    $("#search_fecha_fin").val("");
}

function agregaRowProgInter()
{
    var nombre = $("#nombre").val();
    var departamento = $("#departamento :selected");
    var servicio_clinico = $("#servicio_clinico :selected");
    var responsable = $("#responsable :selected");
    var num_horas = $("#numero_horas").val();
    var fecha_ini = $("input[name=fecha_ini]").val();
    var fecha_fin = $("input[name=fecha_fin]").val();

    if(nombre.length < 1 || departamento.length < 1 || servicio_clinico < 1 || responsable < 1 || fecha_ini.length < 1 || fecha_fin.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input style=\"border:0\" name='nombres[]' value='"+nombre+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='departamentos[]' value='"+departamento.text()+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='servicios[]' value='"+servicio_clinico.text()+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='responsables[]' value='"+responsable.text()+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='nums_horas[]' value='"+num_horas+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='fechas_ini[]' value='"+fecha_ini+"' readonly/></td>";
    str += "<td><input style=\"border:0\" name='fechas_fin[]' value='"+fecha_fin+"' readonly/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".pr_table");

    limpiarCriteriosAgregarProgramacionInternado();
}

function limpiarCriteriosAgregarProgramacionInternado()
{
    $("#nombre").val('');
    $("#departamento").val('');
    $("#servicio_clinico").val('');
    $("#responsable").val('');
    $("#fecha_ini").val('');
    $("#fecha_fin").val('');
}