<script type="text/javascript">
$(document).ready(function() {
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];
    //slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    $("#generar").click(function (){
              Accion.mostrar(data);
        /*var fecha=$("#fecha").val();
        if ( fecha!=="") {
            if ($.trim(area_id)!=='') {
                data = {area_id:area_id,fecha:fecha};
                Accion.mostrar(data);
            } else {
                alert("Seleccione Área");
            }
        } else {
            alert("Seleccione Fecha");
        }*/
    });
});
HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        
        html+="<tr>"+
            "<td>"+$.trim(data.proceso_pla)+"</td>"+
            "<td>"+$.trim(data.plataforma)+"</td>"+
            "<td>"+$.trim(data.fecha_inicio)+"</td>"+
            "<td>"+$.trim(data.dtiempo_final)+"</td>"+
            "<td>"+$.trim(data.proceso)+"</td>"+
            "<td>"+$.trim(data.gestion)+"</td>"+
            "<td>"+$.trim(data.fecha_inicio_gestion)+"</td>"+
            "<td>"+$.trim(data.ult_paso)+"</td>"+
            "<td>"+$.trim(data.act_paso)+"</td>"+
            "<td>"+$.trim(data.fecha_fin)+"</td>"+
            "<td>"+$.trim(data.tiempo_realizado)+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(); 
    $("#reporte").show();
};

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
