<script type="text/javascript">
var Celulas={
    AgregarEditarCelula:function(AE, quiebres_selec){
        $("#form_celulas").append("<input type='hidden' value='"+quiebres_selec+"' name='quiebres_selec'>");
        var datos=$("#form_celulas").serialize().split("txt_").join("").split("slct_").join("");
        var accion="celula/crear";
        if(AE==1){
            accion="celula/editar";
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
                    $('#t_celulas').dataTable().fnDestroy();

                    Celulas.CargarCelulas(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#celulaModal .modal-footer [data-dismiss="modal"]').click();
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
                                        '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente. Si el problema persiste favor de comunicarse a ubicame@puedesencontrar.com</b>'+
                                    '</div>');
            }
        });
    },
    CargarCelulas:function(evento){
        $.ajax({
            url         : 'celula/cargar',
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
                            "<td id='responsable_"+data.id+"'>"+data.responsable+"</td>"+
                            "<td id='empresa_id_"+data.id+"' empresa_id='"+data.empresa_id+"'>"+data.empresa+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#celulaModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });                    
                }      
                $("#tb_celulas").html(html); 
                evento();  
            },
            error: function(){
            }
        });
    },
    cargarEmpresas:function(accion,empresa_id){
        $.ajax({
            url         : 'empresa/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            success : function(obj) {
                if(obj.rst==1){
                    $('#slct_empresa_id').html('');
                    $.each(obj.datos,function(index,data){
                        $('#slct_empresa_id').append('<option value='+data.id+'>'+data.nombre+'</option>');
                    });
                    if (accion==='nuevo')
                        $('#slct_empresa_id').append('<option selected>--- Elige Empresa ---</option>');
                    else
                       $('#slct_empresa_id').val( empresa_id );
                } 
            }
        });
    },
    CambiarEstadoCelulas:function(id,AD){
        $("#form_celulas").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_celulas").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_celulas").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'celula/cambiarestado',
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
                    $('#t_celulas').dataTable().fnDestroy();
                    Celulas.CargarCelulas(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#celulaModal .modal-footer [data-dismiss="modal"]').click();
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
                                        '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente. Si el problema persiste favor de comunicarse a ubicame@puedesencontrar.com</b>'+
                                    '</div>');
            }
        });
    },
    CargarQuiebres:function(accion, celula_id){
        if (accion==='editar') {
            url='quiebre/listarcelula';
        } else { //nuevo
            url='quiebre/listar';
        }

        $.ajax({
            url         : url,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {'celula_id':celula_id},
            success : function(obj) {
                if(obj.rst==1){
                    HTMLListarSlct(obj,accion);
                }
            }
        });
    }
};
</script>