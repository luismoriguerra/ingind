<script type="text/javascript">
var Consulta;
var Rutas={
    mostrar:function(flujo_id){
        $.ajax({
            url         : 'reporte/rutaxtramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {flujo_id:flujo_id},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLreporte(obj.datos);
                    Consulta=obj.datos;
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente. Si el problema persiste favor de comunicarse a ubicame@puedesencontrar.com</b>'+
                                '</div>');
            }
        });
    }
};
</script>