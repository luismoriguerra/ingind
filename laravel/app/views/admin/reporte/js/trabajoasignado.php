<script type="text/javascript">
$(document).ready(function() {
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','multiple',ids,data);
    data={apellido_nombre:1}
    slctGlobal.listarSlct('persona','slct_autoriza_id,#slct_responsable_id,#slct_miembros_id','multiple',ids,data);
    slctGlobalHtml('slct_estado_id','multiple');
    $("#generar").click(GenerarReporte);
});

GenerarReporte=function(){
    var data={
            autoriza:$("#slct_autoriza_id").val(),
            responsable:$("#slct_responsable_id").val(),
            flujo_id:$("#slct_flujo_id").val(),
            miembros:$("#slct_miembros_id").val(),
            carta_inicio:$("#txt_carta_inicio").val(),
            estado_id:$("#slct_estado_id").val(),
            objetivo:$("#txt_objetivo").val(),
            fecha:$("#fecha").val(),
            };
    Accion.mostrar(data);
}

HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        
        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.autoriza.split("|")[0]+"</td>"+
            "<td>"+data.autoriza.split("|")[1]+"</td>"+
            "<td>"+data.responsable.split("|")[0]+"</td>"+
            "<td>"+data.responsable.split("|")[1]+"</td>"+
            "<td>"+data.nro_carta+"</td>"+
            "<td>"+data.objetivo+"</td>"+
            "<td><font size='1px;'>"+data.miembros.split("|").join("<br> -")+"</font></td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.fecha_fin+"</td>"+
            "<td>"+data.estado+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(); 
    $("#reporte").show();
};

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
