<script type="text/javascript">
var filtro_fecha, filtro_averia, fecha_ini, fecha_fin, file,graph;
$(document).ready(function() {
    //inicializand el grafico
    graph =Morris.Bar({
        element: 'chart',
        data: [],
        xkey: 'id_union',
        ykeys: ['ok', 'error', 'corregido'],
        labels: ['Ok', 'Error', 'Corregido'],
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
    //$("#slct_reporte").change(ValidaTipo);

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD'
    });

    slctGlobal.listarSlct('flujo','slct_flujos','simple');
    //Mostrar 
    $("#generar_movimientos").click(function (){
        flujo_id = $('#slct_flujos').val();
        reporte(flujo_id);
    });

});

grafico=function(){
    $("#chart").css('display','block');
    graph.setData(dataMorris);
}
reporte=function(flujo_id){
    Rutas.mostrar(flujo_id);
    
};
HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();
    var i=0;
    $.each(datos,function(index,data){
        i++;
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td id='id_union_"+data.id+"'>"+data.id_union+"</td>"+
            "<td id='software_"+data.id+"'>"+data.software+"</td>"+
            "<td id='persona_"+data.id+"'>"+data.persona+"</td>"+
            "<td id='area_"+data.id+"'>"+data.area+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.fecha_inicio+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.ok+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.error+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";

        var array={id_union: data.id_union, ok: data.ok, error:data.error, corregido:data.corregido};
        dataMorris.push(array);

    });
    $("#tb_reporte").html(html);
    activarTabla();
    grafico();


};
HTMLreporteDetalle=function(datos){
    var html="";
    $('#t_reporte_detalle').dataTable().fnDestroy();
    //html+="<li class='list-group-item'>";
        html+="<div class='row alert alert-dismissible '>";
        html+="<div class='col-sm-2 col-xs-2'>Area</div>";
        html+="<div class='col-sm-1 col-xs-1'>Tiempo</div>";
        html+="<div class='col-sm-1 col-xs-1'>Cant</div>";
        html+="<div class='col-sm-1 col-xs-1'>Tiempo final</div>";
        html+="<div class='col-sm-1 col-xs-1'># orden</div>";
        html+="<div class='col-sm-1 col-xs-1'>Alerta</div>";
        html+="<div class='col-sm-5 col-xs-5'>Accion</div>";
        //html+="<div class='col-sm-2 col-xs-2'>Scaneo</div>";
        //html+="<div class='col-sm-1 col-xs-1'>Finalizo</div>";
        html+="</div>";
   // html+="</li>";
    var alertOk ='alert alert-success';//verde
    var alertError ='alert alert-warning';//ambar
    var alertCorregido ='alert alert-danger';//rojo
    var alert='';
    $.each(datos,function(index,data){
        if (data.alerta===0) alert=alertOk;
        if (data.alerta===1) alert=alertError;
        if (data.alerta===2) alert=alertCorregido;
        //html+="<li class='list-group-item'>";
        html+="<div class='row "+alert+"'>";
        html+="<div class='col-sm-2 col-xs-2'>"+data.area+"</div>";
        html+="<div class='col-sm-1 col-xs-1'>"+data.tiempo+"</div>";
        html+="<div class='col-sm-1 col-xs-1'>"+data.dtiempo+"</div>";
        html+="<div class='col-sm-1 col-xs-1'>"+data.dtiempo_final+"</div>";
        html+="<div class='col-sm-1 col-xs-1'>"+data.norden+"</div>";
        html+="<div class='col-sm-1 col-xs-1'>"+data.alerta+"</div>";
        html+="<div class='col-sm-5 col-xs-5'>"+data.verbo_finalizo+"</div>";
        //html+="<div class='col-sm-2 col-xs-2'>"+data.scaneo+"</div>";
       /// html+="<div class='col-sm-1 col-xs-1'>"+data.finalizo+"</div>";
        html+="</div>";
        //html+="</li>";

    });
    $("#t_reporteDetalle").html(html); 
    //$("#tb_reporte_detalle").html(html);

    $("#t_reporte_detalle").dataTable();
}
activarTabla=function(){
    $("#t_reporte").dataTable(); // inicializo el datatable
    //$("#t_reporte").dataTable().rowGrouping();

};
detalle=function(ruta_id){
    //alert(ruta_id);
    Rutas.mostrarDetalle(ruta_id);
}
</script>
