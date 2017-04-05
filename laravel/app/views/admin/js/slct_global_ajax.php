<script type="text/javascript">
var slctGlobal={
    /**
     * mostrar un mulselect
     * @param:
     * 1 controlador..nombre del controlador   modulo
     * 2 slct         nombre del multiselect   slct_modulos
     * 3 tipo         simple o multiple
     * 4 valarray     valores que se seleccionen
     * 5 data         valores a enviar por ajax
     * 6 afectado     si es afectado o no (1,0)
     * 7 afectados    a quien afecta (slct_submodulos)
     * 8 slct_id      identificador que se esta afectando ('M')
     * 9 slctant
     * 10 slctant_id
     * 11 funciones   evento a ejecutar al hacer hacer changed
     *
     * @return string
     */
    listarSlct:function(controlador,slct,tipo,valarray,data,afectado,afectados,slct_id,slctant,slctant_id, funciones){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    htmlListarSlct(obj,slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id, funciones);
                    if (funciones!=='' && funciones!==undefined) {
                        if (funciones.success!=='' && funciones.success!==undefined) {
                            funciones.success(obj.datos);
                        }
                    }
                }
            },
            error: function(){
                msjG.mensaje('danger', '<?php echo trans("greetings.mensaje_error"); ?>', 6000);
            }
        });
    },
    listarSlctAsi:function(controlador,slct,tipo,valarray,data,afectado,afectados,slct_id,slctant,slctant_id, funciones){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            async       : false,
            beforeSend : function() {
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    htmlListarSlct(obj,slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id, funciones);
                    if (funciones!=='' && funciones!==undefined) {
                        if (funciones.success!=='' && funciones.success!==undefined) {
                            funciones.success(obj.datos);
                        }
                    }
                }
            },
            error: function(){
                msjG.mensaje('danger', '<?php echo trans("greetings.mensaje_error"); ?>', 6000);
            }
        });
    },
    listarSlct2:function(controlador,slct,data){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {                
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    html='<option value="">Seleccione</option>';
                    $.each(obj.datos,function(index,data){
                            html += "<option value=\"" + data.id + "\" >" + data.nombre + "</option>";
                    }); 
                    $("#"+slct).html(html);
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
    listarSlctFuncion:function(controlador,funcion,slct,tipo,valarray,data,afectado,afectados,slct_id,slctant,slctant_id, funciones){
        $.ajax({
            url         : controlador+'/'+funcion,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                if(obj.rst==1){
                    htmlListarSlct(obj,slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id, funciones);
                    if (funciones!=='' && funciones!==undefined) {
                        if (funciones.success!=='' && funciones.success!==undefined) {
                            funciones.success(obj.datos);
                        }
                    }
                }
            },
            error: function(){
                msjG.mensaje('danger', '<?php echo trans("greetings.mensaje_error"); ?>', 6000);
            }
        });
    },
    listarSlctFijo:function(controlador,slct,val){
        $.ajax({
            url         : controlador+'/listar',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            beforeSend : function() {
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                var html="";
                var selected="";
                html += "<option value=''>Seleccione</option>";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        selected="";
                        dat="";
                        if(typeof(val)!='undefined' && val==data.id){
                            selected="selected";
                        }
                        if(data.dat!='undefined'){
                            dat="data-dat='"+data.dat+"'";
                        }
                        html += "<option "+dat+" value=\"" + data.id + "\" "+selected+">" + data.nombre + "</option>";
                    });
                }
                $("#"+slct).html(html);
            },
            error: function(){
                msjG.mensaje('danger', '<?php echo trans("greetings.mensaje_error"); ?>', 6000);
            }
        });
    },
    listarSlctFijo2:function(controlador,evento,slct,datos,val,accion){
        $.ajax({
            url         : controlador+'/'+evento,
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : datos,
            beforeSend : function() {
                //$("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                var html="";
                var selected="";
                html += "<option value=''>Seleccione</option>";
                if(obj.rst==1){
                    $.each(obj.datos,function(index,data){
                        selected="";
                        dat="";
                        if(typeof(val)!='undefined' && val==data.id){
                            selected="selected";
                        }
                        if(data.dat!='undefined'){
                            dat="data-dat='"+data.dat+"'";
                        }
                        html += "<option "+dat+" value=\"" + data.id + "\" "+selected+">" + data.nombre + "</option>";
                    });
                }
                $("#"+slct).html(html);
                accion(slct);
            },
            error: function(){
                msjG.mensaje('danger', '<?php echo trans("greetings.mensaje_error"); ?>', 6000);
            }
        });
    }
};

var dataTableG={
    CargarCab:function(cab){
        var r=[];var clase='';var option=''; var visible=true;
        $.each(cab, 
            function(id, val) {
                var rand=Math.floor((Math.random() * 100) + 1);
                clase=''; option='';  visible=true;
                if(typeof(val.split("|")[3])!='undefined' && val.split("|")[3]!=''){
                    clase=val.split("|")[3];
                }

                if(typeof(val.split("|")[4])!='undefined' && val.split("|")[4]!=''){
                    option=val.split("|")[4];
                }
                
                if(typeof(val.split("|")[5])!='undefined' && val.split("|")[5]!=''){
                    visible=false;
                }
                r.push({
                    'id'    : id,
                    'idide' :'th_'+id.substr(0,2)+id.substr(-2)+'_'+rand,
                    'nombre': val.split("|")[1],
                    'evento': val.split("|")[0],
                    'color' : val.split("|")[2],
                    'clase' : clase,
                    'option' : option,
                    'visible': visible,
                });
            }
        );
        return r;
    },

    CargarCol:function(cab,col,tar,trpos,ajax,table){
        var r=[];
        for(i=0; i<cab.length; i++){
            tar++;

            if( cab[i].evento*1>0 ){
            col.push({
                        "targets": tar,
                        "data": function ( row, type, val, meta) {
                            return GeneraFn(row,meta);
                        },
                        "defaultContent": '',
                        "name": cab[i].id,
                        "visible": cab[i].visible
                    });
            }
            else{
            col.push({
                        "targets": tar,
                        "data": cab[i].id,
                        "name": cab[i].id,
                        "visible": cab[i].visible
                    });
            }

            if(cab[i].evento*1==1 || cab[i].evento*1==0){
                $("#"+table+">tfoot>tr,#"+table+">thead>tr:eq("+trpos+")").append('<th style="background-color:'+cab[i].color+';" class="unread">'+cab[i].nombre+'</th>');
            }
            else if( cab[i].evento*1==2 || cab[i].evento=='estado' ){
                $("#"+table+">thead>tr:eq("+trpos+")").append(
                    '<th style="background-color:'+cab[i].color+';" class="unread" id="'+cab[i].idide+'">'+cab[i].nombre+'<br>'+
                    '<select name="slct_'+cab[i].id+'" id="slct_'+cab[i].id+'" onChange="MostrarAjax(\''+ajax+'\');" class="form-control">'+
                        '<option value="">.::Todo::.</option>'+
                        '<option value="1">.::Activo::.</option>'+
                        '<option value="0">.::Inactivo::.</option>'+
                    '</select>'+
                    '</th>');
                $("#"+table+">tfoot>tr").append('<th style="background-color:'+cab[i].color+';" class="unread">'+cab[i].nombre+'</th>');
            }
            else if( cab[i].evento*1==4 || cab[i].evento=='select' ){
                $("#"+table+">thead>tr:eq("+trpos+")").append(
                    '<th style="background-color:'+cab[i].color+';" class="unread" id="'+cab[i].idide+'">'+cab[i].nombre+'<br>'+
                    '<select name="slct_'+cab[i].id+'" id="slct_'+cab[i].id+'" onChange="MostrarAjax(\''+ajax+'\');" class="form-control">'+
                    '</select>'+
                    '</th>');
                $("#slct_"+cab[i].id).append($("#slct_"+cab[i].option).html());
                $("#"+table+">tfoot>tr").append('<th style="background-color:'+cab[i].color+';" class="unread">'+cab[i].nombre+'</th>');
            }
            else{
                if( cab[i].evento*1==3 ){
                    cab[i].evento='onBlur'
                }
                $("#"+table+">thead>tr:eq("+trpos+")").append('<th style="background-color:'+cab[i].color+';" class="unread" id="'+cab[i].idide+'">'+cab[i].nombre+'<br>'+
                                                '<input name="txt_'+cab[i].id+'" id="txt_'+cab[i].id+'" '+cab[i].evento+'="MostrarAjax(\''+ajax+'\');" onKeyPress="return enterGlobal(event,\''+cab[i].idide+'\',1)" type="text" class="form-control '+cab[i].clase+'" placeholder="'+cab[i].nombre+'" />'+
                                                '</th>');
                $("#"+table+">tfoot>tr").append('<th style="background-color:'+cab[i].color+';" class="unread">'+cab[i].nombre+'</th>');
            }
            
        }
        r.push(col);
        r.push(tar);
        return r;
    },
    CargarBtn:function(col,tar,trpos,evento,table,btnfigure,btncolor){
        var r=[];
        if( typeof(btnfigure)=='undefined' ){
            alert('Ingrese su figura del botón para la tabla '+table);
            r.push([]);
            r.push([]);
            return r;
        }

        if( typeof(btncolor)=='undefined' ){
            btncolor='btn-primary'
        }
        tar++;
        $("#"+table+">tfoot>tr,#"+table+">thead>tr:eq("+trpos+")").append('<th class="unread">[]</th>');
        col.push({
                    "targets": tar,
                    "data": function ( row, type, val, meta ) {
                            return  '<a class="form-control btn '+btncolor+'" onClick="'+evento+'(this,\''+row.id+'\')">'+
                                        '<i class="fa fa-lg '+btnfigure+'"></i>'+
                                    '</a>';
                    },
                    "defaultContent": '',
                    "name": "id"
                });
        r.push(col);
        r.push(tar);
        return r;
    },
    CargarDatos:function(id,controlador,funcion,columnDefs){
        $('#t_'+id).dataTable().fnDestroy();
        $('#t_'+id)
            .on( 'page.dt',   function () { $("body").append('<div class="overlay"></div><div class="loading-img"></div>'); } )
            .on( 'search.dt', function () { $("body").append('<div class="overlay"></div><div class="loading-img"></div>'); } )
            .on( 'order.dt',  function () { $("body").append('<div class="overlay"></div><div class="loading-img"></div>'); } )
            .DataTable( {
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "searching": false,
                "ordering": false,
                "stateLoadCallback": function (settings) {
                    $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
                },
                "stateSaveCallback": function (settings) { // Cuando finaliza el ajax
                    $(".overlay,.loading-img").remove();
                },
                "ajax": {
                        "url": controlador+"/"+funcion,
                        "type": "POST",
                        //"async": false,
                            "data": function(d){
                                datos=$("#form_"+id).serialize().split("txt_").join("").split("slct_").join("").split("%5B%5D").join("[]").split("+").join(" ").split("%7C").join("|").split("&");
                                
                                for (var i = datos.length - 1; i >= 0; i--) {
                                    if( datos[i].split("[]").length>1 ){
                                        d[ datos[i].split("[]").join("["+contador+"]").split("=")[0] ] = datos[i].split("=")[1];
                                        contador++;
                                    }
                                    else{
                                        d[ datos[i].split("=")[0] ] = datos[i].split("=")[1];
                                    }
                                };
                            },
                        },
                columnDefs
            } );
    },
};

var msjG = {
    /**
     * Muestra un mensaje al pie de la página
     * 
     * @param String tipo "success" para OK o "danger" para ERROR
     * @param String texto El mensaje a mostrar
     * @param Int tiempo Tiempo que tarda en desaparecer el mensaje
     * @returns {undefined}
     */
    mensaje: function (tipo, texto, tiempo) {
        if (tipo == 'danger' && texto.length == 0) {
            texto = 'Ocurrio una interrupción en el proceso, favor de intentar nuevamente.';
        }
        $("#msj").html('<div class="alert alert-dismissable alert-' + tipo + '">' +
                '<i class="fa fa-ban"></i>' +
                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                '<b>' + texto + '</b>' +
                '</div>');
        $("#msj").effect('shake');
        $("#msj").fadeOut(tiempo);
    },
    validaDni:function(e,id){ 
        tecla = (document.all) ? e.keyCode : e.which;//captura evento teclado
        if (tecla==8 || tecla==0) return true;//8 barra, 0 flechas desplaz
        if($('#'+id).val().length==8)return false;
        patron = /\d/; // Solo acepta números
        te = String.fromCharCode(tecla); 
        return patron.test(te);
    },
    validaLetras:function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0) return true;//8 barra, 0 flechas desplaz
        patron =/[A-Za-zñÑáéíóúÁÉÍÓÚ\s]/; // 4 ,\s espacio en blanco, patron = /\d/; // Solo acepta números, patron = /\w/; // Acepta números y letras, patron = /\D/; // No acepta números, patron =/[A-Za-z\s]/; //sin ñÑ
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    },
    validaAlfanumerico:function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0 || tecla==46) return true;//8 barra, 0 flechas desplaz
        patron =/[A-Za-zñÑáéíóúÁÉÍÓÚ@.,_\-\s\d]/; // 4 ,\s espacio en blanco, patron = /\d/; // Solo acepta números, patron = /\w/; // Acepta números y letras, patron = /\D/; // No acepta números, patron =/[A-Za-z\s]/; //sin ñÑ
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    },
    validaNumeros:function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0 || tecla==46) return true;//8 barra, 0 flechas desplaz
        patron = /\d/; // Solo acepta números
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    },
};
</script>
