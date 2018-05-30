<script type="text/javascript">
$(document).ready(function() {

    $("[data-toggle='offcanvas']").click();

    $(".fecha").datetimepicker({
        format: "yyyy-mm-dd",
        language: 'es',
        showMeridian: false,
        time: false,
        minView: 3,
        startView: 2, // 1->hora, 2->dia , 3->mes
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

        /*if( $.trim($("#fecha_ini").val())!=='' &&
            $.trim($("#fecha_fin").val())!=='')
        {*/
            dataG = ''
            Reporte.MostrarReporte(dataG);
            Reporte.MostrarReportePapeleta(dataG);
        /*}
        else
        {
            swal("Mensaje", "Por favor ingrese las fechas de busqueda!");
        }*/
    });

    $("#btnbuscar").click(function (){

        if( $.trim($("#fecha_ini").val())!=='' &&
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.BuscarReporte(dataG);
            Reporte.BuscarReportePapeleta(dataG);
        }
        else
        {
            swal("Mensaje", "Por favor ingrese las fechas de busqueda!");
        }
    });

    $("#limpiar").click(function (){
        $('#form_reporte input').not('.checkbox').val('');
        
        $("#tb_ordenest").html('');
        $('#div_detalle').hide();
        $("#tb_deta").html(html);
    });

    $(document).on('click', '#btnexport', function(event) {
        if( $.trim($("#fecha_ini").val())!=='' &&
            $.trim($("#fecha_fin").val())!=='')
        {
            var fecha_ini = $("#fecha_ini").val();
            var fecha_fin = $("#fecha_fin").val();
            var area = $("#slct_area_ws").val();

            if(area != '0')
                area = '&area='+area;
            else
                area = '';

            swal({   
                    title: "Reporte de Personal",   
                    text: "Por favor espere mientras carga el Reporte...",   
                    timer: 5000,   
                    showConfirmButton: false 
            });
            //$(this).attr('href','reportepersonal/exportreportepersonal'+'?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+area);
            window.location = 'reportepersonal/exportreportepersonal'+'?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+area;

        }else{
            swal("Mensaje", "Por favor ingrese las fechas de busqueda!");
            event.preventDefault();
        }
    });
    
});

activarTabla=function(){
    //$("#t_detalles").dataTable(); // inicializo el datatable    
};


HTMLMostrarReporte=function(datos){    
    $('#t_ordenest').dataTable().fnDestroy();

    if(datos === 'not_data'){
        $("#tb_ordenest").html("");
        swal("Reporte", "Error en el proceso de carga, vuelva a ejecutar el Reporte!", "error");
        return false;
    }

    if(datos.length > 0){
        
        var html = '';
        var con = 0;
        $.each(datos,function(index,data){
            con++;
            html+="<tr style='font-size: 12px;'>"+
                    '<td width="">'+con+'</td>'+
                    "<td width=''>"+data.tipo+"</td>"+
                    "<td width=''>"+data.centro_costo+"</td>"+
                    "<td width=''>"+data.cargo+"</td>"+
                    "<td width=''>"+data.dni+"</td>"+
                    "<td width=''>"+data.nombres+"</td>"+
                    "<td width=''>"+data.apellidos+"</td>"+
                    "<td width=''>"+data.fecha+"</td>"+
                    "<td width=''>"+data.hora+"</td>"+
                    "<td width=''>"+data.nro_papeleta+"</td>"+
                    "<td width=''>"+data.anio_papeleta+"</td>"+
                    "<td width=''>"+data.operadorreg+"</td>"+
                    "<td width=''>"+data.nombrereg+"</td>"+
                    "<td width=''>"+data.fechareg+"</td>"+
                    "<td width=''>"+data.estacionreg+"</td>";
            html+="</tr>";
        });

        $("#tb_ordenest").html(html);
        $("#t_ordenest").dataTable();

        // --
    }else{
        $("#tb_ordenest").html("");
        //$("#tb_regimen").html("");
    }
};

HTMLMostrarReportePapeleta=function(datos){    
    $('#t_papeletas').dataTable().fnDestroy();

    if(datos === 'not_data'){
        $("#tb_papeletas").html("");
        swal("Reporte", "Error en el proceso de carga, vuelva a ejecutar el Reporte!", "error");
        return false;
    }

    if(datos.length > 0){
        
        var html = '';
        var con = 0;
        $.each(datos,function(index,data){
            con++;
            html+="<tr style='font-size: 12px;'>"+
                    '<td width="">'+con+'</td>'+
                    "<td width=''>"+data.nropapeleta+"</td>"+
                    "<td width=''>"+data.solicitante+"</td>"+
                    "<td width=''>"+data.motivo_modificacion+"</td>"+
                    "<td width=''>"+data.usuario+"</td>";
            html+="</tr>";
        });

        $("#tb_papeletas").html(html);
        $("#t_papeletas").dataTable();

        // --
    }else{
        $("#tb_ordenest").html("");
        //$("#tb_regimen").html("");
    }
};

</script>
