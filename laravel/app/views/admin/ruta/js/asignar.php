<script type="text/javascript">

$(document).ready(function() {
    //$("[data-toggle='offcanvas']").click();
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    slctGlobal.listarSlct('software','slct_software_id_modal','simple',ids,data);

    Asignar.Relacion(RelacionHTML);

    $('#asignarModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var modal = $(this); //captura el modal
    });

    $('#asignarModal').on('hide.bs.modal', function (event) {
      $("#form_tabla_relacion input[type='text'], #form_tabla_relacion select").val("");
      $("#slct_software_id_modal").multiselect('refresh');
    });

    $("#btn_guardar_todo").click(guardarTodo);
    //$("#areasasignacion").DataTable();
});

mostrarRutaFlujo=function(){
    $("#tabla_ruta_flujo").css("display","none");
    var flujo_id=$.trim($("#slct_flujo_id").val());
    var area_id=$.trim($("#slct_area_id").val());

    if( flujo_id!='' && area_id!='' ){
        var datos={ flujo_id:flujo_id,area_id:area_id };
        $("#tabla_ruta_flujo").css("display","");
        Asignar.mostrarRutaFlujo(datos,mostrarRutaFlujoHTML);
    }
}

mostrarRutaFlujoHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
    var color="";
    var clase="";
     $('#t_ruta_flujo').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        imagen="";
        clase="";
        cont++;
        if(cont==1){
            $("#txt_ruta_flujo_id").remove();
            $("#form_asignar").append('<input type="hidden" id="txt_ruta_flujo_id" name="txt_ruta_flujo_id" value="'+id+'">');
            
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

RelacionHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
     $('#t_tablarelacion').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+data.software+"</td>"+
        "<td>"+data.codigo+"</td>"+
        '<td>'+
            '<a onclick="SeleccionRelacion('+data.id+','+"'"+data.codigo+"'"+');" class="btn btn-success btn-sm"><i class="fa fa-check-square fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#tb_tablarelacion").html(html); 
    $("#t_tablarelacion").dataTable();
}

MostrarTablaRelacion=function(){
    $("#tabla_relacion").css("display","");
}

CerrarTablaRelacion=function(){
    $("#tabla_relacion").css("display","none");
}

SeleccionRelacion=function(id,codigo){
    CerrarTablaRelacion();
    $("#txt_codigo").val(codigo);
    $("#txt_tabla_relacion_id").remove();
    $("#form_asignar").append('<input type="hidden" id="txt_tabla_relacion_id" name="txt_tabla_relacion_id" value="'+id+'">');
}

guardarRelacion=function(){
    if( $.trim($("#txt_codigo_modal").val())=='' ){
        alert("Ingrese un código");
    }
    else if( $.trim($("#slct_software_id_modal").val())=='' ){
        alert("Seleccione un Software relacionado");
    }
    else if( confirm("Esta conforme con los datos registrados? Click en aceptar para continuar.") ){
        Asignar.guardarRelacion();
    }
}

guardarTodo=function(){
    if( $.trim($("#txt_codigo").val())==''){
        alert("Busque y seleccione un código");
    }
    else if( $("#slct_flujo_id").val()='' ){
        alert("Seleccione un Tipo Flujo");
    }
    else if( $("#slct_area_id").val()='' ){
        alert("Seleccione una Area");
    }
    else{
        alert("Guardando");
    }
}

</script>
