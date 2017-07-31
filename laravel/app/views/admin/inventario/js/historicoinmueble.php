<script type="text/javascript">
$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
         showDropdowns: true
    });
    var data = {estado:1};
    var ids = [];
    function DataToFilter(){
        var fecha = $('#fecha').val();
        var data = [];
            if ($.trim(fecha)!=='') {
                data.push({fecha:fecha});
            } else {
                alert("Seleccione Rango de Fecha");
            }
        return data;
    }

//    slctGlobal.listarSlct('area','slct_area_id','multiple',ids,data);

    $("#generar").click(function (){
        var data = DataToFilter();            
        if(data.length > 0){
            Accion.mostrar(data[0]);            
        }
    });

    $(document).on('click', '#btnexport', function(event) {
        var data = DataToFilter();
        if(data.length > 0){
            var fecha = data;
            $(this).attr('href','reporte/exporthistoricoinventario'+'?fecha='+data[0]['fecha']);            
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
            "<td>"+data.cod_patrimonial+"</td>"+
            "<td>"+data.cod_interno+"</td>"+
            "<td>"+data.ultimo+"</td>";
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
