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

window.chartColorsTransparents = {


    aqua:'rgba(64, 253, 251,0.65)',
    ligthred: 'rgba(237, 93, 100,0.65)',
    orange: 'rgba(255, 71, 15,0.65)',
    green: 'rgba(2, 273, 21,0.65)',
    blue: 'rgba(21, 2, 237,0.65)',
    ligthblue: 'rgba(75, 192, 192,0.65)',
    gray: 'rgba(78, 93, 100,0.65)',
    gold: 'rgba(239, 193, 30,0.65)',
    red: 'rgba(209, 4, 4,0.65)',
    purple: 'rgba(253, 0, 221,0.65)',
    marron:'rgba(137, 132, 88,0.65)',
    darkred:'rgba(113, 4, 4,0.65)',
    darkgreen: 'rgba(35, 119, 30,0.65)',
    yellow: 'rgba(245, 242, 4,0.65)'
    
};


var months = [0,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

var ActColor = Math.floor(Math.random()*(14+1));
var globalDatasets = [];
var usingDatasets = [];

var usingDatasetsEtapa2 = [];

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

        
var configChartPendientes = {
        type: 'line',
        data: {
            labels: [],
            datasets: [{}]
        },
        options: {
            legend: {
                labels:false
            },
            responsive: true,
            title: {
                display: true,
                text: 'Grafico de tramites Pendientes'
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


var configChartFinalizadas = {
        type: 'line',
        data: {
            labels: [],
            datasets: [{}]
        },
        options: {
            legend: {
                labels: false,
            },
            responsive: true,
            title: {
                display: true,
                text: 'Grafico de tramites Finalizados'
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
    configChart.data.labels=[];
    configChartFinalizadas.data.labels=[];
    configChartPendientes.data.labels=[];
    for (var i = 0; i < keys.length; i++){
        var auxName = "";

        if(keys[i] == "nombre"){
            auxName = "Nombre area";
            hdr = hdr + "<th>"+auxName+"</th>";
        }else if(keys[i]=='a' || keys[i]=='Total'){
        
        }else{
            var ym = keys[i].split("_");
            configChart.data.labels.push(months[ym[1]]+' '+ym[0]);
            configChartFinalizadas.data.labels.push(months[ym[1]]+' '+ym[0]);
            configChartPendientes.data.labels.push(months[ym[1]]+' '+ym[0]);
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

            var totalAux = 0;
            html = html + "<tr title=\" TOTAL ( PENDIENTES / FINALIZADAS ) \" id=\"ce_"+ datos[i].a+"\" onClick=\"cargarElemento('"+ datos[i].a+"','"+ datos[i].nombre+"');\">";
            var auxA = datos[i].a;
            delete datos[i].a;
            var keys = Object.keys(datos[i]);
            var newObj = [];
            var totalC = 0;
            for (var jx = 0; jx < keys.length; jx++){
                var fieldText = "";
                if(jx != 0 && jx != keys.length){
                    var tData = datos[i][keys[jx]].split("=");

                    totalC = parseInt(tData[0]);
                    p0f1C = tData[1].split("|");

                    var arrPendientes = p0f1C[0].split("/");
                    var arrFinalizadas = p0f1C[1].split("/");

                    var auxPendientes = {asignadas:parseInt(arrPendientes[0]),involucradas:parseInt(arrPendientes[1])};
                    var auxfinalizadas = {asignadas:parseInt(arrFinalizadas[0]),involucradas:parseInt(arrFinalizadas[1])};

                    var fieldObj={total:totalC ,pendientes:auxPendientes,finalizadas:auxfinalizadas}

                    newObj.push(fieldObj);
                    
                    if(totalColumn[jx-1] !== void 0){
                        totalColumn[jx-1]=totalColumn[jx-1]+totalC;
                    }else{
                        totalColumn[jx-1]=totalC;
                    }
            
                totalAux = totalAux+totalC;

                fieldText = totalAux;

                fieldText = "<span style=\"color:green;\">"+fieldObj.total+"</span> <small>( "+(fieldObj.pendientes.asignadas+fieldObj.pendientes.involucradas)+" / "+(fieldObj.finalizadas.asignadas+fieldObj.finalizadas.involucradas)+" )</small>";
                
                }else{
                    fieldText = datos[i][keys[0]];
                }


                html = html + "<td "+ ((jx != 0 && fieldObj.total == 0) ? 'style="background-color:#fe4e4e"':'') +">"+fieldText+"</td>";

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
        usingDatasetsEtapa2 = [];

        configChart.data.datasets[0].label="TOTAL GENERAL";
        configChart.data.datasets[0].data=totalColumn;


        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, configChart);



        configChartPendientes.data.datasets=[{
            label: 'Total Pendientes',
            //backgroundColor: 'rgba(102,102,102,0.65);',
            borderColor: 'rgba(25, 25, 25)',           
        }];

        var ctx2 = document.getElementById('canvas2').getContext('2d');
        window.myLine2 = new Chart(ctx2, configChartPendientes);
        

        configChartFinalizadas.data.datasets=[{
            label: 'Total Finalizados',
            //backgroundColor: 'rgba(102,102,102,0.65);',
            borderColor: 'rgba(25, 25, 25)',           
        }];

        configChartFinalizadas.options.legend.display = false;
        configChartPendientes.options.legend.display = false;

        var ctx3 = document.getElementById('canvas3').getContext('2d');
        window.myLine3 = new Chart(ctx3, configChartFinalizadas);



    $("#tb_produccion").html(html);
    
    }else{
        $("#tb_produccion").html("");
        $("#tb_regimen").html("");
    }
};


var colorNames = Object.keys(window.chartColors);
var colorNamesTransparents = Object.keys(window.chartColorsTransparents);

makeTableEtapa1 = function(){

    var mTable = "";
    var udKeys=Object.keys(usingDatasets);
    for (var i = 0; i < udKeys.length; i++){
        if(usingDatasets[udKeys[i]]>0){
            var tAreaName = $("#ce_"+udKeys[i]).find("td:eq(0)").text();
            mTable = mTable + "<tr class=\"etapa2TR\" id=\"e2_"+udKeys[i]+"\" onclick=\"loadEtapa2("+udKeys[i]+");\"><td>"+tAreaName+"</td></tr>";
        }
    }
    $("#body_etapa1").html(mTable);
}


var tempColor;

function loadEtapa2(idE2){

    var tAreaName = $("#ce_"+idE2).find("td:eq(0)").text();

    configChartPendientes.data.datasets=[{
        label: 'Total Pendientes',
        //backgroundColor: 'rgba(102,102,102,0.65);',
        borderColor: 'rgba(25, 25, 25)',           
    }];

    configChartFinalizadas.data.datasets=[{
        label: 'Total Finalizados',
        //backgroundColor: 'rgba(102,102,102,0.65);',
        borderColor: 'rgba(25, 25, 25)',           
    }];

    var nextColor=ActColor++ % colorNames.length;
    tempColor = nextColor;


    var colorName = colorNames[tempColor];
    var newColor = window.chartColors[colorName];
    var newColorTransparent = window.chartColorsTransparents[colorName];

    var mData0P = [];
    var mData0F = [];

    var mData0PInv = [];
    var mData0PAsg = [];

    var mData0FInv = [];
    var mData0FAsg = [];
    

    var auxDataset =  globalDatasets[idE2];
    delete auxDataset.total;

    for (var i = 0; i < auxDataset.length; i++) {
            
            mData0P.push(auxDataset[i].pendientes.asignadas+auxDataset[i].pendientes.involucradas);
            mData0PInv.push(auxDataset[i].pendientes.involucradas);
            mData0PAsg.push(auxDataset[i].pendientes.asignadas);
            
            mData0F.push(auxDataset[i].finalizadas.asignadas+auxDataset[i].finalizadas.involucradas);
            mData0FInv.push(auxDataset[i].finalizadas.involucradas);
            mData0FAsg.push(auxDataset[i].finalizadas.asignadas);
            
    }



    $(".etapa2TR").attr("style","background-color:none;");
    $("#e2_"+idE2).attr("style","background-color:"+newColorTransparent+";");


    configChartPendientes.data.datasets[configChartPendientes.data.datasets.length]={
        label: "Pendientes: " + tAreaName,
        backgroundColor: 'rgb(0,0,0)',
        borderColor: newColor,
        data: mData0P,
        fill: false
    };

    configChartPendientes.data.datasets[configChartPendientes.data.datasets.length]={
        label: "Involucradas",
        backgroundColor: chartColors.orange,
        borderColor: newColorTransparent,
        data: mData0PInv,
        fill: false
    };

    configChartPendientes.data.datasets[configChartPendientes.data.datasets.length]={
        label: "Asignadas",
        backgroundColor: chartColors.green,
        borderColor: newColorTransparent,
        data: mData0PAsg,
        fill: false
    };


    configChartFinalizadas.data.datasets[configChartFinalizadas.data.datasets.length]={
        label: "Finalizadas:"+tAreaName,
        backgroundColor: 'rgb(0,0,0)',
        borderColor: newColor,
        data: mData0F,
        fill: false
    };

    configChartFinalizadas.data.datasets[configChartFinalizadas.data.datasets.length]={
        label: "Involucradas",
        backgroundColor: chartColors.orange,
        borderColor: newColorTransparent,
        data: mData0FInv,
        fill: false
    };

    configChartFinalizadas.data.datasets[configChartFinalizadas.data.datasets.length]={
        label: "Asignadas",
        backgroundColor: chartColors.green,
        borderColor:newColor,
        data: mData0FAsg,
        fill: false
    };

    usingDatasetsEtapa2[idE2]=configChartPendientes.data.datasets.length-1;

    window.myLine2.update();
    window.myLine3.update();
    //makeTableEtapa1();


   // $("#e2_"+idE2).attr("style","background-color:red;");



}

function fixIndex(idD,mode){

        if(mode == 0){
            var x = "usingDatasets";
        }else if(mode == 1){
            var x = "usingDatasetsEtapa2";
        }

        eval(x).forEach(function(currentValue, index) {
            if(eval(x)[idD] < currentValue){eval(x)[index] = eval(x)[index]-1;}
        });
        eval(x)[idD] = 0;
        return eval(x);

}

function cargarElemento(idD,nombreArea){

    if(usingDatasets[idD]*1 > 0){
        $("#ce_"+idD).attr("style","background-color:none;");
        configChart.data.datasets.splice(usingDatasets[idD], 1);
        window.myLine.update();
        usingDatasets = fixIndex(idD,0);
        makeTableEtapa1();
        return true;
    }

    var nextColor=ActColor++ % colorNames.length;

    var colorName = colorNames[nextColor];
    var newColor = window.chartColors[colorName];
    var newColorTransparent = window.chartColorsTransparents[colorName];
    var mData0 = [];
    
    for (var i = 0; i < globalDatasets[idD].length; i++) {

        mData0.push(globalDatasets[idD][i].total);
    }

    $("#ce_"+idD).attr("style","background-color:"+newColorTransparent+";");


    configChart.data.datasets[configChart.data.datasets.length]={
        label: nombreArea,
        backgroundColor: newColor,
        borderColor: newColor,
        data: mData0,
        fill: false
    };

    usingDatasets[idD]=configChart.data.datasets.length-1;

    window.myLine.update();
    makeTableEtapa1();

}



</script>
