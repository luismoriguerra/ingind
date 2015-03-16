<script type="text/javascript">
temporalBandeja=0;
$(document).ready(function() {
    $("[data-toggle='offcanvas']").click();
    $("#btn_nuevo").click(Nuevo);
    Ruta.CargarRuta(HTMLCargarRuta);
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
});

Nuevo=function(){
    $("#txt_titulo").val("Nueva Ruta");
    $("#slct_flujo,#slct_area,#slct_persona").val("");
    $("#slct_flujo,#slct_area,#slct_persona").multiselect('refresh');
}

Actualiza=function(){
    $("#txt_titulo").val("Actualiza Ruta");
}

HTMLCargarRuta=function(datos){
    var html="";
    var cont=0;
     $('#t_rutaflujo').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+data.persona+"</td>"+
        "<td>"+data.ok+"</td>"+
        "<td>"+data.error+"</td>"+
        "<td>"+data.dep+"</td>"+
        "<td>"+data.fruta+"</td>"+
        '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rutaflujoModal" data-id="'+data.id+'"><i class="fa fa-edit fa-lg"></i> </a>'+
            '<a class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#tb_rutaflujo").html(html); 
    $("#t_rutaflujo").dataTable();
}
</script>
