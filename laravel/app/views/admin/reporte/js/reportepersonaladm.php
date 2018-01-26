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

    // Carga las AREAS por default
    Reporte.MostrarAreas();
    // --

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


    // Fija las cabeceras de las tablas
        //goheadfixed('table.table_nv');
        /*
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
        
                //If the windows resize
                $(window).resize(goresize);
        
            }
        }

        function goresize() {
            $('.fix-head').css('width', $('.fix-inner table').outerWidth(true)+'px');
            $('.fix-head').css('height', $('.fix-inner table thead').outerHeight(true)+'px');
        }
        */
    // --

    
});

activarTabla=function(){
    //$("#t_detalles").dataTable(); // inicializo el datatable    
};

HTMLMostrarAreas=function(datos){    

    if(datos.length > 0){
        var html ='';

        html = '<select class="form-control" name="slct_area_ws" id="slct_area_ws">';
        html += "<option value='0'>.::::::: Seleccione una Opción del listado :::::::.</option>";
        $.each(datos,function(index,data){
                html+="<option value='"+data.id+"'>"+data.area+'</option>';
        });
        html += '</select>';

        $("#div_areas").html(html);
        // --
    }else{
        $("#div_areas").html("No existe Areas.");
    }
};


HTMLMostrarReporte=function(datos){    
    $('#t_ordenest').dataTable().fnDestroy();

    if(datos === 'not_data'){
        $("#tb_ordenest").html("");
        swal("Reporte", "Error en el proceso de carga, vuelva a ejecutar el Reporte!", "error");
        return false;
    }

    if(datos.length > 0){
        var html ='';
        var html1 ='';
        var con = 0;
        //regimen contador 
        var c_a_s=0;
        var terceros=0;
        var empleado_nombrado=0;
        var empleado_contratado=0;
        var funcionarios_cas=0;
        var obreros=0;
        var funcionarios=0;
        var c_a_s_reincorporados=0;
        var terceros_judiciales=0;
        $.each(datos,function(index,data){
            con++;

                if($.trim(data.cant_act) == '') var cant_act = 0;
                else  var cant_act = $.trim(data.cant_act);

                if($.trim(data.tareas) == '') var tareas = 0;
                else  var tareas = $.trim(data.tareas);

                if($.trim(data.total_tramites) == '') var total_tramites = 0;
                else  var total_tramites = $.trim(data.total_tramites);

                if($.trim(data.docu) == '') var docu = 0;
                else  var docu = $.trim(data.docu);
                
                html+="<tr style='font-size: 12px;'>"+
                        '<td width="3%">'+con+'</td>'+
                        '<td width="4%"><a href="'+data.foto+'" alt="'+data.nombres+'" target="_blank" ><img style="min-height: 300px !important; min-width: 300px !important;" src="'+data.foto+'" alt="'+data.nombres+'" class="img-rounded"></td>'+
                        "<td width='4%'>"+data.area+"</td>"+
                        "<td width='5%'>"+data.nombres+"</td>"+
                        "<td width='4%'>"+data.dni+"</td>"+
                        "<td width='5%'>"+data.cargo+"</td>"+
                        "<td width='4%'>"+data.regimen+"</td>"+
                        "<td width='3%'>"+data.faltas+"</td>"+
                        "<td width='4%'>"+data.tardanza+"</td>"+
                        "<td width='4%'>"+data.lic_sg+"</td>"+
                        "<td width='4%'>"+data.sancion_dici+"</td>"+
                        "<td width='4%'>"+data.lic_sindical+"</td>"+
                        "<td width='4%'>"+data.descanso_med+"</td>"+
                        "<td width='4%'>"+data.min_permiso+"</td>"+
                        "<td width='4%'>"+data.comision+"</td>"+
                        "<td width='4%'>"+data.citacion+"</td>"+
                        "<td width='4%'>"+data.essalud+"</td>"+
                        "<td width='4%'>"+data.permiso+"</td>"+
                        "<td width='4%'>"+data.compensatorio+"</td>"+
                        "<td width='4%'>"+data.onomastico+"</td>"+

                        "<td width='4%'>"+cant_act+"</td>"+
                        "<td width='4%'>"+tareas+"</td>"+
                        "<td width='4%'>"+total_tramites+"</td>"+
                        "<td width='4%'>"+docu+"</td>";
                html+="</tr>";
                
               if(data.regimen=='C.A.S.'){c_a_s++;} 
               if(data.regimen=='TERCEROS'){terceros++;} 
               if(data.regimen=='EMPLEADO NOMBRADO'){empleado_nombrado++;} 
               if(data.regimen=='EMPLEADO CONTRATADO'){empleado_contratado++;} 
               if(data.regimen=='FUNCIONARIOS CAS'){funcionarios_cas++;} 
               if(data.regimen=='OBREROS'){obreros++;} 
               if(data.regimen=='FUNCIONARIOS'){funcionarios++;} 
               if(data.regimen=='C.A.S. REINCORPORADOS'){c_a_s_reincorporados++;} 
               if(data.regimen=='TERCEROS JUDICIALES'){terceros_judiciales++;}

        });

        $("#tb_ordenest").html(html);
        $("#t_ordenest").dataTable();
        
       html1+="<tr>"+
                '<td>C.A.S.</td>'+
                "<td>"+c_a_s+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>TERCEROS</td>'+
                "<td>"+terceros+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>EMPLEADO NOMBRADO</td>'+
                "<td>"+empleado_nombrado+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>EMPLEADO CONTRATADO</td>'+
                "<td>"+empleado_contratado+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>FUNCIONARIOS CAS</td>'+
                "<td>"+funcionarios_cas+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>OBREROS</td>'+
                "<td>"+obreros+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>FUNCIONARIOS</td>'+
                "<td>"+funcionarios+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>C.A.S. REINCORPORADOS</td>'+
                "<td>"+c_a_s_reincorporados+"</td>";
       html1+="</tr>";
        html1+="<tr>"+
                '<td>TERCEROS JUDICIALES</td>'+
                "<td>"+terceros_judiciales+"</td>";
       html1+="</tr>";
       html1+="<tr>"+
                '<td><b>TOTAL:</b></td>'+
                "<td><b>"+datos.length+"</b></td>";
       html1+="</tr>";
       
       $("#tb_regimen").html(html1);
        // --
    }else{
        $("#tb_ordenest").html("");
        $("#tb_regimen").html("");
    }
};

</script>
