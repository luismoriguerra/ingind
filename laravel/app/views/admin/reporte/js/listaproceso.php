<script type="text/javascript">
var cabeceraG1=[]; // Cabecera del Datatable
var columnDefsG1=[]; // Columnas de la BD del datatable
var targetsG1=-1; // Posiciones de las columnas del datatable
$(document).ready(function() {

   var idG={   flujo        :'onBlur|Proceso|#DCE6F1', //#DCE6F1
                area        :'onBlur|Area|#DCE6F1',
                fruta        :'onChange|Fecha Creacion|#DCE6F1|fechaG',
                estado        :'4|Estado|#DCE6F1||estados', //#DCE6F1
                id: '1|[]|#DCE6F1',
             };
    var resG=dataTableG.CargarCab(idG);
    cabeceraG1=resG; // registra la cabecera
    var resG=dataTableG.CargarCol(cabeceraG1,columnDefsG1,targetsG1,1,'crear','t_crear');
    columnDefsG1=resG[0]; // registra las columnas del datatable
    targetsG1=resG[1]; // registra los contadores
    //var resG=dataTableG.CargarBtn(columnDefsG1,targetsG1,1,'BtnEditar','t_rutaflujo','fa-edit');
    //columnDefsG1=resG[0]; // registra la colunmna adiciona con boton
   // targetsG1=resG[1]; // registra el contador actualizado
    MostrarAjax('crear');
    var ids=[];
    var data = {estado:1};
    slctGlobal.listarSlct('ruta_detalle','slct_area_id','simple');
    slctGlobal.listarSlct('area','slct_area_id_2','simple',ids,data);


    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);

    $('#fecha').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
        showDropdowns: true
    });

    $('.fechaG').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
        showDropdowns: true
    }, function(start, end, label) {
      MostrarAjax('crear');
    });

    slctGlobal.listarSlct('area','slct_area_id_r','multiple',ids,data);
    slctGlobalHtml('slct_estado_id','multiple');
    slctGlobalHtml('slct_flujo_id','simple');

    $("#generar").click(function (){
        area_id = $('#slct_area_id_r').val();
        var fecha=$("#fecha").val();
        estado_id=$("#slct_estado_id").val();
        if ( fecha!=="") {
            if ($.trim(area_id)!=='') {
                if($.trim(estado_id)!=''){
                data = {area_id:area_id,fecha:fecha,estado_id:estado_id};
                CumpArea.mostrar(data);
                }
                else{
                    alert("Seleccione Estado");
                }
            } else {
                alert("Seleccione Área");
            }
        } else {
            alert("Seleccione Fecha");
        }
    });

    $('#rutaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var text = $.trim( button.data('text') );
      var id= $.trim( button.data('id') );
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      $("#form_ruta_tiempo #txt_nombre").val(text);
      $("#form_ruta_tiempo").append('<input type="hidden" value="'+id.split("_")[0]+'" id="txt_area_id_modal">');
      /*alert(id);
      for(i=0; i<areasGId.length; i++){
        alert(areasGId[i]+"=="+id);
        if(areasGId[i]==id){
            alert("encontrado "+areasGId[i]);
        }
      }*/
      $("#form_ruta_verbo #txt_nombre").val(text);
      $("#form_ruta_verbo").append('<input type="hidden" value="'+id.split("_")[0]+'" id="txt_area_id_modal">');

      if( id.split("_").length>1 ){
          var position=tiempoGIdAuxi.indexOf(id.split("_")[0]);
          var posicioninicial=areasGIdAuxi.indexOf(id.split("_")[0]);
      //alert("tiempo= "+position +" | areapos="+posicioninicial);
          var tid=0;
          var validapos=0;
          var detalle=""; var detalle2="";

          if(position>=0){
            tid=position;
            //alert("actualizando");
            detalle=tiempoGAuxi[tid][0].split("_");
            detalle[0]=posicioninicial;
            tiempoGAuxi[tid][0]=detalle.join("_");

            detalle2=verboGAuxi[tid][0].split("_");
            detalle2[0]=posicioninicial;
            verboGAuxi[tid][0]=detalle2.join("_");
          }
          else{
            //alert("registrando");
            tiempoGIdAuxi.push(id);
            tiempoGAuxi.push([]);
            tid=tiempoGAuxi.length-1;
            tiempoGAuxi[tid].push(posicioninicial+"__");

            verboGAuxi.push([]);
            verboGAuxi[tid].push(posicioninicial+"______");
          }

          var posicioninicialf=posicioninicial;
            for(var i=1; i<tbodyAreaAuxi[posicioninicial].length; i++){
                posicioninicialf++;
                validapos=areasGIdAuxi.indexOf(id.split("_")[0],posicioninicialf);
                posicioninicialf=validapos;
                if( i>=tiempoGAuxi[tid].length ){
                    tiempoGAuxi[tid].push(validapos+"__");

                    verboGAuxi[tid].push(validapos+"______");
                }
                else{
                    detalle=tiempoGAuxi[tid][i].split("_");
                    detalle[0]=validapos;
                    tiempoGAuxi[tid][i]=detalle.join("_");

                    detalle2=verboGAuxi[tid][i].split("_");
                    detalle2[0]=validapos;
                    verboGAuxi[tid][i]=detalle2.join("_");
                }
            }
      pintarTiempoGAuxi(tid);
      }
      else{
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
      }



    });

    $('#rutaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#form_ruta_tiempo input[type='hidden']").remove();
      $("#form_ruta_verbo input[type='hidden']").remove();
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
    //$("#areasasignacion").DataTable();
});
MostrarAjax=function(t){
    if( t=="crear" ){
        if( columnDefsG1.length>0 ){
           // alert("as");
            dataTableG.CargarDatos(t,'ruta_flujo','cargar',columnDefsG1);
        }
        else{
            alert('Faltas datos');
        }
    }
}


GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==1){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="CargarMicroProceso(\''+row.ruta_flujo_id+'\',\''+row.nombre+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
//        estadohtml='<a class="form-control btn-success" onClick="CargarProceso('+row.nombre+')"<i class="fa fa-lg fa-check"></i></a>';
        return estadohtml;
    }
    if(typeof(fn)!='undefined' && fn.col==3){
        var estadohtml='';
        estadohtml=row.estado;            
        return estadohtml;
    }
    else if(typeof(fn)!='undefined' && fn.col==4){
        var estadohtml='';
        estadohtml='<a onclick="cargarRutaId('+row.id+',1)" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-lg"></i> </a>';       
        if(row.cestado==1){             
            estadohtml='<a onclick="cargarRutaId('+row.id+',2)" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-lg"></i> </a>';   
        }
        return estadohtml;
    }
}

cargarRutaId=function(ruta_flujo_id,permiso,ruta_id){
    $("#rutaflujoModal #txt_ruta_flujo_id_modal").remove();
    $("#rutaflujoModal #form_ruta_flujo").append('<input type="hidden" id="txt_ruta_flujo_id_modal" value="'+ruta_flujo_id+'">');
    $("#rutaflujoModal #txt_titulo").text("Vista");
    $("#rutaflujoModal #texto_fecha_creacion").text("Fecha Vista:");
    $("#rutaflujoModal #fecha_creacion").html('<?php echo date("Y-m-d"); ?>');
    $("#rutaflujoModal #form_ruta_flujo .form-group").css("display","");
    Ruta.CargarDetalleRuta(ruta_flujo_id,permiso,CargarDetalleRutaHTML,ruta_id);
    $("#rutaflujoModal").modal('show');
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
            $("#txt_persona_1").val(data.persona);
            $("#txt_proceso_1").val(data.flujo);
            $("#txt_area_1").val(data.area);
        }
        adicionarRutaDetalleAutomatico(data.area2,data.area_id2,data.tiempo_id+"_"+data.dtiempo,data.verbo,data.imagen,data.imagenc,data.imagenp,data.estado_ruta);
    });
    pintarAreasG(permiso);
    //alertatodo();
}

AbreTv=function(val){
    $("#areasasignacion [data-id='"+val+"']").click();
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

</script>
