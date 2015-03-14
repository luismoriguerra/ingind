<script type="text/javascript">
temporalBandeja=0;
$(document).ready(function() {
    Ruta.CargarRuta(HTMLCargarRuta);
});

HTMLCargarRuta=function(datos){
    var html="";
    var cont=0;
     $('#t_rutaflujo').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.persona+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+data.ok+"</td>"+
        "<td>"+data.error+"</td>"+
        "<td>"+data.dep+"</td>"+
        "<td>"+data.fruta+"</td>"+
        '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Modal" data-codactu="'+data.codactu+'"><i class="fa fa-search-plus fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#tb_rutaflujo").html(html); 
    $("#t_rutaflujo").dataTable();
}
</script>
