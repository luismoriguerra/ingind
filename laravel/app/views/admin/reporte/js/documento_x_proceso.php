<script type="text/javascript">
$(document).ready(function() {
    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    $("#generar").click(function (){
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        if ( fecha!=="") {
            if ($.trim(area_id)!=='') {
                data = {area_id:area_id,fecha:fecha};
                Accion.mostrar(data);
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
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        
        html+="<tr>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.tipo_documento+"</td>"+
            "<td>"+data.ndocumentos+"</td>"+
            "<td>"+data.ntramites+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"]],
        }
    ); 
    $("#reporte").show();
};

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
