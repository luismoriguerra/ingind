<script type="text/javascript">
var plantilla_id, PlantillaObj;
var Plantillas={
    AgregarEditar:function(areas,event){
        $("#formNuevoDocDigital input[name='word']").remove();
        $("#formNuevoDocDigital").append("<input type='hidden' value='"+CKEDITOR.instances.plantillaWord.getData()+"' name='word'>");
        $("#txt_titulofinal").val($("#lblDocumento").text()+addZeros( $("#txt_titulo").val(),"6")+$("#lblArea").text());
        var datos=$("#formNuevoDocDigital").serialize().split("txt_").join("").split("slct_").join("");
        datos+="&areasselect="+JSON.stringify(areas);
        var accion="documentodig/crear";
        if(event == 1){
            var accion="documentodig/editar";
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
                    Plantillas.Cargar(HTMLCargar);
                    alertBootstrap('success', obj.msj, 10);
                    $("#NuevoDocDigital").modal('hide');
                }
                else if(obj.rst==3){
                    alertBootstrap('danger', obj.msj+' => '+obj.correlativo, 6);
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
            
    AgregarEditarTitulo:function(AE){
        $("#txt_titulofinal").val($("#lblDocumento").text()+addZeros($("#form_titulos_modal #txt_titulo").val(),"6")+$("#lblArea").text());
        var datos = $("#form_titulos_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "documentodig/editartitulo" : "documentodig/creartitulo";
        
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
                    MostrarAjax("docdigitales");
                    msjG.mensaje('success',obj.msj,4000);
                    $('#tituloModal .modal-footer [data-dismiss="modal"]').click();

                }
                if(obj.rst==2){
                    msjG.mensaje('warning',obj.msj,4000);

                } 
                else {
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
            
    AgregarEditarFecha:function(AE){
        var datos = $("#form_fechas_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "documentodig/editarfecha" : "documentodig/crearfecha";

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
                    Plantillas.Cargar(HTMLCargar);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#fechaModal .modal-footer [data-dismiss="modal"]').click();

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
    Cargar:function(evento,data = ''){
        $.ajax({
            url         : 'documentodig/cargar',
            type        : 'POST',
            cache       : false,
            data : data,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    evento(obj.datos);
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
    CargarAreas:function(){
        $.ajax({
            url         : 'area/areasgerencia',
            type        : 'POST',
            cache       : false,
         /*   data        : data,*/
            dataType    : 'json',
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
               /* $(".overlay,.loading-img").remove();*/
            },
            error: function(){
                /*$(".overlay,.loading-img").remove();*/
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    CargarCorrelativo:function(data,evento){
        $.ajax({
            url         : 'documentodig/correlativo',
            type        : 'POST',
            cache       : false,
            data        : data,
            dataType    : 'json',
            async       : false,
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
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    EliminarDocumento:function(data){
        $.ajax({
            url         : 'documentodig/cambiarestadodoc',
            type        : 'POST',
            cache       : false,
            data        : data,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    Plantillas.Cargar(HTMLCargar);
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
};
</script>
