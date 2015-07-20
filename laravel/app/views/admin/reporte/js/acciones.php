<script type="text/javascript">
$(document).ready(function() {
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    slctGlobalHtml('slct_estado_id','multiple');
    $("#generar").click(function (){
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        estado_id=$("#slct_estado_id").val();
        if ( fecha!=="") {
            if ($.trim(area_id)!=='') {
                if($.trim(estado_id)!=''){
                data = {area_id:area_id,fecha:fecha,estado_id:estado_id};
                Accion.mostrar(data);
                }
                else{
                    alert("Seleccione Estado");
                }
            } else {
                alert("Seleccione Área");
            }
        } else {
            alert("Seleccione Fecha");
        }
    });
});
HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $.each(datos,function(index,data){
        alerta_tipo = '';
        
        if (data.alerta=='Alerta' || data.alerta=='Alerta Validada') {
            if (data.alerta_tipo==1) {
                alerta_tipo = 'Tiempo asignado';
            } else if (data.alerta_tipo==2) {
                alerta_tipo = 'Tiempo de respuesta';
            } else if (data.alerta_tipo==3) {
                alerta_tipo = 'Tiempo aceptado';
            }
        }
        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.duenio+"</td>"+
            "<td>"+data.area_duenio+"</td>"+
            "<td>"+data.n_areas+"</td>"+
            "<td>"+data.n_pasos+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            "<td>"+data.fecha_creacion+"</td>";

            if(data.estado_final==1){
        html+="<td>"+data.fecha_produccion+"</td>";
        html+="<td>"+data.ntramites+"</td>";
        html+='<td><a onClick="detalle('+data.ruta_flujo_id+',this)" class="btn btn-primary btn-sm" data-id="'+data.ruta_flujo_id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a></td>';
            }
            else{
        html+="<td>&nbsp;</td>";
        html+="<td>0</td>";
        html+="<td>&nbsp;</td>";
            }
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#tb_reporteDetalle").html('');
    $("#tb_reporteDetalle2").html('');
    //activarTabla();
    $("#reporte").show();
};

activarTabla=function(){
    $("#t_reporte").dataTable();
};

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
