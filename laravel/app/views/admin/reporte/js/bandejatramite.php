<script type="text/javascript">
$(document).ready(function() {
    slctGlobal.listarSlct('lista/tipovizualizacion','slct_tipo_visualizacion','multiple',null,null);
    Bandeja.mostrar();
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
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.nombre+': '+data.dtiempo+"</td>"+
            "<td>"+data.respuesta+': '+data.respuestad+"</td>"+
            "<td>"+data.observacion+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.norden+"</td>"+
            "<td>"+data.alerta_tipo+"</td>"+
            "<td>"+data.alerta+"</td>"+
            "<td>"+data.condicion+"</td>"+
            "<td>"+data.estado_ruta+"</td>"+
            "<td>"+data.fecha_tramite+"</td>"+
            "<td>"+data.tipo_solicitante+"</td>"+
            "<td>"+data.razon_social+"</td>"+
            "<td>"+data.ruc+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.persona_visual+"</td>"+
            "<td>"+data.email+"</td>"+
            "<td>"+data.persona+"</td>";

            if(data.estado_final==1){
        html+="<td>"+data.fecha_produccion+"</td>";
        html+="<td>"+data.ntramites+"</td>";
        html+='<td><a onClick="detalle('+data.ruta_flujo_id+',this)" class="btn btn-primary btn-sm" data-id="'+data.ruta_flujo_id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
            }
            else{
        html+="<td>&nbsp;</td>";
        html+="<td>0</td>";
        html+="<td>&nbsp;</td>";
            }
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#tb_reporteDetalle").html('');
    $("#tb_reporteDetalle2").html('');
    //activarTabla();
    $("#reporte").show();
};
</script>
