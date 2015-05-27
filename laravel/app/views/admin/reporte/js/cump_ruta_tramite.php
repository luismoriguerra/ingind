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
        html+="<tr>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.software+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.error+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    activarTabla();
    $("#reporte").show();

};
HTMLreporteDetalle=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert='', alerta='', alerta_tipo='';
    $.each(datos,function(index,data){
        alerta="NO";
        alerta_tipo = '';
        if(data.alerta!==0){
            alerta="SI";
        }
        if (data.alerta==0) alert=alertOk;
        if (data.alerta==1) alert=alertError;
        if (data.alerta==2) alert=alertCorregido;

        if (data.alerta==1 || data.alerta==2) {
            if (data.alerta_tipo==1) {
                alerta_tipo = 'Tiempo asignado';
            } else if (data.alerta_tipo==2) {
                alerta_tipo = 'Tiempo de respuesta';
            } else if (data.alerta_tipo==3) {
                alerta_tipo = 'Tiempo aceptado';
            }
        }

        html+="<tr class='"+alert+"'>";
        html+=    "<td>"+data.norden+"</td>";
        html+=    "<td>"+data.area+"</td>";
        html+=    "<td>"+data.tiempo+": "+data.dtiempo+"</td>";
        html+=    "<td>"+data.fecha_inicio+"</td>";
        html+=    "<td>"+data.dtiempo_final+"</td>";
        html+=    "<td>"+alerta_tipo+"</td>";
        html+=    "<td>"+data.verbo_finalizo+"</td>";
        html+="</tr>";
    });
    $("#reporte_detalle").show();
    $("#tb_reporteDetalle").html(html);
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
