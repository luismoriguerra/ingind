<script type="text/javascript">
$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    var data = {estado:1};
    var ids = [];

    function DataToFilter(){
        area_id = $('#slct_area_id').val();
        var fecha=$("#fecha").val();
        var data = [];
        if ( fecha!=="") {
            if ($.trim(area_id)!=='') {
                data.push({area_id:area_id,fecha:fecha});
            } else {
                alert("Seleccione Área");
            }
        } else {
            alert("Seleccione Fecha");
        }
        return data;
    }

    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    $("#generar").click(function (){
        var data = DataToFilter();            
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });

    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            var area = data[0]['area_id'].join('","');
            $(this).attr('href','reporte/exportnotincumplimiento'+'?fecha='+data[0]['fecha']+'&area_id='+area);            
        }else{
            event.preventDefault();
        }
    });
});

HTMLreporte=function(datos){
    var html="";
    
    var alerta_tipo= '';
    $('#t_reporte').dataTable().fnDestroy();
    cont = 0;
    $.each(datos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.documento+"</td>"+
            "<td>"+data.paso+"</td>"+
            "<td>"+data.fechaAsignada+"</td>"+
            "<td>"+data.fechaFinal+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td></td>"+
            "<td>"+data.tipo_aviso+"</td>"+
            "<td>"+ data.proceso +"</td>"+
            "<td>"+ data.area +"</td>";
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
