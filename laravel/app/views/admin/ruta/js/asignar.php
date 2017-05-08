<script type="text/javascript">
temporalBandeja=0;
var fechaTG='<?php echo date("Y-m-d") ?>';
var horaTG='<?php echo date("H:i:s") ?>';
var areasG=[]; // texto area
var areasGId=[]; // id area
var theadArea=[]; // cabecera area
var tbodyArea=[]; // cuerpo area
var tfootArea=[]; // pie area

var tiempoGId=[]; // id posicion del modal en base a una area.
var tiempoG=[];
var verboG=[];
var posicionDetalleVerboG=0;
$(document).ready(function() {
                slctGlobal.listarSlct('area','areasTodas','multiple',null,{estado:1,areagestion:1});
                slctGlobalHtml('select_tipoenvio','simple');
    $( "#tabs" ).tabs();
    $('[data-toggle="popover"]').popover(); 

    $('.chk').on('ifChanged', function(event){
        if(event.target.value == 'tareas'){
            if(event.target.checked == true){
                $("#txt_numareas").prop('disabled',true);
                $("#txt_numareas").val('');
                $(".tablaSelecAreaTiempo").addClass('hidden');
                $("#tb_numareas").html(''); 
                $('#areasTodas option').prop('selected', true);
                $('#areasTodas').multiselect('refresh');
            }else{
                $('#areasTodas option').prop('selected', false);
                $('#areasTodas').multiselect('refresh');
                $("#txt_numareas").prop('disabled',false);
            }
        }
        if(event.target.value == 'etiempo'){
            if(event.target.checked == true){
                $("#txt_tiempo").prop('disabled',false);
            }else{
                $("#txt_tiempo").prop('disabled',true);
            }
        }
       /* var state = event.target.checked;
        if(state == true){
            $('.cancelation').removeClass('hidden');
        }else{
            $('.cancelation').addClass('hidden');

        }*/
    });

    //$("[data-toggle='offcanvas']").click();
    $("#btn_guardar_tiempo,#btn_guardar_verbo").remove();
    $("#btn_close").click(Close);
    var data = {estado:1,tipo_flujo:1};
    var ids = [];

    data = {estado:1};
    slctGlobal.listarSlct('software','slct_software_id_modal','simple',ids,data);
    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);

    //$("[data-mask]").inputmask();

    Asignar.Relacion(RelacionHTML);

    $('#asignarModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var modal = $(this); //captura el modal
    });

    $('#asignarModal').on('hide.bs.modal', function (event) {
      $("#form_tabla_relacion input[type='text'], #form_tabla_relacion select").val("");
      $("#slct_software_id_modal").multiselect('refresh');
    });

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

    $("#btn_guardar_todo").click(guardarTodo);
    $("#btn_guardar_todo2").click(guardarProcesoGestion);
    hora();
    //$("#areasasignacion").DataTable();
});

Liberar=function(txt,id){
    $("#"+txt).removeAttr("readonly");
    $("#"+txt).val('');
    $("#"+id).val('');
    $("#"+txt).focus();
}

eventoSlctGlobalSimple=function (){} 

tpersona=function(valor){//1->natural,2->juridica,3->a.i. y 4->org social
    $(".natural, .juridica, .area, .org").css("display","none");
    $(".natural input[type='text'], .juridica input[type='text'], .area select, .org input[type='text']").val("");
    $(".area select").multiselect("refresh");

    if(valor==1 || valor==6){
        $(".natural").css("display","");
    }
    else if(valor==2){
        $(".juridica").css("display","");
    }
    else if(valor==3){
        $(".area").css("display","");
    }
    else if(valor==4 || valor==5){
        $(".org").css("display","");
    }
}

hora=function(){
//Asignar.FechaActual("");
    tiempo=horaTG.split(":");
    tiempo[1]=tiempo[1]*1+1;
    if(tiempo[1]*1==60){
        tiempo[0]=tiempo[0]*1+1;
        tiempo[1]='0';
    }

    if(tiempo[0]*1<10){
    tiempo[0] = "0" + tiempo[0]*1;
    }

    if(tiempo[1]*1<10){
    tiempo[1] = "0" + tiempo[1]*1;
    }
    
    horaTG=tiempo.join(":");
$("#txt_fecha_inicio").val(fechaTG+" "+horaTG);
$("#txt_fecha_inicio2").val(fechaTG+" "+horaTG);
$("#txt_fecha_inicio3").val(fechaTG+" "+horaTG);
tiempo = setTimeout('hora()',60000);
}

eventoFG=function(evento){
    if(evento=='cargarRutaFlujo'){
        var flujo_id=$.trim($("#txt_flujo2_id").val());
        var area_id=$.trim($("#txt_area2_id").val());

        if( flujo_id!='' && area_id!='' ){
            var datos={ flujo_id:flujo_id,area_id:area_id };
            $("#tabla_ruta_flujo").css("display","");
            Asignar.mostrarRutaFlujo(datos,mostrarRutaFlujoHTML);
        }
    }
}

mostrarRutaFlujoHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
    var color="";
    var clase="";
     $('#t_ruta_flujo').dataTable().fnDestroy();
     $("#txt_ruta_flujo_id").remove();
    $.each(datos,function(index,data){
        imagen="";
        clase="";
        cont++;
        if(cont==1){
            $("#form_asignar").append('<input type="hidden" id="txt_ruta_flujo_id" name="txt_ruta_flujo_id" value="'+data.id+'">');
            
            imagen="<a id='ruta_flujo_id' data-id='"+data.id+"' class='btn btn-success btn-sm'><i class='fa fa-check-square fa-lg'></i></a>";
        }
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.flujo+"</td>"+
        "<td>"+data.area+"</td>"+
        "<td>"+data.persona+"</td>"+
        "<td>"+data.ok+"</td>"+
        "<td>"+data.error+"</td>"+
        "<td>"+data.fruta+"</td>"+
        "<td>"+imagen+
            '<a onclick="cargarRutaId('+data.id+',2)" class="btn btn-warning btn-sm"><i class="fa fa-search-plus fa-lg"></i> </a>'+
        "</td>";
    html+="</tr>";

    });
    $("#tb_ruta_flujo").html(html); 
    $('#t_ruta_flujo').dataTable({
        "ordering": false
    });
}

RelacionHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
     $('#t_tablarelacion').dataTable().fnDestroy();

    $.each(datos,function(index,data){
    cont++;
    html+="<tr>"+
        "<td>"+data.software+"</td>"+
        "<td>"+data.codigo+"</td>"+
        '<td>'+
            '<a onclick="SeleccionRelacion('+data.id+','+"'"+data.codigo+"'"+');" class="btn btn-success btn-sm"><i class="fa fa-check-square fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

    });
    $("#tb_tablarelacion").html(html); 
    $("#t_tablarelacion").dataTable();
}

MostrarTablaRelacion=function(){
    $("#tabla_relacion").css("display","");
}

CerrarTablaRelacion=function(){
    $("#tabla_relacion").css("display","none");
}

SeleccionRelacion=function(id,codigo){
    CerrarTablaRelacion();
    $("#txt_codigo").val(codigo);
    $("#txt_tabla_relacion_id").remove();
    $("#form_asignar").append('<input type="hidden" id="txt_tabla_relacion_id" name="txt_tabla_relacion_id" value="'+id+'">');
}

guardarRelacion=function(){
    if( $.trim($("#txt_codigo_modal").val())=='' ){
        alert("Ingrese un código");
    }
    else if( $.trim($("#slct_software_id_modal").val())=='' ){
        alert("Seleccione un Software relacionado");
    }
    else if( confirm("Esta conforme con los datos registrados? Click en aceptar para continuar.") ){
        Asignar.guardarRelacion();
    }
}

guardarTodo=function(){
    if( $("#slct_flujo2_id").val()=='' ){
        alert("Seleccione un Tipo Flujo");
    }
    else if( $.trim($("#txt_codigo").val())==''){
        alert("Ingrese Nro Trámite");
    }
    else if( $.trim($("#txt_referente").val())!='' && $("#txt_referente").val().length>50 ){
        alert("Referencia supera el maximo de 50 caracteres, Revisar e ingresar solo el documento a referirse.");
    }
    else if( $("#slct_tipo_persona").val()=='' ){
        alert("Seleccione Tipo Persona");
    }
    else if( $("#slct_tipo_persona").val()=='2' && $("#txt_ruc").val()=='' ){
        alert("Ingrese RUC");
    }
    else if( $("#slct_tipo_persona").val()=='2' && $("#txt_razon_social").val()==''){
        alert("Ingrese Razon Social");
    }
    else if( ($("#slct_tipo_persona").val()=='1' || $("#slct_tipo_persona").val()=='6') && $("#txt_paterno").val()=='' ){
        alert("Ingrese Paterno");
    }
    else if( ($("#slct_tipo_persona").val()=='1' || $("#slct_tipo_persona").val()=='6') && $("#txt_materno").val()=='' ){
        alert("Ingrese Materno")
    }
    else if( ($("#slct_tipo_persona").val()=='1' || $("#slct_tipo_persona").val()=='6') && $("#txt_nombre").val()=='' ){
        alert("Ingrese Nombre");
    }
    else if( $("#slct_tipo_persona").val()=='3' && $("#slct_area_p_id").val()=='' ){
        alert("Seleccione Area Interna");
    }
    else if( ($("#slct_tipo_persona").val()=='4' || $("#slct_tipo_persona").val()=='5') && $("#txt_razon_social").val()=='' ){
        alert("Ingrese Razon Social");
    }
    else if( $("#txt_sumilla").val()=='' ){
        alert("Ingrese Sumilla");
    }
    else if( !$("#txt_ruta_flujo_id").val() || $("#txt_ruta_flujo_id").val()=='' ){
        alert("Seleccione una combinacion donde almeno exita 1 registro");
    }
    else{
        Asignar.guardarAsignacion();
    }
}

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
    $("#form_ruta_flujo .form-group").css("display","none");
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
                    //alert(tiempo+" | "+verbo+" | "+valor+" | "+posicioninicial+"-"+validapos);
                    tiempoG[tid].push(validapos+"_"+tiempo);

                    verboG[tid].push(validapos+"_"+verbo1.join("|")+"_"+verbo2.join("|")+"_"+verbo3.join("|")+"_"+verbo4.join("|")+"_"+verbo5.join("|")+"_"+verbo6.join("|"));
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

cargarRutaId=function(ruta_flujo_id,permiso,ruta_id){
    $("#txt_ruta_flujo_id_modal").remove();
    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#txt_titulo").text("Vista");
    $("#texto_fecha_creacion").text("Fecha Vista:");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
    $("#form_ruta_flujo .form-group").css("display","");
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
            $("#txt_proceso_1").val(data.flujo);
            $("#txt_area").val(data.area);
        }
        adicionarRutaDetalleAutomatico(data.area2,data.area_id2,data.tiempo_id+"_"+data.dtiempo,data.verbo,data.imagen,data.imagenc,data.imagenp,data.estado_ruta);
    });
    pintarAreasG(permiso);
    //alertatodo();
}

AbreTv=function(val){
    $("#areasasignacion [data-id='"+val+"']").click();
}

MostrarAjax=function(t){
    if( t=="proceso" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'flujo','listarproceso',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
    if( t=="plataforma" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'tabla_relacion','plataforma',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
    if( t=="referente" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'referido','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
   
};

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
  
    if(typeof(fn)!='undefined' && fn.col==1){
        var name='PROCESO';
        if(row.nombre.length <= 48){
            name = row.nombre;
        }

        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="CargarProceso(\''+row.id+'\',\''+name+'\',\''+row.area_id+'\',\''+row.area+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
//        estadohtml='<a class="form-control btn-success" onClick="CargarProceso('+row.nombre+')"<i class="fa fa-lg fa-check"></i></a>';
        return estadohtml;
    }
     if(typeof(fn)!='undefined' && fn.col==2){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="CargarReferente(\''+row.id+'\',\''+row.ruta_id+'\',\''+row.tabla_relacion_id+'\',\''+row.ruta_detalle_id+'\',\''+row.referido+'\',\''+row.fecha_hora_referido+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
        return estadohtml;
    }
 
};

cargarTabla = function(){
    var cantidad = document.querySelector("#txt_numareas").value;
    if(cantidad>0 && cantidad<31){
        if(cantidad){
            html = '';
            html+= "<tr>";
            html+= "    <td>";
            html+= "        <input class='form-control select_area' type='hidden' id='select_area' name='select_area' value='<?php echo Auth::user()->area_id; ?>' readOnly=''>";
            html+= "        <input class='form-control' id='nombre_area' name='nombre_area' value='<?php echo Auth::user()->areas->nombre; ?>' readOnly=''>";
            html+="     </td>";
            html+= "    <td>";
            html+= "        <input class='form-control txt_dias' type='text' name='txt_dias' id='txt_dias' value='1' placeholder='Cantidad dias' readOnly=''/>";
            html+="    </td>";
            html+= "    <td>";
            html+= "         <input class='form-control chk_copias' type='checkbox' name='chk_copias' id='chk_copias' value='copias'/>";
            html+="    </td>";
            html+= "</tr>";        
            for(var i=0 ; i<cantidad ; i++){
                html+= "<tr>";
                html+= "    <td>";
                html+= "        <select class='form-control select_area' id='select_area"+i+"' name='select_area'></select>";
                html+="     </td>";
                html+= "    <td>";
                html+= "        <input class='form-control txt_dias' type='text' name='txt_dias' id='txt_dias' value='1' placeholder='Cantidad dias' maxlength='2' onkeypress='return validaNumeros(event);'/>";
                html+="    </td>";
                html+= "    <td>";
                html+= "        <input class='form-control chk_copias' type='checkbox' name='chk_copias' id='chk_copias' value='copias'/>";
                html+="    </td>";
                html+= "</tr>";
                slctGlobal.listarSlct('area','select_area'+i+'','simple',null,{estado:1,areagestion:1});
            }
            $("#tb_numareas").html(html);
            $(".tablaSelecAreaTiempo").removeClass('hidden');
        }else{
             alert('Ingrese la cantidad de areas');
             $(".tablaSelecAreaTiempo").addClass('hidden');
        }
    }else {
        $("#txt_numareas").val('');
        $(".tablaSelecAreaTiempo").addClass('hidden');
        $("#tb_numareas").html('');
    }
}

cargarTiempo = function(object){
    $("#tb_numareas tr td input[type=text]").not(':input[readonly]').each(function() {
        $(this).val(object.value);
    });
}

guardarProcesoGestion = function(){
    var checked = $('#chk_todasareas').iCheck('update')[0].checked;
    if( $("#slct_flujo2_id").val()=='' ){
        alert("Seleccione un Tipo Flujo");
    }
    else if( $.trim($("#txt_codigo2").val())==''){
        alert("Ingrese Nro Trámite");
    }
    else if( $.trim($("#txt_referente2").val())!='' && $("#txt_referente2").val().length>50 ){
        alert("Referencia supera el maximo de 50 caracteres, Revisar e ingresar solo el documento a referirse.");
    }
    else if( $("#slct_tipo_persona2").val()=='' ){
        alert("Seleccione Tipo Persona");
    }
//    else if( $("#slct_tipo_persona2").val()=='2' && $("#txt_ruc2").val()=='' ){
//        alert("Ingrese RUC");
//    }
//    else if( $("#slct_tipo_persona2").val()=='2' && $("#txt_razon_social2").val()==''){
//        alert("Ingrese Razon Social");
//    }
//    else if( ($("#slct_tipo_persona2").val()=='1' || $("#slct_tipo_persona2").val()=='6') && $("#txt_paterno2").val()=='' ){
//        alert("Ingrese Paterno");
//    }
//    else if( ($("#slct_tipo_persona2").val()=='1' || $("#slct_tipo_persona2").val()=='6') && $("#txt_materno2").val()=='' ){
//        alert("Ingrese Materno")
//    }
//    else if( ($("#slct_tipo_persona2").val()=='1' || $("#slct_tipo_persona2").val()=='6') && $("#txt_nombre2").val()=='' ){
//        alert("Ingrese Nombre");
//    }
    else if( $("#slct_tipo_persona2").val()=='3' && $("#slct_area_p_id2").val()=='' ){
        alert("Seleccione Area Interna");
    }
//    else if( ($("#slct_tipo_persona2").val()=='4' || $("#slct_tipo_persona2").val()=='5') && $("#txt_razon_socia2l").val()=='' ){
//        alert("Ingrese Razon Social");
//    }
    else if( $("#txt_sumilla2").val()=='' ){
        alert("Ingrese Sumilla");
    }
    else if( $.trim($("#txt_numareas").val())==='' && checked ==false){
        alert("Ingrese Nº de Areas");
    }
    else if( $.trim($("#txt_tiempo").val())==='' || $.trim($("#txt_tiempo").val())==='0'){
        alert("Ingrese Nº de Días");
    }
        else if( $.trim($("#select_tipoenvio").val())===''){
        alert("Seleccionar Tipo de Envio");
    }


    else{
            var combo=$("#txt_numareas").val(); var count=0;
            for($i=0;$i<=combo;$i++){
            if($("#select_area"+$i).val()===''){count++;alert("Seleccionar área del Combo N°: "+($i+1));;}
            }
        if(count>0){}    
        else {Asignar.guardarAsignacionGestion();}
    }
}

validaNumeros=function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0 || tecla==46) return true;//8 barra, 0 flechas desplaz
        patron = /\d/; // Solo acepta números
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
}
</script>
