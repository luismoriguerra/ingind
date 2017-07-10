<script type="text/javascript">
var Asignar={
    guardarOrdenTrabajo:function(data){
        $.ajax({
            url         : 'ruta/actividadpersonalcreate',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {
                            'info' : data
                          },
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                     var dataG = [];
                    dataG = {fecha:'<?php echo date("Y-m-d") ?>'};
                    Asignar.CargarOrdenTrabajoDia(dataG);  
                    $(".ordenesT input[type='hidden'],.ordenesT input[type='numeric'],.ordenesT input[type='text'],.ordenesT select,.ordenesT textarea").not(".mant").val("");
                    $('.ordenesT select').multiselect('refresh');  
                    $(".filtros input[type='hidden'],.filtros input[type='text'],.filtros select,.filtros textarea").val("");
                    $('.filtros select').multiselect('refresh');
                    $(".valido input[id='txt_cantidad']").val("0");
                    $( ".valido .btnDelete" ).click();
                    $(".valido .table tbody tr:visible").remove();
                    msjG.mensaje('success','Registrado Correctamente',4000);
                    if(obj.registro != ''){
                        msjG.mensaje('danger','Fechas no registradas: '+obj.registro,40000);                        
                    }  
                    $(".overlay,.loading-img").remove();
                }
                else{
                    alert('Fallo');
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },

        CargarOrdenTrabajoDia:function( dataG){
        $.ajax({
            url         : 'ruta/ordentrabajodia',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){  
                    HTMLcargarordentrabajodia(obj.datos);
                    
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
    
    EditarActividad: function(dataG,pos){
//        $("#form_rols_modal").append("<input type='hidden' value='"+id+"' name='id'>");
//        $("#form_rols_modal").append("<input type='hidden' value='"+AD+"' name='estado'>");
//        var datos = $("#form_rols_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'ruta/editaractividad',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay, .loading-img").remove();

                if (obj.rst==1) {
                    var dataG = [];
                    dataG = {fecha:'<?php echo date("Y-m-d") ?>'};
                    Asignar.CargarOrdenTrabajoDia(dataG);  
                    msjG.mensaje('warning',obj.msj+' de la fila '+pos,4000);

                } else {
                    msjG.mensaje('danger','No Actualizado',40000);
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    }
}
</script>
