<script type="text/javascript">
var consulta;//, ConsultaDetalle, dataMorris=[];
var Tramite={
    mostrar:function(fecha){
        $.ajax({
            url         : 'reporte/tramitexfecha',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {fecha:fecha},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    //dataMorris=[];
                    HTMLreporte(obj.datos);
                    consulta=obj;
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
