<script type="text/javascript">

$(document).ready(function() {
    //$("[data-toggle='offcanvas']").click();
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);

    //$("#btn_guardar_todo").click(guardarTodo);
    //$("#areasasignacion").DataTable();
});

mostrarRutaFlujo=function(){
    $("#tabla_ruta_flujo").css("display","none");
    var flujo_id=$.trim($("#slct_flujo_id").val());
    var area_id=$.trim($("#slct_area_id").val());

    if( flujo_id!='' && area_id!='' ){
        var datos={ flujo_id:flujo_id,area_id:area_id };
        $("#tabla_ruta_flujo").css("display","");
        Validar.mostrarRutaDetalle(datos,mostrarRutaDetalleHTML);
    }
}

mostrarRutaDetalleHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
    var color="";
    var clase="";
     $('#t_ruta_flujo').dataTable().fnDestroy();
     $("#txt_ruta_flujo_id").remove();
    $.each(datos,function(index,data){
        imagen="";
        clase="";
        cont++;
        if(cont==1){
            $("#form_validar").append('<input type="hidden" id="txt_ruta_flujo_id" name="txt_ruta_flujo_id" value="'+data.id+'">');
            
            imagen="<a id='ruta_flujo_id' data-id='"+data.id+"' class='btn btn-success btn-sm'><i class='fa fa-check-square fa-lg'></i></a>";
        }
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+data.persona+"</td>"+
        "<td>"+data.ok+"</td>"+
        "<td>"+data.error+"</td>"+
        "<td>"+data.fruta+"</td>"+
        "<td>"+imagen+"</td>";
    html+="</tr>";

    });
    $("#tb_ruta_flujo").html(html); 
    $('#t_ruta_flujo').dataTable({
        "ordering": false
    });
}

guardarTodo=function(){
    /*if( $.trim($("#txt_codigo").val())==''){
        alert("Busque y seleccione un código");
    }
    else if( $("#slct_flujo_id").val()=='' ){
        alert("Seleccione un Tipo Flujo");
    }
    else if( $("#slct_area_id").val()=='' ){
        alert("Seleccione una Area");
    }
    else if( !$("#txt_ruta_flujo_id").val() || $("#txt_ruta_flujo_id").val()=='' ){
        alert("Seleccione una combinacion donde almeno exita 1 registro");
    }
    else{
        if ( confirm("Favor de confirmar para registrar") ){
            Validar.guardarAsignacion();
        }
    }*/
}

</script>
