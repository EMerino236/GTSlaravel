function agregarFormacionAcademica(){
    var grado = $("#fa_grado :selected");
    var nombre_grado = $("input[name=fa_nombre_grado]").val();
    var centro_estudios = $("input[name=fa_centro_estudios]").val();
    var pais_estudios = $("#fa_pais_estudios :selected");
    var fecha_inicio = $("input[name=fa_fecha_inicio]").val();
    var fecha_fin = $("input[name=fa_fecha_fin]").val();

    if(grado.length < 1 || nombre_grado.length < 1 || centro_estudios.length < 1 || pais_estudios.length < 1 || fecha_inicio.length < 1 || fecha_fin.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td>"+grado.text()+"<input type='hidden' name='fa_grados[]' value='"+grado.val()+"'/></td>";
    str += "<td><input class='cell' name='fa_titulos[]' value='"+nombre_grado+"' readonly/></td>";
    str += "<td><input class='cell' name='fa_centros[]' value='"+centro_estudios+"' readonly/></td>";
    str += "<td>"+pais_estudios.text()+"<input type='hidden' name='fa_paises[]' value='"+pais_estudios.val()+"'/></td>";
    str += "<td><input class='cell' name='fa_fechas_ini[]' value='"+fecha_inicio+"' readonly/></td>";
    str += "<td><input class='cell' name='fa_fechas_fin[]' value='"+fecha_fin+"' readonly/></td>";
    str += "<td style='overflow:auto'><input type='file' name='archivos[]'/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".form_table");
    
    $("input[name=fa_grado]").val('');
    $("input[name=fa_nombre_grado]").val('');
    $("input[name=fa_centro_estudios]").val('');
    $("input[name=fa_pais_estudios]").val('');
    $("input[name=fa_fecha_inicio]").val('');
    $("input[name=fa_fecha_fin]").val('');
}

function agregarFormacionContinua(){
    var nombre_grado = $("input[name=fc_nombre_capacitacion]").val();
    var centro_estudios = $("input[name=fc_centro_estudios]").val();
    var pais_estudios = $("#fc_pais_estudios :selected");

    if(nombre_grado.length < 1 || centro_estudios.length < 1 || pais_estudios.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td><input class='cell' name='fc_nombres_capacitacion[]' value='"+nombre_grado+"' readonly/></td>";
    str += "<td><input class='cell' name='fc_centros[]' value='"+centro_estudios+"' readonly/></td>";
    str += "<td>"+pais_estudios.text()+"<input type='hidden' name='fc_paises[]' value='"+pais_estudios.val()+"'/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".fc_table");
    
    $("input[name=fc_nombre_capacitacion]").val('');
    $("input[name=fc_centro_estudios]").val('');
    $("input[name=fc_pais_estudios]").val('');
}

function agregarIdioma(){
    var nombre_idioma = $("#nombre_idioma :selected");
    var lectura = $("#lectura :selected");
    var conversacion = $("#conversacion :selected");
    var escritura = $("#escritura :selected");
    var forma = $("#forma_aprendizaje :selected");

    if(nombre_idioma.length < 1 || lectura.length < 1 || conversacion.length < 1 || escritura.length < 1 || forma.length < 1){
        return BootstrapDialog.alert({
            title:  'Alerta',
            message: 'Debe llenar todos los campos',
        });  
    }

    var str = "<tr><td>"+nombre_idioma.text()+"<input type='hidden' name='nombres_idioma[]' value='"+nombre_idioma.val()+"' readonly/></td>";
    str += "<td>"+lectura.text()+"<input type='hidden' name='lecturas[]' value='"+lectura.val()+"'/></td>";
    str += "<td>"+conversacion.text()+"<input type='hidden' name='conversaciones[]' value='"+conversacion.val()+"'/></td>";
    str += "<td>"+escritura.text()+"<input type='hidden' name='escrituras[]' value='"+escritura.val()+"'/></td>";
    str += "<td>"+forma.text()+"<input type='hidden' name='formas[]' value='"+forma.val()+"'/></td>";
    str += "<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>";
    $(str).prependTo(".idioma_table");
    
    $("input[name=nombre_idioma]").val('');
    $("input[name=lectura]").val('');
    $("input[name=conversacion]").val('');
    $("input[name=escritura]").val('');
    $("input[name=forma_aprendizaje]").val('');
}