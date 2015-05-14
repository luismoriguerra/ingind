<script type="text/javascript">
var graph;
$(document).ready(function() {
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
    $("#chart").css('display','none');*/
    var data = {estado:1};
    var ids = [];
    //slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
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
grafico=function(){
    $("#chart").css('display','block');
    graph.setData(dataMorris);
};
HTMLreporte=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert='', alerta_tipo= '';
    $.each(datos,function(index,data){
        alerta_tipo = '';
        if (data.alerta=='Sin Alerta') alert=alertOk;
        if (data.alerta=='Alerta') alert=alertError;
        if (data.alerta=='Alerta Validada') alert=alertCorregido;

        if (data.alerta=='Alerta' || data.alerta=='Alerta Validada') {
            if (data.alerta_tipo==1) {
                alerta_tipo = 'Tiempo asignado';
            } else if (data.alerta_tipo==2) {
                alerta_tipo = 'Tiempo de respuesta';
            } else if (data.alerta_tipo==3) {
                alerta_tipo = 'Tiempo aceptado';
            }
        }

        html+="<tr class='"+alert+"'>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.norden+"</td>"+
            "<td>"+data.verbo_finalizo+"</td>"+
            "<td>"+data.tiempo+": "+data.dtiempo+"</td>"+
            //"<td>"+data.dtiempo+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.dtiempo_final+"</td>"+
            "<td>"+data.alerta+"</td>"+
            "<td>"+alerta_tipo+"</td>";
            //'<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
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
};
activarTabla=function(){
    $("#t_reporte").dataTable();
};
detalle=function(ruta_id){
    //CumpArea.mostrarDetalle(ruta_id);
};

eventoSlctGlobalSimple=function(slct,valores){
    /*if( slct=="slct_flujo_id" ){
        var valor=valores.split('|').join("");
        $("#slct_area_id").val(valor);
        $("#slct_area_id").multiselect('refresh');
    }*/
}
</script>
