<script type="text/javascript">
$(document).ready(function() {

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false
    });
    
    $("#generar").click(function (){
        if($.trim($("#txt_ruc").val())!=='' ||
            $.trim($("#fecha").val())!=='')
        {
            data = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.mostrar(data);
        }
        else
        {
            alert("Por favor ingrese al menos una busqueda!");   
        }
    });


    $(document).on('click', '#btnexport', function(event) {
        if($.trim($("#txt_ruc").val())!=='' || 
            $.trim($("#fecha").val())!=='')
        {
            var ruc = $("#txt_ruc").val();
            var fecha = $("#fecha").val();
            $(this).attr('href','reportegastos/exportsaldosporpagar'+'?ruc='+ruc+'&fecha='+fecha);
        }else{
            event.preventDefault();
        }
    });
});

HTMLreporte=function(datos){
    var html = "";
    var alerta_tipo = '';

    $('#t_reporte').dataTable().fnDestroy();
    
    cont = 0;
    $.each(datos,function(index,data){
        cont=cont+1;
        html+="<tr>"+
            "<td>"+ cont +"</td>"+
            "<td>"+data.ruc+"</td>"+
            "<td>"+data.proveedor+"</td>"+
            "<td>"+data.nro_expede+"</td>"+
            "<td>"+data.total_gc+"</td>"+
            "<td>"+data.total_gd+"</td>"+
            "<td>"+data.total_gg+"</td>"+
            "<td>"+data.total_pagar_gd+"</td>"+
            "<td>"+data.total_pagar_gc+"</td>";
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
