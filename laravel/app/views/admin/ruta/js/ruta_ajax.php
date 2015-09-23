<script type="text/javascript">
var Ruta={
    CrearRuta:function(evento,vista){
        //var datos=$("#form_ruta").serialize().split("txt_").join("").split("slct_").join("");
        /*var areasG=[]; // texto area
        var areasGId=[]; // id area
        var theadArea=[]; // cabecera area
        var tbodyArea=[]; // cuerpo area
        var tfootArea=[]; // pie area

        var tiempoGId=[]; // id posicion del modal en base a una area.
        var tiempoG=[];
        var verboG=[];
        var posicionDetalleVerboG=0;*/
        var accion="ruta_flujo/crear";
        datos=  {
                estadoG:estadoG.join("*"),
                areasG:areasG.join("*"), 
                areasGId:areasGId.join("*"),
                theadArea:theadArea.join("*"),
                tfootArea:tfootArea.join("*"),
                tbodyArea:tbodyArea.join("*"),

                tiempoGId:tiempoGId.join("*"),
                tiempoG:tiempoG.join("*"),
                verboG:verboG.join("*"),
                modificaG:"*"+modificaG.join("*")+"*",
                flujo_id:$("#slct_flujo_id").val(),
                area_id:$("#slct_area_id").val(),
                ruta_flujo_id: $("#txt_ruta_flujo_id_modal").val(),
                tipo_ruta: $("#slct_tipo_ruta").val(),
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
                    $("#txt_ruta_flujo_id_modal").remove();
                    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+obj.ruta_flujo_id+'">');
                    $("#txt_titulo").text("Act. Ruta");
                    $("#texto_fecha_creacion").text("Fecha Actualización:");
                    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
                    //$("#slct_tipo_ruta").attr("disabled","true");

                    if(vista!=null){
                        Ruta.CargarRuta(evento,vista);
                    }
                    else{
                        Ruta.CargarRuta(evento);
                    }
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#rolModal .modal-footer [data-dismiss="modal"]').click();
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    CargarRuta:function(evento,vista){
        var datos={};

        if(vista!=null && vista==1){
            datos={vista:1,tipo_flujo:BandejaTramite};
        }
        else if(vista==3){
            datos={estado:1,tipo_flujo:BandejaTramite};
        }
        else{
            datos={tipo_flujo:BandejaTramite};
        }

        $.ajax({
            url         : 'ruta_flujo/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){                    
                    evento(obj.datos);
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    CargarDetalleRuta:function(id,permiso,evento){

        $.ajax({
            url         : 'ruta_flujo/cdetalle',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {ruta_flujo_id:id},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){                    
                    evento(permiso,obj.datos);
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    ActivarRutaFlujo:function(id,evento){

        $.ajax({
            url         : 'ruta_flujo/activar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {ruta_flujo_id:id},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    Close();
                    Ruta.CargarRuta(evento);
                } 
                else if(obj.rst==2){
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    ActualizarRutaFlujo:function(id,estado,evento){

        $.ajax({
            url         : 'ruta_flujo/actualizar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {ruta_flujo_id:id,estado:estado},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    Ruta.CargarRuta(evento);
                } 
                else if(obj.rst==2){
                    $("#msj").html('<div class="alert alert-dismissable alert-info">'+
                                        '<i class="fa fa-info"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    ValidaProceso:function(id,valor,evento){
        $.ajax({
            url         : 'ruta_flujo/validar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {id:id},
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.datos.length>0){
                    evento(0,valor);
                }
                else{ 
                    evento(1,valor);
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
}
</script>
