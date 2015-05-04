<script type="text/javascript">
$(document).ready(function() {
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    $("#generar").click(function (){
        
        var fecha=$("#fecha").val();
        if ( fecha!=="")
            Tramite.mostrar(fecha);
        else
            alert("Seleccione Fecha");
        
    });
});
HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();
    $("#reporte_detalle").hide();
    if (datos.length>0) {

        $.each(datos,function(index,data){
            html+="<tr>"+
                "<td>"+data.id+"</td>"+
                "<td>"+data.flujo+"</td>"+
                "<td>"+data.persona+"</td>"+
                "<td>"+data.area+"</td>"+
                "<td>"+data.ok+"</td>"+
                "<td>"+data.error+"</td>"+
                "<td>"+data.dep+"</td>"+
                "<td>"+data.fruta+"</td>"+
                "<td>"+data.estado+"</td>"+
                "<td>"+data.norden+"</td>"+
                "<td>"+data.area2+"</td>"+
                "<td>"+data.tiempo+': '+data.dtiempo+"</td>";
                //'<td><a onClick="detalle('+data.id+')" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
            html+="</tr>";

        });
        $("#tb_reporte").html(html);
        activarTabla();
        $("#reporte").show();
    //grafico();
    }


};
activarTabla=function(){
    $("#t_reporte").dataTable();
};
</script>