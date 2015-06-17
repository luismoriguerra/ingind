<script type="text/javascript">
var tiporespuesta, FlujoObj;
var Flujo_tr={
    AgregarEditarFlujo_tr:function(AE){
        var datos=$("#form_flujo_tr").serialize().split("txt_").join("").split("slct_").join("");
        var accion="flujotiporespuesta/crear";
        if(AE==1){
            accion="flujotiporespuesta/editar";
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
                    $('#t_flujo_tr').dataTable().fnDestroy();

                    Flujo_tr.CargarFlujo_tr(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#flujo_trModal .modal-footer [data-dismiss="modal"]').click();
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
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
    CargarFlujo_tr:function(evento){
        $.ajax({
            url         : 'flujotiporespuesta/cargar',
            type        : 'POST',
            cache       : false,
            data        : {usuario:1},
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarFlujo(obj.datos);
                    FlujoObj=obj.datos;
                }
                $(".overlay,.loading-img").remove();
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
    cargarFlujos:function(accion,flujo_id){
        $.ajax({
            url         : 'flujo/listar',
            type        : 'POST',
            cache       : false,
            data        : {usuario:1},
            dataType    : 'json',
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_flujo_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_flujo_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_flujo_id').append("<option selected style='display:none;'>--- Elige Flujo ---</option>");
                    else
                       $('#slct_flujo_id').val( flujo_id );
                } 
            }
        });
    },
    cargarTiempos:function(accion,tiempo_id){
        $.ajax({
            url         : 'tiempo/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data : {estado:1},
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_tiempo_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_tiempo_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_tiempo_id').append("<option selected style='display:none;'>--- Elige Tiempo ---</option>");
                    else
                       $('#slct_tiempo_id').val( tiempo_id );
                } 
            }
        });
    },
    cargarTipoRespuestas:function(accion,tipo_respuesta_id){
        $.ajax({
            url         : 'tiporespuesta/listar',
            type        : 'POST',
            cache       : false,
            data        : {estado:1},
            dataType    : 'json',
            success : function(obj) {
                if(obj.rst==1){
                    tiporespuesta = obj.datos;
                    $('#slct_tipo_respuesta_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_tipo_respuesta_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_tipo_respuesta_id').append("<option selected style='display:none;'>--- Elige Respuesta ---</option>");
                    else
                       $('#slct_tipo_respuesta_id').val( tipo_respuesta_id );
                    alternarFieldSetTiempo();
                } 
            }
        });
    },
    CambiarEstadoFlujo_tr:function(id,AD){
        $("#form_flujo_tr").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_flujo_tr").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_flujo_tr").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'flujotiporespuesta/cambiarestado',
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
                    $('#t_flujo_tr').dataTable().fnDestroy();
                    Flujo_tr.CargarFlujo_tr(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#flujo_trModal .modal-footer [data-dismiss="modal"]').click();
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
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
};
</script>
