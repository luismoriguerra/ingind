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

var fechaAux="";
$(document).ready(function() {
    //$("[data-toggle='offcanvas']").click();
    $("#btn_close2").click(Close);
    $("#btn_guardar_tiempo,#btn_guardar_verbo").remove();
    var data = {estado:1,usuario:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo2_id','simple',ids,data);
    data = {estado:1}
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);

    slctGlobal.listarSlct('ruta_detalle','slct_area2_id','simple');
    slctGlobalHtml('slct_tipo_respuesta,#slct_tipo_respuesta_detalle','simple');
    
    $("#btn_close").click(cerrar);
    $("#btn_guardar_todo").click(guardarTodo);
    $("#btn_buscar").click(buscar);
    hora();

    $('#rutaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var text = $.trim( button.data('text') );
      var id= $.trim( button.data('id') );
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      $("#form_ruta_tiempo #txt_nombre").val(text);
      $("#form_ruta_tiempo").append('<input type="hidden" value="'+id+'" id="txt_area_id_modal">');
      /*alert(id);
      for(i=0; i<areasGId.length; i++){
        alert(areasGId[i]+"=="+id);
        if(areasGId[i]==id){
            alert("encontrado "+areasGId[i]);
        }
      }*/
      var position=tiempoGId.indexOf(id);
      var posicioninicial=areasGId.indexOf(id);
      //alert("tiempo= "+position +" | areapos="+posicioninicial);
      var tid=0;
      var validapos=0;
      var detalle=""; var detalle2="";

      if(position>=0){
        tid=position;
        //alert("actualizando");
        detalle=tiempoG[tid][0].split("_");
        detalle[0]=posicioninicial;
        tiempoG[tid][0]=detalle.join("_");

        detalle2=verboG[tid][0].split("_");
        detalle2[0]=posicioninicial;
        verboG[tid][0]=detalle2.join("_");
      }
      else{
        //alert("registrando");
        tiempoGId.push(id);
        tiempoG.push([]);
        tid=tiempoG.length-1;
        tiempoG[tid].push(posicioninicial+"__");

        verboG.push([]);
        verboG[tid].push(posicioninicial+"__");
      }

      var posicioninicialf=posicioninicial;
        for(var i=1; i<tbodyArea[posicioninicial].length; i++){
            posicioninicialf++;
            validapos=areasGId.indexOf(id,posicioninicialf);
            posicioninicialf=validapos;
            if( i>=tiempoG[tid].length ){
                tiempoG[tid].push(validapos+"__");

                verboG[tid].push(validapos+"__");
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
    //$("#btn_guardar_todo").click(guardarTodo);
    //$("#areasasignacion").DataTable();
});

hora=function(){
var fecha = new Date()
var anio = fecha.getFullYear()
var mes = fecha.getMonth()
var dia = fecha.getDate()
var hora = fecha.getHours()
var minuto = fecha.getMinutes()
var segundo = fecha.getSeconds()

if (dia < 10) {dia = "0" + dia}
if (mes < 9) {mes = "0" + (mes*1+1)}
if (hora < 10) {hora = "0" + hora}
if (minuto < 10) {minuto = "0" + minuto}
if (segundo < 10) {segundo = "0" + segundo}
var horita = anio+"-"+mes+"-"+dia+" "+hora + ":" + minuto + ":" + segundo;
$("#txt_respuesta").val(horita);
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
tiempo = setTimeout('hora()',1000);
}

validacheck=function(val,idcheck){
    var verboaux="";
    var validacheck=0;
    $("#slct_tipo_respuesta,#slct_tipo_respuesta_detalle").multiselect("enable");
    $("#txt_observacion").removeAttr("disabled");

    $(".check1,.check2").removeAttr("disabled");
    if( val==1 && $("#"+idcheck).is(':checked') ){
        $(".check2").removeAttr("checked");
        $(".check2").attr("disabled","true");
    }
    else if( val==2 && $("#"+idcheck).is(':checked') ){
        $(".check1").removeAttr("checked");
        $(".check1").attr("disabled","true");
    }

    $("#t_detalle_verbo input[type='checkbox']").each(
        function( index ) { 
            if ( $(this).is(':checked') ) {
                verboaux+= "|"+$(this).val();
            }
            else if( !$(this).attr("disabled") ){
                validacheck=1;
            }
        }
    );

    if(validacheck==1){
        $("#slct_tipo_respuesta,#slct_tipo_respuesta_detalle").multiselect("disable");
        $("#txt_observacion").attr("disabled","true");
    }
}

cerrar=function(){
    $("#form_ruta_detalle .form-group").css("display","none");
    $("#form_ruta_detalle input[type='text'],#form_ruta_detalle textarea,#form_ruta_detalle select").val("");
    $('#form_ruta_detalle select').multiselect('refresh');
    $("#form_ruta_detalle t_detalle_verbo").html("");
}

buscar=function(){
    if( $("#txt_tramite").val()!="" ){
     var datos={ tramite:$("#txt_tramite").val() };
    $("#tabla_ruta_detalle").css("display","");
    Validar.mostrarRutaDetalle(datos,mostrarRutaDetalleHTML);
    }
    else{
        alert("Ingrese Nro Trámite y busque nuevamente");
    }
}

mostrarRutaFlujo=function(){
    /*$("#form_ruta_detalle>.form-group").css("display","none");
    var flujo_id=$.trim($("#slct_flujo2_id").val());
    var area_id=$.trim($("#slct_area2_id").val());

    if( flujo_id!='' && area_id!='' ){
        var datos={ flujo_id:flujo_id,area_id:area_id };
        $("#tabla_ruta_detalle").css("display","");
        Validar.mostrarRutaDetalle(datos,mostrarRutaDetalleHTML);
    }*/
}

mostrarRutaDetalleHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
    var color="";
    var clase="";
     $('#t_ruta_detalle').dataTable().fnDestroy();
     $("#txt_ruta_detalle_id").remove();
    $.each(datos,function(index,data){
        imagen="";
        clase="";
        cont++;
        if($.trim(data.fecha_inicio)!=''){
            imagen="<a onClick='mostrarDetallle("+data.id+")' class='btn btn-primary btn-sm'><i class='fa fa-edit fa-lg'></i></a>";
        }
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.id_doc+"</td>"+
        "<td>"+data.norden+"</td>"+
        "<td><ul><li>"+data.verbo2.split("|").join("</li><li>")+"</li></ul></td>"+
        "<td>"+data.fecha_inicio+"</td>"+
        "<td>"+data.fecha_max+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+imagen+
            '<a onclick="cargarRutaId('+data.ruta_flujo_id+',2)" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>'+
        "</td>";
    html+="</tr>";

    });
    $("#tb_ruta_detalle").html(html); 
    $('#t_ruta_detalle').dataTable({
        "ordering": false
    });
}

mostrarDetallle=function(id){
    $("#form_ruta_detalle>.form-group").css("display","");
    $("#form_ruta_detalle>#ruta_detalle_id").remove();
    $("#form_ruta_detalle").append("<input type='hidden' id='ruta_detalle_id' name='ruta_detalle_id' value='"+id+"'>");
    var datos={ruta_detalle_id:id}
    Validar.mostrarDetalle(datos,mostrarDetalleHTML);
}

mostrarDetalleHTML=function(datos){
    fechaAux="";
    var data={ flujo_id:datos.flujo_id, estado:1,fecha_inicio:datos.fecha_inicio }
    var ids = [];
    $('#slct_tipo_respuesta,#slct_tipo_respuesta_detalle').multiselect('destroy');
    $('#slct_tipo_respuesta,#slct_tipo_respuesta_detalle').attr('disabled',"true");
    slctGlobal.listarSlct('tiporespuesta','slct_tipo_respuesta','simple',ids,data,0,'#slct_tipo_respuesta_detalle','TR');
    slctGlobal.listarSlct('tiporespuestadetalle','slct_tipo_respuesta_detalle','simple',ids,data,1);
    
    $("#form_ruta_detalle #txt_flujo").val(datos.flujo);
    $("#form_ruta_detalle #txt_area").val(datos.area);
    $("#form_ruta_detalle #txt_id_doc").val(datos.id_doc);
    $("#form_ruta_detalle #txt_orden").val(datos.norden);
    $("#form_ruta_detalle #txt_fecha_inicio").val(datos.fecha_inicio);
    $("#form_ruta_detalle #txt_tiempo").val(datos.tiempo);

    $("#form_ruta_detalle>#txt_fecha_max").remove();
    $("#form_ruta_detalle").append("<input type='hidden' id='txt_fecha_max' name='txt_fecha_max' value='"+datos.fecha_max+"'>");

    $("#t_detalle_verbo").html("");
    var detalle="";
    var html="";
    var imagen="";
    var obs="";
    var cod="";
        if ( datos.verbo!='' ) {
            detalle=datos.verbo.split("|");
            html="";
            for (var i = 0; i < detalle.length; i++) {

                imagen = "<i class='fa fa-check fa-lg'></i>";
                cod = detalle[i].split("=>")[4];
                obs = detalle[i].split("=>")[5];
                if(detalle[i].split("=>")[2]=="Pendiente"){
                    if(detalle[i].split("=>")[3]=="NO"){
                        valorenviado=0;
                    }
                    else if(detalle[i].split("=>")[3]=="+1"){
                        valorenviado=1;
                    }
                    else if(detalle[i].split("=>")[3]=="+2"){
                        valorenviado=2;
                    }
                    cod = "<textarea class='txt"+valorenviado+"' name='txt_"+detalle[i].split("=>")[0]+"' id='txt_"+detalle[i].split("=>")[0]+"'></textarea>";
                    obs = "<textarea data-pos='"+(i*1+1)+"' class='area"+valorenviado+"' name='area_"+detalle[i].split("=>")[0]+"' id='area_"+detalle[i].split("=>")[0]+"'></textarea>";
                    imagen="<input type='checkbox' class='check"+valorenviado+"' onChange='validacheck("+valorenviado+",this.id);' value='"+detalle[i].split("=>")[0]+"' name='chk_verbo_"+detalle[i].split("=>")[0]+"' id='chk_verbo_"+detalle[i].split("=>")[0]+"'>";
                }

                html+=  "<tr>"+
                            "<td>"+(i*1+1)+"</td>"+
                            "<td>"+detalle[i].split("=>")[3]+"</td>"+
                            "<td>"+detalle[i].split("=>")[1]+"</td>"+
                            "<td>"+cod+"</td>"+
                            "<td>"+obs+"</td>"+
                            "<td>"+imagen+"</td>"+
                        "</tr>";
            }
            $("#t_detalle_verbo").html(html);
        }

}

guardarTodo=function(){
    var verboaux="";
    var codaux="";
    var obsaux="";
    var contcheck=0;
    var conttotalcheck=0;
    var alerta=false;
    $("#t_detalle_verbo input[type='checkbox']").each(
        function( index ) { 
            if ( $(this).is(':checked') && alerta==false ) {
                verboaux+= "|"+$(this).val();
                codaux+="|"+$("#txt_"+$(this).val()).val();
                obsaux+="|"+$("#area_"+$(this).val()).val();
                contcheck++;

                if( $("#area_"+$(this).val()).val()=="" ){
                    alert("Ingrese su observación de la acción "+$("#area_"+$(this).val()).attr("data-pos"));
                    alerta=true;
                }
            }
            conttotalcheck++;
        }
    );

    if(conttotalcheck>0){
        verboaux=verboaux.substr(1);
        $("#form_ruta_detalle>#verbog").remove();
        $("#form_ruta_detalle").append("<input type='hidden' id='verbog' name='verbog' value='"+verboaux+"'>");
        codaux=codaux.substr(1);
        $("#form_ruta_detalle>#codg").remove();
        $("#form_ruta_detalle").append("<input type='hidden' id='codg' name='codg' value='"+codaux+"'>");
        obsaux=obsaux.substr(1);
        $("#form_ruta_detalle>#obsg").remove();
        $("#form_ruta_detalle").append("<input type='hidden' id='obsg' name='obsg' value='"+obsaux+"'>");
    }

    if( conttotalcheck>0 && contcheck==0 && alerta==false ) {
            alert("Seleccione al menos 1 check");
    }
    else if ( !$("#slct_tipo_respuesta").attr("disabled") && $("#slct_tipo_respuesta").val()=='' && alerta==false ) {
        alert("Seleccione Tipo de Respuesta");
    }
    else if ( !$("#slct_tipo_respuesta_detalle").attr("disabled") && $("#slct_tipo_respuesta_detalle").val()=='' && alerta==false ) {
        alert("Seleccione Detalle Tipo Respuesta");
    }
    else if ( !$("#txt_observacion").attr("disabled") && $("#txt_observacion").val()=='' && alerta==false ) {
        alert("Ingrese observacion del paso");
    }
    else if( alerta==false ){
        if( confirm("Favor de confirmar para actualizar su información") ){
            Validar.guardarValidacion(buscar);
        }
    }
    /*if( $.trim($("#txt_codigo").val())==''){
        alert("Busque y seleccione un código");
    }
    else if( $("#slct_flujo_id").val()=='' ){
        alert("Seleccione un Tipo Flujo");
    }
    else if( $("#slct_area_id").val()=='' ){
        alert("Seleccione una Area");
    }
    else if( !$("#txt_ruta_flujo_id").val() || $("#txt_ruta_flujo_id").val()=='' ){
        alert("Seleccione una combinacion donde almeno exita 1 registro");
    }
    else{
        if ( confirm("Favor de confirmar para registrar") ){
            Validar.guardarAsignacion();
        }
    }*/
}

eventoSlctGlobalSimple=function(slct,valores){
    if( slct=="slct_tipo_respuesta" ){
        var detval=valores.split("|").join("").split("_");
        fechaAux="";
        if ( detval[1]==1 ) {
        fechaAux=detval[2];
        }
    }
    else if( slct=="slct_flujo2_id" ){
        var valor=valores.split('|').join("");
        $("#slct_area2_id").val(valor);
        $("#slct_area2_id").multiselect('refresh');

        var flujo_id=$.trim($("#slct_flujo2_id").val());
        var area_id=$.trim($("#slct_area2_id").val());

        if( flujo_id!='' && area_id!='' ){
            var datos={ flujo_id:flujo_id,area_id:area_id };
            $("#tabla_ruta_detalle").css("display","");
            Validar.mostrarRutaDetalle(datos,mostrarRutaDetalleHTML);
        }
    }
}

////////////////////// Agregando para el mostrar detalle
pintarTiempoG=function(tid){
    var htm="";var detalle="";var detalle2="";
    $("#tb_tiempo").html(htm);
    $("#tb_verbo").html(htm);

    posicionDetalleVerboG=0; // Inicializando posicion del detalle al pintar

    var subdetalle2="";var subdetalle3="";var imagen="";

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
                        '<input disabled class="form-control" type="number" id="txt_tiempo_'+detalle[0]+'_modal" value="'+detalle[2]+'">'+
                    '</td>'+
                '</tr>';
        $("#tb_tiempo").append(htm);

        $('#slct_tipo_tiempo_'+detalle[0]+'_modal').val(detalle[1]);
        //fin tiempo

        //verbo
        
        detalle2=verboG[tid][i].split("_");

        subdetalle2=detalle2[1].split('|');
        subdetalle3=detalle2[2].split('|');

        for(var j=0; j<subdetalle2.length; j++){
            posicionDetalleVerboG++;
            imagen="";
            if(subdetalle2.length>1){
                imagen='';
            }
            
            if( (j+1)==subdetalle2.length ){
                imagen='';
            }

            htm=   '<tr id="tr_detalle_verbo_'+posicionDetalleVerboG+'">'+
                        '<td>'+(detalle2[0]*1+1)+'</td>'+
                        '<td>'+
                            '<textarea disabled class="form-control txt_verbo_'+detalle2[0]+'_modal" placeholder="Ing. Verbo" type="text">'+subdetalle2[j]+'</textarea>'+
                        '</td>'+
                        '<td>'+
                            '<select disabled class="form-control slct_condicion_'+detalle2[0]+'_modal">'+
                                $('#slct_condicion_modal').html()+
                            '</select>'+
                        '</td>'+
                        '<td>'+imagen+'</td>'+
                    '</tr>';
            $("#tb_verbo").append(htm);

            if(subdetalle3[j]==""){ // En caso no tenga valores se inicializa
                subdetalle3[j]="0";
            }
            //alert(subdetalle3[j]);
            $(".slct_condicion_"+detalle2[0]+"_modal:eq("+j+")").val(subdetalle3[j]);
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
    $("#form_ruta_flujo .form-group").css("display","none");
}

adicionarRutaDetalleAutomatico=function(valorText,valor,tiempo,verbo,imagen,imagenc){
    valor=""+valor;
    var adjunta=false; var position=areasGId.indexOf(valor);
    if( position>=0 ){
        adjunta=true;
    }

    var verboaux=verbo.split("|");
    var verbo1=[];
    var verbo2=[];
    var imgfinal=imagen;
    for(i=0;i<verboaux.length;i++ ){
        verbo1.push(verboaux[i].split("^^")[0]);
        verbo2.push(verboaux[i].split("^^")[1]);

        if($.trim(verboaux[i].split("^^")[1])>0){
            imgfinal=imagenc;
        }
    }

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
      //alert("tiempo= "+position +" | areapos="+posicioninicial);
      var tid=0;
      var validapos=0;
      var detalle=""; var detalle2="";
      
      if(position>=0){
        tid=position;
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

    if( tiempo!='_' || verbo!='' ){
        if( adjunta==false ){ // primer registro
            tiempoGId.push(valor);
            tiempoG.push([]);
            tid=tiempoG.length-1;
            tiempoG[tid].push(posicioninicial+"_"+tiempo);

            verboG.push([]);
            verboG[tid].push(posicioninicial+"_"+verbo1.join("|")+"_"+verbo2.join("|"));
        }
      //}
        else{
            var posicioninicialf=posicioninicial;
            for(var i=1; i<tbodyArea[posicioninicial].length; i++){
                posicioninicialf++;
                validapos=areasGId.indexOf(valor,posicioninicialf);
                posicioninicialf=validapos;
                if( i>=tiempoG[tid].length ){
                    //alert(tiempo+" | "+verbo+" | "+valor+" | "+posicioninicial+"-"+validapos);
                    tiempoG[tid].push(validapos+"_"+tiempo);

                    verboG[tid].push(validapos+"_"+verbo1.join("|")+"_"+verbo2.join("|"));
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

cargarRutaId=function(ruta_flujo_id,permiso){
    $("#txt_ruta_flujo_id_modal").remove();
    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#txt_titulo").text("Vista");
    $("#texto_fecha_creacion").text("Fecha Vista:");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
    $("#form_ruta_flujo .form-group").css("display","");
    Ruta.CargarDetalleRuta(ruta_flujo_id,permiso,CargarDetalleRutaHTML);
    //alert('Actualizando '+ruta_flujo_id+ "Con permiso =>"+permiso);
}

CargarDetalleRutaHTML=function(permiso,datos){
areasG="";  areasG=[]; // texto area
areasGId="";  areasGId=[]; // id area
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
            $("#slct_flujo_id").val(data.flujo_id);
            $("#slct_area_id").val(data.area_id);
            $("#slct_flujo_id,#slct_area_id").multiselect('disable');
            $("#slct_flujo_id,#slct_area_id").multiselect('refresh');
            $("#txt_persona").val(data.persona);
        }
        adicionarRutaDetalleAutomatico(data.area2,data.area_id2,data.tiempo_id+"_"+data.dtiempo,data.verbo,data.imagen,data.imagenc);
    });
    pintarAreasG(permiso);
    //alertatodo();
}

AbreTv=function(val){
    $("#areasasignacion [data-id='"+val+"']").click();
}
</script>
