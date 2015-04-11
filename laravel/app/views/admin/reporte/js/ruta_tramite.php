<script type="text/javascript">
var filtro_fecha, filtro_averia, fecha_ini, fecha_fin, file;
$(document).ready(function() {

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

//dataMorris=dataMorris.join();
/*
var array=[];
for (var i = dataMorris.length - 1; i >= 0; i--) {
    //console.log(dataMorris[i]);

};


for (val in dataMorris) {
    console.log(dataMorris[val]);
}
dataMorris=JSON.stringify(dataMorris);
console.log(dataMorris);
*/
console.log(dataMorris[0]);
    Morris.Area({
        element: 'morris-area-chart',
        data: 
        [dataMorris[0]]


        /*[

        {
            period: '2010 Q1',
            iphone: 2666,
            ipad: null,
            itouch: 2647
        }, {
            period: '2010 Q2',
            iphone: 2778,
            ipad: 2294,
            itouch: 2441
        }, {
            period: '2010 Q3',
            iphone: 4912,
            ipad: 1969,
            itouch: 2501
        }, {
            period: '2010 Q4',
            iphone: 3767,
            ipad: 3597,
            itouch: 5689
        }, {
            period: '2011 Q1',
            iphone: 6810,
            ipad: 1914,
            itouch: 2293
        }, {
            period: '2011 Q2',
            iphone: 5670,
            ipad: 4293,
            itouch: 1881
        }, {
            period: '2011 Q3',
            iphone: 4820,
            ipad: 3795,
            itouch: 1588
        }, {
            period: '2011 Q4',
            iphone: 15073,
            ipad: 5967,
            itouch: 5175
        }, {
            period: '2012 Q1',
            iphone: 10687,
            ipad: 4460,
            itouch: 2028
        }, {
            period: '2012 Q2',
            iphone: 8432,
            ipad: 5713,
            itouch: 1791
        }


        ]*/,
        /*
        xkey: 'period',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        */
        xkey: 'software',
        ykeys: ['cant0', 'cant1', 'cant2'],
        labels: ['cant0', 'cant1', 'cant2'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    $('#side-menu').metisMenu();

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
        var array={software: data.software, cant0: data.cero, cant1:data.uno, cant2:data.dos};
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
