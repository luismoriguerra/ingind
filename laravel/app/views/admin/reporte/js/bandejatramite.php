<script type="text/javascript">
temporalBandeja=0;
valposg=0;
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

var RolIdG='';
var UsuarioId='';
var fechaAux="";
var CartaDesgloseG=0;
$(document).ready(function() {
    slctGlobalHtml('slct_persona','simple');
    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);
    $("#btn_close").click(Close_ruta);

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

    $(document).on('click', '#ExpedienteU', function(event) {
        event.preventDefault();
        $("#expedienteModal").modal('show');
        expedienteUnico();
    });

    $("[data-toggle='offcanvas']").click();
    RolIdG='<?php echo Auth::user()->rol_id; ?>';
    UsuarioId='<?php echo Auth::user()->id; ?>';

    if( RolIdG==8 || RolIdG==9 ){
        var data={estado_persona:1,solo_area:1};
    }else{
        $("#btnAdd").addClass('hidden');
    }

    //Bandeja.MostrarAjax();
    Bandeja.Cargar(HTMLCargarBandeja);

    slctGlobal.listarSlct('ruta_detalle','slct_area2_id','simple');
    //slctGlobalHtml('slct_tipo_respuesta,#slct_tipo_respuesta_detalle','simple');

    $("#btn_guardar_todo").click(guardarTodo);
    hora();

    $('#expedienteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var text = $.trim( button.data('text') );
      var id= $.trim( button.data('id') );
      var modal = $(this); //captura el modal
    });

    $('#expedienteModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      $("#form_expediente input[type='hidden']").remove();
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });

    $('#txt_fecha_inicio_b').daterangepicker({
        format: 'YYYY-MM-DD',
        singleDatePicker: false,
        showDropdowns: true
    }, function(start, end, label) {
      MostrarAjax();
    });

});

ActualizarResponsable=function(val){
    $("#slct_persona").attr("data-id",CartaDesgloseG);
    if( $.trim( $("#slct_persona").attr("data-id") )!='' ){
        var data={persona_id:val,carta_deglose_id:$("#slct_persona").attr("data-id")};
        var ruta='asignacion/responsable';
        Bandeja.AsignacionPersonas(data,ruta);
    }
    else{
        alert('.::No cuenta con cronograma::.');
        $("#slct_persona").val('');
        $('#slct_persona').multiselect('rebuild');
    }
}

ActualizarPersona=function(t){
    var data={persona_id:$(t).val(),ruta_detalle_verbo_id:$(t).attr("data-id")};
    var ruta='asignacion/persona';
    Bandeja.AsignacionPersonas(data,ruta);
}

Close=function(todo){
    $("#bandeja_detalle").hide();
    $("#txt_observacion").val("");
    if ( typeof(todo)!='undefined' ){
        $("#txt_id_ant,#txt_id_union").val("");
    }
}
Close_ruta=function(){
    $("#form_ruta_flujo .form-group").css("display","none");
}

Limpiar=function(text){
    $("#"+text).val("");
}

MostrarAjax=function(){
    Close();
    Bandeja.Cargar(HTMLCargarBandeja);
}

hora=function(){
    //Bandeja.FechaActual();
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
    $("#txt_respuesta").val(fechaTG+" "+horaTG);
    $("#div_cumple>span").html("CUMPLIENDO TIEMPO");
    $("#txt_alerta").val("0");
    $("#txt_alerta_tipo").val("0");

    $("#div_cumple").removeClass("progress-bar-danger").removeClass("progress-bar-warning").addClass("progress-bar-success");
        
        if ( fechaAux!='' && fechaAux < $("#txt_respuesta").val() ) {
            $("#txt_alerta").val("1");
            $("#txt_alerta_tipo").val("2");
            $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-warning").addClass("progress-bar-danger");
            $("#div_cumple>span").html("SE DETIENE FUERA DEL TIEMPO");
        }
        else if ( fechaAux!='' ) {
            $("#txt_alerta").val("1");
            $("#txt_alerta_tipo").val("3");
            $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-danger").addClass("progress-bar-warning");
            $("#div_cumple>span").html("SE DETIENE DENTRO DEL TIEMPO");
        }
        else if ( $("#txt_fecha_max").val() < $("#txt_respuesta").val() ) {
            $("#txt_alerta").val("1");
            $("#txt_alerta_tipo").val("1");
            $("#div_cumple").removeClass("progress-bar-success").removeClass("progress-bar-warning").addClass("progress-bar-danger");
            $("#div_cumple>span").html("NO CUMPLE TIEMPO");
        }
tiempo = setTimeout('hora()',60000);
}

activar=function(ruta_detalle_id,td,ruta_id=''){//establecer como visto
    var tr = td;
    $(tr).attr('onClick','desactivar('+ruta_detalle_id+',this)');
    $(tr).removeClass('unread');
    $(tr).find('i').removeClass('fa-ban').addClass('fa-eye');

    Bandeja.CambiarEstado(ruta_detalle_id, 1,1);
    desactivar(ruta_detalle_id,td,ruta_id);
};

desactivar=function(ruta_detalle_id,td,ruta_id = ''){//establecer como no visto
    var tr = td;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    
    $(tr).attr("style","background-color:#9CD9DE;");

    var data ={ruta_detalle_id:ruta_detalle_id};
    //mostrarDetallle(ruta_detalle_id,rutaid);
};

Liberar=function(txt){
    $("#"+txt).removeAttr("readonly");
    $("#"+txt).val("");
    $("#txt_documento_id_"+txt.split("_")[1]).val('');
    $("#"+txt).focus();
}

eventoSlctGlobalSimple=function(slct,valores){
}

/*add new verb to generate*/
Addtr = function(e){
    e.preventDefault();
    var template = $("#tbldetalleverbo").find('.trNuevo').clone().removeClass('trNuevo').removeClass('hidden');
    $("#tbldetalleverbo tbody").append(template);
}

Deletetr = function(object){
    object.parentNode.parentNode.parentNode.remove();
}

HTMLCombo = function(obj,data){
    if(data){
         html='';
        $.each(data,function(index, el) {
            html+='<option value='+el.id+'>'+el.nombre+'</option>';
        });
        $('#'+obj).html(html);
    } 
}

saveVerbo = function(){
    var id_rutadverbo = document.querySelector("#ruta_detalle_id");
    var condional = 0;
    var rol = $("#t_detalle_verbo #cboRoles").val();
    var verbo = 1;
    var doc = $("#t_detalle_verbo #cbotipoDoc").val();
    var nomb = $("#t_detalle_verbo #txtdescripcion").val();

    var data = {
        'ruta_detalle_id':id_rutadverbo.value,
        'nombre':nomb,
        'documento':doc,
        'condicion':0,
        'rol_id':rol,
        'verbo_id':1,
        'adicional' : 1,
        'orden':0,
    };
    Bandeja.Guardarrdv(JSON.stringify(data),mostrarDetallle);
}

eliminardv = function(id){
    if(id){
        var r = confirm("¿Estas seguro de eliminar?");
        if(r == true){
            var id_rutadverbo = document.querySelector("#ruta_detalle_id");
            var data = {'ruta_detalle_id':id_rutadverbo.value,'ruta_detalle_verbo_id':id,};
            Bandeja.Deleterdv(JSON.stringify(data),mostrarDetallle);            
        }
    }
}
 
expedienteUnico = function(){
    var rd_id=document.querySelector("#ruta_id").value;
    if(rd_id){
        Bandeja.ExpedienteUnico({'ruta_id':rd_id},HTMLExpedienteUnico);        
    }else{
        alert('Error');
    }
}

function HTMLExpedienteUnico(data){
    if(data.length > 0){
        var html ='';
        var cont = 0;
        var last_ref = 0;
        $.each(data,function(index, el) {
            cont+=1;
            parent = 0;child = 1;

            if(el.tipo=='r'){
                last_ref = cont;
            }else if(el.tipo == 's'){
                parent = last_ref;
                child = 2;
            }

            referido = (el.referido !=null) ? el.referido : '';
            fhora = (el.fecha_hora !=null) ? el.fecha_hora : '';
            proc =(el.proceso !=null) ? el.proceso : '';
            area =(el.area !=null) ? el.area : '';
            nord =(el.norden !=null) ? el.norden : '';

            html+="<tr data-id="+cont+" data-parent="+parent+" data-level="+child+">";
            html+=    "<td data-column=name>"+referido+"</td>";
            html+=    "<td>"+fhora+"</td>";
            html+=    "<td>"+proc+"</td>";
            html+=    "<td>"+area+"</td>";
            html+=    "<td>"+nord+"</td>";
            html+="</tr>";            
        });
        $("#tb_tretable").html(html);


        /*tree-table*/
        $(function () {
            var $table = $('#tree-table'),
            rows = $table.find('tr');

            rows.each(function (index, row) {
            var
                $row = $(row),
                level = $row.data('level'),
                id = $row.data('id'),
                $columnName = $row.find('td[data-column="name"]'),
                children = $table.find('tr[data-parent="' + id + '"]');

            if (children.length) {
                var expander = $columnName.prepend('' +
                    '<span class="treegrid-expander glyphicon glyphicon-chevron-right"></span>' +
                    '');

                children.hide();

                expander.on('click', function (e) {
                    var $target = $(e.target);
                    if ($target.hasClass('glyphicon-chevron-right')) {
                        $target
                            .removeClass('glyphicon-chevron-right')
                            .addClass('glyphicon-chevron-down');

                        children.show();
                    } else {
                        $target
                            .removeClass('glyphicon-chevron-down')
                            .addClass('glyphicon-chevron-right');

                        reverseHide($table, $row);
                    }
                });
            }

            $columnName.prepend('' +
                '<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
                '');
        });

        // Reverse hide all elements
        reverseHide = function (table, element) {
            var
                $element = $(element),
                id = $element.data('id'),
                children = table.find('tr[data-parent="' + id + '"]');

            if (children.length) {
                children.each(function (i, e) {
                    reverseHide(table, e);
                });

                $element
                    .find('.glyphicon-chevron-down')
                    .removeClass('glyphicon-chevron-down')
                    .addClass('glyphicon-chevron-right');

                children.hide();
            }
        };
    });

    }else{
        alert('no hay expediente unico');
    }
}

retornar = function(){
    var r = confirm("¿Esta Seguro de retornar al paso anterior?");
    if(r == true){
        var rd_id=document.querySelector("#ruta_detalle_id").value;
        var ruta_id=document.querySelector("#ruta_id").value;
        var nroden=document.querySelector("#txt_orden").value;
        Bandeja.retornarPaso({'ruta_detalle_id':rd_id,'ruta_id':ruta_id,'orden':nroden});            
    }else{
        alert('No es posible retornar al paso anterior');
    }
}

mostrarRuta = function(obj){
    var ruta_flujo_id = obj.getAttribute('ruta_flujo_id');
    cargarRutaId(ruta_flujo_id,2);
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
            $("#txt_area_1").val(data.area);
        }
        adicionarRutaDetalleAutomatico(data.area2,data.area_id2,data.tiempo_id+"_"+data.dtiempo,data.verbo,data.imagen,data.imagenc,data.imagenp,data.estado_ruta);
    });
    pintarAreasG(permiso);
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

HTMLCargarBandeja=function(result){
    var html="";
    $('#t_reporte_ajax').DataTable().destroy();

    $.each(result.data,function(index,r){
        visto=''; 
        eventclick='activar('+r.ruta_detalle_id+',this,'+r.ruta_id+')';
        icon='ban';
        if(r.visto>0){
            visto='unread';
            eventclick='desactivar('+r.ruta_detalle_id+',this,'+r.ruta_id+')';
            icon='eye';
        }
        console.log(eventclick);
        html+="<tr class='"+visto+"' onClick='"+eventclick+"'>"+
                "<td><i id='td_"+r.ruta_detalle_id+"' class='fa fa-"+icon+"'></i></td>"+
                "<td>"+$.trim(r.id_union_ant)+"</td>"+
                "<td>"+$.trim(r.id_union)+"</td>"+
                "<td>"+$.trim(r.tiempo)+"</td>"+
                "<td>"+$.trim(r.fecha_inicio)+"</td>"+
                "<td>"+$.trim(r.tiempo_final)+"</td>"+
                "<td>"+$.trim(r.norden)+"</td>"+
                "<td>"+$.trim(r.proceso)+"</td>"+
                "<td>"+$.trim(r.persona)+"</td>"+
             "</tr>";
    });

    $("#t_reporte_ajax tbody").html(html); 
    $("#t_reporte_ajax").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "lengthMenu": [10],
        "language": {
            "info": "Mostrando página "+result.current_page+" / "+result.last_page+" de "+result.total+" registros",
            "infoEmpty": "No éxite registro(s) aún",
        },
        "initComplete": function () {
            $('#t_reporte_ajax_paginate ul').remove();
            masterG.CargarPaginacion('HTMLCargarBandeja','Bandeja',result,'#t_reporte_ajax_paginate');
        }
    });
};

</script>
