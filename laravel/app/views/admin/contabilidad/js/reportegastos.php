<script type="text/javascript">
$(document).ready(function() {

    $(".fechas").datetimepicker({
        format: "yyyy-mm",
        language: 'es',
        showMeridian: false,
        time: false,
        minView: 3,
        startView: 3,
        autoclose: true,
        todayBtn: false
    });

    $('#div_detalle').hide();

    $("#generar").click(function (){
        if($.trim($("#txt_ruc").val())!=='' || 
            $.trim($("#txt_nro_expede").val())!=='' || 
            $.trim($("#txt_proveedor").val())!=='' || 
            $.trim($("#txt_observacion").val())!=='' ||
            $.trim($("#fecha_ini").val())!=='' ||
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            //console.debug(dataG);
            Reporte.MostrarReporte(dataG);
            Reporte.MostrarReporteDetalle(dataG);
        }
        else
        {
            alert("Por favor ingrese al menos una busqueda!");   
        }
    });

    $("#limpiar").click(function (){
        $('#form_reporte input').val('');
        $("#tb_ordenest").html('');
        $('#div_detalle').hide();
        $("#tb_deta").html(html);
    });
    
});

Regresar=function(){
    
    $('#reporte').show();
    $('fieldset').show();
     $(".nav-tabs-custom").hide();
    $('#bandeja_detalle').hide();
    
};
activarTabla=function(){
    //$("#t_detalles").dataTable(); // inicializo el datatable    
};

HTMLMostrarReporte=function(datos){
  if(datos.length > 0){
    //$('#t_ordenest').dataTable().fnDestroy();
    var html ='';
    var con = 0;
    $.each(datos,function(index,data){
        con++;
        if((con % 2) == 0) var clase = 'odd';
        else var clase = 'even';

        html+="<tr role='row' class='"+clase+"' id='reg"+con+"' >"+
                '<td><span onclick="verAdicional('+con+')" style="cursor: pointer; margin-left: 6px;" class="glyphicon glyphicon-plus" aria-hidden="true"></span></td>'+
                '<td>'+data.nro_expede+'</td>'+
                "<td>"+data.tipo_expede+"</td>"+
                "<td>"+data.monto_expede+"</td>"+
                "<td>"+data.fecha_documento+"</td>"+
                "<td>"+data.documento+"</td>"+
                "<td>"+data.ruc+"</td>"+
                "<td>"+data.proveedor+"</td>";
        html+="</tr>";

        //if($.trim(data.observacion)!=='')        
        html+="<tr role='row' class='class_obs "+clase+"' style='display: none;' id='obs"+con+"'>";
            html+="<td colspan='8'><div style='padding: 15px 15px; background-color: #F5F5F5;'><strong>Observación:</strong> "+data.observacion+"</div></td>";
        html+="</tr>";
    });
    
    $("#tb_ordenest").html(html);

    //$("#t_ordenest").DataTable();
    //console.debug(JSON.stringify(datos));
    //declaro como global
    /*
    $("#t_ordenest").DataTable( {
        "ajax": datos,
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "nro_expede" },
            { "data": "tipo_expede" },
            { "data": "monto_expede" },
            { "data": "fecha_documento" },
            { "data": "documento" },
            { "data": "ruc" },
            { "data": "proveedor" }
            //{ "data": "observacion" }
        ],
        "order": [[1, 'asc']]
    });
    */
    // --

  }else{
    $("#tb_ordenest").html('');
  }
};


HTMLMostrarReporteDetalle=function(datos){

  $('#div_detalle').show();

  if(datos.length > 0){
    var html ='';

    $.each(datos,function(index,data){

        if(data.FC == null) FC = 0;
        else FC = data.FC;

        if(data.FD == null) FD = 0;
        else FD = data.FD;

        if(data.FG == null) FG = 0;
        else FG = data.FG;

        html+="<tr>"+
            "<td>"+data.nro_expede+"</td>"+
            "<td style='font-weight: bold;'>"+data.monto_total+"</td>"+
            "<td>"+data.GC+"</td>"+
            "<td>"+data.GD+"</td>"+
            "<td>"+data.GG+"</td>"+
            "<td style='font-weight: bold;'>"+FC+"</td>"+
            "<td style='font-weight: bold;'>"+FD+"</td>"+
            "<td style='font-weight: bold;'>"+FG+"</td>"
            ;
        html+="</tr>";
    });
    $("#tb_deta").html(html);
    //$("#t_ordenest").dataTable();

  }else{
    $("#tb_deta").html('');
  }
};

verAdicional = function(id)
{
    //$(".class_obs").hide();
    $("#obs" + id ).slideToggle();
}

</script>
