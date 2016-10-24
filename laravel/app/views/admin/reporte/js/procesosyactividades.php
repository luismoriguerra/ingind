<script type="text/javascript">
$(document).ready(function() {

    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);
    slctGlobalHtml('slct_estado','multiple');

    function DataToFilter(){
        area_id = $('#slct_area_id').val();
        estado = $("#slct_estado").val();
        var data = [];
        if ($.trim(area_id)!=='') {
            if ($.trim(estado)!=='') {
                data.push(
                    {
                        area_id:area_id.join('","'),
                        estado:estado.join('","')
                    }
                );
            } else {
                alert("Seleccione estado");
            }
        } else {
            alert("Seleccione Área");
        }
        return data;
    }

    
    $("#generar").click(function (){
        var data = DataToFilter();            
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });

    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            $(this).attr('href','reporte/exportprocesosactividades'+'?estado='+data[0]['estado']+'&area_id='+data[0]['area_id']);            
        }else{
            event.preventDefault();
        }
    });
});

HTMLreporte=function(datos){
    var html="";
    $('#t_reporte').dataTable().fnDestroy();
    cont = 0;
    $.each(datos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.nombdueño+"</td>"+
            "<td>"+data.areanom+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.fechacreacion+"</td>"+
            "<td>"+data.paso+"</td>"+
            "<td>"+data.nombareapaso+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            "<td>"+ data.usuarioupdate +"</td>"+
            "<td>"+ data.fechaupdate +"</td>";
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
