<script type="text/javascript">
var Pois={
    
    AgregarEditarPois:function(AE){
        var datos = $("#form_pois_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "poi/editar" : "poi/crear";

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
                    MostrarAjax('pois');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#poiModal .modal-footer [data-dismiss="modal"]').click();

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
    CargarPois:function(evento){
        $.ajax({
            url         : 'poi/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
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
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#costopersonalModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });
                }
                $("#tb_contrataciones").html(html); 
                evento();  
            },
            error: function(){
            }
        });
    },
    CargarCostoPersonal:function( data ){
        $.ajax({
            url         : 'poi/listarcostopersonal',
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
    CargarEstratPei:function( data ){
        $.ajax({
            url         : 'poi/listarestratpei',
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
    
    
    
    CambiarEstadoPois: function(id, AD){
        $("#form_costo_personal_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_costo_personal_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos = $("#form_costo_personal_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'poi/cambiarestado',
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
                     MostrarAjax('pois');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#costopersonalModal .modal-footer [data-dismiss="modal"]').click();
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
    AgregarEditarCostoPersonal:function(AE){
        var datos = $("#form_costo_personal_modal").serialize().split("txt_").join("").split("slct_").join("");
        var id=$("#form_costo_personal_modal #txt_poi_id").val();
        var accion = (AE==1) ? "poi/editarcostopersonal" : "poi/crearcostopersonal";
        
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
                    $("#form_costo_personal_modal input[type='hidden']").not("#form_costo_personal_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#costopersonalModal .modal-footer [data-dismiss="modal"]').click();

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
        $("#form_costo_personal_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_costo_personal_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var id=$("#form_costo_personal_modal #txt_poi_id").val();
        var datos = $("#form_costo_personal_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'poi/cambiarestadocostopersonal',
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
                     $("#form_costo_personal_modal input[type='hidden']").not("#form_costo_personal_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#costopersonalModal .modal-footer [data-dismiss="modal"]').click();
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
    AgregarEditarEstratPei:function(AE){
        var datos = $("#form_estrat_pei_modal").serialize().split("txt_").join("").split("slct_").join("");
        var id=$("#form_estrat_pei_modal #txt_poi_id").val();
        var accion = (AE==1) ? "poi/editarestratpei" : "poi/crearestratpei";
        
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
                    Pois.CargarEstratPei(data);
                    $("#form_estrat_pei_modal input[type='hidden']").not("#form_estrat_pei_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#estratpeiModal .modal-footer [data-dismiss="modal"]').click();

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
        $("#form_estrat_pei_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_estrat_pei_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var id=$("#form_estrat_pei_modal #txt_poi_id").val();
        var datos = $("#form_estrat_pei_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'poi/cambiarestadoestratpei',
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
                     $("#form_estrat_pei_modal input[type='hidden']").not("#form_estrat_pei_modal #txt_poi_id").remove();
                     msjG.mensaje('success',obj.msj,4000);
                     $('#estratpeiModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarActividad:function( data ){
        $.ajax({
            url         : 'poi/listaractividad',
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
                    actividadHTML(obj.datos);
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
    AgregarEditarActividad:function(AE){
        var datos = $("#form_actividad_modal").serialize().split("txt_").join("").split("slct_").join("");
        var id=$("#form_actividad_modal #txt_poi_id").val();
        var accion = (AE==1) ? "poi/editaractividad" : "poi/crearactividad";
        
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
                    Pois.CargarActividad(data);
                    $("#form_actividad_modal input[type='hidden']").not("#form_actividad_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#actividadModal .modal-footer [data-dismiss="modal"]').click();

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
    CambiarEstadoActividad: function(id, AD){
        $("#form_actividad_modal").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_actividad_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var id=$("#form_actividad_modal #txt_poi_id").val();
        var datos = $("#form_actividad_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'poi/cambiarestadoactividad',
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
                    Pois.CargarActividad(data);
                     $("#form_actividad_modal input[type='hidden']").not("#form_actividad_modal #txt_poi_id").remove();
                    msjG.mensaje('success',obj.msj,4000);
                    $('#actividadModal .modal-footer [data-dismiss="modal"]').click();
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
