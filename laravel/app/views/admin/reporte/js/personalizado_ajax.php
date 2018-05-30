<script type="text/javascript">
var Personalizado={ 
    ReportePersonalizado:function( dataG){
        $.ajax({
            url         : 'reporte/personalizado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG, //{fechames:fechames, ruta_flujo_id:id}, //dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){  
                    HTMLPersonalizado(obj.datos,dataG);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
    
    ReportePersonalizadoDetalle:function( dataG,conexionG){
        $.ajax({
            async       : false,
            url         : 'reporte/personalizadodetalle',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){   
                     html=HTMLPersonalizadoDetalle(obj.datos,conexionG);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });

        return html;
    },
    
    GraficoData:function( dataG,ResumenG){
        $.ajax({
            url         : 'reporte/graficodata',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){ 
                    var atendido = [];
                    var destiempo_a = [];
                    var destiempo_p = [];
                    var pendiente = [];
                    var finalizo = [];
                    var fecha=[];
                    var aux_i=1;
//                    var aniomes=dataG.fecha_ini.split("-");
                    // Solo los dias donde hay datos
                    $.each(obj.datos,function(index,data){
                            atendido.push(data.atendido);
                            destiempo_a.push(data.destiempo_a);
                            destiempo_p.push(data.destiempo_p);
                            pendiente.push(data.pendiente);
                            finalizo.push(data.finalizo);
                            fecha.push(data.fecha);
                    });
                    //--
                    //Dias del 1 al 31
//                    $.each(obj.datos,function(index,data){
//                        for(i=aux_i;i<data.dia;i++){
//                            atendido.push(0);
//                            destiempo_a.push(0);
//                            destiempo_p.push(0);
//                            pendiente.push(0);   
//                            finalizo.push(0);   
//                            fecha.push(i);
//                            aux_i=data.dia;
//                        }
//                            atendido.push(data.atendido);
//                            destiempo_a.push(data.destiempo_a);
//                            destiempo_p.push(data.destiempo_p);
//                            pendiente.push(data.pendiente);
//                            finalizo.push(data.finalizo); 
//                            fecha.push(data.fecha);
//                            aux_i++;
//                    });
//                    for(i=aux_i;i<=daysInMonth(aniomes[1],aniomes[0]);i++){
//                        atendido.push(0);
//                        destiempo_a.push(0);
//                        destiempo_p.push(0);
//                        pendiente.push(0); 
//                        finalizo.push(0);
//                        fecha.push(i);
//                    }
                    //--
                    if(typeof chart !== "undefined") {
                            chart.destroy();
                    }
                    var config = {
                            type: 'line',
                            data: {
                                    labels: fecha,
                                    datasets: [{
                                            label: 'Atendido ('+ResumenG.atendido+')',
                                            fill: false,
                                            backgroundColor: window.chartColors.blue,
                                            borderColor: window.chartColors.blue,
                                            borderDash: [5, 5],
                                            data: atendido
                                    }, {
                                            label: 'Atendidos a Destiempo ('+ResumenG.destiempo_a+')',
                                            fill: false,
                                            backgroundColor: window.chartColors.orange,
                                            borderColor: window.chartColors.orange,
                                            data: destiempo_a
                                    }, {
                                            label: 'Pendientes a Destiempo ('+ResumenG.destiempo_p+')',
                                            fill: true,
                                            backgroundColor: window.chartColors.purple,
                                            borderColor: window.chartColors.purple,
                                            data: destiempo_p,
                                    }, {
                                            label: 'Pendiente ('+ResumenG.pendiente+')',
                                            fill: true,
                                            borderDash: [5, 5],
                                            backgroundColor: window.chartColors.red,
                                            borderColor: window.chartColors.red,
                                            data: pendiente,
                                    }, {
                                            label: 'Finalizó ('+ResumenG.finalizo+')',
                                            fill: false,
                                            backgroundColor: window.chartColors.black,
                                            borderColor: window.chartColors.black,
                                            data: finalizo,
                                    }]
                            },
                            options: {
                                    responsive: true,
                                    title: {
                                            display: true,
                                            text: "Desde: "+dataG.fecha_ini+" - Hasta: "+dataG.fecha_fin,
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
                                                            labelString: 'Día'
                                                    }
                                            }],
                                            yAxes: [{
                                                    display: true,
                                                    scaleLabel: {
                                                            display: true,
                                                            labelString: '# Trámites'
                                                    }
                                            }]
                                    },
                                    animation: {
                                       duration:2000,
                                    }
                            }
                    };
                    var ctx = $("#myChart")[0].getContext('2d');
                    chart = new Chart(ctx, config);

                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },

};
</script>
