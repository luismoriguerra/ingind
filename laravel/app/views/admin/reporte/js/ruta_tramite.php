<script type="text/javascript">
var filtro_fecha, filtro_averia, fecha_ini, fecha_fin, file,graph;
$(document).ready(function() {
    //inicializand el grafico
    graph =Morris.Bar({
        element: 'chart',
        data: [],
        xkey: 'id',
        ykeys: ['cant0', 'cant1', 'cant2'],
        labels: ['cant0', 'cant1', 'cant2'],
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
            "<td id='software_"+data.id+"'>"+data.software+"</td>"+
            "<td id='persona_"+data.id+"'>"+data.persona+"</td>"+
            "<td id='area_"+data.id+"'>"+data.area+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.fecha_inicio+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.cero+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.uno+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.dos+"</td>"+
            '<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";

        var array={id: data.id, cant0: data.cero, cant1:data.uno, cant2:data.dos};
        //dataMorris[i]=array;
        dataMorris.push(array);
        //console.log(array);

    });
    $("#tb_reporte").html(html);
    activarTabla();
    grafico();


};
HTMLreporteDetalle=function(datos){
    var html="";
    $('#t_reporte_detalle').dataTable().fnDestroy();

    $.each(datos,function(index,data){
/*
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td id='software_"+data.id+"'>"+data.software+"</td>"+
            "<td id='persona_"+data.id+"'>"+data.persona+"</td>"+
            "<td id='area_"+data.id+"'>"+data.area+"</td>"+
            "<td id='fecha_inicio_"+data.id+"'>"+data.fecha_inicio+"</td>"+
            '<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
*//*
        html+="<li class='list-group-item'><div class='row'>";
        html+="<div class='col-sm-4' id='modulo_"+data[0]+"'><h5>"+$("#slct_modulos option[value=" +data[0] +"]").text()+"</h5></div>";
        var submodulos =''// data[1].split(",");
        html+="<div class='col-sm-6'><select class='form-control' multiple='multiple' name='slct_submodulos"+data[0]+"[]' id='slct_submodulos"+data[0]+"'></select></div>";
        var envio = '';//{modulo_id: data[0]};
        slctGlobal.listarSlct('submodulo','slct_submodulos'+data[0],'multiple',submodulos,envio);

        html+='<div class="col-sm-2">';
        html+='<button type="button" id="'+data[0]+'" Onclick="EliminarSubmodulo(this)" class="btn btn-danger btn-sm" >';
        html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
        html+="</div></li>";
*/
        html+="<li class='list-group-item'>";
        html+="<div class='row'>";
        html+="<div class='col-sm-2'>1</div>";
        html+="<div class='col-sm-2'>1</div>";
        html+="<div class='col-sm-2'>1</div>";
        html+="<div class='col-sm-2'>1</div>";
        html+="<div class='col-sm-2'>1</div>";
        html+="<div class='col-sm-2'>1</div>";
        html+="</div>";
        html+="</li>";
        //modulos_selec.push(data[0]);

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
