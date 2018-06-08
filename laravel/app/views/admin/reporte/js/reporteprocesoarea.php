<script type="text/javascript">
window.chartColors = {


    aqua:'rgb(64, 253, 251)',
    ligthred: 'rgb(237, 93, 100)',
    orange: 'rgb(255, 71, 15)',
    green: 'rgb(2, 273, 21)',
    blue: 'rgb(21, 2, 237)',
    ligthblue: 'rgb(75, 192, 192)',
    gray: 'rgb(78, 93, 100)',
    gold: 'rgb(239, 193, 30)',
    red: 'rgb(209, 4, 4)',
    purple: 'rgb(253, 0, 221)',
    marron:'rgb(137, 132, 88)',
    darkred:'rgb(113, 4, 4)',
    darkgreen: 'rgb(35, 119, 30)',
    yellow: 'rgb(245, 242, 4)'
    
};

var months = [0,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

var ActColor = Math.floor(Math.random()*(14+1));
var globalDatasets = [];
var usingDatasets = [];

var configChart = {
        type: 'line',
        data: {
            labels: [],
            datasets: [{}]
        },
        options: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    fontColor: 'black',
                    defaultFontSize:14,

                }
            },
            responsive: true,
            title: {
                display: true,
                text: 'Comparacion grafica de los procesos por areas'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Estadistica '
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad'
                    }
                }]
            }
        }
    };

        

$(document).ready(function() {
    

    $(".fechaMes").datetimepicker({
        format: "yyyy/mm",
        language: 'es',
        showMeridian: false,
        time: false,
        minView: 3,
        maxView: 3,
        startView: 3, // 1->hora, 2->dia , 3->mes
        autoclose: true,
        todayBtn: false
    });
    slctGlobal.listarSlct('area','slct_area_id','multiple',null,{estado:1,areagestionf:1});

    // Carga las AREAS por default
    Reporte.MostrarAreas();
    // --

    $('#div_detalle').hide();

    $('#spn_fecha0').click(function(){
        $('#fecha0').focus();
    });
    $('#spn_fecha1').click(function(){
        $('#fecha1').focus();
    });

    $("#generar").click(function (){

        if( $.trim($("#fecha0").val())!=='' &&
            $.trim($("#fecha1").val())!=='')
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
        
        $("#tb_produccion").html('');
        $('#div_detalle').hide();
        $("#tb_deta").html(html);
    });

    $(document).on('click', '#btnexport', function(event) {
        if( $.trim($("#fecha0").val())!=='' &&
            $.trim($("#fecha1").val())!=='')
        {
            var fecha0 = $("#fecha0").val();
            var fecha1 = $("#fecha1").val();
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
            //$(this).attr('href','reportepersonal/exportreportepersonal'+'?fecha0='+fecha0+'&fecha1='+fecha1+area);
            window.location = 'reportepersonal/exportreportepersonal'+'?fecha0='+fecha0+'&fecha1='+fecha1+area;

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


makeHeader = function(data){

    var hdr = "";
    hdr = hdr + "<tr>";
    
    
    var keys = Object.keys(data);
    console.log(data);
    configChart.data.labels=[];
    for (var i = 0; i < keys.length; i++){
        var auxName = "";

        if(keys[i] == "nombre"){
            auxName = "Nombre area";
            hdr = hdr + "<th>"+auxName+"</th>";
        }else if(keys[i]=='a' || keys[i]=='Total'){
        
        }else{
            var ym = keys[i].split("_");
            configChart.data.labels.push(months[ym[1]]+' '+ym[0]);
            auxName = months[ym[1]]+' <small>'+ym[0]+'</small>';
            hdr = hdr + "<th>"+auxName+"</th>";
        }
        
    }

    hdr = hdr + "<th>Total</th></tr>";

    return hdr ;
}

HTMLMostrarReporte=function(response){
var datos = response.datos;    

    if(datos === 'not_data'){
        $("#tb_produccion").html("");
        swal("Reporte", "Error en el proceso de carga, vuelva a ejecutar el Reporte!", "error");
        return false;
    }

    
    if(datos.length > 0){
        var aux = datos;
        $("#tt_produccion").html(makeHeader(datos[0]));
        

        var html = "";
        var totalColumn = [];
        var totalGlobal = 0;
        for (var i = 0; i < datos.length; i++) {

            var totalAux = datos[i].Total;
            html = html + "<tr id=\"ce_"+ datos[i].a+"\" onClick=\"cargarElemento('"+ datos[i].a+"','"+ datos[i].nombre+"');\">";
            var auxA = datos[i].a;
            delete datos[i].a;
            delete datos[i].Total;
            var keys = Object.keys(datos[i]);
            
            var newObj = [];

            for (var jx = 0; jx < keys.length; jx++){
                if(jx != 0 && jx !=keys.length){

                    newObj.push(datos[i][keys[jx]]);
                    
                    if(totalColumn[jx-1] !== void 0){
                        totalColumn[jx-1]=totalColumn[jx-1]+datos[i][keys[jx]];
                    }
                    else{
                        totalColumn[jx-1]=datos[i][keys[jx]];
                    }
                   
                }

                html = html + "<td "+ (datos[i][keys[jx]] == 0 ? 'style="background-color:#fe4e4e"':'') +">"+datos[i][keys[jx]]+"</td>";


            }


            globalDatasets[auxA] = newObj;

            html = html + "<td style=\"background-color:#7bf7ae\">"+totalAux+"</td>";
            html = html + "</tr>";

            totalGlobal = totalGlobal + totalAux;
        }


        html = html + "<tr><th>Totales</th>";
        for (var i = 0; i < totalColumn.length; i++) {
            html = html + "<th>"+totalColumn[i]+"</th>";
        }

            html = html + "<th style=\"background-color:#7bf7ae\">"+totalGlobal+"</th>";
            html = html + "</tr>";
         


        configChart.data.datasets=[{
            label: 'TOTAL GENERAL',
            //backgroundColor: 'rgba(102,102,102,0.65);',
            borderColor: 'rgba(25, 25, 25)',           
        }];
        usingDatasets = [];
        configChart.data.datasets[0].label="TOTAL GENERAL";

        configChart.data.datasets[0].data=totalColumn;

        


        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, configChart);


        $("#tb_produccion").html(html);
    
    }else{
        $("#tb_produccion").html("");
        $("#tb_regimen").html("");
    }
};


var colorNames = Object.keys(window.chartColors);


function fixIndex(idD){
            //console.log(usingDatasets);
        usingDatasets.forEach(function(currentValue, index) {
           // console.log("IDD:"+idD+" CV:"+currentValue+ "  I:" +index);
            if(usingDatasets[idD] < currentValue){usingDatasets[index] = usingDatasets[index]-1;}
        });

        usingDatasets[idD] = 0;

        return usingDatasets;
}

function cargarElemento(idD,nombreArea){

    console.log( configChart.data.datasets);


    if(usingDatasets[idD]*1 > 0){
        console.log("tryRemove:"+(usingDatasets[idD]));
        $("#ce_"+idD).attr("style","background-color:none;");
        configChart.data.datasets.splice(usingDatasets[idD], 1);
        window.myLine.update();
        usingDatasets = fixIndex(idD);
        
        return true;
    }

    var colorName = colorNames[ActColor++ % colorNames.length];
    var newColor = window.chartColors[colorName];


    var newDataset = {
        label: nombreArea,
        backgroundColor: newColor,
        borderColor: newColor,
        data: globalDatasets[idD],
        fill: false
    };

    $("#ce_"+idD).attr("style","background-color:"+newColor.replace(")", ",0.5)").replace("rgb", "rgba")+";");
    configChart.data.datasets[configChart.data.datasets.length]=newDataset;

    console.log(configChart.data.datasets.length);

    usingDatasets[idD]=configChart.data.datasets.length-1;

    window.myLine.update();

}



</script>
