<script type="text/javascript">

var tramite = {
    AgregarEditarDocumento:function(AE){
        var datos = $("#form_tramite_modal").serialize().split("txt_").join("").split("slct_").join("");
        var accion = (AE==1) ? "tabla_relacion/editasignado" : "tabla_relacion/editasignado";

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
                    MostrarAjax('documentos');
                    msjG.mensaje('success',obj.msj,4000);
                    $('#documentoModal .modal-footer [data-dismiss="modal"]').click();

                } else {
                    var cont = 0;

                    $.each(obj.msj, function(index, datos){
                        cont++;
                         if(cont==1){
                            alert(datos[0]);
                       }

                    });
                }
            },
            error: function(){
                $(".overlay,.loading-img").remove();
                msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
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
                            console.log(row);
                            ruta_detalle_id.push('td_'+row.ruta_detalle_id);
                            if(row.id>0){//est visto
                                //el boton debera cambiar  a no visto
                                estado.push('desactivar('+row.id+','+row.ruta_detalle_id+',this,'+row.ruta_id+')');
                                fondo.push('');
                                visto='<i id="td_'+row.ruta_detalle_id+'" class="fa fa-eye"></i>';
                            } else {
                                //unread
                                estado.push('activar('+row.id+','+row.ruta_detalle_id+',this,'+row.ruta_id+')');
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
                        "data": "id_union",
                        "name": "id_union"
                    },
                    {
                        "targets": 2,
                        "data": "fecha_tramite",
                        "name": "fecha_tramite"
                    },
                    {
                        "targets": 3,
                        "data": "usuario",
                        "name": "usuario"
                    },                    
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
                "url": "reportef/bandejatramite",
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
};
</script>
