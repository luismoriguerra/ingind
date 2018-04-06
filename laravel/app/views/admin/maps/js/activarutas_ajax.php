<script type="text/javascript">
var Reporte={
    MostrarReporte:function( dataG){

        $.ajax({
            url         : 'maps/rutasactivas',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            async        : false, // Mantiene la carga Ajax
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
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
    grabarRutaDetaMaps:function(datos){
        $.ajax({
            url         : 'maps/grabarrutadetamaps',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            async        : false,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    msjG.mensaje('success',obj.msj,4000);
                } else if(obj.rst==2){
                    msjG.mensaje('warning',obj.msj,4000);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    modificarRutaDetaMaps:function(datos){
        $.ajax({
            url         : 'maps/modificarrutadetamaps',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            async        : false,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    msjG.mensaje('success',obj.msj,4000);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    }

};
</script>
