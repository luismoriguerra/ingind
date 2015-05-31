<script type="text/javascript">
$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujos','simple',ids,data);
    //Mostrar 
    $("#generar").click(function (){
        flujo_id = $('#slct_flujos').val();
        var fecha=$("#fecha").val();
        if ( fecha!==""){
            if (flujo_id!=='') {
                data = {flujo_id:flujo_id,fecha:fecha};
                Rutas.mostrar(data);
            } else {
                alert("Seleccione Proceso");
            }
        } else {
            alert("Seleccione Fecha");
        }
    });

});

HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();
    $("#reporte_detalle").hide();
    $.each(datos,function(index,data){
        /*html+="<tr>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.software+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.error+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";*/
        html+="<tr>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.tipo_persona+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.ultimo_paso_area+"</td>"+
            //"<td>"+data.ultima_area+"</td>"+
            "<td>"+data.fecha_tramite+"</td>"+
            "<td>"+data.fecha_fin+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.errorr+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#tb_reporteDetalle").html('');
    activarTabla();
    $("#reporte").show();

};
HTMLreporteDetalle=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert='', i;
    $.each(datos,function(index,data){
        if (data.alerta=='0') alert=alertOk;
        if (data.alerta=='1') alert=alertError;
        if (data.alerta=='2') alert=alertCorregido;

        alerta_tipo = '';
        observacion = data.observacion.split(",");
        descripcion_v = data.descripcion_v.split(",");
        documento = data.documento.split(",");
        estado_accion = data.estado_accion.split(",");
        rol = data.rol.split(",");
        verbo = data.verbo.split(",");
        verbo_finalizo = data.verbo_finalizo.split(",");

        html+="<tr class='"+alert+"'>"+
                "<td>"+data.norden+"</td>"+
                "<td>"+data.area+"</td>"+
                "<td>"+data.tiempo+': '+data.dtiempo+"</td>"+
                "<td>"+data.fecha_inicio+"</td>"+
                "<td>"+data.dtiempo_final+"</td>"+
                //"<td>"+data.verbo_finalizo+"</td>";
                "<td>"+data.alerta+"</td>";

        html+=  "<td><table>";
        for (i = rol.length - 1; i >= 0; i--) 
            html+= "<tr><td style='height: 19px'>"+rol[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (i = verbo.length - 1; i >= 0; i--) 
            html+= "<tr><td style='height: 19px'>"+verbo[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (i = documento.length - 1; i >= 0; i--) 
            html+= "<tr><td style='height: 19px'>"+documento[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (i = descripcion_v.length - 1; i >= 0; i--) 
            html+= "<tr><td style='height: 19px'>"+descripcion_v[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (i = verbo.length - 1; i >= 0; i--) //n_doc
            html+=      "<tr><td></tr></td>";
        html+=  "</table></td><td><table>";
        for (i = observacion.length - 1; i >= 0; i--) 
            html+= "<tr><td style='height: 19px'>"+observacion[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (i = estado_accion.length - 1; i >= 0; i--) 
            html+= "<tr><td style='height: 19px'>"+estado_accion[i]+"</tr></td>";
        html+=  "</table></td>";
        html+=  "</tr>";

    });
    $("#tb_reporteDetalle").html(html);
    //$("#t_reporteDetalle2").dataTable();
    $("#reporte_detalle").show();
};
activarTabla=function(){
    $("#t_reporte").dataTable();
};
detalle=function(ruta_id, boton){
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    Rutas.mostrarDetalle(ruta_id);
};
eventoSlctGlobalSimple=function(slct,valores){
};
</script>
