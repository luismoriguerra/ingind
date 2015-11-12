<script type="text/javascript">
$(document).ready(function() {
    Carta.CargarCartas(HTMLCargarCartas);
    $("#btn_nuevo").click(Nuevo);
    $("#btn_close").click(Close);
    /*
    $("#btn_guardar_tiempo,#btn_guardar_verbo").remove();
    var data = {estado:1,tipo_flujo:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    data = {estado:1};
    slctGlobal.listarSlct('area','slct_area2_id,#slct_area_id,#slct_area_p_id','simple',ids,data);
    */
});

Nuevo=function(){
    $("#cartainicio").css("display","");
}

Close=function(){
    $("#cartainicio").css("display","none");
}

HTMLCargarCartas=function(datos){
    var html="";
    $('#t_carta').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td >"+data.nro_carta+"</td>"+
            "<td >"+data.objetivo+"</td>"+
            "<td >"+data.entregable+"</td>";
        html+="</tr>";
    });
    $("#tb_carta").html(html); 
    $('#t_carta').dataTable();
}
</script>
