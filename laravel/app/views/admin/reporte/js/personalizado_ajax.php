<script type="text/javascript">
var Personalizado={ 
    ReportePersonalizado:function( dataG){
        $.ajax({
            url         : 'reporte/personalizado',
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
    
    GraficoData:function( dataG){
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
                    var fecha=[];
                    $.each(obj.datos,function(index,data){
                        atendido.push(data.atendido);
                        fecha.push(data.fecha);
                        destiempo_a.push(data.destiempo_a);
                        destiempo_p.push(data.destiempo_p);
                        pendiente.push(data.pendiente);
                    });
                    if(typeof chart !== "undefined") {
                            chart.destroy();
                    }
                    var config = {
                            type: 'line',
                            data: {
                                    labels: fecha,
                                    datasets: [{
                                            label: 'Atendido',
                                            fill: false,
                                            backgroundColor: window.chartColors.blue,
                                            borderColor: window.chartColors.blue,
                                            data: atendido
                                    }, {
                                            label: 'Atendidos a Destiempo',
                                            fill: false,
                                            backgroundColor: window.chartColors.orange,
                                            borderColor: window.chartColors.orange,
                                            borderDash: [5, 5],
                                            data: destiempo_a
                                    }, {
                                            label: 'Pendiente',
                                            fill: false,
                                            backgroundColor: window.chartColors.red,
                                            borderColor: window.chartColors.red,
                                            data: pendiente,
                                    }, {
                                            label: 'Pendientes a Destiempo',
                                            fill: false,
                                            backgroundColor: window.chartColors.purple,
                                            borderColor: window.chartColors.purple,
                                            data: destiempo_p,
                                    }]
                            },
                            options: {
                                    responsive: true,
                                    title: {
                                            display: true,
                                            text: 'Chart.js Line Chart'
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
