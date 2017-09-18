<script type="text/javascript">
$(document).ready(function() {

    $(".fecha").datetimepicker({
        format: "yyyy/mm/dd",
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

        if( $.trim($("#fecha_ini").val())!=='' ||
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.MostrarReporte(dataG);
        }
        else
        {
            swal("Mensaje", "Por favor ingrese al menos una busqueda!");
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


    // Fija las cabeceras de las tablas
    //goheadfixed('table.table_nv');

    function goheadfixed(classtable) {
    
        if($(classtable).length) {
    
            $(classtable).wrap('<div class="fix-inner"></div>'); 
            $('.fix-inner').wrap('<div class="fix-outer" style="position:relative; margin:auto;"></div>');
            $('.fix-outer').append('<div class="fix-head"></div>');
            $('.fix-head').prepend($('.fix-inner').html());
            $('.fix-head table').find('caption').remove();
            $('.fix-head table').css('width','100%');
    
            //$('.fix-outer').css('width', $('.fix-inner table').outerWidth(true)+'px');
            $('.fix-head').css('width', $('.fix-inner table').outerWidth(true)+'px');
            $('.fix-head').css('height', $('.fix-inner table thead').height()+'px');
    
            // If exists caption, calculte his height for then remove of total
            var hcaption = 0;
            if($('.fix-inner table caption').length != 0)
                hcaption = parseInt($('.fix-inner table').find('caption').height()+'px');

            // Table's Top
            var hinner = parseInt( $('.fix-inner').offset().top );

            // Let's remember that <caption> is the beginning of a <table>, it mean that his top of the caption is the top of the table
            $('.fix-head').css({'position':'absolute', 'overflow':'hidden', 'top': hcaption+'px', 'left':0, 'z-index':100 });
        
            $(window).scroll(function () {
                var vscroll = $(window).scrollTop();

                if(vscroll >= hinner + hcaption)
                    $('.fix-head').css('top',(vscroll-hinner)+'px');
                else
                    $('.fix-head').css('top', hcaption+'px');
            });
    
            /*  If the windows resize   */
            $(window).resize(goresize);
    
        }
    }

    function goresize() {
        $('.fix-head').css('width', $('.fix-inner table').outerWidth(true)+'px');
        $('.fix-head').css('height', $('.fix-inner table thead').outerHeight(true)+'px');
    }
    // --

    
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
                '<td>'+con+'</td>'+
                '<td><img src="'+data.foto+'" alt="'+data.nombres_completos+'" class="img-rounded"></td>'+
                "<td>"+data.AREA+"</td>"+
                "<td>"+data.nombres_completos+"</td>"+
                "<td>"+data.dni+"</td>"+
                "<td>"+data.cargo+"</td>"+
                "<td>"+data.condicion+"</td>"+
                "<td>"+data.FALTAS+"</td>"+
                "<td>"+data.DIASFALTAS+"</td>"+
                "<td>"+data.TARDANZAS+"</td>"+
                "<td>"+data.SLSG+"</td>"+

                "<td>"+data.DIASSLSG+"</td>"+
                "<td>"+data.Sancion_Dici+"</td>"+
                "<td>"+data.DIAS_SDSG+"</td>"+
                "<td>"+data.Licencia_Sindical+"</td>"+
                "<td>"+data.DIASLS+"</td>"+

                "<td>"+data.DESCANSO_MEDICO+"</td>"+
                "<td>"+data.DIASDESCMED+"</td>"+
                "<td>"+data.MINPERMISO+"</td>"+
                "<td>"+data.comision+"</td>"+
                "<td>"+data.CITACION+"</td>"+
                "<td>"+data.ESSALUD+"</td>"+
                "<td>"+data.PERMISO+"</td>"+
                "<td>"+data.COMPENSATORIO+"</td>"+
                "<td>"+data.ONOMASTICO+"</td>";
        html+="</tr>";
    });

    
    $("#tb_ordenest").html(html);
    //$("#t_ordenest").dataTable(); 
    //$("#reporte").show();
    // --

  }else{
    $("#tb_ordenest").html("<tr style='font-size: 13px;'><td colspan='25'>No se encontraron datos!</td></tr>");
  }
};

</script>
