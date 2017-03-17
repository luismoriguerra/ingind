<script type="text/javascript">
var Pois={
    AgregarEditarCostoPersonal:function(AE){
        var datos = $("#form_requisitos_modal").serialize().split("txt_").join("").split("slct_").join("");
        var id=$("#form_requisitos_modal #txt_poi_id").val();
        var accion = (AE==1) ? "clasificadortramite/editarrequisito" : "clasificadortramite/crearrequisito";
        
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
                    Pois.CargarCostoPersonal(data);
                    $("#form_requisitos_modal input[type='hidden']").not("#form_requisitos_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#requisitoModal .modal-footer [data-dismiss="modal"]').click();

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
    CambiarEstadoCostoPersonal: function(id, AD){
        $("#form_requisitos_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_requisitos_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var id=$("#form_requisitos_modal #txt_poi_id").val();
        var datos = $("#form_requisitos_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'clasificadortramite/cambiarestadorequisito',
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
                    Pois.CargarCostoPersonal(data);
                     $("#form_requisitos_modal input[type='hidden']").not("#form_requisitos_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#requisitoModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarCostoPersonal:function( data ){
        $.ajax({
            url         : 'clasificadortramite/listarrequisito',
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
                    costopersonalHTML(obj.datos);
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
    
    AgregarEditarEstratPei:function(AE){
        var datos = $("#form_tipotramites_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "tipotramite/editar" : "tipotramite/crear";
        
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
                    Pois.CargarEstratPei();
                    var datos={estado:1};slctGlobal.listarSlct('tipotramite','slct_tipo_tramite','simple',null,datos);
                    msjG.mensaje('success',obj.msj,4000);
                    $('#tipotramiteModal .modal-footer [data-dismiss="modal"]').click();

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
    CambiarEstadoEstratPei: function(id, AD){
        $("#form_tipotramites_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_tipotramites_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var id=$("#form_tipotramites_modal #txt_poi_id").val();
        var datos = $("#form_tipotramites_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'tipotramite/cambiarestado',
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
                     Pois.CargarEstratPei(data);
                     var datos={estado:1};slctGlobal.listarSlct('tipotramite','slct_tipo_tramite','simple',null,datos);
                     $("#form_tipotramites_modal input[type='hidden']").not("#form_estrat_pei_modal #txt_poi_id").remove();
                     msjG.mensaje('success',obj.msj,4000);
                     $('#tipotramiteModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarEstratPei:function(  ){
        $.ajax({
            url         : 'tipotramite/listartipotramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    estratpeiHTML(obj.datos);
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
    agregarProceso:function(){

        var datos=$("#form_actividad").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'clasificadortramite/agregarproceso',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#tb_ruta_flujo").html("");
                    $("#form_actividad input[type='hidden'],#form_actividad input[type='text'],#form_actividad select,#form_actividad textarea").not('.mant').val("");
                    MostrarAjax('clasificadortramites');
                        $("#msj").html('<div class="alert alert-dismissable alert-success">' +
                        '<i class="fa fa-ban"></i>' +
                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                        '<b>' + obj.msj + '</b>' +
                        '</div>');
                        $("#msj").effect('shake');
 //                       $("#msj").fadeOut(4000);
                }
                else{
                    alert(obj.msj);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
};
</script>
