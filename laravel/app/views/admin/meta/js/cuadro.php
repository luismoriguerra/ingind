<script type="text/javascript">
    var Pest=1;
    var Cuadro = {fecha_actual: ""}; // Datos Globales
    var arr_fecha = ["01-01", "01-15","02-01", "02-15","03-01", "03-15","04-01", "04-15","05-01", "05-15","06-01", "06-15",
                     "07-01", "07-15","08-01", "08-15","09-01", "09-15","10-01", "10-15","11-01", "11-15","12-01", "12-15",
                     "01-01", "01-15","02-01", "02-15","03-01", "03-15","04-01", "04-15","05-01", "05-15","06-01", "06-15",
                     "07-01", "07-15","08-01", "08-15","09-01", "09-15","10-01", "10-15","11-01", "11-15","12-01", "12-15"];
    $(document).ready(function () {

        var datos = {estado: 1,cuadro:1};
        slctGlobal.listarSlct('meta','slct_meta', 'multiple', null, datos);
        Cuadro.fecha_actual = '<?php echo date('Y-m-d') ?>';
        $("#generar_area").click(function () {
            meta = $('#slct_meta').val();
            if ($.trim(meta) !== '') {
                data = {meta: meta};
                Usuario.mostrar(data);
            } else {
                alert("Seleccione Metas");
            }
        });

        $(document).on('click', '.btnDelete', function (event) {
            $(this).parent().parent().remove();
        });
    });
    var ap = 0;
    AgregarAP = function (cont1, avance_id) {
        ap++;
        var html = '';
        html += "<tr>" +
                "<td>#" +
                "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='4'>" +
                "<input type='hidden' name='avance_id[]' id='avance_id' value='" + avance_id + "'></td></td> " +
                "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre' + ap + '""  name="pago_nombre[]" value="">' +
                '<input type="text" style="display: none;" id="pago_archivo' + ap + '" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,' + ap + ',\'#t_aparchivo' + cont1 + '\');" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";

        $("#t_aparchivo" + cont1).append(html);

    };
    var ad = 0;
    AgregarD = function (cont2, avance_id) {
        ad++;
        var html = '';
        html += "<tr>" +
                "<td>#" +
                "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='3'>" +
                "<input type='hidden' name='avance_id[]' id='avance_id' value='" + avance_id + "'></td></td> " +
                "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre' + ad + '""  name="pago_nombre[]" value="">' +
                '<input type="text" style="display: none;" id="pago_archivo' + ad + '" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,' + ad + ',\'#t_darchivo' + cont2 + '\');" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";

        $("#t_darchivo" + cont2).append(html);

    };
    var aa = 0;
    AgregarA = function (cont3, avance_id) {
        aa++;
        var html = '';
        html += "<tr>" +
                "<td>#" +
                "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='2'>" +
                "<input type='hidden' name='avance_id[]' id='avance_id' value='" + avance_id + "'></td></td> " +
                "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre' + aa + '""  name="pago_nombre[]" value="">' +
                '<input type="text" style="display: none;" id="pago_archivo' + aa + '" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,' + aa + ',\'#t_aarchivo' + cont3 + '\');" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";

        $("#t_aarchivo" + cont3).append(html);

    };
    var am = 0;
    AgregarM = function (cont4, avance_id) {
        am++;
        var html = '';
        html += "<tr>" +
                "<td>#" +
                "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='1'>" +
                "<input type='hidden' name='avance_id[]' id='avance_id' value='" + avance_id + "'></td></td> " +
                "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre' + am + '""  name="pago_nombre[]" value="">' +
                '<input type="text" style="display: none;" id="pago_archivo' + am + '" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,' + am + ',\'#t_marchivo' + cont4 + '\');" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";

        $("#t_marchivo" + cont4).append(html);

    };
    var aq = 0;
    AgregarQ = function (cont4_1, avance_id,fecha_id) {
        aq++;
        var html = '';
        html += "<tr>" +
                "<td>#" +
                "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='5'>" +
                "<input type='hidden' name='fecha_id[]' id='fecha_id' value='"+fecha_id+"'>" +
                "<input type='hidden' name='avance_id[]' id='avance_id' value='" + avance_id + "'></td> " +
                "<td>";
        html += '<input type="text"  readOnly class="form-control input-sm" id="pago_nombre' + aq + '""  name="pago_nombre[]" value="">' +
                '<input type="text" style="display: none;" id="pago_archivo' + aq + '" name="pago_archivo[]">' +
                '<label class="btn btn-default btn-flat margin btn-xs">' +
                '<i class="fa fa-file-pdf-o fa-lg"></i>' +
                '<i class="fa fa-file-word-o fa-lg"></i>' +
                '<i class="fa fa-file-image-o fa-lg"></i>' +
                '<input type="file" style="display: none;" onchange="onPagos(event,' + aq + ',\'#t_qarchivo' + cont4_1 + '\');" >' +
                '</label>';
        html += "</td>" +
                '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a></td>';
        html += "</tr>";

        $("#t_qarchivo" + cont4_1).append(html);

    };

    HTMLreporte = function (datos) {
        var html = "";
        pos = 0;

        n = 1;
        a = 1;
        b = 1;
        c = 1;
        n1 = 1;
        a1 = 1;
        a2 = 1;
        b1 = 1;
        c1 = 1;
        n2 = 1;

        aux_meta_id = '';
        aux_meta_cuadro_id = '';
        aux_id_d = '';
        aux_id_p = '';

        aux_meta_id1 = '';
        aux_meta_id2 = '';
        aux_meta_cuadro_id1 = '';
        aux_meta_cuadro_id2 = '';
        aux_id_d1 = '';
        aux_id_p1 = '';

        cont1 = 0;
        cont2 = 0;
        cont3 = 0;
        cont3_1 = 0;
        cont4 = 0;
        cont4_1 = 0;
        $.each(datos, function (index, data) {

            html += '<tr>';
            if (aux_meta_id !== data.meta_id) {
                aux_meta_id = data.meta_id;
                if (index > 0) {
                    html = html.replace("rowspann", "rowspan='" + n + "'");
                }
                html += '<td rowspann >' + data.nombre + '<br><b>'+data.mf_me+'</b></td>';
                n = 1;
            } else {
                n++;
            }

            if (aux_meta_cuadro_id !== data.meta_cuadro_id) {
                aux_meta_cuadro_id = data.meta_cuadro_id;
                if (index > 0) {
                    html = html.replace("rowspana", "rowspan='" + a + "'");
                }
                html += '<td rowspana >' + data.actividad + '<br><b>'+data.af_ac+ '</br></td>';
                a = 1;
            } else {
                a++;
            }

            if (aux_id_d !== data.id_d) {
                aux_id_d = data.id_d;
                if (index > 0) {
                    html = html.replace(/rowspanb/g, "rowspan='" + b + "'");
                    //  html= html.split('rowspanb').join("rowspan='"+b+"'");
                }
                html += '<td rowspanb >' + data.d + '</td>';
                html += '<td rowspanb ><b>' + data.df_de + '</b></td>';
                b = 1;
            } else {
                b++;
            }

            if (aux_id_p !== data.id_p) {
                aux_id_p = data.id_p;
                if (index > 0) {
                    html = html.replace(/rowspanc/g, "rowspan='" + c + "'");
                }
                html += '<td rowspanc >' + data.p + '</td>';
                html += '<td rowspanc ><b>' + data.pf_pa + '</b></td>';
                c = 1;
            } else {
                c++;
            }
            
            if (aux_meta_id2 !== data.meta_id) {
                aux_meta_id2 = data.meta_id;
                if (index > 0) {
                    html = html.replace("rowspann2", "rowspan='" + n2 + "'");
                }
                cont4_1++;
                html += '<td rowspann2 >'
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html+= '<div>';
                var di=data.pf_pa.split('-');
                var df=data.mf_me.split('-');
                if(di[2]<=15){
                    var did='15';
                    var dim=di[1];
                    var dia=di[0];
                }else { 
                    did='01'; 
                    if(di[1]==12){ 
                        var dia=parseInt(di[0])+1;
                        dim='01';
                    }else {
                        dim=pad((parseInt(di[1])+1),2); 
                        var dia=di[0];
                         }
                      }
                if(df[2]<=15){
                    var dfa=df[0];
                    var dfd='01';
                    var dfm=df[1];
                }else {
                    var dfa=df[0];
                    var dfd='15';
                    var dfm=df[1];
                }
                if(df[0]!=di[0]){
                    var pi = arr_fecha.indexOf(dim+'-'+did);
                    var pf = arr_fecha.indexOf(dfm+'-'+dfd,arr_fecha.indexOf(dfm+'-'+dfd)+1);
                }else {
                     pi = arr_fecha.indexOf(dim+'-'+did);
                     pf = arr_fecha.indexOf(dfm+'-'+dfd);
                      }
                
                for (j = pi; j <= pf; j++) {
                    if(j<=23){ var anio=dia;} else { var anio=dfa;}
                    var d = Date.parse(anio+"-"+arr_fecha[j]+" 00:00:00 GMT") / 1000;       
                    html+=  '<form name="form_qarchivo' + cont4_1 +j+ '" id="form_qarchivo' + cont4_1 +j+ '" enctype=”multipart/form-data”>' +
                        '<table id="t_qarchivo' + cont4_1 +j+'" class="table table-bordered">' +
                        '<thead class="bg-aqua disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Archivo<br>'+anio+"-"+arr_fecha[j]+'</th>';
                if (anio+"-"+arr_fecha[j] >= Cuadro.fecha_actual) {    
                    html+= '<th><a class="btn btn-default btn-xs"' +
                        'onclick="AgregarQ(' + cont4_1+j+ ',' + data.meta_id + ',' + d + ')"><i class="fa fa-plus fa-lg"></i></a></th>';
                 }
                    html+= ' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_qarchivo' + cont4_1 +j+ '">';
                if (data.a_q != null) {
                    var a_q = data.a_q.split('|');
                    var a_q_nombre = a_q[0].split(',');
                    var a_q_id = a_q[1].split(',');
                    var a_q_fechaid = a_q[2].split(',');
                    pos_aq = 1;
                    for (i = 0; i < a_q_nombre.length; i++) {
                        if(a_q_fechaid[i]==d){
                        var nombre = a_q_nombre[i].split('/');
                        html += "<tr>" +
                                "<td>" + pos_aq + "<input type='hidden' name='c_id[]' id='c_id' value='" + a_q_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='file/meta/" + a_q_nombre[i] + "'>" + nombre[1] + "</a></td>";
                        if (anio+"-"+arr_fecha[j] >= Cuadro.fecha_actual) {
                        html+='<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\'' + a_q_id[i] + '\',\'' + nombre[0] + '\',\'' + nombre[1] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                        }
                        html += "</tr>";
                        pos_aq++;
                        }
                    }
                }
                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
            if (anio+"-"+arr_fecha[j] >= Cuadro.fecha_actual) {  
                html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px" onClick="Guardar(\'#form_qarchivo' + cont4_1 +j+ '\')">' +
                        '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar' +
                        '</a>';
            }else {
                    html += '<br>';
                  }
                  html += '</div>';
                  html += '<div>' ;
//                                     if(j<=23){ var anio=dia;} else { var anio=dfa;}
//                    var d = Date.parse(anio+"-"+arr_fecha[j]+" 00:00:00 GMT") / 1000;  
                html +='<form name="form_qdocumento' + cont4_1 +j+ '" id="form_qdocumento' + cont4_1 +j+ '" enctype=”multipart/form-data”>' +
                        '<table id="t_qdocumento' + cont4_1 +j+ '" class="table table-bordered" >' +
                        '<thead class="bg-teal disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Documento<br>'+anio+"-"+arr_fecha[j]+'</th>';
                if (anio+"-"+arr_fecha[j] >= Cuadro.fecha_actual) {
                    html += '<th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal" id="btn_list_digital" data-texto="txt_codigo" data-tipoid="5" data-form="#t_qdocumento' + cont4_1 +j+ '" data-avanceid="' + data.meta_id + '" data-fechaid="' + d + '" data-id="txt_doc_digital_id">' +
                            '<i class="glyphicon glyphicon-file"></i>' +
                            '</span></th>';
                }
                html += ' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_adocumento' + cont4_1 +j+ '">';
                if (data.d_q != null) {
                    var d_q = data.d_q.split('|');
                    var d_q_nombre = d_q[0].split(',');
                    var d_q_id = d_q[1].split(',');
                    var d_q_doc_digital_id = d_q[2].split(',');
                    var d_q_fechaid = d_q[3].split(',');
                    pos_aq = 1;
                    for (i = 0; i < d_q_nombre.length; i++) {
                        if(d_q_fechaid[i]==d){    
                        html += "<tr>" +
                                "<td>" + pos_aq + "<input type='hidden' name='c_id[]' id='c_id' value='" + d_q_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='documentodig/vista/" + d_q_doc_digital_id[i] + "/4/1'>" + d_q_nombre[i] + "</a></td>" ;
                        if (anio+"-"+arr_fecha[j] >= Cuadro.fecha_actual) {
                        html += '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="EliminarDoc(\'' + d_q_id[i] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                        }
                        html += "</tr>";
                        pos_aq++;
                    }
                    }
                }

                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (anio+"-"+arr_fecha[j] >= Cuadro.fecha_actual) {
                    html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px;" onClick="GuardarDoc(\'#form_qdocumento' + cont4_1 +j+'\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar' +
                            '</a>';
                }else {
                    html += '<br>';
                  }
                  html += '</div>';
                  
              }

//        }                      

                html +='</td>';
                n2 = 1;
            } else {
                n2++;
            }
            if (aux_id_p1 !== data.id_p) {
                aux_id_p1 = data.id_p;
                if (index > 0) {
                    html = html.replace(/rowspanc1/g, "rowspan='" + c1 + "'");
                }
                cont1++;

                html += '<td rowspanc1 >';
//        if( data.a_p==null && data.pf>=Cuadro.fecha_actual){
                html += '<div>' +
                        '<form name="form_aparchivo' + cont1 + '" id="form_aparchivo' + cont1 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_aparchivo' + cont1 + '" class="table table-bordered" >' +
                        '<thead class="bg-aqua disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Archivo</th>';
                if (data.pf >= Cuadro.fecha_actual) {
                    html += '<th><a class="btn btn-default btn-xs" title="Agregar Archivo"' +
                            'onclick="AgregarAP(' + cont1 + ',' + data.id_p + ')"><i class="fa fa-plus fa-lg"></i></a></th>';
                }
                 
                  html +=' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_aparchivo' + cont1 + '">';
                if (data.a_p != null) {
                    var a_p = data.a_p.split('|');
                    var a_p_nombre = a_p[0].split(',');
                    var a_p_id = a_p[1].split(',');
                    pos_ap = 1;
                    for (i = 0; i < a_p_nombre.length; i++) {
                        var nombre = a_p_nombre[i].split('/');
                        html += "<tr>" +
                                "<td>" + pos_ap + "<input type='hidden' name='c_id[]' id='c_id' value='" + a_p_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='file/meta/" + a_p_nombre[i] + "'>" + nombre[1] + "</a></td>";
                        if (data.pf >= Cuadro.fecha_actual) {
                        html+='<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\'' + a_p_id[i] + '\',\'' + nombre[0] + '\',\'' + nombre[1] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                        }
                        html += "</tr>";
                        pos_ap++;
                    }
                }

                html += ' </tbody>' +
                        '</table>' +
                        '</form>';

                if (data.pf >= Cuadro.fecha_actual) {
                    html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px" onClick="Guardar(\'#form_aparchivo' + cont1 + '\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar' +
                            '</a>';
                } else {
                    html += '<br>';
                }
                html += '</div>';
//        }
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html += '<div>' +
                        '<form name="form_apdocumento' + cont1 + '" id="form_apdocumento' + cont1 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_apdocumento' + cont1 + '" class="table table-bordered" >' +
                        '<thead class="bg-teal disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Documento</th>';
                if (data.pf >= Cuadro.fecha_actual) {
                    html += '<th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal" id="btn_list_digital" data-texto="txt_codigo" data-tipoid="4" data-form="#t_apdocumento' + cont1 + '" data-avanceid="' + data.id_p + '" data-id="txt_doc_digital_id">' +
                            '<i class="glyphicon glyphicon-file"></i>' +
                            '</span></th>';
                }
                html +=' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_apdocumento' + cont1 + '">';
                if (data.d_p != null) {
                    var d_p = data.d_p.split('|');
                    var d_p_nombre = d_p[0].split(',');
                    var d_p_id = d_p[1].split(',');
                    var d_p_doc_digital_id = d_p[2].split(',');
                    pos_ap = 1;
                    for (i = 0; i < d_p_nombre.length; i++) {

                        html += "<tr>" +
                                "<td>" + pos_ap + "<input type='hidden' name='c_id[]' id='c_id' value='" + d_p_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='documentodig/vista/" + d_p_doc_digital_id[i] + "/4/1'>" + d_p_nombre[i] + "</a></td>";
                        if (data.pf >= Cuadro.fecha_actual) {
                        html += '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="EliminarDoc(\'' + d_p_id[i] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                        }
                        html += "</tr>";
                        pos_ap++;
                    }
                }

                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (data.pf >= Cuadro.fecha_actual) {
                    html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="GuardarDoc(\'#form_apdocumento' + cont1 + '\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar' +
                            '</a>';
                }
                html += '</div>';
//                    }
                html += '</td>';

                c1 = 1;
            } else {
                c1++;
            }

            if (aux_id_d1 !== data.id_d) {
                aux_id_d1 = data.id_d;
                if (index > 0) {
                    html = html.replace(/rowspanb1/g, "rowspan='" + b1 + "'");
                }
                cont2++;
                html += '<td rowspanb1 >' +
                        //        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                        '<div>' +
                        '<form name="form_darchivo' + cont2 + '" id="form_darchivo' + cont2 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_darchivo' + cont2 + '" class="table table-bordered">' +
                        '<thead class="bg-aqua disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Archivo</th>';
                if (data.df >= Cuadro.fecha_actual) {
                html+='<th><a class="btn btn-default btn-xs"' +
                        'onclick="AgregarD(' + cont2 + ',' + data.id_d + ')"><i class="fa fa-plus fa-lg"></i></a></th>';
                }
                html+=' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_darchivo' + cont2 + '">';

                if (data.a_d != null) {
                    var a_d = data.a_d.split('|');
                    var a_d_nombre = a_d[0].split(',');
                    var a_d_id = a_d[1].split(',');
                    pos_ad = 1;
                    for (i = 0; i < a_d_nombre.length; i++) {
                        var nombre = a_d_nombre[i].split('/');
                        html += "<tr>" +
                                "<td>" + pos_ad + "<input type='hidden' name='c_id[]' id='c_id' value='" + a_d_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='file/meta/" + a_d_nombre[i] + "'>" + nombre[1] + "</a></td>" ;
                        if (data.df >= Cuadro.fecha_actual) {
                        html += '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\'' + a_d_id[i] + '\',\'' + nombre[0] + '\',\'' + nombre[1] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                    }
                        html += "</tr>";
                        pos_ad++;
                    }
                }
                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (data.df >= Cuadro.fecha_actual) {    
                html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px" onClick="Guardar(\'#form_darchivo' + cont2 + '\')">' +
                        '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar' +
                        '</a>';} else {
                html+='<br>';        
                        }
                 html += '</div>';
                //}
                //        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html += '<div>' +
                        '<form name="form_ddocumento' + cont2 + '" id="form_ddocumento' + cont2 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_ddocumento' + cont2 + '" class="table table-bordered" >' +
                        '<thead class="bg-teal disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Documento</th>';
                if (data.df >= Cuadro.fecha_actual) {
                    html += '<th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal" id="btn_list_digital" data-texto="txt_codigo" data-tipoid="3" data-form="#t_ddocumento' + cont2 + '" data-avanceid="' + data.id_d + '" data-id="txt_doc_digital_id">' +
                            '<i class="glyphicon glyphicon-file"></i>' +
                            '</span></th>';
                }
                html += ' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_ddocumento' + cont2 + '">';
                if (data.d_d != null) {
                    var d_d = data.d_d.split('|');
                    var d_d_nombre = d_d[0].split(',');
                    var d_d_id = d_d[1].split(',');
                    var d_d_doc_digital_id = d_d[2].split(',');
                    pos_d = 1;
                    for (i = 0; i < d_d_nombre.length; i++) {

                        html += "<tr>" +
                                "<td>" + pos_d + "<input type='hidden' name='c_id[]' id='c_id' value='" + d_d_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='documentodig/vista/" + d_d_doc_digital_id[i] + "/4/1'>" + d_d_nombre[i] + "</a></td>" ;
                        if (data.df >= Cuadro.fecha_actual) {
                        html += '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="EliminarDoc(\'' + d_d_id[i] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                        }
                        html += "</tr>";
                        pos_d++;
                    }
                }

                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (data.df >= Cuadro.fecha_actual) {
                    html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="GuardarDoc(\'#form_ddocumento' + cont2 + '\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar' +
                            '</a>';
                }
                html += '</div>';
//                    }
                '</td>';

                b1 = 1;
            } else {
                b1++;
            }

            if (aux_meta_cuadro_id1 !== data.meta_cuadro_id) {
                aux_meta_cuadro_id1 = data.meta_cuadro_id;
                if (index > 0) {
                    html = html.replace("rowspana1", "rowspan='" + a1 + "'");
                }
                cont3++;
                html += '<td rowspana1 >';
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html+= '<div>'+
                        '<form name="form_aarchivo' + cont3 + '" id="form_aarchivo' + cont3 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_aarchivo' + cont3 + '" class="table table-bordered">' +
                        '<thead class="bg-aqua disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Archivo</th>'+
                        '<th>';
                if (data.af >= Cuadro.fecha_actual) {  
                 html+='<a class="btn btn-default btn-xs"' +
                        'onclick="AgregarA(' + cont3 + ',' + data.meta_cuadro_id + ')"><i class="fa fa-plus fa-lg"></i></a>';
                 }
                html+= '</th> </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_aarchivo' + cont3 + '">';
                if (data.a_a != null) {
                    var a_a = data.a_a.split('|');
                    var a_a_nombre = a_a[0].split(',');
                    var a_a_id = a_a[1].split(',');
                    var a_a_valida = a_a[2].split(',');
                    pos_aa = 1;
                    for (i = 0; i < a_a_nombre.length; i++) {
                        var nombre = a_a_nombre[i].split('/');
                        html += "<tr>" +
                                "<td>" + pos_aa + "<input type='hidden' name='c_id[]' id='c_id' value='" + a_a_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='file/meta/" + a_a_nombre[i] + "'>" + nombre[1] + "</a></td>" ;
                        html +='<td>';
                        if (data.af >= Cuadro.fecha_actual && a_a_valida[i]==1) {
                        html +='<a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\'' + a_a_id[i] + '\',\'' + nombre[0] + '\',\'' + nombre[1] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>';
                        }
                        html += '</a></td>';
                        
                        html += "</tr>";
                        pos_aa++;
                    }
                }
                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
            if (data.af >= Cuadro.fecha_actual) {    
                html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px" onClick="Guardar(\'#form_aarchivo' + cont3 + '\')">' +
                        '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar' +
                        '</a>';
            }else {
                    html += '<br>';
                }
                html += '</div>';
//        }                      
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html += '<div>' +
                        '<form name="form_adocumento' + cont3 + '" id="form_adocumento' + cont3 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_adocumento' + cont3 + '" class="table table-bordered" >' +
                        '<thead class="bg-teal disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Documento</th>'+
                        '<th>';
                if (data.af >= Cuadro.fecha_actual) {
                    html +='<span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal" id="btn_list_digital" data-texto="txt_codigo" data-tipoid="2" data-form="#t_adocumento' + cont3 + '" data-avanceid="' + data.meta_cuadro_id + '" data-id="txt_doc_digital_id">' +
                            '<i class="glyphicon glyphicon-file"></i>' +
                            '</span>';
                }
                html += ' </th></tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_adocumento' + cont3 + '">';
                if (data.d_a != null) {
                    var d_a = data.d_a.split('|');
                    var d_a_nombre = d_a[0].split(',');
                    var d_a_id = d_a[1].split(',');
                    var d_a_doc_digital_id = d_a[2].split(',');
                    var d_a_valida = d_a[3].split(',');
                    pos_a = 1;
                    for (i = 0; i < d_a_nombre.length; i++) {

                        html += "<tr>" +
                                "<td>" + pos_a + "<input type='hidden' name='c_id[]' id='c_id' value='" + d_a_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='documentodig/vista/" + d_a_doc_digital_id[i] + "/4/1'>" + d_a_nombre[i] + "</a></td>" +
                                '<td>';
                        if (data.af >= Cuadro.fecha_actual && d_a_valida[i]==1) {
                        html +='<a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="EliminarDoc(\'' + d_a_id[i] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a>';
                        }
                        html += "</td></tr>";
                        pos_a++;
                    }
                }

                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (data.af >= Cuadro.fecha_actual) {
                    html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="GuardarDoc(\'#form_adocumento' + cont3 + '\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar' +
                            '</a>';
                } 
                html += '</div>';
//                    }
                 html +=  '</td>';
                a1 = 1;
            } else {
                a1++;
            }
            
            if (aux_meta_cuadro_id2 !== data.meta_cuadro_id) {
                aux_meta_cuadro_id2 = data.meta_cuadro_id;
                if (index > 0) {
                    html = html.replace("rowspana2", "rowspan='" + a2 + "'");
                }
                cont3_1++;
                html += '<td rowspana2 >';
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html+= '<div>'+
                        '<form name="form_aproceso' + cont3_1 + '" id="form_aproceso' + cont3_1 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_aproceso' + cont3_1 + '" class="table table-bordered">' +
                        '<thead class="bg-aqua disabled color-palette">' +
                        '<tr>' +
                        '<th>[]</th>' +
                        '<th>Proceso</th>';
//                html+= '<th>[]</th>';
                html+= ' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_aproceso' + cont3_1 + '">';
                if (data.a_proceso != null) {
                    var a_proceso = data.a_proceso.split('|');
                    var a_proceso_nombre = a_proceso[0].split(',');
                    var a_proceso_concluido = a_proceso[1].split(',');
                    var a_proceso_total = a_proceso[2].split(',');
                    var a_proceso_pendiente = a_proceso[3].split(',');

                    for (i = 0; i < a_proceso_nombre.length; i++) {

                        html += "<tr>" +
                                "<td><b>Nombre:</b></td> " +
                                "<td>"+a_proceso_nombre[i]+"</td>" ;
                        html += "</tr>";
                        html += "<tr>" +
                                "<td><b>Total:</b></td> " +
                                "<td>"+a_proceso_concluido[i]+"</td>" ;
                        html += "</tr>";
                         html += "<tr>" +
                                "<td><b>Concluido:</b></td> " +
                                "<td>"+a_proceso_pendiente[i]+"</td>" ;
                        html += "</tr>";
                        html += "<tr>" +
                                "<td><b>Pendiente:</b></td> " +
                                "<td>"+a_proceso_total[i]+"</td>" ;
                        html += "</tr>";

                    }
                }
                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                html += '<a class="btn btn-default btn-xs" id="detalle"  style="width: 100%;margin-top:10px" onClick="Detalle(\'' + data.a_proceso_id + '\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Detalle' +
                         '</a>';
                html += '</div>';
//        }                      
                        '</td>';
                a2 = 1;
            } else {
                a2++;
            }

            if (aux_meta_id1 !== data.meta_id) {
                aux_meta_id1 = data.meta_id;
                if (index > 0) {
                    html = html.replace("rowspann1", "rowspan='" + n1 + "'");
                }
                cont4++;
                html += '<td rowspann1 >';
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html += '<div>'+
                        '<form name="form_marchivo' + cont4 + '" id="form_marchivo' + cont4 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_marchivo' + cont4 + '" class="table table-bordered">' +
                        '<thead class="bg-aqua disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Archivo</th>';
                if (data.mf >= Cuadro.fecha_actual) {
                html+=  '<th><a class="btn btn-default btn-xs"' +
                        'onclick="AgregarM(' + cont4 + ',' + data.meta_id + ')"><i class="fa fa-plus fa-lg"></i></a></th>';
                }
                html+= ' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_marchivo' + cont4 + '">';
                if (data.a_m != null) {
                    var a_m = data.a_m.split('|');
                    var a_m_nombre = a_m[0].split(',');
                    var a_m_id = a_m[1].split(',');
                    pos_am = 1;
                    for (i = 0; i < a_m_nombre.length; i++) {
                        var nombre = a_m_nombre[i].split('/');
                        html += "<tr>" +
                                "<td>" + pos_am + "<input type='hidden' name='c_id[]' id='c_id' value='" + a_m_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='file/meta/" + a_m_nombre[i] + "'>" + nombre[1] + "</a></td>" ;
                        if (data.mf >= Cuadro.fecha_actual) {
                        html += '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\'' + a_m_id[i] + '\',\'' + nombre[0] + '\',\'' + nombre[1] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                         }
                        html += "</tr>";
                        pos_am++;
                    }
                }
                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (data.mf >= Cuadro.fecha_actual) {
                html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px" onClick="Guardar(\'#form_marchivo' + cont4 + '\')">' +
                        '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar' +
                        '</a>';
                }else{
               html += '<br>';
                } 
                html += '</div>';
//        }                
//        if( data.d_p==null && data.pf>=Cuadro.fecha_actual){
                html += '<div>' +
                        '<form name="form_mdocumento' + cont4 + '" id="form_mdocumento' + cont4 + '" enctype=”multipart/form-data”>' +
                        '<table id="t_mdocumento' + cont4 + '" class="table table-bordered" >' +
                        '<thead class="bg-teal disabled color-palette">' +
                        '<tr>' +
                        '<th>N°</th>' +
                        '<th>Documento</th>';
                if (data.mf >= Cuadro.fecha_actual) {
                    html += '<th><span class="btn btn-default btn-xs" data-toggle="modal" data-target="#docdigitalModal" id="btn_list_digital" data-texto="txt_codigo" data-tipoid="1" data-form="#t_mdocumento' + cont4 + '" data-avanceid="' + data.meta_id + '" data-id="txt_doc_digital_id">' +
                            '<i class="glyphicon glyphicon-file"></i>' +
                            '</span></th>';
                }
                html += ' </tr>' +
                        ' </thead>' +
                        ' <tbody id="tb_mdocumento' + cont3 + '">';
                if (data.d_m != null) {
                    var d_m = data.d_m.split('|');
                    var d_m_nombre = d_m[0].split(',');
                    var d_m_id = d_m[1].split(',');
                    var d_m_doc_digital_id = d_m[2].split(',');
                    pos_m = 1;
                    for (i = 0; i < d_m_nombre.length; i++) {

                        html += "<tr>" +
                                "<td>" + pos_m + "<input type='hidden' name='c_id[]' id='c_id' value='" + d_m_id[i] + "'></td></td> " +
                                "<td><a target='_blank' href='documentodig/vista/" + d_m_doc_digital_id[i] + "/4/1'>" + d_m_nombre[i] + "</a></td>" ;
                        if (data.mf >= Cuadro.fecha_actual) {
                        html += '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="EliminarDoc(\'' + d_m_id[i] + '\',this)">' +
                                '<i class="fa fa-trash fa-lg"></i>' +
                                '</a></td>';
                        }
                        html += "</tr>";
                        pos_m++;
                    }
                }

                html += ' </tbody>' +
                        '</table>' +
                        '</form>';
                if (data.mf >= Cuadro.fecha_actual) {
                    html += '<a class="btn btn-default btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="GuardarDoc(\'#form_mdocumento' + cont4 + '\')">' +
                            '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar' +
                            '</a>';
                } 
                html += '</div>';
//                    }
                        '</td>';
                n1 = 1;
            } else {
                n1++;
            }
            html += '</tr>';

        });
        html = html.replace("rowspann", "rowspan='" + n + "'");
        html = html.replace("rowspana", "rowspan='" + a + "'");
        html = html.replace(/rowspanb/g, "rowspan='" + b + "'");
        html = html.replace(/rowspanc/g, "rowspan='" + c + "'");
        
        html = html.replace(/rowspanc1/g, "rowspan='" + c1 + "'");
        html = html.replace(/rowspanb1/g, "rowspan='" + b1 + "'");
        html = html.replace("rowspana1", "rowspan='" + a1 + "'");
        html = html.replace("rowspana2", "rowspan='" + a2 + "'");
        html = html.replace("rowspann1", "rowspan='" + n1 + "'");
        html = html.replace("rowspann2", "rowspan='" + n2 + "'");

        $("#tb_reporte").html(html);
        $("#reporte").show();
    };


    ActPest = function (nro) {
        Pest = nro;
    };

    activarTabla = function () {
        $("#t_detalles").dataTable(); // inicializo el datatable    
    };
    eventoSlctGlobalSimple = function (slct, valores) {
    };

    Guardar = function (form) {
        var datos = $(form).serialize().split("txt_").join("").split("slct_").join("");
        Usuario.Crear(datos, 1);
    };

    GuardarDoc = function (form) {
        var datos = $(form).serialize().split("txt_").join("").split("slct_").join("");
        Usuario.Crear(datos, 0);
    };

    Eliminar = function (id, carpeta, nombre, tr) {

        var datos = {id: id, carpeta: carpeta, nombre: nombre};
        var c = confirm("¿Está seguro de Eliminar el archivo?");
        if (c) {
            $(tr).parent().parent().remove();
            Usuario.Eliminar(datos, 1);
        }
    };

    EliminarDoc = function (id, tr) {

        var datos = {id: id};
        var c = confirm("¿Está seguro de Eliminar el Documento?");
        if (c) {
            $(tr).parent().parent().remove();
            Usuario.Eliminar(datos, 0);

        }

    };

    onPagos = function (event, item,form) {
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
            return;
        var image = new Image();
        var reader = new FileReader();
        reader.onload = (e) => {
            $(form+' #pago_archivo' + item).val(e.target.result);
        };
        reader.readAsDataURL(files[0]);
        $(form+' #pago_nombre' + item).val(files[0].name);
        console.log(files[0].name);
    };
    HTMLCargar = function (datos, campos) {
        var c_text = campos.nombre;
        var c_id = campos.id;
        var c_avance_id = campos.avance_id;
        var c_tipo_id = campos.tipo_id;
        var c_fecha_id = campos.fecha_id;
        var c_form = campos.form;

        console.log(datos);
        var html = "";
        $('#t_doc_digital').dataTable().fnDestroy();
        $.each(datos, function (index, data) {

            if ($.trim(data.ruta) == 0 && $.trim(data.rutadetallev) == 0) {
                html += "<tr class='danger'>";
            } else {
                html += "<tr class='success'>";
            }

            html += "<td>" + data.titulo + "</td>";
            html += "<td>" + data.asunto + "</td>";
            html += "<td>" + data.plantilla + "</td>";
            if ($.trim(data.ruta) != 0 || $.trim(data.rutadetallev) != 0) {
                html += "<td><a class='btn btn-success btn-sm' c_fecha_id='" + c_fecha_id + "' c_tipo_id='" + c_tipo_id + "' c_avance_id='" + c_avance_id + "' c_form='" + c_form + "' c_text='" + c_text + "' c_id='" + c_id + "'  id='" + data.id + "' title='" + data.titulo + "' onclick='SelectDocDig(this)'><i class='glyphicon glyphicon-ok'></i> </a></td>";
                html += "<td><a class='btn btn-primary btn-sm' id='" + data.id + "' onclick='openPlantilla(this,0,4,1)'><i class='fa fa-eye'></i> </a></td>";
            } else {
                html += "<td></td>";
                html += "<td></td>";
            }
            html += "</tr>";
        });
        $("#tb_doc_digital").html(html);
        $("#t_doc_digital").dataTable();
    };
    
    Detalle=function(id){
        var dataG=[];
        dataG = {id:id,envio_meta:1};
        Usuario.MostrarTramites(dataG);
        $('#tramiteModal').modal('show');
};

HTMLCargaTramites=function(datos){
    var html ='';
    var alerta_tipo= '';

    $('#form_tramite #t_tramite').dataTable().fnDestroy();
    pos=0;
    

    $.each(datos,function(index,data){
        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2,'+data.id+')" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
        html+="<tr>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.tipo_persona+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+$.trim(data.ult_paso).split(",")[0]+"</td>"+
            "<td>"+data.total_pasos+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a> '+btnruta+'</td>';
        html+="</tr>";
    });

    $("#form_tramite #tb_tramite").html(html);
    $("#form_tramite #t_tramite").dataTable(
                         {
            "order": [[ 0, "asc" ],[1, "asc"]],
            "pageLength": 10,
        }
    );


};

detalle=function(ruta_id, boton){
    $("#btn_close").click();
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";

    $("#form_"+Pest).append("<input type='hidden' id='txt_ruta_id' name='txt_ruta_id' value='"+ruta_id+"'>");
    var datos=$("#form_"+Pest).serialize().split("txt_").join("").split("slct_").join("");
    $("#form_"+Pest+" #txt_ruta_id").remove();
    Tramite.mostrar( datos,HTMLreported,'d' );
};

cargarRutaId=function(ruta_flujo_id,permiso,ruta_id){
    $("#txt_ruta_flujo_id_modal").remove();
    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#txt_titulo").text("Vista");
    $("#texto_fecha_creacion").text("Fecha Vista:");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
    $("#form_ruta_flujo").css("display","");
    Ruta.CargarDetalleRuta(ruta_flujo_id,permiso,CargarDetalleRutaHTML,ruta_id);
};
ActPest=function(nro){
    Pest=nro;
};

HTMLreported=function(datos){
    var html="";
    var alertOk ='success';//verde
    var alertError ='danger';//rojo
    var alertCorregido ='warning';//ambar
    var alerta='';
    var estado_final='';

    $("#t_reported_tab_"+Pest+" tbody").html('');
    $("#t_reported_tab_"+Pest).dataTable().fnDestroy();

    $.each(datos,function(index,data){
        if (data.alerta=='0') alerta=alertOk;
        if (data.alerta=='1') alerta=alertError;
        if (data.alerta=='2') alerta=alertCorregido;

        
        estado_final='Pendiente';
        if(data.dtiempo_final!=''){
            if(data.alerta=='0'){
                estado_final='Concluido';
            }
            else if(data.alerta=='1' && data.alerta_tipo=='1'){
                estado_final='A Destiempo';
            }
            else if(data.alerta=='1' && data.alerta_tipo=='2'){
                estado_final='Lo He Detenido a Destiempo';
            }
            else if(data.alerta=='1' && data.alerta_tipo=='3'){
                estado_final='Lo He Detenido';
            }
            else if(data.alerta=='2'){
                estado_final='Lo He Detenido R.';
            }
        }

        html+="<tr class='"+alerta+"'>"+
                "<td>"+data.norden+"</td>"+
                "<td>"+data.area+"</td>"+
                "<td>"+data.tiempo+': '+data.dtiempo+"</td>"+
                "<td>"+data.fecha_inicio+"</td>"+
                "<td>"+data.dtiempo_final+"</td>"+
                "<td>"+estado_final+"</td>"+
                "<td>"+data.verbo2.split("|").join("<br>")+"</td>"+
                "<td>"+data.ordenv.split("|").join("<br>")+"</td>";
        html+=  "</tr>";

    });

    $("#t_reported_tab_"+Pest+" tbody").html(html);
    $("#t_reported_tab_"+Pest).dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reported_tab_"+Pest).show();
};

CalcularMeses= function(inicio,fin){

  aF1 = inicio.split("-");
  aF2 = fin.split("-");
  var a_f=aF2[0]*1;
  var m_f=aF2[1]*1;
  var a_i=aF1[0]*1;
  var m_i=aF1[1]*1;
  numMeses = a_f*12 + m_f - (a_i*12 + m_i);
  if (aF2[2]<aF1[2]){
    numMeses = numMeses - 1;
  }
 return numMeses;
};
</script>
