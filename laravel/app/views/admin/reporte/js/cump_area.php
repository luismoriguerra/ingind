<script type="text/javascript">
var graph;
$(document).ready(function() {

    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    $("#generar").click(function (){
        //flujo_id = $('#slct_flujo_id').val();
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        if ( area_id!=="") {
            CumpArea.mostrar(0, area_id);
            //enviar y generar reporte
        } else{
            alert("Seleccione Area");
        }
        
    });
});
HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $.each(datos,function(index,data){
        alerta_tipo = '';
        
        if (data.alerta=='Alerta' || data.alerta=='Alerta Validada') {
            if (data.alerta_tipo==1) {
                alerta_tipo = 'Tiempo asignado';
            } else if (data.alerta_tipo==2) {
                alerta_tipo = 'Tiempo de respuesta';
            } else if (data.alerta_tipo==3) {
                alerta_tipo = 'Tiempo aceptado';
            }
        }
        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.duenio+"</td>"+
            "<td>"+data.area_duenio+"</td>"+
            "<td>"+data.n_areas+"</td>"+
            "<td>"+data.n_pasos+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            '<td><a onClick="detalle('+data.ruta_flujo_id+')" class="btn btn-primary btn-sm" data-id="'+data.ruta_flujo_id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#tb_reporteDetalle").html('');
    $("#tb_reporteDetalle2").html('');
    //activarTabla();
    $("#reporte").show();
};
HTMLreporteDetalle=function(datos){
    var html="";
    
    $.each(datos,function(index,data){
        alerta_tipo = '';

        html+="<tr>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.tipo_persona+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.ultimo_paso+"</td>"+
            "<td>"+data.ultima_area+"</td>"+
            "<td>"+data.fecha_tramite+"</td>"+
            "<td>"+data.fecha_fin+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.errorr+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle2('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";

    });
    $("#tb_reporteDetalle").html(html);
    $("#tb_reporteDetalle2").html('');
    //$("#t_reporteDetalle").dataTable();
    $("#reporte_detalle").show();
};
HTMLreporteDetalle2=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert='';
    $.each(datos,function(index,data){
        if (data.alerta=='Sin Alerta') alert=alertOk;
        if (data.alerta=='Alerta') alert=alertError;
        if (data.alerta=='Alerta Validada') alert=alertCorregido;

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
        for (var i = rol.length - 1; i >= 0; i--) 
            html+=      "<tr><td>"+rol[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (var i = verbo.length - 1; i >= 0; i--) 
            html+=      "<tr><td>"+verbo[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (var i = documento.length - 1; i >= 0; i--) 
            html+=      "<tr><td>"+documento[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (var i = descripcion_v.length - 1; i >= 0; i--) 
            html+=      "<tr><td>"+descripcion_v[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (var i = verbo.length - 1; i >= 0; i--) //n_doc
            html+=      "<tr><td></tr></td>";
        html+=  "</table></td><td><table>";
        for (var i = observacion.length - 1; i >= 0; i--) 
            html+=      "<tr><td>"+observacion[i]+"</tr></td>";
        html+=  "</table></td><td><table>";
        for (var i = estado_accion.length - 1; i >= 0; i--) 
            html+=      "<tr><td>"+estado_accion[i]+"</tr></td>";
        html+=  "</table></td>";
        html+=  "</tr>";

    });
    $("#tb_reporteDetalle2").html(html);
    //$("#t_reporteDetalle2").dataTable();
    $("#reporte_detalle2").show();
};
activarTabla=function(){
    $("#t_reporte").dataTable();
};
detalle=function(ruta_flujo_id){
    CumpArea.mostrarDetalle(ruta_flujo_id);
};
detalle2=function(ruta_flujo_id){
    CumpArea.mostrarDetalle2(ruta_flujo_id);
};
eventoSlctGlobalSimple=function(slct,valores){
    /*if( slct=="slct_flujo_id" ){
        var valor=valores.split('|').join("");
        $("#slct_area_id").val(valor);
        $("#slct_area_id").multiselect('refresh');
    }*/
}
</script>
