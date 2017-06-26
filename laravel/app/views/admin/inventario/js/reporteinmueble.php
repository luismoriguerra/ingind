<script type="text/javascript">
$(document).ready(function() {

    var data = {estado:1};
    var ids = [];

    function DataToFilter(){
        var area_id = $('#slct_area_id').val();
        var data = [];
            if ($.trim(area_id)!=='') {
                data.push({area_id:area_id});
            } else {
                alert("Seleccione Área");
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
            $(this).attr('href','reporte/exportreporteinventario'+'?area_id='+area);            
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
            "<td>"+data.area+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.cod_patrimonial+"</td>"+
            "<td>"+data.cod_interno+"</td>"+
            "<td>"+data.descripcion+"</td>";
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
