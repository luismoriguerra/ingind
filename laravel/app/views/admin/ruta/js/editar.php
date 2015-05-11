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
    $("#btn_adicionar_ruta_detalle").click(adicionarRutaDetalle);
    $("#btn_guardar_tiempo").click(guardarTiempo);
    $("#btn_guardar_verbo").click(guardarVerbo);
    $("#btn_guardar_todo").click(guardarTodo);
    $("#btn_buscar").click(buscar);
    var data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('flujo','slct_flujo_id','simple',ids,data);
    slctGlobal.listarSlct('flujo','slct_flujo2_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id','simple',ids,data);
    slctGlobal.listarSlct('area','slct_area_id_2','simple',ids,data);

    slctGlobal.listarSlct('ruta_detalle','slct_area2_id','simple');
    slctGlobalHtml('slct_tipo_respuesta,#slct_tipo_respuesta_detalle','simple');

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

buscar=function(){
    if( $("#txt_tramite").val()!="" ){
     var datos={ tramite:$("#txt_tramite").val() };
    $("#tabla_ruta_detalle").css("display","");
    Editar.mostrarRutaDetalleAlerta(datos,mostrarRutaDetalleAlertaHTML);
    }
    else{
        alert("Ingrese Nro Trámite y busque nuevamente");
    }
}

reiniciarslct=function(){
    $("#slct_flujo_id,#slct_area_id").multiselect("disable");
}

mostrarRutaDetalleAlertaHTML=function(datos){
    var html="";
    var cont=0;
    var botton="";
    var color="";
    var clase=""; var iov1=0; var iov2=0;
     $('#t_ruta_detalle').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        imagen="";
        clase="";
        cont++;
        if($.trim(data.fecha_inicio)!=''){
            iov1=data.verbo.indexOf("+1");
            iov2=data.verbo.indexOf("+2");

            agrega=1;
            if(iov1>=0 || iov2>=0){
                agrega=2;
            }

            imagen='<a onclick="cargarRutaId('+data.ruta_flujo_id+',1,'+data.id+','+data.ruta_id+','+(data.norden*1+agrega)+','+"'"+data.codalerta+"'"+','+agrega+');" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-lg"></i> </a>';
        }
    html+="<tr>"+
        "<td>"+cont+"</td>"+
        "<td>"+data.id_doc+"</td>"+
        "<td>"+data.norden+"</td>"+
        "<td>"+data.tiempo+"</td>"+
        "<td>"+data.fecha_inicio+"</td>"+
        "<td>"+data.fecha_final+"</td>"+
        "<td>"+data.observacion+"</td>"+
        "<td>"+data.alerta_tipo+"</td>"+
        "<td>"+imagen+
        "</td>";
    html+="</tr>";

    });
    $("#tb_ruta_detalle").html(html); 
    $('#t_ruta_detalle').dataTable({
        "ordering": false
    });
}

guardarTodo=function(){
    if( $("#slct_flujo_id").val()=="" ){
        alert("Seleccione Tipo de Flujo");
    }
    else if( $("#slct_area_id").val()=="" ){
        alert("Seleccione Area");
    }
    else if( !$("#txt_iniciara").attr("disabled") && ($("#txt_iniciara").val()=="" || $("#txt_iniciara").val()*1<=0 || $("#txt_iniciara").val()*1>$("#txt_orden_max").val()*1 || $("#txt_iniciara").val()*1>areasG.length) ){
    var r=areasG.length;
        if(r>$("#txt_orden_max").val()*1){
            r=$("#txt_orden_max").val()*1;
        }
        alert("No es válido, ingrese un número dentro del rango de 1 a "+r);
    }
    else if( $("#slct_estado_final").val()=='' ){
        alert("Seleccione el estado final");
    }
    else{
        $("#slct_flujo_id,#slct_area_id").multiselect("enable");
        Editar.CrearRuta(buscar);
    }

}

guardarTiempo=function(){
    var id=$("#form_ruta_tiempo #txt_area_id_modal").val();
    var tid=tiempoGId.indexOf(id);

    for(var i=0; i<tiempoG[tid].length; i++){
        detalle=tiempoG[tid][i].split("_");
        detalle[1]=$("#slct_tipo_tiempo_"+detalle[0]+"_modal").val();
        detalle[2]=$("#txt_tiempo_"+detalle[0]+"_modal").val();

        //alert("guardando: "+ detalle.join("_") +" tt=> "+$("#slct_tipo_tiempo_"+detalle[0]+"_modal").val()+"; t=> "+$("#txt_tiempo_"+detalle[0]+"_modal").val());
        tiempoG[tid][i]=detalle.join("_");
    }
    alert('Timepo(s) Actualizado(s)');
}

guardarVerbo=function(){
    var id=$("#form_ruta_tiempo #txt_area_id_modal").val();
    var tid=tiempoGId.indexOf(id);
    var position=areasGId.indexOf(id);
    var imagen=$("#slct_area_id_2 option[value='"+id+"']").attr("data-evento").split("|").join("");
    var imagenc= imagen.split(".").join("c.");
    var alerta=false;
    var verboaux="";var verboaux2="";
    var poseq=-1;

    ///////////////ENCONTRAR POSICION DEL GRAFICO EN PANTALLA///////////////
    $(".areafinal").each(
                function( index ) { 
                    if( ( $(this).attr("style").split(imagen).length>1 || $(this).attr("style").split(imagenc).length>1 ) && poseq==-1){
                        //alert($(this).attr("style")+" Pos:"+index);
                        poseq=index;
                    }
                }
        );
    ////////////////////////////////////7


    for(var i=0; i<tiempoG[tid].length; i++){
        detalle=verboG[tid][i].split("_");
        verboaux="";verboaux2="";
        alerta=false;
        $(".txt_verbo_"+detalle[0]+"_modal").each(
                function( index ) { 
                    verboaux+= "|"+$(this).val().split(",").join(";");
                }
        );

        $(".slct_condicion_"+detalle[0]+"_modal").each(
                function( index ) { 
                    verboaux2+= "|"+$(this).val();
                    if ( $(this).val()>0 ) {
                        alerta=true;
                    }
                }
        );

        if(i>0){
            poseq++;
        }
        //alert(verboaux.substr(1));
        detalle[1]=verboaux.substr(1);
        detalle[2]=verboaux2.substr(1);
        if(alerta==true){
            //alert(".areafinal:eq("+poseq+")  false");
            $(".areafinal:eq("+poseq+")").attr("style","height:100px; background-image: url('img/admin/area/"+imagenc+"');")
            tbodyArea[position][i]=tbodyArea[position][i].split(imagen).join(imagenc);
        }
        else{
            //alert(".areafinal:eq("+poseq+") true");
            $(".areafinal:eq("+poseq+")").attr("style","height:100px; background-image: url('img/admin/area/"+imagen+"');")
            tbodyArea[position][i]=tbodyArea[position][i].split(imagenc).join(imagen);
        }

        //alert("guardando: "+ detalle.join("_"));
        verboG[tid][i]=detalle.join("_");
    }
    alert('Accion(es) Actualizado(s)');
}

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
                            '<input class="form-control txt_verbo_'+detalle2[0]+'_modal" value="'+subdetalle2[j]+'" placeholder="Ing. Acción" type="text">'+
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

eliminaDetalleVerbo=function(posdet){
    $("#tr_detalle_verbo_"+posdet).remove();
}

adicionaDetalleVerbo=function(det){
    var imagen="";
    posicionDetalleVerboG++;
    imagen='<button onclick="eliminaDetalleVerbo('+posicionDetalleVerboG+');" type="button" class="btn btn-danger btn-sm">'+
              '<i class="fa fa-minus fa-lg"></i>'+
            '</button>';
    htm=   '<tr id="tr_detalle_verbo_'+posicionDetalleVerboG+'">'+
                '<td>'+(det*1+1)+'</td>'+
                '<td>'+
                    '<input class="form-control txt_verbo_'+det+'_modal" placeholder="Ing. Acción" type="text">'+
                '</td>'+
                '<td>'+
                    '<select class="form-control slct_condicion_'+det+'_modal">'+
                        $('#slct_condicion_modal').html()+
                    '</select>'+
                '</td>'+
                '<td>'+imagen+'</td>'+
            '</tr>';
    $("#tb_verbo").append(htm);
}

eventoSlctGlobalSimple=function(slct,valor){
    if( slct=="slct_flujo2_id" ){
        var valor=valor.split('|').join("");
        $("#slct_area2_id").val(valor);
        $("#slct_area2_id").multiselect('refresh');

       reiniciarslct();
        $("#form_ruta_detalle>.form-group").css("display","none");
        var flujo_id=$.trim($("#slct_flujo2_id").val());
        var area_id=$.trim($("#slct_area2_id").val());

        if( flujo_id!='' && area_id!='' ){
            var datos={ flujo_id:flujo_id,area_id:area_id };
            $("#tabla_ruta_detalle").css("display","");
            Editar.mostrarRutaDetalleAlerta(datos,mostrarRutaDetalleAlertaHTML);
        }
    }
}

adicionarRutaDetalle=function(){
    if( $.trim($("#slct_area_id_2").val())=='' ){
        alert('Seleccione un Area para adicionar');
    }
    else if( areasGId.length>0 && $("#slct_area_id_2").val()==areasGId[(areasGId.length-1)] ){
        alert('No se puede asignar 2 veces continuas la misma Area');
    }
    else if( $.trim($("#slct_area_id_2").val())!='' ){
        valorText=$("#slct_area_id_2 option[value='"+$("#slct_area_id_2").val()+"']").text();
        imagen=$("#slct_area_id_2 option[value='"+$("#slct_area_id_2").val()+"']").attr("data-evento").split("|").join("");
        valor=$("#slct_area_id_2").val();



        var adjunta=false; var position=areasGId.indexOf(valor);
        if( position>=0 ){
            adjunta=true;
        }

        areasG.push(valorText);
        areasGId.push(valor);

        if( adjunta==false ){
            head='<th class="eliminadetalleg" style="width:110px;min-width:100px !important;">'+valorText+'</th>';
            theadArea.push(head);

            body=   '<tr>'+
                        '<td class="areafinal" style="height:100px; background-image: url('+"'"+'img/admin/area/'+imagen+"'"+');">&nbsp;'+
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
                        '<td class="areafinal" style="height:100px; background-image: url('+"'"+'img/admin/area/'+imagen+"'"+');">&nbsp;'+
                        '<span class="badge bg-yellow">'+areasG.length+'</span>'+
                        '</td>'+
                    '</tr>';
            tbodyArea[position].push(body);

        }
        

        pintarAreasG(1);
    }
}

CambiarDetalle=function(t){
    if( areasGId[t]==areasGId[(t-2)] ){
        alert('No se puede asignar 2 veces continuas la misma Area: '+areasG[t]);
    }
    else if( areasGId[(t-1)]==areasGId[(t+1)] ){
        alert('No se puede asignar 2 veces continuas la misma Area: '+areasG[(t-1)]);
    }
    else{
        var auxText=areasG[t];
        var aux=areasGId[t];
        var auxthead=theadArea[t];
        var auxtfoot=tfootArea[t];

        var auxtbody=[];
        //alert(t+"=>"+auxthead+" => "+tbodyArea[t][0]);
        if(areasGId[t]==areasGId[(t-1)] /*&& theadArea[(t-1)]!=0*/){
            //no se realizará nada...
        }
        else{
            if(auxthead==0){
                auxtbody.push(tbodyArea[t][0]);
                valorNuevo=tbodyArea[t][0].split("|");

                tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ]=tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ].split( ">"+(t+1)+"<" ).join( ">"+t+"<" );
            }
            else{
                var idfilas=0;
                for(var i=0; i<tbodyArea[t].length; i++){
                    idfilas=areasGId.indexOf(areasGId[t],idfilas); 
                    if(i>0){
                        //alert(idfilas+'|'+i+" INICIA "+t+" => "+(t-1));
                        tbodyArea[idfilas][0]=(t-1)+'|'+i;
                    }
                    idfilas++;
                    auxtbody.push( tbodyArea[t][i].split( "area"+(t+1) ).join( "area"+t ).split( ">"+(t+1)+"<" ).join( ">"+t+"<" ) );
                }
            }

            tbodyArea[t]=[];
            if(theadArea[(t-1)]==0){
                tbodyArea[t].push( tbodyArea[(t-1)][0] );
                valorNuevo=tbodyArea[(t-1)][0].split("|");

                tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ]=tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ].split( ">"+t+"<" ).join( ">"+(t+1)+"<" );
            }
            else{
                var idfilas=0;
                for(var i=0; i<tbodyArea[(t-1)].length; i++){
                    idfilas=areasGId.indexOf(areasGId[(t-1)],idfilas); 
                    if(i>0){
                        //alert(idfilas+'|'+i+' INICIA '+(t-1)+" => "+t);
                        tbodyArea[idfilas][0]=t+'|'+i;
                    }
                    idfilas++;
                    tbodyArea[t].push( tbodyArea[(t-1)][i].split( "area"+t ).join("area"+(t+1) ).split( ">"+t+"<" ).join( ">"+(t+1)+"<" ) );
                }
            }

            areasG[t]=areasG[(t-1)];
            areasGId[t]=areasGId[(t-1)];
            theadArea[t]=theadArea[(t-1)];
            tfootArea[t]=tfootArea[(t-1)];


            tbodyArea[(t-1)]=[];
            for(var i=0; i<auxtbody.length; i++){
                tbodyArea[(t-1)].push(auxtbody[i]);
            }

            areasG[(t-1)]=auxText;
            areasGId[(t-1)]=aux;
            theadArea[(t-1)]=auxthead;
            tfootArea[(t-1)]=auxtfoot;

            pintarAreasG(1);
        }
    }
}

CambiarDetalleDinamico=function(t){
var auxText=areasG[t];
var aux=areasGId[t];
var auxthead=theadArea[t];
var auxtfoot=tfootArea[t];

var auxtbody=[];
//alert(t+"=>"+auxthead+" => "+tbodyArea[t][0]);
    if(areasGId[t]==areasGId[(t-1)] /*&& theadArea[(t-1)]!=0*/){
        //no se realizará nada...
    }
    else{
        if(auxthead==0){
            auxtbody.push(tbodyArea[t][0]);
            valorNuevo=tbodyArea[t][0].split("|");

            tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ]=tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ].split( ">"+(t+1)+"<" ).join( ">"+t+"<" );
        }
        else{
            var idfilas=0;
            for(var i=0; i<tbodyArea[t].length; i++){
                idfilas=areasGId.indexOf(areasGId[t],idfilas); 
                if(i>0){
                    //alert(idfilas+'|'+i+" INICIA "+t+" => "+(t-1));
                    tbodyArea[idfilas][0]=(t-1)+'|'+i;
                }
                idfilas++;
                auxtbody.push( tbodyArea[t][i].split( "area"+(t+1) ).join( "area"+t ).split( ">"+(t+1)+"<" ).join( ">"+t+"<" ) );
            }
        }

        tbodyArea[t]=[];
        if(theadArea[(t-1)]==0){
            tbodyArea[t].push( tbodyArea[(t-1)][0] );
            valorNuevo=tbodyArea[(t-1)][0].split("|");

            tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ]=tbodyArea[ valorNuevo[0] ][ valorNuevo[1] ].split( ">"+t+"<" ).join( ">"+(t+1)+"<" );
        }
        else{
            var idfilas=0;
            for(var i=0; i<tbodyArea[(t-1)].length; i++){
                idfilas=areasGId.indexOf(areasGId[(t-1)],idfilas); 
                if(i>0){
                    //alert(idfilas+'|'+i+' INICIA '+(t-1)+" => "+t);
                    tbodyArea[idfilas][0]=t+'|'+i;
                }
                idfilas++;
                tbodyArea[t].push( tbodyArea[(t-1)][i].split( "area"+t ).join("area"+(t+1) ).split( ">"+t+"<" ).join( ">"+(t+1)+"<" ) );
            }
        }

        areasG[t]=areasG[(t-1)];
        areasGId[t]=areasGId[(t-1)];
        theadArea[t]=theadArea[(t-1)];
        tfootArea[t]=tfootArea[(t-1)];


        tbodyArea[(t-1)]=[];
        for(var i=0; i<auxtbody.length; i++){
            tbodyArea[(t-1)].push(auxtbody[i]);
        }

        areasG[(t-1)]=auxText;
        areasGId[(t-1)]=aux;
        theadArea[(t-1)]=auxthead;
        tfootArea[(t-1)]=auxtfoot;
    }
}

EliminarDetalle=function(t){
    var eliminando=areasG[t];
    if( confirm("Esta apunto de elimar "+eliminando+" de la posición "+(t+1)+"; Todo su detalle será eliminado; Confirme para continuar de lo contrario cancelar") ){


        if( areasGId[(t-1)]==areasGId[(t+1)] && areasG.length>(t+1) ){
            alert('No se puede asignar 2 veces continuas la misma Area: '+areasG[(t+1)]);
        }
        else{
            $("#tr-detalle-"+t).remove();
            var posiciont= tiempoGId.indexOf( areasGId[t] );
            var theadAreaaux= theadArea[t];
            var tbodyAreaaux= tbodyArea[t][0].split("|");
            var eliminapos=0;
            if( posiciont>=0 ){
                if( theadAreaaux==0 ){
                    eliminapos=tbodyAreaaux[1];
                }

                for(var i=eliminapos; i<tiempoG[posiciont].length; i++){
                    if( (i+1)==tiempoG[posiciont].length ){
                        tiempoG[posiciont].pop();
                        //alert("eliminndo ult");
                        verboG[posiciont].pop();
                    }
                    else{
                        //alert(tiempoG[posiciont][i]+" antes de eliminar");
                        tiempoG[posiciont][i]=tiempoG[posiciont][(i*1+1)];
                        //alert(tiempoG[posiciont][i]+" =>elimiando pos: "+i);
                        verboG[posiciont][i]=verboG[posiciont][(i*1+1)];
                    }
                }
            }

            for( var i=t; i<areasG.length; i++){
                if( (i+1)==areasG.length ){
                    if( theadArea[i]==0 ){
                        valorNuevo=tbodyArea[i][0].split("|");
                        tbodyArea[ valorNuevo[0] ].pop();
                    }
                        //alert(tbodyArea[i][0]);
                    tbodyArea[i]=0;
                    tbodyArea.pop();

                    areasG.pop();
                    areasGId.pop();
                    theadArea.pop();
                    tfootArea.pop();
                }
                else{
                    CambiarDetalleDinamico( (i+1) );
                }
            }
            pintarAreasG(1);
            //alertatodo();
        }
    }
}

alertatodo=function(){
    for(i=0;i<areasGId.length;i++){
        alert( i +"id =>"+ areasGId[i] +" \n"+
               "area=>"+ areasG[i] +" \n"+
               "head=>"+ theadArea[i] +" \n"+
               "foot=>"+ tfootArea[i] +" \n"+
               "body=>"+ tbodyArea[i][0] +" \n"+
               "cantbody=>"+ tbodyArea[i].length +" \n"+
               "bodys=>"+tbodyArea.length +" \n"+
               "textbody=>"+tbodyArea[ (tbodyArea.length-1) ][0]);
    }
}

pintarAreasG=function(permiso){
    var htm=''; var click=""; var imagen=""; var clickeli="";
    $("#areasasignacion .eliminadetalleg").remove();
    $("#btn_guardar_todo").css("display","none");
    $("#slct_area_id_2").val("");$("#slct_area_id_2").multiselect("refresh");
    $("#slct_area_id_2").multiselect("disable");

    if(permiso!=2){
        $("#btn_guardar_todo").css("display","");
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
                        "<button class='btn bg-navy btn-sm' "+click+" type='button'>"+
                            (i+1)+"&nbsp;"+imagen+
                        "</button>&nbsp;&nbsp;"+
                        "<button class='btn btn-danger btn-sm' "+clickeli+" type='button'>"+
                            "<i class='fa fa-remove fa-sm'></i>"+
                        "</button>"+
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

Actualiza=function(){
    $("#txt_titulo").val("Actualiza Ruta");
    $("#fecha_creacion").html('');
}

Close=function(){
    $("#form_ruta_flujo .form-group").css("display","none");
}

cargarRutaId=function(ruta_flujo_id,permiso,rdid,rid,norden,codalerta,ncond){
    $("#txt_iniciara").removeAttr("disabled");
    $("#condicional").val("0");
    if(codalerta=='1-1'){
        $("#txt_iniciara").attr("disabled","true");
    }
    if(ncond==2){
        $("#condicional").val("1");
    }
    $("#txt_iniciara,#slct_estado_final").val("");
    $("#txt_ruta_detalle_id").val(rdid);
    $("#txt_ruta_id").val(rid);
    $("#txt_orden_max").val(norden);
    $("#txt_ruta_flujo_id_modal").remove();
    $("#form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#txt_titulo").text("Act. Ruta");
    $("#texto_fecha_creacion").text("Fecha Actualización:");
    $("#fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
    $(".form-group").css("display","");
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
            $("#slct_flujo_id,#slct_area_id").multiselect('refresh');
            $("#txt_persona").val(data.persona);
        }
        adicionarRutaDetalleAutomatico(data.area2,data.area_id2,data.tiempo_id+"_"+data.dtiempo,data.verbo,data.imagen,data.imagenc);
    });
    pintarAreasG(permiso);
    //alertatodo();
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

AbreTv=function(val){
    $("#areasasignacion [data-id='"+val+"']").click();
}
</script>
