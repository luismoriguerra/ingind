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
    $('#t_reporte').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        alerta_tipo = '';
        
        html+="<tr>"+
            "<td>"+data.areapaso+"</td>"+
            "<td>"+data.nverbos+"</td>"+
            "<td>"+data.fecha+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.norden+"</td>";
        html+="</tr>";
    });
    $("#tb_reporte").html(html);
    $("#t_reporte").dataTable(
        {
            "order": [[ 4, "asc" ],[6, "asc"]],
        }
    ); 
    $("#reporte").show();
};

eventoSlctGlobalSimple=function(slct,valores){
};
</script>
