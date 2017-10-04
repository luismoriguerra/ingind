<script type="text/javascript">
var Asignar={
    FechaActual:function(evento){
        $.ajax({
            url         : 'ruta/fechaactual',
            type        : 'POST',
            cache       : false,
            async       : false,
            dataType    : 'json',
            data        : {estado:1},
            beforeSend : function() {
            },
            success : function(obj) {
                $("#txt_fecha_inicio").val(obj.fecha+' '+obj.hora);
                $("#txt_fecha_inicio2").val(obj.fecha+' '+obj.hora);
                $("#txt_fecha_inicio3").val(obj.fecha+' '+obj.hora);
                fechaTG=obj.fecha;
                horaTG=obj.hora;
                clearInterval(TiempoFinalTG);
                TiempoFinalTG='';
                evento();
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
                Asignar.FechaActual(hora);
                if(obj.rst==1){
                    $("#tb_ruta_flujo").html("");
                    $(".natural, .juridica, .area").css("display","none");
                    $("#form_asignar input[type='hidden'],#form_asignar input[type='text'],#form_asignar select,#form_asignar textarea").not('.mant').val("");
                    $('#form_asignar select').multiselect('refresh');  
                    $("#formNuevoDocDigital input[type='hidden'],#formNuevoDocDigital input[type='text'],#formNuevoDocDigital select,#form_asignar textarea").val("");
                        $("#msj").html('<div class="alert alert-dismissable alert-success">' +
                        '<i class="fa fa-ban"></i>' +
                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                        '<b>' + obj.msj + '</b>' +
                        '</div>');
                        $("#msj").effect('shake');
 //                       $("#msj").fadeOut(4000);
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
            areasTodas.push({'area_id':<?php  echo Auth::user()->area_id; ?>,'tiempo':$("#txt_tiempo").val(),'copia':0});
            $("#areasTodas option").map(function(){return areasTodas.push({'area_id':$(this).val(),'tiempo':$("#txt_tiempo").val(),'copia':0})});
            datos+="&areasTodas="+JSON.stringify(areasTodas);
        }else{
            var areasSingular = [];
            $("#tb_numareas tr").each(function(index, el) {
                var area = $(this).find('.select_area').val();
                var tiempo = $(this).find('.txt_dias').val();

                /*
                if($(this).find('.chk_copias').iCheck('update')[0].checked == true){
                    var copia = 1
                }else{
                    var copia = 0
                }
                */
                var copia = 0;
                areasSingular.push({'area_id':area,'tiempo':tiempo,'copia':copia});
            });
/*
            var diasTiempo = $("input[name='txt_dias']").map(function(){return $(this).val();}).get();
            var select_area = $("[name='select_area']").map(function(){return $(this).val();}).get();
            var copias = $("[name='chk_copias']").map(function(){return $(this).val();}).get();*/
/*            console.log(diasTiempo);
            console.log(select_area);
            console.log(copias);*/

            datos+="&areasSelect="+JSON.stringify(areasSingular);
        }

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
                Asignar.FechaActual(hora);
                if(obj.rst==1){
                    $("#tb_ruta_flujo").html("");
                    $(".natural, .juridica, .area").css("display","none");
                    $("#form_asignarGestion input[type='hidden'],#form_asignarGestion input[type='text'],#form_asignarGestion select,#form_asignarGestion textarea").not('.mant').val("");
                    $(".tablaSelecAreaTiempo").addClass('hidden');
                    $('#form_asignarGestion select').multiselect('rebuild');   
                    $("#msj").html('<div class="alert alert-dismissable alert-success">' +
                        '<i class="fa fa-ban"></i>' +
                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                        '<b>' + obj.msj + '</b>' +
                        '</div>');
                        $("#msj").effect('shake');
//                        $("#msj").fadeOut(tiempo);
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
}
</script>
