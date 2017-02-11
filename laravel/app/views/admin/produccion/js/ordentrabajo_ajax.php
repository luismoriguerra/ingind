<script type="text/javascript">
var Asignar={
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
                $("#txt_fecha_inicio").val(obj.fecha);
                $("#txt_fecha_inicio2").val(obj.fecha);
                $("#txt_fecha_inicio3").val(obj.fecha);
            },
            error: function(){
            }
        });
    },
    Relacion:function(evento){
        $.ajax({
            url         : 'tabla_relacion/relacionunico',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
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
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
    mostrarRutaFlujo:function(datos,evento){
        $.ajax({
            url         : 'tabla_relacion/rutaflujo',
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
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
    guardarRelacion:function(){
        var datos=$("#form_tabla_relacion").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'tabla_relacion/guardar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {                
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $('#asignarModal .modal-footer [data-dismiss="modal"]').click();
                    SeleccionRelacion(obj.id,obj.codigo);
                    Asignar.Relacion(RelacionHTML);
                }  
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
    guardarAsignacion:function(){
        $("#form_asignar #txt_ci").remove();
        $("#form_asignar").append('<input type="hidden" value="CI-" name="txt_ci" id="txt_ci">');
        var datos=$("#form_asignar").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        $.ajax({
            url         : 'ruta/crear',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#tb_ruta_flujo").html("");
                    $(".natural, .juridica, .area").css("display","none");
                    $("#form_asignar input[type='hidden'],#form_asignar input[type='text'],#form_asignar select,#form_asignar textarea").val("");
                    $('#form_asignar select').multiselect('refresh');  
                    hora();
                    msjG.mensaje('success',obj.msj,4000);
                }
                else{
                    alert(obj.msj);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
     guardarAsignacionGestion:function(){
        $("#form_asignarGestion #txt_ci").remove();
        $("#form_asignarGestion").append('<input type="hidden" value="CI-" name="txt_ci" id="txt_ci">');
        var datos=$("#form_asignarGestion").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");

        var checked = $('#chk_todasareas').iCheck('update')[0].checked;
        if(checked == true){
            var areasTodas = [];
            areasTodas.push(<?php  echo Auth::user()->area_id; ?>);
                    $("#areasTodas option").map(function(){return areasTodas.push($(this).val());});
            datos+="&areasTodas="+JSON.stringify(areasTodas);
        }else{
            var diasTiempo = $("input[name='txt_dias']").map(function(){return $(this).val();}).get();
            var select_area = $("[name='select_area']").map(function(){return $(this).val();}).get();
            datos+="&areasSelect="+JSON.stringify(select_area)+"&diasTiempo="+JSON.stringify(diasTiempo);
        }

        console.log(datos);
        $.ajax({
            url         : 'ruta/crearutagestion',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $("#tb_ruta_flujo").html("");
                    $(".natural, .juridica, .area").css("display","none");
                    $("#form_asignarGestion input[type='hidden'],#form_asignarGestion input[type='text'],#form_asignarGestion select,#form_asignarGestion textarea").val("");
                    $(".tablaSelecAreaTiempo").addClass('hidden');
                    $('#form_asignarGestion select').multiselect('refresh');  
                    hora();
                    msjG.mensaje('success',obj.msj,4000);
                }
                else{
                    alert(obj.msj);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
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
                    $(".ordenesT input[type='hidden'],.ordenesT input[type='numeric'],.ordenesT input[type='text'],.ordenesT select,.ordenesT textarea").val("");
                    $('.ordenesT select').multiselect('refresh');  
                    $(".filtros input[type='hidden'],.filtros input[type='text'],.filtros select,.filtros textarea").val("");
                    $('.filtros select').multiselect('refresh');  
                    msjG.mensaje('success','Registrado',4000);
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
    Plataforma:function(evento){
        $.ajax({
            url         : 'tabla_relacion/plataforma',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : {estado:1},
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
                    $.each(obj.msj, function(index, datos) {
                        $("#error_"+index).attr("data-original-title",datos);
                        $('#error_'+index).css('display','');
                    });
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
