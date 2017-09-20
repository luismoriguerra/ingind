<script type="text/javascript">
$(document).ready(function() {

    $("[data-toggle='offcanvas']").click();

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

        if( $.trim($("#fecha_ini").val())!=='' &&
            $.trim($("#fecha_fin").val())!=='')
        {
            dataG = $('#form_reporte').serialize().split("txt_").join("").split("slct_").join("");
            Reporte.MostrarReporte(dataG);
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

activarTabla=function(){
    //$("#t_detalles").dataTable(); // inicializo el datatable    
};

HTMLMostrarReporte=function(datos){    
    $('#t_ordenest').dataTable().fnDestroy();

    if(datos === 'not_data'){
        $("#tb_ordenest").html("");
        swal("Reporte", "Error en el proceso de carga!", "error");
        return false;
    }

    if(datos.length > 0){
        var html ='';
        var con = 0;

        $.each(datos,function(index,data){
            con++;
            if(con != 1)
            {
                html+="<tr style='font-size: 12px;'>"+
                        '<td width="3%">'+con+'</td>'+
                        '<td width="4%"><img src="'+data.foto+'" alt="'+data.nombres_completos+'" class="img-rounded"></td>'+
                        "<td width='4%'>"+data.AREA+"</td>"+
                        "<td width='5%'>"+data.nombres_completos+"</td>"+
                        "<td width='4%'>"+data.dni+"</td>"+
                        "<td width='5%'>"+data.cargo+"</td>"+
                        "<td width='4%'>"+data.condicion+"</td>"+
                        "<td width='3%'>"+data.FALTAS+"</td>"+
                        //"<td width='4%'>"+data.DIASFALTAS+"</td>"+
                        "<td width='4%'>"+data.TARDANZAS+"</td>"+
                        "<td width='4%'>"+data.SLSG+"</td>"+

                        //"<td width='4%'>"+data.DIASSLSG+"</td>"+
                        "<td width='4%'>"+data.Sancion_Dici+"</td>"+
                        //"<td width='4%'>"+data.DIAS_SDSG+"</td>"+
                        "<td width='4%'>"+data.Licencia_Sindical+"</td>"+
                        //"<td width='4%'>"+data.DIASLS+"</td>"+

                        "<td width='4%'>"+data.DESCANSO_MEDICO+"</td>"+
                        //"<td width='4%'>"+data.DIASDESCMED+"</td>"+
                        "<td width='4%'>"+data.MINPERMISO+"</td>"+
                        "<td width='4%'>"+data.comision+"</td>"+
                        "<td width='4%'>"+data.CITACION+"</td>"+
                        "<td width='4%'>"+data.ESSALUD+"</td>"+
                        "<td width='4%'>"+data.PERMISO+"</td>"+
                        "<td width='4%'>"+data.COMPENSATORIO+"</td>"+
                        "<td width='4%'>"+data.ONOMASTICO+"</td>";
                html+="</tr>";
            }
        });

        $("#tb_ordenest").html(html);
        $("#t_ordenest").dataTable();
        //$("#reporte").show();
        // --
    }else{
        $("#tb_ordenest").html("");
    }
};

</script>
