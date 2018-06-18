<script type="text/javascript">
temporalBandeja=0;
var areasG=[]; // texto area
var areasGId=[]; // id area
var theadArea=[]; // cabecera area
var tbodyArea=[]; // cuerpo area
var tfootArea=[]; // pie area

var tiempoGId=[]; // id posicion del modal en base a una area.
var tiempoG=[];
var verboG=[];
var posicionDetalleVerboG=0;
var Pest=1;


var tempOpt = 0;

    var preventSubmit0 = function(event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            setTimeout(function(){reportet(1);},100);
            return false;
        }
    }
    var preventSubmit1 = function(event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            setTimeout(function(){reportet(2);},100);
            return false;
        }
    }
    var preventSubmit2 = function(event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            setTimeout(function(){reportep();},100);
            return false;
        }
    }
    var preventSubmit3 = function(event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            setTimeout(function(){reportea();},100);
            return false;
        }
    }

$(document).ready(function(){

    $("#txt_tramite_1").keypress(preventSubmit0);
    $("#txt_tramite_2").keypress(preventSubmit1);
    $("#txt_tramite_3").keypress(preventSubmit2);
    $("#txt_tramite_4").keypress(preventSubmit3);

    $("[data-toggle='offcanvas']").click();
    $('#txt_fecha_2,#txt_fecha_3,#txt_fecha_4').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
        showDropdowns: true
    });
    var data = {estado:1};
    var ids = [];

    $("#btn_close").click(Close);
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_proceso_3','multiple',ids,data);
    slctGlobal.listarSlct('categoria','slct_categoria_3','multiple',ids,data);
    data = {estado:1};
    slctGlobal.listarSlct('area','slct_area_3,#slct_area_4','multiple',ids,data);

    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);

    $("#generar_1").click(function (){
        reportet(1);
    });
    $("#generar_2").click(function (){
        reportet(2);
    });
    $("#generar_3").click(function (){
        reportep();
    });
    $("#generar_4").click(function (){
        reportea();
    });

    $('#rutaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var text = $.trim( button.data('text') );
      var id= $.trim( button.data('id') );
      
      var modal = $(this); //captura el modal
      $("#form_ruta_tiempo #txt_nombre").val(text);
      $("#form_ruta_tiempo").append('<input type="hidden" value="'+id+'" id="txt_area_id_modal">');
      
      var position=tiempoGId.indexOf(id);
      var posicioninicial=areasGId.indexOf(id);
      var tid=0;
      var validapos=0;
      var detalle=""; var detalle2="";

      if(position>=0){
        tid=position;
        detalle=tiempoG[tid][0].split("_");
        detalle[0]=posicioninicial;
        tiempoG[tid][0]=detalle.join("_");

        detalle2=verboG[tid][0].split("_");
        detalle2[0]=posicioninicial;
        verboG[tid][0]=detalle2.join("_");
      }
      else{
        tiempoGId.push(id);
        tiempoG.push([]);
        tid=tiempoG.length-1;
        tiempoG[tid].push(posicioninicial+"__");

        verboG.push([]);
        verboG[tid].push(posicioninicial+"______");
      }

      var posicioninicialf=posicioninicial;
        for(var i=1; i<tbodyArea[posicioninicial].length; i++){
            posicioninicialf++;
            validapos=areasGId.indexOf(id,posicioninicialf);
            posicioninicialf=validapos;
            if( i>=tiempoG[tid].length ){
                tiempoG[tid].push(validapos+"__");
                verboG[tid].push(validapos+"______");
            }
            else{
                detalle=tiempoG[tid][i].split("_");
                detalle[0]=validapos;
                tiempoG[tid][i]=detalle.join("_");

                detalle2=verboG[tid][i].split("_");
                detalle2[0]=validapos;
                verboG[tid][i]=detalle2.join("_");
            }
        }

      pintarTiempoG(tid);

      $("#form_ruta_verbo #txt_nombre").val(text);
      $("#form_ruta_verbo").append('<input type="hidden" value="'+id+'" id="txt_area_id_modal">');
    });

    $('#rutaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#form_ruta_tiempo input[type='hidden']").remove();
      $("#form_ruta_verbo input[type='hidden']").remove();
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

ActPest=function(nro){
    Pest=nro;
}

valida=function(nro){
    var r=true;
    if( nro==1 ){
        if( $.trim( $("#txt_tramite_1").val() )=='' ){
            alert('Ingrese Trámite a buscar');
            $("#txt_tramite_1").focus();
            r=false;
        }
    }
    else if( nro==2 ){
        if( $.trim( $("#txt_fecha_2").val() )=='' ){
            alert('Seleccione fechas');
            $("#txt_fecha_2").focus();
            r=false;
        }
    }
    else if( nro==3 ){
        if( $.trim( $("#txt_fecha_3").val() )=='' ){
            alert('Seleccione fechas');
            $("#txt_fecha_3").focus();
            r=false;
        }
    }
    else if( nro==4 ){
    }
    return r;
}

reportet=function(tab){
        $("#btn_close").click();
    if( valida(tab) ){
        var datos=$("#form_"+tab).serialize().split("txt_").join("").split("slct_").join("");
        Tramite.mostrar( datos,HTMLreportet,'t' );
        $("#reported_tab_"+Pest).hide();
    }
}

reportep=function(){
        $("#btn_close").click();
    if( valida(3) ){
        var datos=$("#form_3").serialize().split("txt_").join("").split("slct_").join("");
        Tramite.mostrar( datos,HTMLreportep,'p' );
        $("#reportet_tab_"+Pest+",#reported_tab_"+Pest).hide();
    }
}

reportea=function(){
        $("#btn_close").click();
    if( valida(4) ){
        var datos=$("#form_4").serialize().split("txt_").join("").split("slct_").join("");
        Tramite.mostrar( datos,HTMLreportetp,'tp' );
        $("#reportet_tab_"+Pest+",#reported_tab_"+Pest).hide();
    }
}

HTMLreportep=function(datos){
    var html="";
    $("#t_reportep_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reportep_tab_"+Pest+" tbody").html('');
    /*******************DETALLE****************************/
    $("#t_reportet_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reported_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reportet_tab_"+Pest+" tbody").html('');
    $("#t_reported_tab_"+Pest+" tbody").html('');
    /******************************************************/

    $.each(datos,function(index,data){

        html+="<tr>"+
            "<td>"+data.proceso+"</td>"+
            "<td>"+data.duenio+"</td>"+
            "<td>"+data.area_duenio+"</td>"+
            "<td>"+data.n_areas+"</td>"+
            "<td>"+data.n_pasos+"</td>"+
            "<td>"+data.tiempo+"</td>"+
            "<td>"+data.fecha_creacion+"</td>";

        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2)" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';

            if(data.estado_final==1){
        html+="<td>"+data.fecha_produccion+"</td>";
        html+="<td>"+data.ntramites+"</td>";
        html+="<td>"+data.inconclusos+"</td>";
        html+="<td>"+data.concluidos+"</td>";
        html+='<td><a onClick="detalletra('+data.ruta_flujo_id+',this)" class="btn btn-primary btn-sm"><i class="fa fa-search fa-lg"></i> </a>'+btnruta+'</td>';
            }
            else{
        html+="<td>&nbsp;</td>";
        html+="<td>0</td>";
        html+="<td>0</td>";
        html+="<td>0</td>";
        html+="<td>&nbsp;"+btnruta+"</td>";
            }

        html+="</tr>";
    });
    $("#t_reportep_tab_"+Pest+" tbody").html(html);
    $("#t_reportep_tab_"+Pest).dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reportep_tab_"+Pest).show();
};

detalletra=function(ruta_flujo_id, boton){
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";

    $("#form_"+Pest).append("<input type='hidden' id='txt_ruta_flujo_id' name='txt_ruta_flujo_id' value='"+ruta_flujo_id+"'>");
    var datos=$("#form_"+Pest).serialize().split("txt_").join("").split("slct_").join("");
    $("#form_"+Pest+" #txt_ruta_flujo_id").remove();
    
    Tramite.mostrar( datos,HTMLreportet,'t' );
    $("#reported_tab_"+Pest).hide();
}

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

HTMLreportet=function(datos){
    var btnruta='';
    var html="";
    
    $("#t_reportet_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reportet_tab_"+Pest+" tbody").html('');
    /*******************DETALLE****************************/
    $("#t_reported_tab_"+Pest).dataTable().fnDestroy();
    $("#t_reported_tab_"+Pest+" tbody").html('');
    /******************************************************/

    $.each(datos,function(index,data){

        var paso_area = $.trim(data.ult_paso).split(",")[0];
        
        if($.trim(paso_area) == '') {
            var paso = '';
            var area = '';
        } else {
            var paso = $.trim(paso_area).split("-")[0];
            var area = $.trim(paso_area).split("-")[1];
        }

        btnruta='<a onclick="cargarRutaId('+data.ruta_flujo_id+',2,'+data.id+')" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>';
        html+="<tr>"+
            "<td>"+data.tramite+"</td>"+
            "<td>"+data.tipo_persona+"</td>"+
            "<td>"+data.persona+"</td>"+
            "<td>"+data.sumilla+"</td>"+
            "<td>"+data.estado+"</td>"+
            "<td>"+paso+"</td>"+
            "<td>"+area+"</td>"+
            //"<td>"+data.total_pasos+"</td>"+
            "<td>"+data.fecha_inicio+"</td>"+
            "<td>"+data.ok+"</td>"+
            "<td>"+data.error+"</td>"+
            "<td>"+data.corregido+"</td>"+
            '<td><a onClick="detalle('+data.id+',this)" class="btn btn-primary btn-sm" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-search fa-lg"></i> </a> '+btnruta+'</td>';
        html+="</tr>";
    });

    $("#t_reportet_tab_"+Pest+" tbody").html(html);
    $("#t_reportet_tab_"+Pest).DataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reportet_tab_"+Pest).show();
};

HTMLreportetp=function(datos){
    var btnruta='';
    var html="";
    var colspan="";

    if( $("#t_reportetp_tab_"+Pest+" tbody>tr").length>0 ){
        $("#t_reportetp_tab_"+Pest).dataTable().fnDestroy();
    }
    $("#t_reportetp_tab_"+Pest+" tbody").html('');
    $("#t_reportetp_tab_"+Pest+" thead>tr .Eliminar").remove();

    if( datos[2]!='' ){
        $("#t_reportetp_tab_"+Pest+" thead>tr:eq(0)").append('<th class="Eliminar">&nbsp;</th>');
        $("#t_reportetp_tab_"+Pest+" thead>tr:eq(1)").append('<th class="Eliminar">Procesos de las<br>Áreas dueñas</th>');
    }

    $("#t_reportetp_tab_"+Pest+" thead>tr:eq(1)").append('<th class="Eliminar">Total Pend vs<br> Total Inconc</th>');
    $("#t_reportetp_tab_"+Pest+" thead>tr:eq(0)").append('<th colspan="'+datos[0].length+'" style="text-align:center !important;" class="Eliminar">Áreas Dueñas de los Procesos </th>');
    carga=1;color='';datounico='';ocultar='';

    $.each(datos[1],function(i,d){
        color='black';
        area=d['area'];
            if( area+d['proceso']!=datounico ){
                datounico=area+d['proceso'];
                ocultar='';
            }
            else if( area+d['proceso']==datounico && datos[1].length-1==i ){
                ocultar='';
            }
            else{
                datounico=area+d['proceso'];
                ocultar=' style="display:none"';
            }

            if( d['total_in']*1>0 ){
                color='red';
            }
            
        html+="<tr "+ocultar+">";
            if( datos[1].length-1==i ){
                if( datos[2]!='' ){
                html+="<td>&nbsp;</td>";
                }
                html+="<td><b>Totales:</b></td>";
            }
            else{
                html+="<td>"+area+"</td>";
                if( datos[2]!='' ){
                    html+="<td>"+d['proceso']+"</td>";
                }
            }
            
        html+="<td>'"+d['total']+"/<font color="+color+">"+d['total_in']+"</font></td>";
        
        $.each(datos[0],function(i2,d2){
            if( carga==1 ){
                $("#t_reportetp_tab_"+Pest+" thead>tr:eq(1)").append('<th class="Eliminar">'+d2.split("|")[1]+'</th>');
            }
                color='black';
                if( d['area_id_'+d2.split("|")[0]+'_in']*1>0 ){
                    color='red';
                }
            html+="<td>'"+d['area_id_'+d2.split("|")[0]]+"/<font color="+color+">"+d['area_id_'+d2.split("|")[0]+'_in']+"</font></td>";
        });
        carga++;
        html+="</tr>";
    });

    $("#t_reportetp_tab_"+Pest+" tbody").html(html);
    $("#t_reportetp_tab_"+Pest).dataTable({
            "scrollY": "400px",
            "scrollCollapse": true,
            "scrollX": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "visible": false,
    });
    $("#reportetp_tab_"+Pest).show();
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

        var archiv = '';
        if($.trim(data.archivo) != '') {

            var data_fotos = $.trim(data.archivo).split("|");
            $.each(data_fotos, function (index, d_foto) {
                if (d_foto.length != 0) {
                    var cant_foto = d_foto.length;

                    if(d_foto.substring((cant_foto-3), cant_foto) == 'png' || 
                        d_foto.substring((cant_foto-3), cant_foto) == 'jpg' ||
                        d_foto.substring((cant_foto-3), cant_foto) == 'gif' ||
                        d_foto.substring((cant_foto-4), cant_foto) == 'jpeg' )
                        foto = d_foto;
                    else
                        foto = 'img/admin/ruta_detalle/marca_doc.jpg';
                    
                    archiv += '<a href="'+foto+'" target="_blank"><img src="'+foto+'" alt="" border="0" height="50" width="60" class="img-responsive foto_desmonte"></a>';
                }
            });
        }            
        else
            archiv = '';

        html+="<tr class='"+alerta+"'>"+
                "<td>"+data.norden+"</td>"+
                "<td>"+data.area+"</td>"+
                "<td>"+data.tiempo+': '+data.dtiempo+"</td>"+
                "<td>"+data.fecha_inicio+"</td>"+
                "<td>"+data.dtiempo_final+"</td>"+
                "<td>"+estado_final+"</td>"+
                "<td>"+archiv+"</td>"+
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
}

eventoSlctGlobalSimple=function(slct,valores){
};
////////////////////// Agregando para el mostrar detalle
pintarTiempoG=function(tid){
    var htm="";var detalle="";var detalle2="";
    $("#tb_tiempo").html(htm);
    $("#tb_verbo").html(htm);

    posicionDetalleVerboG=0; // Inicializando posicion del detalle al pintar

    var subdetalle1="";var subdetalle2="";var subdetalle3="";var subdetalle4="";var subdetalle5="";var subdetalle6="";var imagen="";

    for(var i=0;i<tiempoG[tid].length;i++){
        // tiempo //
        detalle=tiempoG[tid][i].split("_");

        htm=   '<tr>'+
                    '<td>'+(detalle[0]*1+1)+'</td>'+
                    '<td>'+
                        '<select disabled class="form-control" id="slct_tipo_tiempo_'+detalle[0]+'_modal">'+
                            $('#slct_tipo_tiempo_modal').html()+
                        '</select>'+
                    '</td>'+
                    '<td>'+
                        '<input readonly class="form-control" type="number" id="txt_tiempo_'+detalle[0]+'_modal" value="'+detalle[2]+'">'+
                    '</td>'+
                '</tr>';
        $("#tb_tiempo").append(htm);

        $('#slct_tipo_tiempo_'+detalle[0]+'_modal').val(detalle[1]);
        //fin tiempo

        //verbo
        
        detalle2=verboG[tid][i].split("_");

        subdetalle1=detalle2[1].split('|');
        subdetalle2=detalle2[2].split('|');
        subdetalle3=detalle2[3].split('|');
        subdetalle4=detalle2[4].split('|');
        subdetalle5=detalle2[5].split('|');
        subdetalle6=detalle2[6].split('|');

        selectestado='';
        for(var j=0; j<subdetalle1.length; j++){
            posicionDetalleVerboG++;
            imagen="";
            
            
            if( (j+1)==subdetalle1.length ){
                selectestado='<br><select disabled id="slct_paralelo_'+detalle2[0]+'_modal">'+
                             '<option value="1">Normal</option>'+
                             '<option value="2">Paralelo</option>'+
                             '</select>';
            }

            htm=   '<tr id="tr_detalle_verbo_'+posicionDetalleVerboG+'">'+
                        '<td>'+(detalle2[0]*1+1)+selectestado+'</td>'+
                        '<td>'+
                            '<input readonly type="number" class="form-control txt_orden_'+detalle2[0]+'_modal" placeholder="Ing. Orden" value="'+subdetalle6[j]+'">'+
                        '</td>'+
                        '<td>'+
                            '<select disabled class="form-control slct_rol_'+detalle2[0]+'_modal">'+
                                $('#slct_rol_modal').html()+
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<select disabled class="form-control slct_verbo_'+detalle2[0]+'_modal">'+
                                $('#slct_verbo_modal').html()+
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<select disabled class="form-control slct_documento_'+detalle2[0]+'_modal">'+
                                $('#slct_documento_modal').html()+
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<textarea disabled class="form-control txt_verbo_'+detalle2[0]+'_modal" placeholder="Ing. Acción">'+subdetalle1[j]+'</textarea>'+
                        '</td>'+
                        '<td>'+
                            '<select disabled class="form-control slct_condicion_'+detalle2[0]+'_modal">'+
                                $('#slct_condicion_modal').html()+
                            '</select>'+
                        '</td>'+
                        '<td>'+imagen+'</td>'+
                    '</tr>';
            $("#tb_verbo").append(htm);

            if( (j+1)==subdetalle1.length ){
                $("#slct_paralelo_"+detalle2[0]+"_modal").val(estadoG[detalle2[0]]);
            }

            if(subdetalle2[j]==""){ // En caso no tenga valores se inicializa
                subdetalle2[j]="0";
            }
            //alert(subdetalle2[j]);
            $(".slct_condicion_"+detalle2[0]+"_modal:eq("+j+")").val(subdetalle2[j]);
            $(".slct_rol_"+detalle2[0]+"_modal:eq("+j+")").val(subdetalle3[j]);
            $(".slct_verbo_"+detalle2[0]+"_modal:eq("+j+")").val(subdetalle4[j]);
            $(".slct_documento_"+detalle2[0]+"_modal:eq("+j+")").val(subdetalle5[j]);
        }
        //fin verbo
    }
}

pintarAreasG=function(permiso){
    var htm=''; var click=""; var imagen=""; var clickeli="";
    $("#areasasignacion .eliminadetalleg").remove();
    $("#slct_area_id_2").val("");$("#slct_area_id_2").multiselect("refresh");
    $("#slct_area_id_2").multiselect("disable");

    if(permiso!=2){
        $("#slct_area_id_2").multiselect("enable");
    }

    for ( var i=0; i<areasG.length; i++ ) {
        click="";
        imagen="";
        clickeli="";
        if(permiso!=2){
            clickeli=" onclick='EliminarDetalle("+i+");' ";
        }

        if ( i>0 ) {
            if(permiso!=2){
                click=" onclick='CambiarDetalle("+i+");' ";
            }
            imagen="<i class='fa fa-sort-up fa-sm'></i>";
        }

        htm+=   "<tr id='tr-detalle-"+i+"'>"+
                    "<td>"+
                        (i+1)+
                    "</td>"+
                    "<td>"+
                        areasG[i]+
                    "</td>"+
                "</tr>";


        if(theadArea[i]!=0){

            $("#areasasignacion>thead>tr.head").append(theadArea[i]);
            $("#areasasignacion>tfoot>tr.head").append(tfootArea[i]);

            var detbody='<td class="eliminadetalleg">'+
                            '<table class="table table-bordered">';
            for(j=0; j<tbodyArea[i].length ; j++){
                if(j>0){
                    detbody+=   '<tr>'+
                                    '<td style="height:8px;">&nbsp;'+
                                    '</td>'+
                                '</tr>';
                }
                detbody+=tbodyArea[i][j];
            }
            detbody+='</table> </td>';
            $("#areasasignacion>tbody>tr.body").append(detbody);
        }
        
    };

    $("#areasasignacion>thead>tr.head").append('<th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>'); // aqui para darle el area global

    $("#tb_rutaflujodetalleAreas").html(htm);
}

Close=function(){
    $("#form_ruta_flujo").css("display","none");
}

adicionarRutaDetalleAutomatico=function(valorText,valor,tiempo,verbo,imagen,imagenc,imagenp,estruta){
    valor=""+valor;
    var adjunta=false; var position=areasGId.indexOf(valor);
    if( position>=0 ){
        adjunta=true;
    }

    var verboaux=verbo.split("|");
    var verbo1=[];
    var verbo2=[];
    var verbo3=[];
    var verbo4=[];
    var verbo5=[];
    var verbo6=[];
    var imgfinal=imagen;
    for(i=0;i<verboaux.length;i++ ){
        verbo1.push(verboaux[i].split("^^")[0]);
        verbo2.push(verboaux[i].split("^^")[1]);
        verbo3.push(verboaux[i].split("^^")[2]);
        verbo4.push(verboaux[i].split("^^")[3]);
        verbo5.push(verboaux[i].split("^^")[4]);
        verbo6.push(verboaux[i].split("^^")[5]);

        if($.trim(verboaux[i].split("^^")[1])>0){
            imgfinal=imagenc;
        }
    }

    if(estruta>1){
        imgfinal=imagenp;
    }

    estadoG.push(estruta);
    areasG.push(valorText);
    areasGId.push(valor);

    if( adjunta==false ){
        head='<th class="eliminadetalleg" style="width:110px;min-width:100px !important;">'+valorText+'</th>';
        theadArea.push(head);

        body=   '<tr>'+
                    '<td class="areafinal" onclick="AbreTv('+valor+');" style="height:100px; background-image: url('+"'"+'img/admin/area/'+imgfinal+"'"+');">&nbsp;'+
                    '<span class="badge bg-yellow">'+areasG.length+'</span>'+
                    '</td>'+
                '</tr>';
        tbodyArea.push([]);
        tbodyArea[ (tbodyArea.length-1) ].push(body);

        foot=   '<th class="eliminadetalleg">'+
                    '<div style="text-align:center;">'+
                    '<a class="btn bg-olive btn-sm" data-toggle="modal" data-target="#rutaModal" data-id="'+valor+'" data-text="'+valorText+'">'+
                        '<i class="fa fa-desktop fa-lg"></i>'+
                    '</a>'+
                    '</div>'+
                '</th>';
        tfootArea.push(foot);
    }
    else{

        theadArea.push(0);
        tfootArea.push(0);
        tbodyArea.push([]);
        tbodyArea[ (tbodyArea.length-1) ].push(position+"|"+tbodyArea[position].length );
        body=   '<tr>'+
                    '<td class="areafinal" onclick="AbreTv('+valor+');" style="height:100px; background-image: url('+"'"+'img/admin/area/'+imgfinal+"'"+');">&nbsp;'+
                    '<span class="badge bg-yellow">'+areasG.length+'</span>'+
                    '</td>'+
                '</tr>';
        tbodyArea[position].push(body);

    }

      var position=tiempoGId.indexOf(valor);
      var posicioninicial=areasGId.indexOf(valor);
      var tid=0;
      var validapos=0;
      var detalle=""; var detalle2="";
      
      if(position>=0){
        tid=position;
      }

    if( tiempo!='_' || verbo!='' ){
        if( adjunta==false ){ // primer registro
            tiempoGId.push(valor);
            tiempoG.push([]);
            tid=tiempoG.length-1;
            tiempoG[tid].push(posicioninicial+"_"+tiempo);

            verboG.push([]);
            verboG[tid].push(posicioninicial+"_"+verbo1.join("|")+"_"+verbo2.join("|")+"_"+verbo3.join("|")+"_"+verbo4.join("|")+"_"+verbo5.join("|")+"_"+verbo6.join("|"));
        }
      //}
        else{
            var posicioninicialf=posicioninicial;
            for(var i=1; i<tbodyArea[posicioninicial].length; i++){
                posicioninicialf++;
                validapos=areasGId.indexOf(valor,posicioninicialf);
                posicioninicialf=validapos;
                if( i>=tiempoG[tid].length ){
                    tiempoG[tid].push(validapos+"_"+tiempo);
                    verboG[tid].push(validapos+"_"+verbo1.join("|")+"_"+verbo2.join("|")+"_"+verbo3.join("|")+"_"+verbo4.join("|")+"_"+verbo5.join("|")+"_"+verbo6.join("|"));
                }
            }
        }
    }
}

cargarRutaId=function(ruta_flujo_id,permiso,ruta_id){
    $("#txt_ruta_flujo_id_modal").remove();
    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#txt_titulo").text("Vista");
    $("#texto_fecha_creacion").text("Fecha Vista:");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
    $("#form_ruta_flujo").css("display","");
    Ruta.CargarDetalleRuta(ruta_flujo_id,permiso,CargarDetalleRutaHTML,ruta_id);
}

CargarDetalleRutaHTML=function(permiso,datos){
    areasG="";  areasG=[]; // texto area
    areasGId="";  areasGId=[]; // id area
    estadoG="";  estadoG=[]; // Normal / Paralelo
    theadArea="";  theadArea=[]; // cabecera area
    tbodyArea="";  tbodyArea=[]; // cuerpo area
    tfootArea="";  tfootArea=[]; // pie area

    tiempoGId="";  tiempoGId=[]; // id posicion del modal en base a una area.
    tiempoG="";  tiempoG=[];
    verboG="";  verboG=[];
    posicionDetalleVerboG=0;
    validandoconteo=0;
    $.each(datos,function(index,data){
        validandoconteo++;
        if(validandoconteo==1){
            $("#txt_persona").val(data.persona);
            $("#txt_proceso").val(data.flujo);
            $("#txt_area").val(data.area);
        }
        adicionarRutaDetalleAutomatico(data.area2,data.area_id2,data.tiempo_id+"_"+data.dtiempo,data.verbo,data.imagen,data.imagenc,data.imagenp,data.estado_ruta);
    });
    pintarAreasG(permiso);
}

AbreTv=function(val){
    $("#areasasignacion [data-id='"+val+"']").click();
}
</script>
