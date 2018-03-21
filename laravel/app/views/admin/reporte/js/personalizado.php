<script type="text/javascript">

$(document).ready(function() {

   $('.tree').treegrid({
//        onChange: function() {
//            alert("Changed: "+$(this).attr("id"));
//        }, 
//        onCollapse: function() {
//            alert("Collapsed: "+$(this).attr("id"));
//        }, 
//        onExpand: function() {
//            alert("Expanded "+$(this).attr("id"));
//        }});
//        $('#node-1').on("change", function() {
//            alert("Event from " + $(this).attr("id"));
    });
//    $("#generar").click(function (){
//        var fecha=$("#fecha").val();
//        if ( fecha!=="") {
//            var dataG = {fecha:fecha};
//            Auditoria.CuadroAuditoria(dataG);
//        }else{
//            alert("Seleccione Fecha");
//        }
//    });
//   
//    $("#btnexport").click(GeneraHref);

});

eventoSlctGlobalSimple=function(slct,valores){
};

HTMLPersonalizado=function(datos,parametros){
    var html ='';
    pos=0;
//    $('#t_tree').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        pos++;
        html+="<tr class='treegrid-"+pos+"'>"+
            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
        html+="</tr>";
        
        if(data.cant_flujo>0){
            var dataG = [];
            var conexionG=[];
            dataG = {ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,norden:data.norden};
            conexionG={pos:pos};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);
            html+=detalle;
        }
    });
    $("#tb_tree").html(html);
    $("#t_tree").treegrid();
//    $('#t_tree').dataTable(
//                    {
//                    "pageLength": 10,
//                });

};

HTMLPersonalizadoDetalle=function(datos,conexion){
    var html ='';
    var aux_id=0;
    var pos_2=(conexion.pos+1);
    var parent=0;
    $.each(datos,function(index,data){
        
        if(aux_id!==data.flujo_id){
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+conexion.pos+"'>";
            html+="<td colspan='6'><b>"+data.flujo+"</b></td>";
            html+="</tr>";
            
            aux_id=data.flujo_id;
            parent=pos_2;
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"'>"+
            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
       
        }else{
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"'>"+
            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
        }
        pos_2++;

    });

//            html+="<tr class='treegrid-2 treegrid-parent-1'>";
//            html+="<td colspan='6'>1</td>";
//            html+="</tr>";
//            html+="<tr class='treegrid-3 treegrid-parent-2'>";
//            html+="<td>1.1</td>";
//            html+="<td>1</td>";
//            html+="<td>1</td>";
//            html+="<td>1</td>";
//            html+="<td>1</td>";
//            html+="<td>1</td>";
//            html+="</tr>";
    return html;
};

</script>
