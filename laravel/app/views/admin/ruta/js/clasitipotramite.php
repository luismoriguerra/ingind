<script type="text/javascript">
var cabeceraG=[]; // Cabecera del Datatable
var columnDefsG=[]; // Columnas de la BD del datatable
var targetsG=-1; // Posiciones de las columnas del datatable

var CostoPersonalG={id:0,nombre:"",cantidad:"",estado:1}; // Datos Globales
var EstratPeiG={id:0,descripcion:"",estado:1}; // Datos Globales

    // Datos Globales
$(document).ready(function() {
    /*  1: Onblur ,Onchange y para número es a travez de una función 1: 
        2: Descripción de cabecera
        3: Color Cabecera
    */
       data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('software','slct_software_id_modal','simple',ids,data);
    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);
 
   $("#btn_close").click(Close);
    slctGlobalHtml('form_tipotramites_modal #slct_estado','simple');
    slctGlobalHtml('form_requisitos_modal #slct_estado','simple');
    CargarEstratPei();

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
    $('#requisitoModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Requisito');
      $('#form_requisitos_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_requisitos_modal input[type='hidden']").remove();
 
        if(titulo=='Nuevo'){
            //$("#form_requisitos_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarCostoPersonal();');
            $('#form_requisitos_modal #slct_estado').val(1);
            $('#form_requisitos_modal #txt_nombre').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarCostoPersonal();');

            $('#form_requisitos_modal #txt_nombre').val( CostoPersonalG.nombre );
            $('#form_requisitos_modal #txt_cantidad').val( CostoPersonalG.cantidad );
            $('#form_requisitos_modal #slct_estado').val( CostoPersonalG.estado );
            $("#form_requisitos_modal").append("<input type='hidden' value='"+CostoPersonalG.id+"' name='id'>");
            
          
        }
             $('#form_requisitos_modal select').multiselect('rebuild');
    });
    
    $('#requisitoModal').on('hide.bs.modal', function (event) {
       $('#requisitoModal :visible').val('');
       $('#requisitoModal textarea').val('');
        $('#requisitoModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
    
    $('#tipotramiteModal').on('show.bs.modal', function (event) { 
        
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tipo de Trámite');
      $('#form_tipotramites_modal [data-toggle="tooltip"]').css("display","none");
//      $("#form_tipotramites_modal input[type='hidden']").remove();
 
        if(titulo=='Nueva'){
            //$("#form_tipotramites_modal").append("<input type='hidden' value='263' name='txt_contratacion_id'>");
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','AgregarEstratPei();');
            $('#form_tipotramites_modal #slct_estado').val(1);
            $('#form_tipotramites_modal #txt_descripcion').focus();
           
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','EditarEstratPei();');

            $('#form_tipotramites_modal #txt_nombre').val( EstratPeiG.descripcion );
            $('#form_tipotramites_modal #slct_estado').val( EstratPeiG.estado );
            $("#form_tipotramites_modal").append("<input type='hidden' value='"+EstratPeiG.id+"' name='id'>");
            
          
        }
             $('#form_tipotramites_modal select').multiselect('rebuild');
    });
    
    $('#tipotramiteModal').on('hide.bs.modal', function (event) {
       $('#tipotramiteModal :visible').val('');
        $('#tipotramiteModal select').val('');
     //   var modal = $(this);
       // modal.find('.modal-body input').val('');
    });
     $("#btn_guardar_todo").click(guardarasignacion);
    
});



desactivarCostoPersonal = function(id){
      Pois.CambiarEstadoCostoPersonal(id, 0); 
};

activarCostoPersonal = function(id){
      Pois.CambiarEstadoCostoPersonal(id, 1);   
};

desactivarEstratPei = function(id){
      Pois.CambiarEstadoEstratPei(id, 0); 
};

activarEstratPei = function(id){
      Pois.CambiarEstadoEstratPei(id, 1);   
};

Editar = function(){
    if(validaContrataciones()){
        Pois.AgregarEditarPois(1);
        $("#form_costo_personal .form-group").css("display","none");
    }
};
Agregar = function(){
    if(validaContrataciones()){
       Pois.AgregarEditarPois(0);
       $("#form_costo_personal .form-group").css("display","none");
    }
};

validaContrataciones = function(){
    var r=true;

        if( $("#form_pois_modal #txt_objetivo_general").val()=='' ){
            alert("Ingrese Objetivo General");
            r=false;
        }
        if( $("#form_pois_modal #slct_area").val()=='' ){
            alert("Seleccione Área");
            r=false;
        }


    return r;
};

CargarCostoPersonal=function(id,titulo,boton){
    
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    
    $("#form_requisitos_modal #txt_poi_id").val(id);
    $("#form_costo_personal #txt_titulo").text(titulo);
    $("#form_costo_personal .form-group").css("display","");
    $("#form_actividad").css("display","none");
    
    data={id:id};
    Pois.CargarCostoPersonal(data);
};

CargarActividad=function(id,titulo,boton){
    
    var tr = boton.parentNode.parentNode;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    
    $("#form_actividad #id").val(id);
    $("#form_actividad #txt_titulo").text(titulo);
    $("#form_actividad").css("display","");
    
    $("#form_costo_personal .form-group").css("display","none");

};

CargarEstratPei=function(){

    Pois.CargarEstratPei();
};


costopersonalHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_costo_personal').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"</td>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+data.cantidad+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#requisitoModal' data-titulo='Editar' onclick='BtnEditarCostoPersonal(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
        if(data.estado==1){
            html+='<td align="center"><span id="'+data.id+'" onClick="desactivarCostoPersonal('+data.id+')" data-estado="'+data.estado+'" class="btn btn-success">Activo</span></td>';
        }
        else {
           html+='<td align="center"><span id="'+data.id+'" onClick="activarCostoPersonal('+data.id+')" data-estado="'+data.estado+'" class="btn btn-danger">Inactivo</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_costo_personal").html(html);
    $("#t_costo_personal").dataTable(
    ); 


};

estratpeiHTML=function(datos){
  var html="";
    var alerta_tipo= '';
    $('#t_estrat_pei').dataTable().fnDestroy();
    pos=0;
    $.each(datos,function(index,data){
        pos++;
        html+="<tr>"+
             "<td>"+pos+"</td>"+
            "<td>"+data.nombre+"</td>";
        html+="<td align='center'><a class='form-control btn btn-primary' data-toggle='modal' data-target='#tipotramiteModal' data-titulo='Editar' onclick='BtnEditarEstratPei(this,"+data.id+")'><i class='fa fa-lg fa-edit'></i></a></td>";
        if(data.estado==1){
            html+='<td align="center"><span id="'+data.id+'" onClick="desactivarEstratPei('+data.id+')" data-estado="'+data.estado+'" class="btn btn-success">Activo</span></td>';
        }
        else {
           html+='<td align="center"><span id="'+data.id+'" onClick="activarEstratPei('+data.id+')" data-estado="'+data.estado+'" class="btn btn-danger">Inactivo</span></td>';

        }

        html+="</tr>";
    });
    $("#tb_estrat_pei").html(html);
    $("#t_estrat_pei").dataTable(
    ); 


};


eventoSlctGlobalSimple=function(){
};

BtnEditarCostoPersonal=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    CostoPersonalG.id=id;
    CostoPersonalG.nombre=$(tr).find("td:eq(1)").text();
    CostoPersonalG.cantidad=$(tr).find("td:eq(2)").text();
    CostoPersonalG.estado=$(tr).find("td:eq(4)>span").attr("data-estado");

};


BtnEditarEstratPei=function(btn,id){
    var tr = btn.parentNode.parentNode; // Intocable
    EstratPeiG.id=id;
    EstratPeiG.descripcion=$(tr).find("td:eq(1)").text();
    EstratPeiG.estado=$(tr).find("td:eq(3)>span").attr("data-estado");

};

validaCostoPersonal = function(){
    var r=true;
    if( $("#form_requisitos_modal #txt_modalidad").val()=='' ){
        alert("Ingrese Modalidad");
        r=false;
    }
    return r;
};
EditarCostoPersonal = function(){
    if(validaCostoPersonal()){
        Pois.AgregarEditarCostoPersonal(1);
    }
};
AgregarCostoPersonal = function(){
    if(validaCostoPersonal()){
        Pois.AgregarEditarCostoPersonal(0);
    }
};


EditarEstratPei = function(){
    if(validaEstratPei()){
        Pois.AgregarEditarEstratPei(1);
    }
};
AgregarEstratPei = function(){
    if(validaEstratPei()){
        Pois.AgregarEditarEstratPei(0);
    }
};

validaEstratPei = function(){
    var r=true;
    if( $("#form_tipotramites_modal #txt_nombre").val()=='' ){
        alert("Ingrese Nombre");
        r=false;
    }
    return r;
};


Close=function(){
    $("#form_costo_personal .form-group").css("display","none");
}


guardarasignacion=function(){
    if( $("#txt_flujo2_id").val()=='' ){
        alert("Seleccione un Tipo Flujo");
    }

    else{
        Pois.agregarProceso();
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