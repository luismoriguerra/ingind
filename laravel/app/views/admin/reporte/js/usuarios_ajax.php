<script type="text/javascript">
var Consulta, ConsultaDetalle, ConsultaDetalle2;
var Usuario={
    mostrar:function( data){
        $.ajax({
            url         : 'reporte/usuarios',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLreporte(obj.datos);
                    Consulta=obj;
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
    mostrarReporte2:function( data){
        $.ajax({
            url         : 'reporte/usuariosqr',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLreporte2(obj.datos);
                    //Consulta=obj;
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
    obtenerQRUser:function(rol_id, area_id, dni, tamano, tipo){
        $.ajax({
            url         : 'reporte/obtenerqr',
            type        : 'POST',
            cache       : false,
            async       : false,
            dataType    : 'json',
            data        : {rol_id: rol_id, area_id:area_id, dni: dni, tamano:tamano, tipo:tipo},
            success : function(obj) {
                //$('#uqr'+dni).html(obj.qr);
                window.img_qr = obj.qr;
            },
            error: function(){
                alert('error de QR usuario'+dni);
            }
        });
        return img_qr;
    },
    actualizarCodResolucion:function(persona_id, resolucion, cod_inspector){
        $.ajax({
            url         : 'persona/actualizarcodresolucion',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {id:persona_id, resolucion: resolucion, cod_inspector:cod_inspector},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    //MostrarAjax('proveedores');
                    msjG.mensaje('success',obj.msj,4000);
                } else {
                    alert('ERROR!');
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    }
};
</script>
