<script type="text/javascript">
var Bandeja={
    Expediente:function(data){
        $.ajax({
            //url         : 'reporte/bandejatramitedetalle',
            url         : 'referido/expediente',
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
                    HTMLreporteDetalle(obj.datos);
                    ConsultaDetalle=obj;
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
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
                $("#txt_respuesta").val(obj.fecha);
                $("#div_cumple>span").html("CUMPLIENDO TIEMPO");
                $("#txt_alerta").val("0");
                $("#txt_alerta_tipo").val("0");

                $("#div_cumple").removeClass("progress-bar-danger").removeClass("progress-bar-warning").addClass("progress-bar-success");
                    
                    if ( fechaAux!='' && fechaAux < $("#txt_respuesta").val() ) {
                        $("#txt_alerta").val("1");
                        $("#txt_alerta_tipo").val("2");
                        $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-warning").addClass("progress-bar-danger");
                        $("#div_cumple>span").html("NO CUMPLE TIEMPO ALERTA");
                    }
                    else if ( fechaAux!='' ) {
                        $("#txt_alerta").val("1");
                        $("#txt_alerta_tipo").val("3");
                        $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-danger").addClass("progress-bar-warning");
                        $("#div_cumple>span").html("ALERTA ACTIVADA");
                    }
                    else if ( $("#txt_fecha_max").val() < $("#txt_respuesta").val() ) {
                        $("#txt_alerta").val("1");
                        $("#txt_alerta_tipo").val("1");
                        $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-warning").addClass("progress-bar-danger");
                        $("#div_cumple>span").html("NO CUMPLE TIEMPO");
                    }
            },
            error: function(){
            }
        });
    },
    MostrarAjax:function(){
        var datos="";var estado=[];
        var fondo=[];var visto="";
        var ruta_detalle_id=[];

        var columnDefs=[{
                        "targets": 0,
                        "data": function ( row, type, val, meta ) {
                            ruta_detalle_id.push('td_'+row.ruta_detalle_id);
                            if(row.id>0){//est visto
                                //el boton debera cambiar  a no visto
                                estado.push('desactivar('+row.id+','+row.ruta_detalle_id+',this)');
                                fondo.push('');
                                visto='<i id="td_'+row.ruta_detalle_id+'" class="fa fa-eye"></i>';
                            } else {
                                //unread
                                estado.push('activar('+row.id+','+row.ruta_detalle_id+',this)');
                                fondo.push('unread');
                                visto='<i id="td_'+row.ruta_detalle_id+'" class="fa fa-ban"></i>';
                            }
                            return visto;
                        },
                        "defaultContent": '',
                        "name": "visto"
                    },
                     {
                        "targets": 1,
                        "data": "responsable",
                        "name": "responsable"
                    },
                    {
                        "targets": 2,
                        "data": "id_union_ant",
                        "name": "id_union_ant"
                    },
                    {
                        "targets": 3,
                        "data": "id_union",
                        "name": "id_union"
                    },
                    {
                        "targets": 4,
                        "data": "tiempo",
                        "name": "tiempo"
                    },
                    {
                        "targets": 5,
                        "data": "fecha_inicio",
                        "name": "fecha_inicio"
                    },
                    {
                        "targets": 6,
                        "data": "tiempo_final",
                        "name": "tiempo_final"
                    },
                    {
                        "targets": 7,
                        "data": "norden",
                        "name": "norden"
                    },
                    {
                        "targets": 8,
                        "data": "proceso",
                        "name": "proceso"
                    },
                    {
                        "targets": 9,
                        "data": "persona",
                        "name": "persona"
                    }
                    ];

        $('#t_reporte_ajax').dataTable().fnDestroy();
        $('#t_reporte_ajax')
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
              var trsimple;
                for(i=0;i<ruta_detalle_id.length;i++){
                    trsimple=$("#"+ruta_detalle_id[i]).closest('tr');
                    trsimple.attr('class',fondo[i]);
                    trsimple.attr('onClick',estado[i]);
                }
                $(".overlay,.loading-img").remove();
            },
            "ajax": {
                "url": "reportef/bandejatramitearea",
                "type": "POST",
                "data": function(d){
                        var contador=0;
                        datos=$("#form_filtros").serialize().split("txt_").join("").split("slct_").join("").split("%5B%5D").join("[]").split("+").join(" ").split("%7C").join("|").split("&");

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
    Mostrar:function( data ){
        $.ajax({
            url         : 'reporte/bandejatramite',
            type        : 'POST',
            contentType: false,
            processData: false,
            cache       : false,
            dataType    : 'json',
            data        : data,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    HTMLreporte(obj.datos);
                    Consulta=obj;
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    MostrarDetalle:function(data){
        $.ajax({
            //url         : 'reporte/bandejatramitedetalle',
            url         : 'ruta_detalle/cargardetalle',
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
                    HTMLreporteDetalle(obj.datos);
                    ConsultaDetalle=obj;
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });
    },
    CambiarEstado:function(ruta_detalle_id, id,AD){//si AD es 1, establecer como visto
        parametros = {estado:AD,ruta_detalle_id:ruta_detalle_id,id:id};
        $.ajax({
            url         : 'tramite/cambiarestado',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : parametros,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    
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
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });

    },
    MostrarUsuarios:function(ruta_detalle_id){//si AD es 1, establecer como visto
        parametros = {ruta_detalle_id:ruta_detalle_id};
        $.ajax({
            url         : 'tramite/usuarios',
            type        : 'POST',
            cache       : false,
            dataType    : 'json',
            data        : parametros,
            beforeSend : function() {
                $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
            },
            success : function(obj) {
                $(".overlay,.loading-img").remove();
                if(obj.rst==1){
                    var html='';
                    $.each(obj.datos,function(index,data){
                        html+="<tr>";
                        html+="<td>"+data.persona+"</td>";
                        html+="<td>"+data.fecha+"</td>";
                        html+="<td>"+data.estado+"</td>";
                        html+="</tr>";
                    });
                    $("#tb_usuarios").html(html);
                    $("#t_usuarios").dataTable();
                    $('#usuarios_vieron_tramite').modal('show');

                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje("danger","Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.",3000);
            }
        });

    }
};
</script>
