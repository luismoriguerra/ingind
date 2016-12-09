<script type="text/javascript">

var documento_id, DocumentoObj;

var Documento={
    AgregarEditar:function(AE){
        $("#form_documento input[name='word']").remove();
        $("#form_documento").append("<input type='hidden' value='"+CKEDITOR.instances.plantillaWord.getData()+"' name='word'>");
        var datos=$("#form_documento").serialize().split("txt_").join("").split("slct_").join("");

        var accion = (AE==1)? "documentoword/editar": "documentoword/crear";

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
                    Documento.Cargar(activarTabla);
                    alertBootstrap('success', obj.msj, 6);
                    $('#documentoModal .modal-footer [data-dismiss="modal"]').click();
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
    Cargar:function(evento){
        $.ajax({
            url         : 'documentoword/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargar(obj.datos);
                    DocumentoObj=obj.datos;
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
        $("#form_documento").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_documento").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_documento").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'plantilla/cambiarestado',
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
                    Documento.Cargar(activarTabla);
                    alertBootstrap('success', obj.msj, 6);
                    $('#documentoModal .modal-footer [data-dismiss="modal"]').click();
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
    Previsualizar:function(){
    },
    GetEncargadoAreaDelUsuarioLogeado:function(){
        $.ajax({
            url         : 'documentoword/encargado-area-del-usuario-logeado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();

                if (obj.rst==1) {
                    $('#gerencia_de').text( obj.datos.area );
                    $('#encargado_de').text( [obj.datos.nombre, obj.datos.paterno, obj.datos.materno].join(' ') );
                    $('#txt_area_de').val(obj.datos.area_id);
                    $('#txt_encargado_area_de').val(obj.datos.id);
                } else {
                    // $.each(obj.msj,function(index,datos){
                    //     $("#error_"+index).attr("data-original-title",datos);
                    //     $('#error_'+index).css('display','');
                    // });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    GetPlantilla:function(plantilla_id){

        $.ajax({
            url         : 'plantilla/plantilla',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {id: plantilla_id},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();

                if (obj.rst==1) {

                    $('#txt_titulo').closest('.row').show();
                    $('#plantillaWord').closest('.row').show();
                    $('#divCebecera').hide();
                    $('#txt_cabecera').val(0);

                    if (obj.datos[0].cabecera) {
                        $('#divCebecera').show();
                        $('#txt_cabecera').val(1);
                    }

                    $('#txt_titulo').val(obj.datos[0].titulo);
                    $('#txt_correlativo').val(obj.correlativo);
                    CKEDITOR.instances.plantillaWord.setData( obj.datos[0].cuerpo );

                } else {
                    // $.each(obj.msj,function(index,datos){
                    //     $("#error_"+index).attr("data-original-title",datos);
                    //     $('#error_'+index).css('display','');
                    // });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });

    },
};
</script>
