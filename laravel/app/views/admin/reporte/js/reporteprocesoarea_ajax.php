<script type="text/javascript">
var Reporte={

    MostrarAreas:function(){
        $.ajax({
            url         : 'reportepersonal/areasadm',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {}, 
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                //console.log(obj.area);
                HTMLMostrarAreas(obj.area);
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso de carga de AREAS, Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },


    MostrarReporte:function( dataG){

        $.ajax({
            url         : 'reporteprocesos/procesosarea',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                //console.log(obj.reporte);
                HTMLMostrarReporte(obj);
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
    export:function(dataG){
        $.ajax({
            url         : 'reportepersonal/exportreportepersonal',
            type        : 'GET',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                  /*  HTMLreporte(obj.datos);
                    Consulta=obj;*/
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
    }

};
</script>
