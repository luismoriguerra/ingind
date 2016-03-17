<script type="text/javascript">
var Bandeja={
    FechaActual:function(evento){
        $.ajax({
            url         : 'ruta/fechaactual',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
            beforeSend : function() {
            },
            success : function(obj) {
                $("#txt_respuesta").val(obj.fecha);
                $("#div_cumple>span").html("CUMPLIENDO TIEMPO");
                $("#txt_alerta").val("0");
                $("#txt_alerta_tipo").val("0");

                $("#div_cumple").removeClass("progress-bar-danger").removeClass("progress-bar-warning").addClass("progress-bar-success");
                    
                    if ( fechaAux!='' && fechaAux < $("#txt_respuesta").val() ) {
                        $("#txt_alerta").val("1");
                        $("#txt_alerta_tipo").val("2");
                        $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-warning").addClass("progress-bar-danger");
                        $("#div_cumple>span").html("NO CUMPLE TIEMPO ALERTA");
                    }
                    else if ( fechaAux!='' ) {
                        $("#txt_alerta").val("1");
                        $("#txt_alerta_tipo").val("3");
                        $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-danger").addClass("progress-bar-warning");
                        $("#div_cumple>span").html("ALERTA ACTIVADA");
                    }
                    else if ( $("#txt_fecha_max").val() < $("#txt_respuesta").val() ) {
                        $("#txt_alerta").val("1");
                        $("#txt_alerta_tipo").val("1");
                        $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-warning").addClass("progress-bar-danger");
                        $("#div_cumple>span").html("NO CUMPLE TIEMPO");
                    }
            },
            error: function(){
            }
        });
    },
    Mostrar:function( data ){
        $.ajax({
            url         : 'reporte/bandejatramite',
            type        : 'POST',
            contentType: false,
            processData: false,
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLreporte(obj.datos);
                    Consulta=obj;
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
    MostrarDetalle:function(data){
        $.ajax({
            //url         : 'reporte/bandejatramitedetalle',
            url         : 'ruta_detalle/cargardetalle',
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
                    HTMLreporteDetalle(obj.datos);
                    ConsultaDetalle=obj;
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
    CambiarEstado:function(ruta_detalle_id, id,AD){//si AD es 1, establecer como visto
        parametros = {estado:AD,ruta_detalle_id:ruta_detalle_id,id:id};
        $.ajax({
            url         : 'tramite/cambiarestado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : parametros,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    
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
    MostrarUsuarios:function(ruta_detalle_id){//si AD es 1, establecer como visto
        parametros = {ruta_detalle_id:ruta_detalle_id};
        $.ajax({
            url         : 'tramite/usuarios',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : parametros,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    //$('#t_reporte').dataTable().fnDestroy();
                    //Bandeja.Mostrar(activarTabla);
                    //mostrar el detalle
                    //var data ={ruta_detalle_id:ruta_detalle_id};
                    //Bandeja.MostrarDetalle(data);
                    //pintar usuarios en modal
                    var html='';
                    $.each(obj.datos,function(index,data){
                        html+="<tr>";
                        html+="<td>"+data.persona+"</td>";
                        html+="<td>"+data.fecha+"</td>";
                        html+="<td>"+data.estado+"</td>";
                        html+="</tr>";
                    });
                    $("#tb_usuarios").html(html);
                    $("#t_usuarios").dataTable();
                    $('#usuarios_vieron_tramite').modal('show');

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

    }
};
</script>
