<script type="text/javascript">
$(document).ready(function() {
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujos','multiple',ids,data);
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];

    $("#generar").click(function (){
        var fecha=$("#fecha").val();
        var proceso=$("#slct_flujos").val();
        
        if( proceso.length>0 ){
            if ( fecha!=="") {
                    data = {fecha:fecha,flujo:proceso};
                    Accion.mostrar(data);
            } else {
                alert("Seleccione Fecha");
            }
        }
        else{
            alert('Seleccione Proceso');
        }
    });
});

HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td>"+data.flujo+"</td>"+
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
            '<td><a onClick="detalle2('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
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

HTMLreporteDetalle2=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//ambar
    var alertCorregido ='warning';//rojo
    var alert='', i;
    var estado_final='';
    $.each(datos,function(index,data){
        if (data.alerta=='0') alert=alertOk;
        if (data.alerta=='1') alert=alertError;
        if (data.alerta=='2') alert=alertCorregido;

        alerta_tipo = '';
        observacion = data.observacion.split(",");
        descripcion_v = data.descripcion_v.split(",");
        documento = data.documento.split(",");
        estado_accion = data.estado_accion.split(",");
        rol = data.rol.split(",");
        verbo = data.verbo.split(",");
        verbo_finalizo = data.verbo_finalizo.split(",");
        estado_final='Pendiente';
        if(data.dtiempo_final!=''){
            if(data.alerta=='0'){
                estado_final='Concluido';
            }
            else if(data.alerta=='1'){
                estado_final='Truncado';
            }
            else if(data.alerta=='2'){
                estado_final='Truncado R.';
            }
        }

        html+="<tr class='"+alert+"'>"+
                "<td>"+data.norden+"</td>"+
                "<td>"+data.area+"</td>"+
                "<td>"+data.tiempo+': '+data.dtiempo+"</td>"+
                "<td>"+data.fecha_inicio+"</td>"+
                "<td>"+data.dtiempo_final+"</td>"+
                "<td>"+estado_final+"</td>"+
                "<td colspan='4'>"+data.verbo2.split("|").join("<br>")+"</td>"+
                "<td colspan='3'>"+data.ordenv.split("|").join("<br>")+"</td>";
        html+=  "</tr>";

    });
    $("#tb_reporteDetalle2").html(html);
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

detalle2=function(ruta_id,boton){
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    CumpArea.mostrarDetalle2(ruta_id);
};
</script>
