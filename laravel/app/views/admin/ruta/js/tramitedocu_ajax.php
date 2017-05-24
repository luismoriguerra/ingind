<script type="text/javascript">
var Bandeja={
    MostrarPreTramites:function(data,evento){
        $.ajax({
            url         : 'pretramite/listarpretramites',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    DetallePreTramite:function(data){
        $.ajax({
            url         : 'pretramite/anexosbytramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    /*evento(obj.data);           */         
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GetTipoSolicitante:function(data,evento){
        $.ajax({
            url         : 'tiposolicitante/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    getEmpresasByPersona:function(data,evento){
        $.ajax({
            url         : 'pretramite/empresasbypersona',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    getClasificadoresTramite:function(data,evento){
        $.ajax({
            url         : 'pretramite/clasificadorestramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    getRequisitosbyclatramite:function(data,evento,tramite){
        $.ajax({
            url         : 'pretramite/requisitosbyctramite',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
              /*  $("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
                /*$(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos,tramite);                    
                }
            },
            error: function(){
            /*    $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GuardarPreTramite:function(data){
        var datos = {'info':data};
        $.ajax({
            url         : 'pretramite/create',
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
                    $('#FormCrearPreTramite').find('input[type="text"],input[type="email"],textarea,select').val('');
                    msjG.mensaje("success","Registrado",3000); 
                    $('.usuarioSeleccionado').addClass('hidden');
                    $('.empresa').addClass('hidden');
                    $('#cbo_tiposolicitante,#cbo_tipotramite,#cbo_tipodoc,#cbo_persona,#cbo_empresa,#cbo_tipodocumento').multiselect('refresh');
                    $('.persona,.emp').addClass('hidden');         
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GetPreTramitebyid:function(data,evento){
        $.ajax({
            url         : 'pretramite/getbyid',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                /*$("body").append('<div class="overlay"></div><div class="loading-img"></div>');*/
            },
            success : function(obj) {
               /* $(".overlay,.loading-img").remove();*/
                if(obj.rst==1){
                    evento(obj.datos);                       
                }
            },
            error: function(){
               /* $(".overlay,.loading-img").remove();*/
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    GetAreasbyCTramite:function(data,info){
        $.ajax({
            url         : 'pretramite/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                    var result = obj.datos;
                    if(result.length > 1){
                        $(".rowArea").removeClass('hidden');
                         $("#buscartramite #reporte").hide();
                        slctGlobal.listarSlct('pretramite','slcAreasct','simple',null,data);
                        document.querySelector('#txt_clasificador_id').value=info.id;
                        document.querySelector('#txt_clasificador_nomb').value=info.nombre;
                        $("#clasificarSelect").text(info.nombre);
                    }else{
                        info.area = result[0].nombre;
                        info.areaid = result[0].id;
                        poblateData('tramite',info);
                        $('#buscartramite').modal('hide');
                    }            
                }
            },
            error: function(){
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    guardarUsuario:function(){
        var datos=$("#FrmCrearUsuario").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
        datos+="&estado=1&area=107&rol=94";
        $.ajax({
            url         : 'persona/crear',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $(".overlay,.loading-img").remove();
                    msjG.mensaje('success','<b>Registrado',4000);
                    $('#FrmCrearUsuario').find('input[type="text"],input[type="email"],textarea,select').val('');
                    $('#CrearUsuario').modal('hide');
                    $("#cbo_persona").multiselect('destroy');
                    slctGlobal.listarSlct('persona','cbo_persona','simple',null,{estado_persona:1});
                }
                else{
                     msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },
     GetEmpresabyId:function(data){
        $.ajax({
            url         : 'empresa/getempresa',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
            },
            success : function(obj) {
                if(obj.rst==1){
                    poblateData('empresa',obj.datos[0]);
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
                    if($("#cbo_tiposolicitante").val()==2){
                      poblateData('selectpersona',obj.datos[0]);   
                    }
                    else {
                    poblateData('persona',obj.datos[0]);
                }
                }
            },
            error: function(){
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
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
    guardarEmpresa:function(){
        var datos=$("#FrmCrearEmpresa").serialize().split("txt_").join("").split("slct_").join("").split("_modal").join("");
/*        datos+="&estado=1&area=107&rol=94";*/
        $.ajax({
            url         : 'empresa/creatempresa',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    $(".overlay,.loading-img").remove();
                    msjG.mensaje('success','<b>Registrado',4000);
                    $('#FrmCrearEmpresa').find('input[type="text"],input[type="email"],textarea,select').val('');
                    $('#crearEmpresa').modal('hide');
                    GetEmpresabyId({id:obj.data});
/*                    $("#cbo_persona").multiselect('destroy');
                    slctGlobal.listarSlct('persona','cbo_persona','simple',null,{estado_persona:1});*/
                }
                else{
                     msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
                }
                $(".overlay,.loading-img").remove();
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
            }
        });
    },

};
</script>
