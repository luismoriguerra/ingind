<script type="text/javascript">
var Tipos={
    AgregarEditarTipo:function(AE){
        var datos = $("#form_tipos_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "poitipo/editar" : "poitipo/crear";

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
                    MostrarAjax('tipos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#tipoModal .modal-footer [data-dismiss="modal"]').click();

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
    CargarTipos:function(evento){
        $.ajax({
            url         : 'poitipo/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                
            },
            success : function(obj) {
                var html="";
                var estadohtml="";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
                        if(data.estado==1){
                            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
                        }

                        html+="<tr>"+
                            "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tipoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });
                }
                $("#tb_tipos").html(html); 
                evento();  
            },
            error: function(){
            }
        });
    },
      CambiarEstadoTipos: function(id, AD){
        $("#form_tipos_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_tipos_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_tipos_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'poitipo/cambiarestado',
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
                    MostrarAjax('tipos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#tipoModal .modal-footer [data-dismiss="modal"]').click();
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
    },
    
    CargarSubtipos:function( data ){
        $.ajax({
            url         : 'poisubtipo/cargar',
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
                    subtipoHTML(obj.datos);
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
    AgregarEditarSubtipo:function(AE){
        var datos = $("#form_subtipos_modal").serialize().split("txt_").join("").split("slct_").join("");
        var id=$("#form_subtipos_modal #txt_tipo").val();
        var accion = (AE==1) ? "poisubtipo/editar" : "poisubtipo/crear";
        
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
                    data={id:id};
                    Tipos.CargarSubtipos(data);
                    $("#form_subtipos_modal input[type='hidden']").not("#form_subtipos_modal #txt_tipo_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#subtipoModal .modal-footer [data-dismiss="modal"]').click();

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
    CambiarEstadoSubTipo: function(id, AD){
        $("#form_subtipos_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_subtipos_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var id=$("#form_subtipos_modal #txt_tipo").val();
        var datos = $("#form_subtipos_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'poisubtipo/cambiarestado',
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
                    data={id:id};
                    Tipos.CargarSubtipos(data);
                     $("#form_subtipos_modal input[type='hidden']").not("#form_subtipos_modal #txt_tipo_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#subtipoModal .modal-footer [data-dismiss="modal"]').click();
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
    },
};
</script>
