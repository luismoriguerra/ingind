<script type="text/javascript">

var LlamadaAtencionObj;

$(document).ready(function() {

    LlamadaAtencion.CargarNumeroMaximo();
    $('body').find('#editar_numeromaximo').attr('onClick','Editar();');

});

Editar = function(){
    if(validaNumeroMaximo()){
        LlamadaAtencion.EditarNumeroMaximo();
    }
};
HTMLCargarDatos = function(datos){
    var nro_max = datos[0] || 0;

    if(typeof nro_max == 'object')
        nro_max = nro_max.nro_max

    $("#txt_numeromaximo").val(nro_max);

};
validaNumeroMaximo = function(){
    $('#form_cargos [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","numeromaximo","");
    var rpta=true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};
valida = function(inicial,id,v_default){
    var texto="Seleccione";
    if(inicial=="txt"){
        texto="Ingrese";
    }

    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }
};

var LlamadaAtencion = {
    EditarNumeroMaximo:function(){

        var datos = $("#form_numeromaximo").serialize().split("txt_").join("").split("slct_").join("");
        var accion = "llamadaatencion/editar";

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
                $(".overlay, .loading-img").remove();
                if(obj.rst==1){

                    LlamadaAtencion.CargarNumeroMaximo();

                    $("#msj").html('<div class="alert alert-dismissable alert-success">'+
                                        '<i class="fa fa-check"></i>'+
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                        '<b>'+obj.msj+'</b>'+
                                    '</div>');

                } else {
                    $.each(obj.msj, function(index, datos){
                        $("#error_"+index).attr("data-original-title", datos);
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
    CargarNumeroMaximo: function(evento){
        $.ajax({
            url         : 'llamadaatencion/cargar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    HTMLCargarDatos(obj.datos);
                    LlamadaAtencionObj = obj.datos;
                }
                $(".overlay, .loading-img").remove();
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
