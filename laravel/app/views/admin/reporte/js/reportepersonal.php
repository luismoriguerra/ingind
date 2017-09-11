<script type="text/javascript">
$(document).ready(function() {

    $(".fecha").datetimepicker({
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

        if( $.trim($("#fecha_ini").val())!=='' ||
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.MostrarReporte(dataG);
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
        
    });
    
});

/*
Regresar=function(){
    $('#reporte').show();
    $('fieldset').show();
     $(".nav-tabs-custom").hide();
    $('#bandeja_detalle').hide();
    
};
*/
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
        html+="<tr style='font-size: 12px;'>"+
                '<td>'+data.NRO+'</td>'+
                "<td>"+data.AREA+"</td>"+
                "<td>"+data.nombres_completos+"</td>"+
                "<td>"+data.dni+"</td>"+
                "<td>"+data.cargo+"</td>"+
                "<td>"+data.funciones+"</td>"+
                "<td>"+data.estado+"</td>"+
                "<td>"+data.sueldo+"</td>"+
                "<td>"+data.doc_emitido_varios+"</td>"+
                "<td>"+data.DOCUMENTOS_acciones+"</td>"+

                    "<td>"+data.Cantidad+"</td>"+
                    "<td>"+data.horas+"</td>"+
                    "<td>"+data.descanso+"</td>"+
                    "<td>"+data.porcentaje+"</td>"+
                    "<td>"+data.Cantidad_proc+"</td>"+
                    "<td>"+data.dias_pro+"</td>"+
                    "<td>"+data.uso+"</td>"+
                    "<td>"+data.FALTAS+"</td>"+
                    "<td>"+data.TARDANZAS+"</td>"+
                    "<td>"+data.permiso+"</td>"+
                    "<td>"+data.comision+"</td>"+
                    "<td>"+data.CITACION+"</td>"+
                    "<td>"+data.ESSALUD+"</td>"+
                    "<td>"+data.PERMISO+"</td>"+
                    "<td>"+data.COMPENSATORIO+"</td>"+
                    "<td>"+data.ONOMASTICO+"</td>";
                //'<td><span onclick="verAdicional('+con+')" style="cursor: pointer; margin-left: 4px;" class="glyphicon glyphicon-plus" aria-hidden="true"></span></td>';
        html+="</tr>";
    });

    
    $("#tb_ordenest").html(html);
    //$("#reporte").show();
    // --

  }else{
    $("#tb_ordenest").html('');
  }
};

</script>
