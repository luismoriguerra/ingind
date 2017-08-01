<script type="text/javascript">
var Data={
    AgregarEditar:function(AE, name_frmG, name_controllerG){ //AgregarEditarProveedor
        var datos = $("#form_"+name_frmG+"_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? name_controllerG+"/editar" : name_controllerG+"/crear";

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
                    MostrarAjax(name_frmG);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#'+name_controllerG+'Modal .modal-footer [data-dismiss="modal"]').click();

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
    CambiarEstado: function(id, AD, name_frmG, name_controllerG){ //CambiarEstadoProveedor
        $("#form_"+name_frmG+"_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_"+name_frmG+"_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_"+name_frmG+"_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : name_controllerG+'/cambiarestado',
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
                    MostrarAjax(name_frmG);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#'+name_controllerG+'Modal .modal-footer [data-dismiss="modal"]').click();
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
