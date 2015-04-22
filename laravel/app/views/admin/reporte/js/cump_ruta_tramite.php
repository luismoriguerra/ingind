<script type="text/javascript">
var graph;
$(document).ready(function() {
    //inicializand el grafico
    //$("#detalle").hide();
    /*graph =Morris.Bar({
        element: 'chart',
        data: [],
        xkey: 'id_union',
        ykeys: ['ok', 'error', 'corregido'],
        labels: ['Sin Alerta', 'Alerta', 'Alerta Validada'],
        barColors: ["#59E175", "#FE5629", "#FAC044"],
        //stacked: true,
        pointSize: 2,
        hideHover: 'auto',//mostrar leyenda
        resize: true,
        ymin: 0,
        ymax: 6,
        parseTime: false
    });
    $("#chart").css('display','none');
*/
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });

    slctGlobal.listarSlct('flujo','slct_flujos','simple');
    //Mostrar 
    $("#generar").click(function (){
        flujo_id = $('#slct_flujos').val();
        var fecha=$("#fecha").val();
        if ( fecha!=="")
            Rutas.mostrar(flujo_id, fecha);
        else
            alert("Seleccione Fecha");
        
    });

});

/*grafico=function(){
    $("#chart").css('display','block');
    graph.setData(dataMorris);
};*/
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
            '<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";

        var array={id_union: data.id_union, ok: data.ok, error:data.error, corregido:data.corregido};
        dataMorris.push(array);

    });
    $("#tb_reporte").html(html);
    activarTabla();
    $("#reporte").show();
    //grafico();


};
HTMLreporteDetalle=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert=''; var alerta='';
    $.each(datos,function(index,data){
        alerta="NO";
        if(data.alerta!==0){
            alerta="SI";
        }
        if (data.alerta===0) alert=alertOk;
        if (data.alerta===1) alert=alertError;
        if (data.alerta===2) alert=alertCorregido;
        html+="<tr class='"+alert+"'>";
        html+=    "<td>"+data.area+"</td>";
        html+=    "<td>"+data.tiempo+": "+data.dtiempo+"</td>";
        html+=    "<td>"+data.fecha_inicio+"</td>";
        //html+=    "<td>"+data.dtiempo+"</td>";
        html+=    "<td>"+data.dtiempo_final+"</td>";
        html+=    "<td>"+data.norden+"</td>";
        html+=    "<td>"+alerta+"</td>";
        html+=    "<td>"+data.verbo_finalizo+"</td>";
        html+="</tr>";
    });
    $("#reporte_detalle").show();
    $("#tb_reporteDetalle").html(html);
};
activarTabla=function(){
    $("#t_reporte").dataTable();
};
detalle=function(ruta_id){
    Rutas.mostrarDetalle(ruta_id);
};
</script>
