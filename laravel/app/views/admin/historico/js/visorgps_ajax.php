<script type="text/javascript">
var Visorgps={
    AgregarEditarRol:function(AE){
        var datos=$("#form_bandeja").serialize().split("txt_").join("").split("slct_").join("");
        var accion="gestion_movimiento/crear";

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
                    $('#t_bandeja').dataTable().fnDestroy();

                    Bandeja.CargarBandeja(activarTabla);
                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');
                    $('#rolModal .modal-footer [data-dismiss="modal"]').click();
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
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    CargarBandeja:function(PG){
        var datos="";

        if(PG=="P"){
            datos=$("#form_Personalizado").serialize().split("txt_").join("").split("slct_").join("");
        }
        else{
            datos=$("#form_General").serialize().split("txt_").join("").split("slct_").join("");
        }

        $.ajax({
            url         : 'gestion/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){                    
                    HTMLCargarBandeja(obj.datos);
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
    ListarSlct:function(controlador){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {                
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                
                var html = "";
                
                if(obj.rst==1){                    
                    $.each(obj.datos, function (index, data){
                        /**
                         * Tablas relacionadas
                         */
                        var optValue = data.id;
                        
                        //Celula
                        if ( controlador === 'celula' )
                        {
                            optValue = data.relation + '_' + data.id;
                        }
                        
                        html += '<option value="'+optValue+'">' 
                            + data.nombre 
                            + '</option>';
                    });
                    
                    //Primera opcion por defecto
                    if ( controlador === 'empresa' )
                    {
                        $("#slct_" + controlador).prepend(
                            "<option value=\"\">-Seleccione-</option>"
                        );
                    }
                    if ( controlador === 'celula' )
                    {
                        $("#slct_" + controlador).prepend(
                            "<option value=\"\">-Seleccione-</option>"
                        );
                    }
                    
                    $("#slct_" + controlador).append(html);
                    $("#slct_" + controlador).multiselect('deselectAll', false);
                    $("#slct_" + controlador).multiselect('rebuild');
                    $("#slct_" + controlador).multiselect('refresh');
                }  
                //$(".overlay,.loading-img").remove();
            },
            error: function(){
                //$(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                        '<i class="fa fa-ban"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                    '</div>');
            }
        });
    },
    PanelCelulaTecnico:function(){
    
        bounds = new google.maps.LatLngBounds();        
    
        var data = $("form#form_visorgps").serialize().split("txt_").join("").split("slct_").join("");
    
        $.ajax({
            url         : 'visorgps/panelcelulatecnico',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                
                //Lista de tecnicos
                doTecList(obj.tecnicos, obj.icons);
                
                //Lista agendas tecnicos
                doTecAgenda(obj.data, obj.icons);
                
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
    DoPath:function(code, color){
        //Get coords by address                
        $.ajax({
            url     : "visorgps/codepath",
            type    : "POST",
            cache   : false,
            data    : "codePath=" + code + "&pdate=" + $("#fecha_estado").val(),
            dataType: 'json',
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            error: function(data) {
                $(".overlay,.loading-img").remove();
                $("#msj").html('<div class="alert alert-dismissable alert-danger">'+
                                    '<i class="fa fa-ban"></i>'+
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                    '<b><?php echo trans("greetings.mensaje_error"); ?></b>'+
                                '</div>');
            },
            success: function(data) {
                
                //Dibujar ruta del tecnico
                drawTecPath(data, code, color, objMap);
                
                $(".overlay,.loading-img").remove();
            }
        });
        return true;
    }
}
</script>