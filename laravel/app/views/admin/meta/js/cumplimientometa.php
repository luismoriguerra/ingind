<script type="text/javascript">
$(document).ready(function() {

    var data = {estado:1};
    var ids = [];

    function DataToFilter(){
        var meta_id = $('#slct_meta').val();
        var data = [];
            if ($.trim(meta_id)!=='') {
                data.push({meta:meta_id});
            } else {
                alert("Seleccione Meta");
            }
        return data;
    }

     var datos = {estado: 1,cuadro:1};
     slctGlobal.listarSlct('meta','slct_meta', 'multiple', null, datos);

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
        var style="";
        if(data.estado=='SI'){
            var style=';background-color:#7BF7AE';
        }
        else if(data.estado=='NO'){
            var style=';background-color:#FE4E4E';  
        }
        else if(data.estado=='A TIEMPO'){
            var style=';background-color:#ffff66'; 
        }
        else if(data.estado=='ALERTA'){
        var style=';background-color:#FFA027';
        }
        cont=cont+1;
        html+="<tr style='"+style+"'>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.meta+"</td>"+
            "<td>"+data.actividad+"</td>"+
            "<td>"+data.fecha+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+data.porcentaje+" %</td>"+
            "<td>"+data.des_por+" %</td>";
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
