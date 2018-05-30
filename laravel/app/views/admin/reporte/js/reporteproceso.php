<script type="text/javascript">

    $(document).ready(function () {
        /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
         2: Descripción de cabecera
         3: Color Cabecera
         */
        data = {estado: 1};
        var ids = [];
        slctGlobal.listarSlct('software', 'slct_software_id_modal', 'simple', ids, data);
        slctGlobal.listarSlct2('rol', 'slct_rol_modal', data);
        slctGlobal.listarSlct2('verbo', 'slct_verbo_modal', data);
        slctGlobal.listarSlct2('documento', 'slct_documento_modal', data);

//   $("#btn_close").click(Close);
        slctGlobalHtml('form_tipotramites_modal #slct_estado', 'simple');
        slctGlobalHtml('form_requisitos_modal #slct_estado', 'simple');


        $('#rutaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // captura al boton
            var text = $.trim(button.data('text'));
            var id = $.trim(button.data('id'));
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this); //captura el modal
            $("#form_ruta_tiempo #txt_nombre").val(text);
            $("#form_ruta_tiempo").append('<input type="hidden" value="' + id + '" id="txt_area_id_modal">');
            /*alert(id);
             for(i=0; i<areasGId.length; i++){
             alert(areasGId[i]+"=="+id);
             if(areasGId[i]==id){
             alert("encontrado "+areasGId[i]);
             }
             }*/
            var position = tiempoGId.indexOf(id);
            var posicioninicial = areasGId.indexOf(id);
            //alert("tiempo= "+position +" | areapos="+posicioninicial);
            var tid = 0;
            var validapos = 0;
            var detalle = "";
            var detalle2 = "";

            if (position >= 0) {
                tid = position;
                //alert("actualizando");
                detalle = tiempoG[tid][0].split("_");
                detalle[0] = posicioninicial;
                tiempoG[tid][0] = detalle.join("_");

                detalle2 = verboG[tid][0].split("_");
                detalle2[0] = posicioninicial;
                verboG[tid][0] = detalle2.join("_");
            } else {
                //alert("registrando");
                tiempoGId.push(id);
                tiempoG.push([]);
                tid = tiempoG.length - 1;
                tiempoG[tid].push(posicioninicial + "__");

                verboG.push([]);
                verboG[tid].push(posicioninicial + "______");
            }

            var posicioninicialf = posicioninicial;
            for (var i = 1; i < tbodyArea[posicioninicial].length; i++) {
                posicioninicialf++;
                validapos = areasGId.indexOf(id, posicioninicialf);
                posicioninicialf = validapos;
                if (i >= tiempoG[tid].length) {
                    tiempoG[tid].push(validapos + "__");

                    verboG[tid].push(validapos + "______");
                } else {
                    detalle = tiempoG[tid][i].split("_");
                    detalle[0] = validapos;
                    tiempoG[tid][i] = detalle.join("_");

                    detalle2 = verboG[tid][i].split("_");
                    detalle2[0] = validapos;
                    verboG[tid][i] = detalle2.join("_");
                }
            }

            pintarTiempoG(tid);



            $("#form_ruta_verbo #txt_nombre").val(text);
            $("#form_ruta_verbo").append('<input type="hidden" value="' + id + '" id="txt_area_id_modal">');
        });

        $('#rutaModal').on('hide.bs.modal', function (event) {
            var modal = $(this); //captura el modal
            $("#form_ruta_tiempo input[type='hidden']").remove();
            $("#form_ruta_verbo input[type='hidden']").remove();
            modal.find('.modal-body input').val(''); // busca un input para copiarle texto
        });

        $(".fechas").datetimepicker({
            format: "yyyy-mm-dd",
            language: 'es',
            showMeridian: false,
            time: false,
            minView: 3,
            startView: 2,
            autoclose: true,
            todayBtn: false
        });

        slctGlobal.listarSlct('area', 'slct_area_id', 'multiple', null, {estado: 1, personal: 1});

        $("#generar").click(function () {
            var area_id = $('#slct_area_id').val();
            var sino = $('#slct_sino').val();
            $('#area_id').val(area_id);
            var fecha_ini = $('#fecha_ini').val();
            var fecha_fin = $('#fecha_fin').val();

            if ($.trim(area_id) !== '') {
                if (fecha_ini !== "" && fecha_fin !== "" && (fecha_ini <= fecha_fin)) {
                    var dataG = {area_id: area_id.join(','), fecha_ini: fecha_ini, fecha_fin: fecha_fin, sino: sino};
                    Proceso.CuadroProceso(dataG);

                } else {
                    alert("Seleccione Fecha correctamente");
                }
            } else {
                alert("Seleccione Área");
            }
        });

        $("#btnexport").click(GeneraHref);

    });

    GeneraHref = function () {
        var area_id = $('#slct_area_id').val();
        $('#area_id').val(area_id);
        var fecha_ini = $('#fecha_ini').val();
        var fecha_fin = $('#fecha_fin').val();
        var sino = $('#slct_sino').val();

        if ($.trim(area_id) !== '') {
            $("#btnexport").removeAttr('href');
            if (fecha_ini !== "" && fecha_fin !== "" && (fecha_ini <= fecha_fin)) {
                data = {sino: sino, fecha_fin: fecha_fin, fecha_ini: fecha_ini, area_id: $("#slct_area_id").val().join(',')};
                window.location = 'reporte/exportcuadroproceso?fecha_ini=' + data.fecha_ini + '&fecha_fin=' + data.fecha_fin + '&sino=' + data.sino + '&area_id=' + data.area_id;
            } else {
                alert("Seleccione Fecha correctamente");
            }
        } else {
            alert("Seleccione Área");
        }
    }

    HTMLCProceso = function (datos, cabecera, sino) {
        var html = "";
        var html_cabecera = "";
        var alerta_tipo = '';
        $('#t_proceso').dataTable().fnDestroy();
        pos = 0;
        contarproceso0 = 0;
        if (sino == 1) {
            html_cabecera += "<tr><th colspan='4'></th>";
        } else {
            html_cabecera += "<tr><th colspan='3'></th>";
        }
        var n = 0;
        $.each(cabecera, function (index, cabecera) {
            html_cabecera += "<th style='text-align:center'>" + cabecera + "</th>";
            n++;
        });

        html_cabecera += "<th colspan='2' style='text-align:center'>Total</th>";
        html_cabecera += "<th colspan='5' style='text-align:center'>Índices</th>";
        html_cabecera += "</tr>";

        html_cabecera += "<tr>" +
                "<th>N°</th>";
        html_cabecera += "<th>Ruta</th>";
        if (sino == 1) {
            html_cabecera += "<th>Área</th>";
        }
        html_cabecera += "<th style='text-align:center'>Proceso</th>";
        var n = 0;

        $.each(cabecera, function (index, cabecera) {
            html_cabecera += "<th >N° T.</th>";
            n++;
        });

        //html_cabecera += "<th>N° T. Total</th>";
        html_cabecera += "<th>N° T. T 1</th>";
        html_cabecera += "<th>N° T. T 2</th>";
        html_cabecera += "<th>Faltas Cometidas</th>";
        html_cabecera += "<th>% F. C.</th>";
        html_cabecera += "<th>Áreas Involucradas</th>";
        html_cabecera += "<th>Alertas</th>";
        html_cabecera += "<th>% Alertas</th>";
        html_cabecera += "</tr>";

        $.each(datos, function (index, data) {
//            evento='';
//            if(data.evento!==''){evento='<a onClick="'+data.evento+'('+ data.ruta_flujo_id +')" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a>'}
            pos++;
            html += "<tr>" +
                    "<td>" + pos + "</td>" +
                    '<td><a onclick="cargarRutaId(' + data.ruta_flujo_id + ',2,null,this)" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a></td>';
//                    '<td><a onclick="cargardetalle(' + data.ruta_flujo_id + ',this)" class="btn btn-info btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a></td>' ;
            if (sino == 1) {
                html += "<td>" + data.area + "</td>";
            }

            html += "<td>" + data.proceso +'</td>';

            var i;
            for (i = 1; i <= n; i++) {
                html += '<td style="text-align:center;">' +
                        '<table>' +
                            '<tr>' +
                                '<td style="text-align:center">'+ $.trim(data['r' + i]) +'</td>' +
                                '<td style="text-align:center;border-left: 1px solid #999999;">'+ $.trim(data['p' + i]) +'</td>' +
                                '<td style="text-align:center"></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td><a onclick="Detalle(' + data.ruta_flujo_id + ',\'' + cabecera[i - 1] + '\',1)" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a></td>' +
                                '<td><a onclick="Detalle(' + data.ruta_flujo_id + ',\'' + cabecera[i - 1] + '\',2)" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a></td>' +
                                '<td><a onclick="ExportarRTP(' + data.ruta_flujo_id + ',\'' + cabecera[i - 1] + '\',1)" class="btn btn-primary btn-xs ertp_'+data.ruta_flujo_id+'"><i class="glyphicon glyphicon-download-alt"></i> </a></td>' +
                            '</tr>' +
                        '</table>'+
                        '</td>';
            }

//            if (data.rt == 0) {
//                contarproceso0++;
//            }
            var porcentaje_faltas = 0;
            var porcentaje_alertas = 0;
            if (data.ft != 0 && data.rt != 0) {
                porcentaje_faltas = (data.ft * 100) / data.rt;
            }
            if (data.alertas != 0 && data.areas != 0) {
                porcentaje_alertas = (data.alertas * 100) / data.areas;
            }
            
            /*html += '<td style="text-align:center;">' +
                        '<table>' +
                        '<tr>' +
                        '<td style="text-align:center">'+ data.rt +'</td>' +
                        '<td style="text-align:center;border-left: 1px solid #999999;">'+ data.pt +'</td>' +
                        '<td style="text-align:center"></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><a onclick="Detalle(' + data.ruta_flujo_id + ',null,1)" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a></td>' +
                        '<td><a onclick="Detalle(' + data.ruta_flujo_id + ',null,2)" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a></td>' +
                        '</tr>' +
                        '</table>'+
                        '</td>'; */
            html += '<td style="text-align:center;">' +
                        '<table>' +
                        '<tr>' +
                        '<td style="text-align:center">'+ data.rt +'</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><a onclick="Detalle(' + data.ruta_flujo_id + ',null,1)" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a></td>' +
                        '</tr>' +
                        '</table>'+
                        '</td>'; 
            html += '<td style="text-align:center;">' +
                        '<table>' +
                        '<tr>' +
                        '<td style="text-align:center;border-left: 1px solid #999999;">'+ data.pt +'</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><a onclick="Detalle(' + data.ruta_flujo_id + ',null,2)" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list-alt"></i> </a></td>' +
                        '</tr>' +
                        '</table>'+
                        '</td>'; 

            html += '<td>' + data.ft + "</td>";
            html += '<td>' + porcentaje_faltas.toFixed(2) + "%</td>";
            html += '<td>' + data.areas + "</td>";
            html += '<td>' + data.alertas + "</td>";
            html += '<td>' + porcentaje_alertas.toFixed(2) + "%</td>";
        });
//        var totalcero = contarproceso0;
//        var totalmascero = pos - contarproceso0;

        html += "</tr>";
        $("#tb_proceso").html(html);
        $("#tt_proceso").html(html_cabecera);
        $("#t_proceso").dataTable(
                {
                    "order": [[0, "asc"]],
                    "pageLength": 10,
                }
        );
//        var htmlca = '';
//        var htmlresumen = '';
//        htmlca += "<tr><th style='text-align:center'>Resumen</th><th style='text-align:center'>Cantidad</th></tr>";
//        htmlresumen += "<tr><td>Cantidad de Procesos con 0 trámites</td><td style='text-align:right'>" + totalcero + "</td></tr>";
//        htmlresumen += "<tr><td>Cantidad de Procesos con trámites</td><td style='text-align:right'>" + totalmascero + "</td></tr>";
//        $("#tt_resumen").html(htmlca);
//        $("#tb_resumen").html(htmlresumen);
//    $("#t_resumen").dataTable(
//            {
//            "order": [[ 0, "asc" ],[1, "asc"]],
//            "pageLength": 10,
//            }
//    ); 
    };

    ActPest = function (nro) {
        Pest = nro;
    };


    activarTabla = function () {
        $("#t_detalles").dataTable(); // inicializo el datatable    
    };
    eventoSlctGlobalSimple = function (slct, valores) {
    };


    HTMLCargaActividades = function (datos, envio_actividad, exonera) {
        var html = '';
        var alerta_tipo = '';
        $("#exonera").text("");
        $("#fechas").text("");
        $('#form_actividad #t_actividad').dataTable().fnDestroy();
        pos = 0;


        $.each(datos, function (index, data) {
            pos++;
            var horas = Math.floor(data.ot_tiempo_transcurrido / 60);
            var min = data.ot_tiempo_transcurrido % 60;
            html += "<tr>" +
                    "<td>" + pos + "</td>" +
                    "<td>" + data.actividad + "</td>" +
                    "<td>" + data.fecha_inicio + "</td>" +
                    "<td>" + data.dtiempo_final + "</td>" +
                    "<td>" + Math.abs(data.ot_tiempo_transcurrido) + " min" + "</td>" +
                    "<td>" + horas + ":" + min + "</td>";
            html += "</tr>";
        });

        MostrarMensajes(envio_actividad, exonera);




        $("#form_actividad #tb_actividad").html(html);
        $("#form_actividad #t_actividad").dataTable(
                {
                    "order": [[0, "asc"], [1, "asc"]],
                    "pageLength": 10,
                }
        );


    };

    cargarRutaId = function (ruta_flujo_id, permiso, ruta_id, boton) {
        var tr = boton.parentNode.parentNode;
        var trs = tr.parentNode.children;
        for (var i = 0; i < trs.length; i++)
            trs[i].style.backgroundColor = "#f9f9f9";
        tr.style.backgroundColor = "#9CD9DE";

        $("#txt_ruta_flujo_id_modal").remove();
        $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="' + ruta_flujo_id + '">');
        $("#txt_titulo").text("Vista");
        $("#texto_fecha_creacion").text("Fecha Vista:");
        $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
        $("#form_ruta_flujo").css("display", "");
        Ruta.CargarDetalleRuta(ruta_flujo_id, permiso, CargarDetalleRutaHTML, ruta_id);
        $("#form_tramite_detalle").css("display", "none");
        $("#form_tramite").css("display", "none");
        $("#form_detallecuadro").css("display", "none");

    }
    CargarDetalleRutaHTML = function (permiso, datos) {
        areasG = "";
        areasG = []; // texto area
        areasGId = "";
        areasGId = []; // id area
        estadoG = "";
        estadoG = []; // Normal / Paralelo
        theadArea = "";
        theadArea = []; // cabecera area
        tbodyArea = "";
        tbodyArea = []; // cuerpo area
        tfootArea = "";
        tfootArea = []; // pie area

        tiempoGId = "";
        tiempoGId = []; // id posicion del modal en base a una area.
        tiempoG = "";
        tiempoG = [];
        verboG = "";
        verboG = [];
        posicionDetalleVerboG = 0;
        validandoconteo = 0;
        $.each(datos, function (index, data) {
            validandoconteo++;
            if (validandoconteo == 1) {
                $("#txt_persona_1").val(data.persona);
                $("#txt_proceso_1").val(data.flujo);
                $("#txt_area_1").val(data.area);
            }
            adicionarRutaDetalleAutomatico(data.area2, data.area_id2, data.tiempo_id + "_" + data.dtiempo, data.verbo, data.imagen, data.imagenc, data.imagenp, data.estado_ruta);
        });
        pintarAreasG(permiso);
        //alertatodo();
    }

    AbreTv = function (val) {
        $("#areasasignacion [data-id='" + val + "']").click();
    }

    adicionarRutaDetalleAutomatico = function (valorText, valor, tiempo, verbo, imagen, imagenc, imagenp, estruta) {
        valor = "" + valor;
        var adjunta = false;
        var position = areasGId.indexOf(valor);
        if (position >= 0) {
            adjunta = true;
        }

        var verboaux = verbo.split("|");
        var verbo1 = [];
        var verbo2 = [];
        var verbo3 = [];
        var verbo4 = [];
        var verbo5 = [];
        var verbo6 = [];
        var imgfinal = imagen;
        for (i = 0; i < verboaux.length; i++) {
            verbo1.push(verboaux[i].split("^^")[0]);
            verbo2.push(verboaux[i].split("^^")[1]);
            verbo3.push(verboaux[i].split("^^")[2]);
            verbo4.push(verboaux[i].split("^^")[3]);
            verbo5.push(verboaux[i].split("^^")[4]);
            verbo6.push(verboaux[i].split("^^")[5]);

            if ($.trim(verboaux[i].split("^^")[1]) > 0) {
                imgfinal = imagenc;
            }
        }

        if (estruta > 1) {
            imgfinal = imagenp;
        }

        estadoG.push(estruta);
        areasG.push(valorText);
        areasGId.push(valor);

        if (adjunta == false) {
            head = '<th class="eliminadetalleg" style="width:110px;min-width:100px !important;">' + valorText + '</th>';
            theadArea.push(head);

            body = '<tr>' +
                    '<td class="areafinal" onclick="AbreTv(' + valor + ');" style="height:100px; background-image: url(' + "'" + 'img/admin/area/' + imgfinal + "'" + ');">&nbsp;' +
                    '<span class="badge bg-yellow">' + areasG.length + '</span>' +
                    '</td>' +
                    '</tr>';
            tbodyArea.push([]);
            tbodyArea[ (tbodyArea.length - 1) ].push(body);

            foot = '<th class="eliminadetalleg">' +
                    '<div style="text-align:center;">' +
                    '<a class="btn bg-olive btn-sm" data-toggle="modal" data-target="#rutaModal" data-id="' + valor + '" data-text="' + valorText + '">' +
                    '<i class="fa fa-desktop fa-lg"></i>' +
                    '</a>' +
                    '</div>' +
                    '</th>';
            tfootArea.push(foot);
        } else {

            theadArea.push(0);
            tfootArea.push(0);
            tbodyArea.push([]);
            tbodyArea[ (tbodyArea.length - 1) ].push(position + "|" + tbodyArea[position].length);
            body = '<tr>' +
                    '<td class="areafinal" onclick="AbreTv(' + valor + ');" style="height:100px; background-image: url(' + "'" + 'img/admin/area/' + imgfinal + "'" + ');">&nbsp;' +
                    '<span class="badge bg-yellow">' + areasG.length + '</span>' +
                    '</td>' +
                    '</tr>';
            tbodyArea[position].push(body);

        }

        var position = tiempoGId.indexOf(valor);
        var posicioninicial = areasGId.indexOf(valor);
        //alert("tiempo= "+position +" | areapos="+posicioninicial);
        var tid = 0;
        var validapos = 0;
        var detalle = "";
        var detalle2 = "";

        if (position >= 0) {
            tid = position;
            //alert("actualizando");
            /*detalle=tiempoG[tid][0].split("_");
             detalle[0]=posicioninicial;
             tiempoG[tid][0]=detalle.join("_");
             
             detalle2=verboG[tid][0].split("_");
             detalle2[0]=posicioninicial;
             verboG[tid][0]=detalle2.join("_");
             */
        }
        //else{
        //alert("registrando");

        if (tiempo != '_' || verbo != '') {
            if (adjunta == false) { // primer registro
                tiempoGId.push(valor);
                tiempoG.push([]);
                tid = tiempoG.length - 1;
                tiempoG[tid].push(posicioninicial + "_" + tiempo);

                verboG.push([]);
                verboG[tid].push(posicioninicial + "_" + verbo1.join("|") + "_" + verbo2.join("|") + "_" + verbo3.join("|") + "_" + verbo4.join("|") + "_" + verbo5.join("|") + "_" + verbo6.join("|"));
            }
            //}
            else {
                var posicioninicialf = posicioninicial;
                for (var i = 1; i < tbodyArea[posicioninicial].length; i++) {
                    posicioninicialf++;
                    validapos = areasGId.indexOf(valor, posicioninicialf);
                    posicioninicialf = validapos;
                    if (i >= tiempoG[tid].length) {
                        //alert(tiempo+" | "+verbo+" | "+valor+" | "+posicioninicial+"-"+validapos);
                        tiempoG[tid].push(validapos + "_" + tiempo);

                        verboG[tid].push(validapos + "_" + verbo1.join("|") + "_" + verbo2.join("|") + "_" + verbo3.join("|") + "_" + verbo4.join("|") + "_" + verbo5.join("|") + "_" + verbo6.join("|"));
                    }
                    /*else{
                     detalle=tiempoG[tid][i].split("_");
                     detalle[0]=validapos;
                     tiempoG[tid][i]=detalle.join("_");
                     
                     detalle2=verboG[tid][i].split("_");
                     detalle2[0]=validapos;
                     verboG[tid][i]=detalle2.join("_");
                     }*/
                }
            }
        }
    }

    pintarAreasG = function (permiso) {
        var htm = '';
        var click = "";
        var imagen = "";
        var clickeli = "";
        $("#areasasignacion .eliminadetalleg").remove();
        $("#slct_area_id_2").val("");
        $("#slct_area_id_2").multiselect("refresh");
        $("#slct_area_id_2").multiselect("disable");

        if (permiso != 2) {
            $("#slct_area_id_2").multiselect("enable");
        }

        for (var i = 0; i < areasG.length; i++) {
            click = "";
            imagen = "";
            clickeli = "";
            if (permiso != 2) {
                clickeli = " onclick='EliminarDetalle(" + i + ");' ";
            }

            if (i > 0) {
                if (permiso != 2) {
                    click = " onclick='CambiarDetalle(" + i + ");' ";
                }
                imagen = "<i class='fa fa-sort-up fa-sm'></i>";
            }

            htm += "<tr id='tr-detalle-" + i + "'>" +
                    "<td>" +
                    (i + 1) +
                    "</td>" +
                    "<td>" +
                    areasG[i] +
                    "</td>" +
                    "</tr>";


            if (theadArea[i] != 0) {

                $("#areasasignacion>thead>tr.head").append(theadArea[i]);
                $("#areasasignacion>tfoot>tr.head").append(tfootArea[i]);

                var detbody = '<td class="eliminadetalleg">' +
                        '<table class="table table-bordered">';
                for (j = 0; j < tbodyArea[i].length; j++) {
                    if (j > 0) {
                        detbody += '<tr>' +
                                '<td style="height:8px;">&nbsp;' +
                                '</td>' +
                                '</tr>';
                    }
                    detbody += tbodyArea[i][j];
                }
                detbody += '</table> </td>';
                $("#areasasignacion>tbody>tr.body").append(detbody);
            }

        }
        ;

        $("#areasasignacion>thead>tr.head").append('<th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>'); // aqui para darle el area global

        $("#tb_rutaflujodetalleAreas").html(htm);
    }
////////////////////// Agregando para el mostrar detalle
    pintarTiempoG = function (tid) {
        var htm = "";
        var detalle = "";
        var detalle2 = "";
        $("#tb_tiempo").html(htm);
        $("#tb_verbo").html(htm);

        posicionDetalleVerboG = 0; // Inicializando posicion del detalle al pintar

        var subdetalle1 = "";
        var subdetalle2 = "";
        var subdetalle3 = "";
        var subdetalle4 = "";
        var subdetalle5 = "";
        var subdetalle6 = "";
        var imagen = "";

        for (var i = 0; i < tiempoG[tid].length; i++) {
            // tiempo //
            detalle = tiempoG[tid][i].split("_");

            htm = '<tr>' +
                    '<td>' + (detalle[0] * 1 + 1) + '</td>' +
                    '<td>' +
                    '<select disabled class="form-control" id="slct_tipo_tiempo_' + detalle[0] + '_modal">' +
                    $('#slct_tipo_tiempo_modal').html() +
                    '</select>' +
                    '</td>' +
                    '<td>' +
                    '<input readonly class="form-control" type="number" id="txt_tiempo_' + detalle[0] + '_modal" value="' + detalle[2] + '">' +
                    '</td>' +
                    '</tr>';
            $("#tb_tiempo").append(htm);

            $('#slct_tipo_tiempo_' + detalle[0] + '_modal').val(detalle[1]);
            //fin tiempo

            //verbo

            detalle2 = verboG[tid][i].split("_");

            subdetalle1 = detalle2[1].split('|');
            subdetalle2 = detalle2[2].split('|');
            subdetalle3 = detalle2[3].split('|');
            subdetalle4 = detalle2[4].split('|');
            subdetalle5 = detalle2[5].split('|');
            subdetalle6 = detalle2[6].split('|');

            selectestado = '';
            for (var j = 0; j < subdetalle1.length; j++) {
                posicionDetalleVerboG++;
                imagen = "";


                if ((j + 1) == subdetalle1.length) {
                    selectestado = '<br><select disabled id="slct_paralelo_' + detalle2[0] + '_modal">' +
                            '<option value="1">Normal</option>' +
                            '<option value="2">Paralelo</option>' +
                            '</select>';
                }

                htm = '<tr id="tr_detalle_verbo_' + posicionDetalleVerboG + '">' +
                        '<td>' + (detalle2[0] * 1 + 1) + selectestado + '</td>' +
                        '<td>' +
                        '<input readonly type="number" class="form-control txt_orden_' + detalle2[0] + '_modal" placeholder="Ing. Orden" value="' + subdetalle6[j] + '">' +
                        '</td>' +
                        '<td>' +
                        '<select disabled class="form-control slct_rol_' + detalle2[0] + '_modal">' +
                        $('#slct_rol_modal').html() +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<select disabled class="form-control slct_verbo_' + detalle2[0] + '_modal">' +
                        $('#slct_verbo_modal').html() +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<select disabled class="form-control slct_documento_' + detalle2[0] + '_modal">' +
                        $('#slct_documento_modal').html() +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<textarea disabled class="form-control txt_verbo_' + detalle2[0] + '_modal" placeholder="Ing. Acción">' + subdetalle1[j] + '</textarea>' +
                        '</td>' +
                        '<td>' +
                        '<select disabled class="form-control slct_condicion_' + detalle2[0] + '_modal">' +
                        $('#slct_condicion_modal').html() +
                        '</select>' +
                        '</td>' +
                        '<td>' + imagen + '</td>' +
                        '</tr>';
                $("#tb_verbo").append(htm);

                if ((j + 1) == subdetalle1.length) {
                    $("#slct_paralelo_" + detalle2[0] + "_modal").val(estadoG[detalle2[0]]);
                }

                if (subdetalle2[j] == "") { // En caso no tenga valores se inicializa
                    subdetalle2[j] = "0";
                }
                //alert(subdetalle2[j]);
                $(".slct_condicion_" + detalle2[0] + "_modal:eq(" + j + ")").val(subdetalle2[j]);
                $(".slct_rol_" + detalle2[0] + "_modal:eq(" + j + ")").val(subdetalle3[j]);
                $(".slct_verbo_" + detalle2[0] + "_modal:eq(" + j + ")").val(subdetalle4[j]);
                $(".slct_documento_" + detalle2[0] + "_modal:eq(" + j + ")").val(subdetalle5[j]);
            }
            //fin verbo
        }
    }


    HTMLreported = function (datos) {
        var html = "";
        var alertOk = 'success';//verde
        var alertError = 'danger';//rojo
        var alertCorregido = 'warning';//ambar
        var alerta = '';
        var estado_final = '';

        $("#t_reported_tab_1 tbody").html('');
        $("#t_reported_tab_1").dataTable().fnDestroy();

        $.each(datos, function (index, data) {
            if (data.alerta == '0')
                alerta = alertOk;
            if (data.alerta == '1')
                alerta = alertError;
            if (data.alerta == '2')
                alerta = alertCorregido;


            estado_final = 'Pendiente';
            if (data.dtiempo_final != '') {
                if (data.alerta == '0') {
                    estado_final = 'Concluido';
                } else if (data.alerta == '1' && data.alerta_tipo == '1') {
                    estado_final = 'A Destiempo';
                } else if (data.alerta == '1' && data.alerta_tipo == '2') {
                    estado_final = 'Lo He Detenido a Destiempo';
                } else if (data.alerta == '1' && data.alerta_tipo == '3') {
                    estado_final = 'Lo He Detenido';
                } else if (data.alerta == '2') {
                    estado_final = 'Lo He Detenido R.';
                }
            }

            html += "<tr class='" + alerta + "'>" +
                    "<td>" + data.norden + "</td>" +
                    "<td>" + data.area + "</td>" +
                    "<td>" + data.tiempo + ': ' + data.dtiempo + "</td>" +
                    "<td>" + data.fecha_inicio + "</td>" +
                    "<td>" + data.dtiempo_final + "</td>" +
                    "<td>" + estado_final + "</td>" +
                    "<td>" + data.verbo2.split("|").join("<br>") + "</td>" +
                    "<td>" + data.ordenv.split("|").join("<br>") + "</td>";
            html += "</tr>";

        });

        $("#t_reported_tab_1 tbody").html(html);
        $("#t_reported_tab_1").dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
        });

    };

    // Reporte de Tramite Actividades
    HTMLCargaTramiteActividad = function (datos,cabecera) {
        $("#form_tactividad").show();
        var html_cabecera = '';
        var html = '';
        var n = 0;

        var array_total_actividad = [];

        $('#t_tramite_actividad').dataTable().fnDestroy();

        html_cabecera = "<tr class='info'>" +
                        "<th> [] </th>"+
                        "<th style='min-width: 160px !important;'> Descripci&oacute;n </th>"+
                        "<th> Tramite </th>";
                        $.each(cabecera, function (index, cabecera) {
                            html_cabecera += "<th >Actividad "+cabecera+"</th>";
                            n++;                            
                        });
        html_cabecera += "</tr>";

        
        $.each(datos, function (index, data) {
            html += "<tr>";
                html += '<td><a onClick="detallee(' + data.id + ',this)" class="btn btn-primary btn-sm" data-id="' + data.id + '" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a> </td>'+
                        "<td>" + data.sumilla + "</td>"+
                        "<td>" + data.id_union + "</td>";
                var i;


                for (i = 0; i <= (n-1); i++)
                {
                    if(data['act' + i])
                    {
                        var res = data['act' + i].split("|");
                        if (res[1]!='') {
                            if(res[1]=='V')
                                var stylhe_class = 'success';
                            else if(res[1]=='N')
                                var style_class = 'warning';
                            else if(res[1]=='R')
                                var style_class = 'danger';
                            else
                                var style_class = '';
                        } else {
                            var style_class = '';
                        }
                        html += "<td class='"+style_class+"'>";
                        if($.trim(data['archivo' + i]) == '')
                            html += res[0] + res[2];
                        else {
                            //html += "<a href='"+data['archivo' + i]+"' target='_blank'>"+res[0] + res[2] + "</a>";
                            html += res[0] + res[2];
                            html += '<button type="button" id="' + data.id + '" onclick="verFotosModal(this.id)"  data-toggle="modal" data-target="#modalFotos' + data.id + '" class="btn btn-primary btn-xs"><span class="fa fa-list fa-lg" aria-hidden="true"></span> Ver Fotos</button>';

                            html += '&nbsp;<button type="button" id="' + data.id + '" onclick="verMapaModal(this.id)"  data-toggle="modal" data-target="#modalMapas' + data.id + '" class="btn btn-default btn-xs"><span class="fa fa-list fa-lg" aria-hidden="true"></span> Ver Mapa</button>';
                        }
                            

                        html += "</td>";
                        /*
                        if (count(res[2]) > 0) {
                            var res = res[2].split("<br>");
                            if (count(res[2]) > 0) {
                                con_t + 1;
                                array_total_actividad.push(con_t);
                            }                            
                        }
                        */
                    }
                    else
                        html += "<td class=''>&nbsp;</td>";   
                } 
            html += "</tr>";
        });        

        // Totales
        /*
        html_cabecera_tot = "<tr class='info'>" +
                        "<th> &nbsp; </th>"+
                        "<th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>";
        $.each(cabecera, function (index, cabecera) {
            html_cabecera_tot += "<th >TOTALES "+cabecera+"</th>";
        });
        html_cabecera_tot += "</tr>";
        */
        // --        

        $("#form_tactividad #tt_tramite_actividad").html(html_cabecera);
        $("#form_tactividad #tb_tramite_actividad").html(html);

        //$("#tt_actividad_resum").html(html_cabecera_tot);
        //$("#tb_actividad_resum").html(html_tot);

        $("#t_tramite_actividad").dataTable(
            {
                "pageLength": 10,
            }
        );
    };
    // -


    verFotosModal = function(id) {
        //Proceso.verArchivosDesmontesMotorizado(id);        
        //$("#d_ver_fotos").html('<img src="img/loading.gif" style="border: 0px;">');
        $.ajax({
                url: 'reporte/verarchivosdesmontesmotorizado',
                type:'POST',
                cache       : false,
                dataType    : 'json',
                data        : { ruta_id:id },
                success: function(obj)
                {
                    datos = obj.datos;
                    //console.log(datos);
                    var html_pd = '';
                    var foto = '';

                    $.each(datos, function (index, data) {
                        var d_foto = data.archivo;
                        if (d_foto.length != 0) {

                            var data_fotos = $.trim(data.archivo).split("|");

                            $.each(data_fotos, function (index, d_foto) {
                                var cant_foto = d_foto.length;
                                if(d_foto.substring((cant_foto-3), cant_foto) == 'png' || 
                                    d_foto.substring((cant_foto-3), cant_foto) == 'jpg' ||
                                    d_foto.substring((cant_foto-3), cant_foto) == 'gif' ||
                                    d_foto.substring((cant_foto-4), cant_foto) == 'jpeg' )
                                    foto = d_foto;
                                else
                                    foto = 'img/admin/ruta_detalle/marca_doc.jpg';

                                html_pd += '<div class="col-md-2" id="ad'+index+'" style="padding-left: 0px; padding-right: 10px;">'+
                                                '<a href="'+d_foto+'" target="_blank"><img src="'+foto+'" alt=""  border="0" class="img-responsive foto_desmonte"></a>'+
                                                '<div class="text-center"></div>'+
                                            '</div>';
                            });                        
                        }
                    });
                    $("#d_ver_fotos").html(html_pd);       
                },
                error: function(jqXHR, textStatus, error)
                {
                  console.log(jqXHR.responseText);
                }
            });

        
        var html_modal = '<div class="modal fade" id="modalFotos'+id+'" role="dialog">'+
                                          '<div class="modal-dialog modal-md">'+
                                            '<div class="modal-content">'+
                                              '<div class="modal-header" style="padding: 7px;">'+
                                                '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                                '<h4 class="modal-title text-center">LISTADO DE FOTOS</h4>'+
                                              '</div>'+
                                              '<div class="modal-body" style="overflow: hidden;">'+
                                                  '<div id="d_ver_fotos" class="col-md-12">'+
                                                    '<p></p>'+
                                                  '</div>'+
                                              '</div>'+
                                              '<div class="modal-footer" style="padding: 7px;">'+
                                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'+
                                              '</div>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>';

        $('#div_ver_archivos_id').html(html_modal);
    }

    verMapaModal = function(id) {

        $.ajax({
                url: 'reporte/vermapadesmontesmotorizado',
                type:'POST',
                cache       : false,
                dataType    : 'json',
                data        : { ruta_id:id },
                success: function(obj)
                {
                    datos = obj.datos;                    
                    // Gmaps
                    var map;
                    map = new GMaps({
                        el: '#map',
                        lat: datos[0].latitud,
                        lng: datos[0].longitud
                    });

                    conten_market = '<div style="text-align:center; width: 100%;"><h3>'+datos[0].tipo+'</h3>'+
                                          '<p>'+datos[0].direccion+'</p>'+
                                      '</div>'+
                                      '<div style="width: 100%;">'+
                                        '<div style="text-align:center;">'+
                                          '<a href="'+datos[0].foto+'" target="_blank"><img src="'+datos[0].foto+'" width="90"/></a>'+
                                        '</div>';                               
                    conten_market += '</div>';   

                    map.addMarker({
                        lat: datos[0].latitud,
                        lng: datos[0].longitud,
                        title: datos[0].direccion,
                        infoWindow: {
                          //content: '<p><strong>DSDSDSD</strong></br><img src="http://www.muniindependencia.gob.pe/sicmovil/fotoed/29447.jpg" border="0" width="60"></p>'
                          content : conten_market
                        }
                    });
                    // --
                },
                error: function(jqXHR, textStatus, error)
                {
                  console.log(jqXHR.responseText);
                }
            });

        
        var html_modal_map = '<div class="modal fade" id="modalMapas'+id+'" role="dialog">'+
                                          '<div class="modal-dialog modal-md">'+
                                            '<div class="modal-content">'+
                                              '<div class="modal-header" style="padding: 7px;">'+
                                                '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                                '<h4 class="modal-title text-center">MAPA DESMONTE</h4>'+
                                              '</div>'+
                                              '<div class="modal-body" style="overflow: hidden;">'+
                                                  '<div id="map" class="col-md-12">'+
                                                    '<p></p>'+
                                                  '</div>'+
                                              '</div>'+
                                              '<div class="modal-footer" style="padding: 7px;">'+
                                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'+
                                              '</div>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>';

        $('#div_ver_mapas_id').html(html_modal_map);
    }


    HTMLCargaTramites = function (datos) {
        var html = '';
        var alerta_tipo = '';

        //$('#form_tramite #t_tramite').dataTable().fnDestroy();
        $('#form_tramite').dataTable().fnDestroy();
        pos = 0;


        $.each(datos, function (index, data) {
        var style='';

        if(data.estado=='Concluido'){
          style='background-color:#D1E1FF;'; //azul
        }
        else if(data.fecha_valida>='<?php echo date('Y-m-d H:m:s'); ?>' ){
           style='background-color:#99ff99;';   //verde
        }
        else if(data.fecha_valida<'<?php echo date('Y-m-d H:m:s'); ?>' || data.estado=='Trunco'){
           style='background-color:#ff9999;';   //rojo
        }
//        else(data.estado=='Trunco'){
//           style='background-color:#ff9999;';   //rojo
//        }
//        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2,'+data.id+')" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
            html += "<tr  style='"+style+"' >" +
                    "<td>" + data.fecha_inicio_referido + "</td>" +
                    "<td>" + data.tramite_referido + "</td>" +
                    "<td>" + data.persona_referido + "</td>" +
                    "<td>" + data.sumilla_referido + "</td>" +
                    "<td>" + data.tramite + "</td>" +
                    "<td>" + data.tipo_persona + "</td>" +
                    "<td>" + data.persona + "</td>" +
                    "<td>" + data.sumilla + "</td>" +
                    "<td>" + data.estado + "</td>" +
                    "<td>" + $.trim(data.ult_paso).split(",")[0].split('|')[0] + "</td>" +
                    "<td>" + $.trim( $.trim(data.ult_paso).split(",")[0].split('|')[1] ) + "</td>" +
                    "<td>" + data.total_pasos + "</td>" +
                    '<td><a onClick="detalle(' + data.id + ',this)" class="btn btn-primary btn-sm" data-id="' + data.id + '" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a> </td>';
            html += "</tr>";
        });

        $("#form_tramite #tb_tramite").html(html);
        $("#form_tramite #t_tramite").dataTable(
                {
                    "order": [[0, "asc"], [1, "asc"]],
                    "pageLength": 10,
                }
        );

    };

    detallee = function (ruta_id, boton) {

        $("#form_1").append("<input type='hidden' id='txt_ruta_id' name='txt_ruta_id' value='" + ruta_id + "'>");
        var datos = $("#form_1").serialize().split("txt_").join("").split("slct_").join("");
        $("#form_1 #txt_ruta_id").remove();
        Tramite.mostrar(datos, HTMLreported, 'd');
        $("#form_tramite_detalle").css("display", "");
        $("#form_tramite").css("display", "");
        $("#form_detallecuadro").css("display", "none");
        $("#form_ruta_flujo").css("display", "none");
    };

    Detalle = function (id, fechames,tramite) {
        var fecha_ini = $('#fecha_ini').val();
        var fecha_fin = $('#fecha_fin').val();
        var dataG = [];
            dataG = {ruta_flujo_id: id, fecha_ini: fecha_ini, fecha_fin: fecha_fin, tramite: tramite};


        $("#div_tactividad_previo").html('<img src="img/loading.gif" style="border: 0px;">').show();
        $("#form_tactividad").hide();


        $('#text_fecha_ini').html('Fecha inicial '+fecha_ini);
        Proceso.MostrarTramiteActividad({ ruta_flujo_id:id, fecha_ini: fecha_ini, fecha_fin: fecha_fin, tramite:tramite });
        
        Personalizado.ReportePersonalizado({ fechames: fechames, ruta_flujo_id:id, fecha_ini: fecha_ini, fecha_fin: fecha_fin});
        //Personalizado.ReportePersonalizado(dataG);

        $("#form_tactividad").css("display", "");

        //Proceso.MostrarTramites(dataG);
        $("#form_tramite").css("display", "");
        $("#form_tramite_detalle").css("display", "none");
        $("#form_detallecuadro").css("display", "none");
        $("#form_ruta_flujo").css("display", "none");
        
        // --
//        Proceso.CalcularTotalesXNumeroOrden(id, fechames, tramite);
       // Proceso.CalcularTotalActividad(id, fechames, tramite);
        // --
    };

//    HTMLCargaTotalesXNumeroOrden = function (datos) {
//        var html_cabecera_tot = '';
//        var html_tot = '';
//        var n = 1;
//
//        html_cabecera_tot = "<tr class='info'>";            
//        var i = 0;
//        $.each(datos, function (index, data) {
//            html_cabecera_tot += "<th> Actividad "+data.norden+" </th>";    
//        });
//        html_cabecera_tot += "</tr>";
//
//        html_tot += "<tr style=''>";
//        $.each(datos, function (index, data) {
//                html_tot += "<td>" + data.cant + "</td>";                
//        });
//        html_tot += "</tr>";
//
//        $("#tt_orden_resum").html(html_cabecera_tot);
//        $("#tb_orden_resum").html(html_tot);
//    };

    HTMLCargaTotalActividad = function (datos,cabecera) {
        var html_cabecera_tot = '';
        var html_tot = '';
        var n = 1;

        html_cabecera_tot = "<tr class='info'>" +
                            "<th> AREA </th>"+
                            "<th> ACTIVIDAD </th>"+
                            "<th> TOTALES </th>";    
        html_cabecera_tot += "</tr>";

        var i = 0;
        $.each(datos, function (index, data) {
            i = index;
        });

        $.each(datos, function (index, data) {
            if (i != index) {
                if(data.norden) {
                    var style = '';
                    var orden = data.norden;                    
                } else {
                    var style = 'font-weight: bold; text-transform: uppercase;';
                    var orden = '';
                }

                html_tot += "<tr style='" + style + "'>";
                    html_tot += "<td>" + data.nombre + "</td>"+
                                "<td>" + orden + "</td>"+
                                "<td>" + data.cant + "</td>";
                html_tot += "</tr>";
            }
        });        

        $("#tt_actividad_resum").html(html_cabecera_tot);
        $("#tb_actividad_resum").html(html_tot);
    };


    ExportarRTP = function (id, fechames,tramite) {
        var fecha_ini = $('#fecha_ini').val();
        var fecha_fin = $('#fecha_fin').val();
        //var dataG = [];

        if (fechames == null) {
            $(".ertp_"+id).attr('href','reporte/exportreportetramite'+'?ruta_flujo_id='+id+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&tramite='+tramite);
        } else {
            $(".ertp_"+id).attr('href','reporte/exportreportetramite'+'?ruta_flujo_id='+id+'&fechames='+fechames+'&tramite='+tramite);
        }
    };

//    cargardetalle = function (id,boton) {
//        var tr = boton.parentNode.parentNode;
//        var trs = tr.parentNode.children;
//        for (var i = 0; i < trs.length; i++)
//            trs[i].style.backgroundColor = "#f9f9f9";
//        tr.style.backgroundColor = "#9CD9DE";
//        
//        var fecha_ini = $('#fecha_ini').val();
//        var fecha_fin = $('#fecha_fin').val();
//        var dataG = [];
//        dataG = {ruta_flujo_id: id ,fecha_ini: fecha_ini, fecha_fin: fecha_fin};
//        Proceso.DetalleCuadroProceso(dataG);
//        $("#form_detallecuadro").css("display", "");
//        $("#form_tramite_detalle").css("display", "none");
//        $("#form_tramite").css("display", "none");
//        $("#form_ruta_flujo").css("display", "none");
//
//    };
//    HTMLCargaDetalleCuadroProceso = function (datos) {
//        var html = '';
//        var alerta_tipo = '';
//
//        $('#form_detallecuadro #t_detallecuadro').dataTable().fnDestroy();
//        pos = 0;
//
//
//        $.each(datos, function (index, data) {
////        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2,'+data.id+')" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
//            html += "<tr>" +
//                    "<td>" + data.flujo + "</td>" +
//                    "<td>" + data.area + "</td>" +
//                    "<td>" + data.norden + "</td>" +
//                    "<td>" + data.total + "</td>" +
//                    "<td>" + data.tf + "</td>";
//            html += "</tr>";
//        });
//
//        $("#form_detallecuadro #tb_detallecuadro").html(html);
//        $("#form_detallecuadro #t_detallecuadro").dataTable(
//                {
//                    "order": [[0, "asc"], [1, "asc"]],
//                    "pageLength": 10,
//                }
//        );
//
//    };
</script>
