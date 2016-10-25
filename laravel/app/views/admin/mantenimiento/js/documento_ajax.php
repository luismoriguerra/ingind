<script type="text/javascript">

var Documentos = {
    AgregarEditarDocumento:function(AE){
        var datos = $("#form_documentos_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "documento/editar" : "documento/crear";

        $.ajax({
            url         : accion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();
                if(obj.rst==1){
                    MostrarAjax('documentos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#documentoModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    var cont = 0;

                    $.each(obj.msj, function(index, datos){
                        cont++;
                         if(cont==1){
                            alert(datos[0]);
                       }

                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });

    },
    CambiarEstadoDocumentos: function(id, AD){
        $("#form_documentos_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_documentos_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_documentos_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'documento/cambiarestado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    MostrarAjax('documentos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#verboModal .modal-footer [data-dismiss="modal"]').click();
                } else {
                    $.each(obj.msj, function(index, datos) {
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
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
