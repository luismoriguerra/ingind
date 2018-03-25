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
    var pos=0;
    var parent=0;
    var aux_id=0;
    
    var totalr=0;
    var pendienter=0;
    var atendidor=0;
    var finalizador=0;
    $.each(datos,function(index,data){
        
        if(aux_id!==data.flujo_id){
            if(index>0){
                html = html.replace("totalr", totalr);
            }
            pos++;
            html+="<tr class='treegrid-"+pos+"'>";
            html+="<td colspan='2'><b>"+data.flujo+"</b></td>"+
            "<td>totalr</td>"+
            "<td>pendienter</td>"+
            "<td>atentidor</td>"+
            "<td>finalizador</td>";
            html+="</tr>";
            
            aux_id=data.flujo_id;
            parent=pos;
            pos++;
            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            html+="<tr class='treegrid-"+pos+" treegrid-parent-"+parent+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";

        }else{
            pos++;
            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            html+="<tr class='treegrid-"+pos+" treegrid-parent-"+parent+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
        }
        
        if(data.cant_flujo>0){
            var dataG = [];
            var conexionG=[];
            var length_norden=(data.norden.length)+3;
            var indice=data.norden.length;
            dataG = {indice:indice,length_norden:length_norden,ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,norden:data.norden};
            conexionG={pos:pos,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);
            html+=detalle.html;
            pos=detalle.pos;
        }
    });
    html = html.replace("totalr", totalr);
    $("#tb_tree").html(html);
    $("#t_tree").treegrid();

};

HTMLPersonalizadoDetalle=function(datos,conexion){
    var html ='';
    var aux_id=0;
    var pos_2=conexion.pos;
    var parent=0;
    $.each(datos,function(index,data){
        
        if(aux_id!==data.flujo_id){
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+conexion.pos+"'>";
            html+="<td colspan='6'><b>"+data.flujo+"</b></td>";
            html+="</tr>";
            
            aux_id=data.flujo_id;
            parent=pos_2;
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
       
        }else{
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
        }
                    
        if(data.cant_flujo>0){
            var dataG = [];
            var conexionG=[];
            var length_norden=(data.norden.length)+3;
            var indice=data.norden.length;
            dataG = {indice:indice,length_norden:length_norden,ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: conexion.ruta_flujo_id, fechames: conexion.fechames,norden:data.norden};
            conexionG={pos:pos_2,ruta_flujo_id: conexion.ruta_flujo_id, fechames: conexion.fechames};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);
            html+=detalle.html;
            pos_2=detalle.pos;
        }

    });
    returnG={html:html,pos:pos_2};
    return returnG;
};

</script>
