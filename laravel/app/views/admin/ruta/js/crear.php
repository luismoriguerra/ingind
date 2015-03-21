<script type="text/javascript">
temporalBandeja=0;
posruta=0;verificavalorUlt="";
$(document).ready(function() {
    $("[data-toggle='offcanvas']").click();
    $("#btn_nuevo").click(Nuevo);
    $("#btn_close").click(Close);
    $("#btn_adicionar_ruta_detalle").click(adicionarRutaDetalle);
    Ruta.CargarRuta(HTMLCargarRuta);
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id_2','simple',ids,data);

    //$("#areasasignacion").DataTable();
});

adicionarRutaDetalle=function(){
    if($.trim($("#slct_area_id_2").val())==''){
        alert('Seleccione un Area para adicionar');
    }
    else if($("#slct_area_id_2").val()==posruta && posruta!=''){
        alert('No se puede asignar 2 veces continuas la misma Area');
    }
    else if($.trim($("#slct_area_id_2").val())!='' && $("#slct_area_id_2").val()!=verificavalorUlt){
        posruta++;
        verificavalorUlt=$("#slct_area_id_2").val();
        valorUlt=$("#slct_area_id_2 option[value='"+$("#slct_area_id_2").val()+"']").text();
        var valor='';
        valor=  "<tr id='tr-detalle-"+posruta+"'>"+
                    "<td>"+
                        "<button class='btn btn-danger btn-sm' onclick='EliminarDetalle("+posruta+");' type='button'>"+
                            posruta+" &nbsp;<i class='fa fa-remove fa-sm'></i>"+
                        "</button>"+
                    "</td>"+
                    "<td>"+
                        valorUlt+
                    "</td>"+
                "</tr>";
        $("#tb_rutaflujodetalleAreas").append(valor);
    }
}

EliminarDetalle=function(t){
    $("#tr-detalle-"+posruta).remove();
}

Nuevo=function(){
    $(".form-group").css("display","");
    $("#txt_titulo").val("Nueva Ruta");
    $("#slct_flujo,#slct_area").val("");
    $("#slct_flujo,#slct_area").multiselect('refresh');
    $("#txt_persona").val('<?php echo Auth::user()->paterno." ".Auth::user()->materno." ".Auth::user()->nombre;?>');
    $("#txt_ok,#txt_error").val("0");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
}

Actualiza=function(){
    $("#txt_titulo").val("Actualiza Ruta");
    $("#fecha_creacion").html('');
}

Close=function(){
    $(".form-group").css("display","none");
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
