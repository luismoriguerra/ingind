<script type="text/javascript">
$(document).ready(function() {
    $("#enviar").click(function (){
        var data={draw:1,start:0,length:5,tiempo_final:0}
        Accion.mostrar(mostrarHTML,data);
    });
});
mostrarHTML=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>";
        html+="<td>"+data.proceso+"</td>";
        html+="<td>"+data.id_union+"</td>";
        html+="<td>"+data.norden+"</td>";
        html+="<td>"+data.tiempo+"</td>";
        html+="<td>"+data.fecha_inicio+"</td>";
        html+="<td>"+data.tipo_tarea+"</td>";
        html+="<td>"+data.descripcion+"</td>";
        html+="<td>"+data.nemonico+"</td>";
        html+="<td>"+data.responsable+"</td>";
        html+="<td>"+data.recursos+"</td>";
        html+="</tr>";
    });
    $("#t_reporte>tbody").html(html);
    $("#t_reporte").dataTable();
};
</script>
