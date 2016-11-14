<script type="text/javascript">
var area_id, AreaObj;
var Areas={
   AgregarEditarArea:function(AE){
        //var formData = new FormData($("#form_areas")[0]); 
        //$("#form_areas input[name='h_imagenp']").remove();
        //$("#form_areas").append("<input type='hidden' value='"+$("#imagenp")[0]+"' name='h_imagenp'>");

        var datos=$("#form_areas_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion="area/crear";
        if(AE==1){
            accion="area/editar";
            $('#form_imagen_').ajaxForm(options).submit();
            $('#form_imagenp').ajaxForm(options).submit();
            $('#form_imagenc').ajaxForm(options).submit();
        }
        var options = { 
            beforeSubmit:   beforeSubmit(),
            success:        success(),
            dataType: 'json' 
        };
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
                    if(AE==0){//subir imagenes despues de crear el area
                        var area_id=obj.area_id

                        $('#upload_id').val(area_id);
                        $('#upload_idc').val(area_id);
                        $('#upload_idp').val(area_id);
                        $('#form_imagen_').ajaxForm(options).submit();
                        $('#form_imagenc').ajaxForm(options).submit();
                        $('#form_imagenp').ajaxForm(options).submit();
                    }
                   $(".overlay, .loading-img").remove();
                if(obj.rst==1){
                    MostrarAjax('areas');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#areaModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    var cont = 0;

                    $.each(obj.msj, function(index, datos){
                        cont++;
                         if(cont==1){
                            alert(datos[0]);
                       }

                    });
                }

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
    CargarAreas:function(evento){
        $.ajax({
            url         : 'area/cargar',
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
                            "<td id='nombre_"+data.id+"'>"+data.nemonico+"</td>"+
                            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
                            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#verboModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

                        html+="</tr>";
                    });
                }
                $("#tb_areas").html(html); 
                evento();  
            },
            error: function(){
              
            }
        });
    },
    CambiarEstadoAreas:function(id,AD){
        $("#form_areas").append("<input type='hidden' value='"+id+"' name='id'>");
        $("#form_areas").append("<input type='hidden' value='"+AD+"' name='estado'>");
        var datos=$("#form_areas").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'area/cambiarestado',
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
                    MostrarAjax('areas');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#areaModal .modal-footer [data-dismiss="modal"]').click();
                } else {
                    $.each(obj.msj, function(index, datos) {
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
