<script type="text/javascript">
var Indedocs={
    mostrar:function(){
        datos=$("#form_indedocs").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'indedocs/listadocumentosindedocs',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    mostrarHTML(obj.data);
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
    listar:function(){
        $.ajax({
            url         : 'indedocs/listatipodocumentosindedocs',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                    mostrarListaHTML(obj.data);
                }
            },
            error: function(){
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
