<script type="text/javascript">
var Detalles={
    AgregarEditarDetalles:function(AE){
        var datos=$("#form_detalles").serialize().split("txt_").join("").split("slct_").join("");
        var accion="tiporespuestadetalle/crear";
        if(AE==1){
            accion="tiporespuestadetalle/editar";
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
                    $('#t_detalles').dataTable().fnDestroy();

                    Detalles.CargarDetalles(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#detalleModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarDetalles:function(evento){
        $.ajax({
            url         : 'tiporespuestadetalle/listar',
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
                            "<td id='tiporespuesta_id_"+data.id+"' tiporespuesta_id='"+data.tiporespuesta_id+"'>"+data.tiporespuesta+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detalleModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });                    
                }      
                $("#tb_detalles").html(html); 
                evento();  
            },
            error: function(){
            }
        });
    },
    cargarTipoRespuesta:function(accion,tiporespuesta_id){
        $.ajax({
            url         : 'tiporespuesta/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_tiporespuesta_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_tiporespuesta_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_tiporespuesta_id').append("<option selected style='display:none;'>--- Elige Respuesta ---</option>");
                    else
                       $('#slct_tiporespuesta_id').val( tiporespuesta_id );
                } 
            }
        });
    },
    CambiarEstadoDetalles:function(id,AD){
        $("#form_detalles").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_detalles").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_detalles").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'tiporespuestadetalle/cambiarestado',
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
                    $('#t_detalles').dataTable().fnDestroy();
                    Detalles.CargarDetalles(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#detalleModal .modal-footer [data-dismiss="modal"]').click();
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
