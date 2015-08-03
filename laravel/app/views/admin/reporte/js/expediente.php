<script type="text/javascript">
$(document).ready(function() {
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];

    $("#generar").click(function (){
        var fecha=$("#fecha").val();
        if ( fecha!=="") {
                data = {fecha:fecha};
                Accion.mostrar(data);
        } else {
            alert("Seleccione Fecha");
        }
    });
});

HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.tipo_persona+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.ultimo_paso_area+"</td>"+
            "<td>"+data.total_pasos+"</td>"+
            "<td>"+data.fecha_tramite+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.errorr+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
        html+="</tr>";
    });

    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ]],
        }
    ); 
    $("#reporte").show();
};

HTMLreportedetalle=function(datos){
    var html="";
    $('#t_reporte2').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td>"+data.id_union+"</td>"+
            "<td>"+data.tipo_solicitante+"</td>"+
            "<td>"+data.area_proceso+"</td>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.nanp+"</td>"+
            "<td>"+data.area_generada+"</td>"+
            "<td>"+data.tipo_documento+"</td>"+
            "<td>"+data.documento+"</td>";
        html+="</tr>";
    });

    $("#tb_reporte2").html(html);
    $("#t_reporte2").dataTable();
    $("#reporte2").show();
};


detalle=function(ruta_id, boton){
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    var data={id:ruta_id};
    Accion.mostrar_detalle(data);
};
</script>
