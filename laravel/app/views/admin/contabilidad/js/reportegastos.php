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

    $('#spn_fecha_ini').click(function(){
        $('#fecha_ini').focus();
    });
    $('#spn_fecha_fin').click(function(){
        $('#fecha_fin').focus();
    });

    $("#generar").click(function (){

        if($.trim($("#txt_ruc").val())!=='' || 
            $.trim($("#txt_nro_expede").val())!=='' || 
            $.trim($("#txt_proveedor").val())!=='' || 
            $.trim($("#txt_observacion").val())!==''||
            $.trim($("#fecha_ini").val())!=='' ||
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.MostrarReporte(dataG);
            //Reporte.MostrarReporteDetalle(dataG); // Ya no va este listado!
        }
        else
        {
            alert("Por favor ingrese al menos una busqueda!");
        }
    });

    $("#limpiar").click(function (){
        $('#form_reporte input').not('.checkbox').val('');
        
        $("#tb_ordenest").html('');
        $('#div_detalle').hide();
        $("#tb_deta").html(html);
    });

    $(document).on('click', '#btnexport', function(event) {
        if($.trim($("#txt_ruc").val())!=='' || 
            $.trim($("#txt_nro_expede").val())!=='' || 
            $.trim($("#txt_proveedor").val())!=='' || 
            $.trim($("#txt_observacion").val())!=='' ||
            $.trim($("#fecha_ini").val())!=='' ||
            $.trim($("#fecha_fin").val())!=='')
        {
            var ruc = $("#txt_ruc").val();
            var nro_expede = $("#txt_nro_expede").val();
            var proveedor = $("#txt_proveedor").val();
            var observacion = $("#txt_observacion").val();
            var fecha_ini = $("#fecha_ini").val();
            var fecha_fin = $("#fecha_fin").val();
            var saldos_pago = $("#txt_saldos_pago").val();

            $(this).attr('href','reportegastos/exportdetallegastos'+'?ruc='+ruc+'&nro_expede='+nro_expede+'&proveedor='+proveedor+'&observacion='+observacion+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+"&saldos_pago="+saldos_pago);
        }else{
            event.preventDefault();
        }
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

    var AC_GC = 0;
    var AC_GD = 0;
    var AC_GG = 0;

    var aux_id = '';
    $.each(datos,function(index,data){
        con++;
        if( aux_id != data.contabilidad_gastos_id ){
               
            if(aux_id != ''){
                html+="<tr style='font-weight: bold; font-size: 12px; '>"+
                        '<td>SALDOS</td>'+
                        "<td>"+AC_GC.toFixed(2)+"</td>"+
                        "<td>"+AC_GD.toFixed(2)+"</td>"+
                        "<td>"+AC_GG.toFixed(2)+"</td>"+
                        "<td colspan='11'>&nbsp;</td>";
                html+="</tr>";
                AC_GC = 0;
                AC_GD = 0;
                AC_GG = 0;
            }
            aux_id = data.contabilidad_gastos_id;
        }

        html+="<tr style='font-size: 12px;'>"+
                '<td>'+data.nro_expede+'</td>'+
                "<td>"+data.gc+"</td>"+
                "<td>"+data.gd+"</td>"+
                "<td>"+data.gg+"</td>"+
                "<td>"+data.fecha_documento+"</td>"+
                "<td>"+data.documento+"</td>"+
                "<td>"+data.nro_documento+"</td>"+
                "<td>"+data.ruc+"</td>"+
                "<td>"+data.proveedor+"</td>"+
                "<td>"+data.esp_d+"</td>"+
                    "<td>"+data.fecha_doc_b+"</td>"+
                    "<td>"+data.doc_b+"</td>"+
                    "<td>"+data.nro_doc_b+"</td>"+
                    "<td>"+data.persona_doc_b+"</td>"+
                    "<td>"+data.observacion+"</td>"
                //'<td><span onclick="verAdicional('+con+')" style="cursor: pointer; margin-left: 4px;" class="glyphicon glyphicon-plus" aria-hidden="true"></span></td>';
        html+="</tr>";

        // Muestra la observación
        /*html+="<tr role='row' style='display: none;' id='obs"+con+"'>";
            html+="<td colspan='8'><div style='padding: 15px 15px; background-color: #F5F5F5;'><strong>Observación:</strong> "+data.observacion+"</div></td>";
        html+="</tr>";*/
        // --

        AC_GC += data.gc*1;
        AC_GD += data.gd*1;
        AC_GG += data.gg*1;
    });

        html+="<tr style='font-weight: bold; font-size: 12px; '>"+
                '<td>SALDOS</td>'+
                "<td>"+AC_GC.toFixed(2)+"</td>"+
                "<td>"+AC_GD.toFixed(2)+"</td>"+
                "<td>"+AC_GG.toFixed(2)+"</td>"+
                "<td colspan='11'>&nbsp;</td>";
        html+="</tr>";
    
    $("#tb_ordenest").html(html);
    //$("#reporte").show();
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
    $("#obs" + id ).slideToggle();
}

</script>
