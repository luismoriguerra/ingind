<script type="text/javascript">
var Tramite={
    mostrar:function( data,evento,turl ){
        var url='';
        if( turl=='p' ){
            url='reportef/tramiteproceso';
        }
        else if( turl=='t' ){
            url='reportef/tramite';
        }
        else if( turl=='d' ){
            url='reportef/tramitedetalle';
        }
        else if( turl=='tp' ){
            url='reportef/tramitependiente';
        }

        $.ajax({
            url         : url,
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
                    evento(obj.datos);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    }
};
</script>
