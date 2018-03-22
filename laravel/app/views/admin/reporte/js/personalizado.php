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
            var length_norden=(data.norden.length)+3;
            var indice=data.norden.length;
            dataG = {indice:indice,length_norden:length_norden,ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,norden:data.norden};
            conexionG={pos:pos,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);console.log(detalle);
            html+=detalle.html;
            pos=detalle.pos;
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
            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.pendiente+"</td>"+
            "<td>"+data.atendido+"</td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
       
        }else{
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"'>"+
            "<td>"+data.norden+"</td>"+
            "<td>Actividad N° "+data.norden+"</td>"+
            "<td>"+data.area+"</td>"+
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
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);console.log(detalle);
            html+=detalle.html;
            pos_2=detalle.pos;
        }

    });
    returnG={html:html,pos:pos_2};
    return returnG;
};

</script>
