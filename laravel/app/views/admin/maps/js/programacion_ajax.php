<script type="text/javascript">
var Reporte={
    MostrarReporte:function( dataG){

        $.ajax({
            url         : 'maps/rutasactivas',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : dataG,
            async        : false, // Mantiene la carga Ajax
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                HTMLMostrarReporte(obj);

            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso, Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
    modificarProgramacion:function(){
        var datos=$("#form_programacion_modal").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'maps/modificaprogramacion',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
//            async        : false,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    msjG.mensaje('success',obj.msj,4000);
                    $("#programacionModal").modal("hide");
                    $( "#generar" ).click();
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    modificarProgramacionmasivo:function(){
        var datos=$("#form_reporte").serialize().split("txt_").join("").split("slct_").join("");
        $.ajax({
            url         : 'maps/modificaprogramacionmasivo',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
//            async        : false,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    msjG.mensaje('success',obj.msj,4000);
                    $("#programacionModal").modal("hide");
                    $( "#generar" ).click();
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                alertBootstrap('danger', 'Ocurrio una interrupción en el proceso,Favor de intentar nuevamente', 6);
            }
        });
    },
    listarvehiculo:function(){
        $.ajax({
            async       : false,
            url         : 'maps/listavehiculo',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                    mostrarListaHTML(obj.data);
                }
            },
            error: function(){
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.'+
                                '</div>');
            }
        });
    },
    GetPersons:function(data,evento){
        $.ajax({
            url         : 'persona/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                    evento(obj.datos);
                    /*poblateData('persona',obj.datos[0]);*/
                }
            },
            error: function(){
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
        GetPersonabyId:function(data){
        $.ajax({
            url         : 'persona/getuserbyid',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                
                      poblateData('selectpersona',obj.datos[0]);   
                }
            },
            error: function(){
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },

};
</script>
