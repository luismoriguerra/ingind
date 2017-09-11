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
    });

    
    $("#tb_ordenest").html(html);
    //$("#reporte").show();
    // --

  }else{
    $("#tb_ordenest").html('');
  }
};

</script>
