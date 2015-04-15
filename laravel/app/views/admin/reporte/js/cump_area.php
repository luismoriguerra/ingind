<script type="text/javascript">
var graph;
$(document).ready(function() {
    graph =Morris.Bar({
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
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    $("#generar").click(function (){
        flujo_id = $('#slct_flujo_id').val();
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        if ( flujo_id!=="") {
            if ( area_id!=="") {
                CumpArea.mostrar(flujo_id, area_id);
                //enviar y generar reporte
            } else
                alert("Seleccione Area");
        }
        else
            alert("Seleccione Tramite");
        
    });
});
mostrarRutaFlujo=function(){
    $("#form_ruta_detalle>.form-group").css("display","none");
    /*var flujo_id=$.trim($("#slct_flujo_id").val());
    var area_id=$.trim($("#slct_area_id").val());

    if( flujo_id!='' && area_id!='' ){
        var datos={ flujo_id:flujo_id,area_id:area_id };
        $("#tabla_ruta_detalle").css("display","");
        Validar.mostrarRutaDetalle(datos,mostrarRutaDetalleHTML);
    }*/
};
grafico=function(){
    $("#chart").css('display','block');
    graph.setData(dataMorris);
};
HTMLreporte=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert='';
    $.each(datos,function(index,data){
        if (data.alerta==='Sin Alerta') alert=alertOk;
        if (data.alerta==='Alerta') alert=alertError;
        if (data.alerta==='Alerta Validada') alert=alertCorregido;
        html+="<tr class='"+alert+"'>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.norden+"</td>"+
            "<td>"+data.verbo_finalizo+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            "<td>"+data.dtiempo+"</td>"+
            "<td>"+data.dtiempo_final+"</td>"+
            "<td>"+data.alerta+"</td>"+
            '<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";

        var array={id_union: data.id_union, ok: data.ok, error:data.error, corregido:data.corregido};
        dataMorris.push(array);

    });
    $("#tb_reporte").html(html);
    activarTabla();
    $("#reporte").show();
    grafico();

};
HTMLreporteDetalle=function(datos){
};
activarTabla=function(){
    $("#t_reporte").dataTable();
};
detalle=function(ruta_id){
    //CumpArea.mostrarDetalle(ruta_id);
};
</script>