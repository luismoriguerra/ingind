<script type="text/javascript">
var Proceso={

    CuadroProceso:function( dataG){
        $.ajax({
            url         : 'reporte/cuadroproceso',
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
                    HTMLCProceso(obj.datos,obj.cabecera,obj.sino);
                    
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
    
    MostrarActividades:function( dataG,envio_actividad,exonera){
        $.ajax({
            url         : 'reporte/cargaractividad',
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
                    HTMLCargaActividades(obj.datos,envio_actividad,exonera);
                    
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
    MostrarTramiteActividad:function(dataG){
        $.ajax({
            url         : 'reporte/reportetramiteactividad',
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
                    $("#div_tactividad_previo").hide();
                    HTMLCargaTramiteActividad(obj.datos,obj.cabecera);
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
//    CalcularTotalesXNumeroOrden:function(id, fechames, tramite){
//        $.ajax({
//            url         : 'reporte/calculartotalesxnumeroorden',
//            type        : 'POST',
//            cache       : false,
//            dataType    : 'json',
//            data        : { ruta_flujo_id:id, fechames:fechames, tramite:tramite },
//            beforeSend : function() {
//                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
//            },
//            success : function(obj) {
//                $(".overlay,.loading-img").remove();
//                if(obj.rst==1){
//                    HTMLCargaTotalesXNumeroOrden(obj.datos);
//                }
//            },
//            error: function(){
//                $(".overlay,.loading-img").remove();
//                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
//                                    '<i class="fa fa-ban"></i>'+
//                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
//                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
//                                '</div>');
//            }
//        });
//    },
    /*
    verArchivosDesmontesMotorizado:function(id){
        $.ajax({
            url         : 'reporte/verarchivosdesmontesmotorizado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : { ruta_id:ruta_id },
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLVerArchivosDesmontesMotorizado(obj.datos);
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
    */
//    CalcularTotalActividad:function(id, fechames, tramite){
//        $.ajax({
//            url         : 'reporte/calculartotalactividad',
//            type        : 'POST',
//            cache       : false,
//            dataType    : 'json',
//            data        : { ruta_flujo_id:id, fechames:fechames, tramite:tramite },
//            beforeSend : function() {
//                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
//            },
//            success : function(obj) {
//                $(".overlay,.loading-img").remove();
//                if(obj.rst==1){
//                    HTMLCargaTotalActividad(obj.datos,obj.cabecera);
//                }
//            },
//            error: function(){
//                $(".overlay,.loading-img").remove();
//                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
//                                    '<i class="fa fa-ban"></i>'+
//                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
//                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
//                                '</div>');
//            }
//        });
//    },
    MostrarTramites:function( dataG){
        $.ajax({
            url         : 'reporte/reportetramite',
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
                    HTMLCargaTramites(obj.datos);
                    
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
        
    DetalleCuadroProceso:function( dataG){
        $.ajax({
            url         : 'reporte/detallecuadroproceso',
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
                    HTMLCargaDetalleCuadroProceso(obj.datos);
                    
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
    /*
    exportRepTramite:function(dataG){
        $.ajax({
            url         : 'reportegastos/exportreportetramite',
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
    */
};
</script>
