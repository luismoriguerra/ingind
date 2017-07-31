<script type="text/javascript">
//var Consulta, ConsultaDetalle, ConsultaDetalle2;
var Reporte={
    MostrarReporte:function( dataG){

        $.ajax({
            url         : 'reportegastos/reportedetallegastos',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                //console.debug(obj);
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){  
                    HTMLMostrarReporte(obj.datos);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso, Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
    MostrarReporteDetalle:function( dataG){

        $.ajax({
            url         : 'reportegastos/reportedetallegastostotales',
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
                    HTMLMostrarReporteDetalle(obj.datos);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso, Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    }

};
</script>
