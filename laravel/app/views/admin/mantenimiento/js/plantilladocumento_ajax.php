<script type="text/javascript">
var plantilla_id, PlantillaObj;
var Plantillas={
    AgregarEditar:function(AE){
        $("#form_plantilla input[name='word']").remove();
        $("#form_plantilla").append("<input type='hidden' value='"+CKEDITOR.instances.plantillaWord.getData()+"' name='word'>");
        var datos=$("#form_plantilla").serialize().split("txt_").join("").split("slct_").join("");
        var accion="plantilladoc/crear";
        if(AE==1){
            accion="plantilladoc/editar";
        }
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
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    $('#t_plantilla').dataTable().fnDestroy();
                    Plantillas.Cargar(activarTabla);
                    alertBootstrap('success', obj.msj, 6);
                    $('#plantillaModal .modal-footer [data-dismiss="modal"]').click();
                }
                else{
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    Cargar:function(evento,data = ''){
        $.ajax({
            url         : 'plantilladoc/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data: data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargar(obj.datos);
                   /* PlantillaObj=obj.datos;*/
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    CargarDetalle:function(id){
        var datos = {
            id:id
        };
        $.ajax({
            url         : 'plantilla/cargardetalle',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    if (obj.datos == null) {
                        $('#word').val(obj.datos);
                    } else {
                        $('#word').val('');
                    }
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    CambiarEstado:function(id,AD){
       /* $("#form_plantilla").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_plantilla").append("<input type='hidden' value='"+AD+"' name='estado'>");*/
       /* var datos=$("#form_plantilla").serialize().split("txt_").join("").split("slct_").join("");*/
        var datos={'id':id,'estado':AD};
        $.ajax({
            url         : 'plantilladoc/cambiarestado',
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
                    $('#t_plantilla').dataTable().fnDestroy();
                    Plantillas.Cargar(activarTabla);
                   /* alertBootstrap('success', obj.msj, 6);
                    $('#plantillaModal .modal-footer [data-dismiss="modal"]').click();*/
                }
               /* else{
                    $.each(obj.msj,function(index,datos){
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
                }*/
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    Previsualizar:function(){
    },
    CargarInfo:function(data,evento){
        $.ajax({
            url         : 'plantilladoc/cargar',
            type        : 'POST',
            cache       : false,
            data        : data,
            dataType    : 'json',
            async       :false,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    evento(obj.datos);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
};
</script>
