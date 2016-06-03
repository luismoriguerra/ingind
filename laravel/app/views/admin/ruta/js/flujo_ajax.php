<script type="text/javascript">
var Flujos={
    AgregarEditarFlujo:function(AE){
        var datos=$("#form_flujos").serialize().split("txt_").join("").split("slct_").join("");
        var accion="flujo/crear";
        if(AE==1){
            accion="flujo/editar";
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
                    $('#t_flujos').dataTable().fnDestroy();

                    Flujos.CargarFlujos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#flujoModal .modal-footer [data-dismiss="modal"]').click();
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
    CargarFlujos:function(evento){
        $.ajax({
            url         : 'flujo/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {usuario:2},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
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
                            "<td id='area_"+data.id+"' data-area='"+data.area_id+"'>"+data.area+"</td>"+
                            "<td id='tipo_"+data.id+"' data-tipo='"+data.tipo_flujo_id+"'>"+data.tipo_flujo+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#flujoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });                    
                }      
                $("#tb_flujos").html(html); 
                evento();  
            },
            error: function(){
                $(".overlay,.loading-img").remove();
            }
        });
    },
    ListarAreas:function(area){
        $.ajax({
            url         : 'ruta_detalle/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {usuario:2},
            beforeSend : function() {
                
            },
            success : function(obj) {
                var html="<option value=''> Seleccione </option>";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        html+='<option value="'+data.id+'">'+data.nombre+'</option>';
                    });
                }
                 $("#"+area).html(html); 
            },
            error: function(){
            }
        });
    },
    CambiarEstadoFlujos:function(id,AD){
        $("#form_flujos").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_flujos").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_flujos").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'flujo/cambiarestado',
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
                    $('#t_flujos').dataTable().fnDestroy();
                    Flujos.CargarFlujos(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#flujoModal .modal-footer [data-dismiss="modal"]').click();
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
    }
};
</script>
