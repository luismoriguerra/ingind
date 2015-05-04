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
$(document).ready(function() {
    //$("[data-toggle='offcanvas']").click();
    $("#btn_close").click(Close);
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo2_id,#slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area2_id,#slct_area_id','simple',ids,data);
    var data = {estado:1};
    slctGlobal.listarSlct('software','slct_software_id_modal','simple',ids,data);

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

    $("#btn_guardar_todo").click(guardarTodo);
    hora();
    //$("#areasasignacion").DataTable();
});

eventoSlctGlobalSimple=function(slct,valores){

}

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
$("#txt_fecha_inicio").val(horita);

tiempo = setTimeout('hora()',1000);
}

mostrarRutaFlujo=function(){
    $("#tabla_ruta_flujo").css("display","none");
    var flujo_id=$.trim($("#slct_flujo2_id").val());
    var area_id=$.trim($("#slct_area2_id").val());

    if( flujo_id!='' && area_id!='' ){
        var datos={ flujo_id:flujo_id,area_id:area_id };
        $("#tabla_ruta_flujo").css("display","");
        Asignar.mostrarRutaFlujo(datos,mostrarRutaFlujoHTML);
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
    if( $.trim($("#txt_codigo").val())==''){
        alert("Busque y seleccione un código");
    }
    else if( $("#slct_flujo2_id").val()=='' ){
        alert("Seleccione un Tipo Flujo");
    }
    else if( $("#slct_area2_id").val()=='' ){
        alert("Seleccione una Area");
    }
    else if( !$("#txt_ruta_flujo_id").val() || $("#txt_ruta_flujo_id").val()=='' ){
        alert("Seleccione una combinacion donde almeno exita 1 registro");
    }
    else{
        if ( confirm("Favor de confirmar para registrar") ){
            Asignar.guardarAsignacion();
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
                        '<select class="form-control" id="slct_tipo_tiempo_'+detalle[0]+'_modal">'+
                            $('#slct_tipo_tiempo_modal').html()+
                        '</select>'+
                    '</td>'+
                    '<td>'+
                        '<input class="form-control" type="number" id="txt_tiempo_'+detalle[0]+'_modal" value="'+detalle[2]+'">'+
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
                imagen='<button onclick="eliminaDetalleVerbo('+posicionDetalleVerboG+');" type="button" class="btn btn-danger btn-sm">'+
                          '<i class="fa fa-minus fa-lg"></i>'+
                        '</button>';
            }
            
            if( (j+1)==subdetalle2.length ){
                imagen='<button onclick="adicionaDetalleVerbo('+detalle2[0]+');" type="button" class="btn btn-success btn-sm">'+
                          '<i class="fa fa-plus fa-lg"></i>'+
                        '</button>';
            }

            htm=   '<tr id="tr_detalle_verbo_'+posicionDetalleVerboG+'">'+
                        '<td>'+(detalle2[0]*1+1)+'</td>'+
                        '<td>'+
                            '<input class="form-control txt_verbo_'+detalle2[0]+'_modal" value="'+subdetalle2[j]+'" placeholder="Ing. Verbo" type="text">'+
                        '</td>'+
                        '<td>'+
                            '<select class="form-control slct_condicion_'+detalle2[0]+'_modal">'+
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
                    '<td class="areafinal" style="height:100px; background-image: url('+"'"+'img/admin/area/'+imgfinal+"'"+');">&nbsp;'+
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
                    '<td class="areafinal" style="height:100px; background-image: url('+"'"+'img/admin/area/'+imgfinal+"'"+');">&nbsp;'+
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

</script>
