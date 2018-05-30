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
$(document).ready(function() {
    $("[data-toggle='offcanvas']").click();
    RolIdG='<?php echo Auth::user()->rol_id; ?>';
    UsuarioId='<?php echo Auth::user()->id; ?>';

    slctGlobal.listarSlct('lista/tipovizualizacion','slct_tipo_visualizacion','multiple',null,null);    

    if( RolIdG==8 || RolIdG==9 ){
        var data={estado_persona:1,solo_area:1};
        //slctGlobal.listarSlct('persona','cboPersona','simple',null,data);
        slctGlobal.listarSlct('persona','slct_persona','simple',null,data);
    }else{
        $("#btnAdd").addClass('hidden');
    }

    Bandeja.MostrarAjax();

    slctGlobal.listarSlct('ruta_detalle','slct_area2_id','simple');
    slctGlobalHtml('slct_tipo_respuesta,#slct_tipo_respuesta_detalle','simple');

    $("#btn_guardar_todo").click(guardarTodo);
    hora();

    $('#expedienteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var text = $.trim( button.data('text') );
      var id= $.trim( button.data('id') );
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
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

Limpiar=function(text){
    $("#"+text).val("");
}

MostrarAjax=function(t){
    if( t=="docs" ){
        if( columnDefsG.length>0 ){
            dataTableG.CargarDatos(t,'docs','cargar',columnDefsG);
        }
        else{
            alert('Faltas datos');
        }
    }
    else{
        Close();
        Bandeja.MostrarAjax();
    }
}

GeneraFn=function(row,fn){ // No olvidar q es obligatorio cuando queire funcion fn
    if(typeof(fn)!='undefined' && fn.col==3){
        var estadohtml='';
        estadohtml='<span id="'+row.id+'" onClick="CargarDoc(\''+row.id+'\',\''+row.titulo+'\')" class="btn btn-success"><i class="fa fa-lg fa-check"></i></span>';
        return estadohtml;
    }
};

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

activar=function(id,ruta_detalle_id,td){//establecer como visto
    var tr = td;
    $(tr).attr('onClick','desactivar('+id+','+ruta_detalle_id+',this)');
    $(tr).removeClass('unread');
    $(tr).find('i').removeClass('fa-ban').addClass('fa-eye');

    Bandeja.CambiarEstado(ruta_detalle_id, id,1);
    //tambien debera cargar un detalle en la parte de abajo
    desactivar(id,ruta_detalle_id,td);
};

desactivar=function(id,ruta_detalle_id,td){//establecer como no visto
    var tr = td;
    var trs = tr.parentNode.children;
    for(var i =0;i<trs.length;i++)
        trs[i].style.backgroundColor="#f9f9f9";
    
    $(tr).attr("style","background-color:#9CD9DE;");

    var data ={ruta_detalle_id:ruta_detalle_id};
    mostrarDetallle(ruta_detalle_id);
};

validacheck=function(val,idcheck){
    var verboaux="";
    var validacheck=0;
    var usuario=idcheck.split("_")[3];
    if( usuario=='' || usuario=='0' || ( usuario!='' && usuario==UsuarioId ) || ( RolIdG==8 || RolIdG==9 ) ){
        if( val>0 ){
            $("#t_detalle_verbo input[type='checkbox']").removeAttr('disabled');
        }
        disabled=false;
        $("#t_detalle_verbo input[type='checkbox']").each(
            function( index ) { 
                if ( val>0 && $(this).is(':checked') && $(this).attr("class")=='check'+val ) {
                    disabled=true;
                }
                    verboaux+= "|"+$(this).val();
                    if( val>0 && $(this).attr("class")!='check0' && $(this).attr("class")!='check'+val ){
                        $(this).attr("disabled","true");
                        $(this).removeAttr("checked");
                    }
            }
        );

        if(disabled==false && val>0){
            $("#t_detalle_verbo input[type='checkbox']").removeAttr('disabled');
        }
    }
    else{
        $("#"+idcheck).removeAttr("checked");
        alert(".::Ud no cuenta con permisos para realizar esta tarea::.");
    }
}


mostrarDetallle=function(id){ //OK
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

    /*add new ruta detalle verbo*/
    var filtro={estado:1};
    slctGlobal.listarSlct2('documento','cbotipoDoc',filtro);
    slctGlobal.listarSlct2('rol','cboRoles',filtro);
    /*Bandeja.poblarCombo('documento','cbotipoDoc',filtro,HTMLCombo);
    Bandeja.poblarCombo('rol','cboRoles',filtro,HTMLCombo);*/
    /*add new ruta detalle verbo*/

    if( RolIdG==8 || RolIdG==9 ){
        $("#slct_persona").attr("data-id",datos.carta_deglose_id);
        $("#slct_persona").val('');
        $('#slct_persona').multiselect('rebuild');
        $("#slct_persona").val(datos.persona_id);
        $('#slct_persona').multiselect('rebuild');
    }
    else{
        $("#slct_persona").html(datos.persona_responsable);
    }
    //$('#slct_tipo_respuesta,#slct_tipo_respuesta_detalle').attr('disabled',"true");
    slctGlobal.listarSlct('tiporespuesta','slct_tipo_respuesta','simple',ids,data,0,'#slct_tipo_respuesta_detalle','TR');
    slctGlobal.listarSlct('tiporespuestadetalle','slct_tipo_respuesta_detalle','simple',ids,data,1);
    $("#form_ruta_detalle [data-target='#expedienteModal']").attr("data-id",datos.id_tr);

    $("#form_ruta_detalle #txt_fecha_tramite").val(datos.fecha_tramite);
    $("#form_ruta_detalle #txt_sumilla").val(datos.sumilla);
    $("#form_ruta_detalle #txt_solicitante").val(datos.solicitante);

    $("#form_ruta_detalle #txt_flujo").val(datos.flujo);
    $("#form_ruta_detalle #txt_area").val(datos.area);
    $("#form_ruta_detalle #txt_id_doc").val(datos.id_doc);
    $("#form_ruta_detalle #txt_orden").val(datos.norden);
    $("#form_ruta_detalle #txt_fecha_inicio").val(datos.fecha_inicio);
    $("#form_ruta_detalle #txt_tiempo").val(datos.tiempo);

    $("#form_ruta_detalle>#txt_fecha_max").remove();
    $("#form_ruta_detalle").append("<input type='hidden' id='txt_fecha_max' name='txt_fecha_max' value='"+datos.fecha_max+"'>");

  /*  $("#t_detalle_verbo").html("");*/
    var detalle="";
    var html="";
    var imagen="";
    var obs="";
    var cod="";
    var rol="";
    var verbo="";
    var documento="";
    var orden="";
    var archivo="";

    $("#t_detalle_verbo").html("");
        if ( datos.verbo!='' ) {
            detalle=datos.verbo.split("|");
            html="";
            for (var i = 0; i < detalle.length; i++) {

                imagen = "<i class='fa fa-check fa-lg'></i>";
                imagenadd = "<ul><li>"+detalle[i].split("=>")[4].split("^").join("</li><li>")+"</li></ul>";
                obs = detalle[i].split("=>")[5];

                rol = detalle[i].split("=>")[6];
                verbo = detalle[i].split("=>")[7];
                documento = detalle[i].split("=>")[8];

                if(detalle[i].split("=>")[13] == 1 && detalle[i].split("=>")[2]=="Pendiente" && (RolIdG==8 || RolIdG==9)){
                    orden = '<span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-xs btnDelete" onclick="eliminardv('+detalle[i].split("=>")[0]+')"><i class="glyphicon glyphicon-trash"></i></span>';
                }else{
                    orden = detalle[i].split("=>")[9];
                }
                
                archivo="";
                denegar=false;

                persona=detalle[i].split("=>")[10];
                fecha ='';
                if( detalle[i].split("=>")[2]!="Pendiente" ){
                    fecha=detalle[i].split("=>")[11];
                }
                else if( RolIdG==8 || RolIdG==9 ){
                    persona="<select data-id='"+detalle[i].split("=>")[0]+"' onChange='ActualizarPersona(this);'>"+$("#slct_persona").html()+"</select>";
                }

                if(detalle[i].split("=>")[2]=="Pendiente"){
                    if(detalle[i].split("=>")[3]=="NO"){
                        valorenviado=0;
                    }
                    else{
                        valorenviado=detalle[i].split("=>")[3]*1;
                    }

                    if( datos.maximo!=0 && valorenviado!=0 && valorenviado!=datos.maximo ){
                        denegar=true;
                    }
                    /*imagenadd=  '<div class="input-group success">'+
                                '   <div class="input-group-addon btn btn-success" onclick="adicionaDetalleVerbo('+detalle[i].split("=>")[0]+');">'+
                                '       <i class="fa fa-plus fa-lg"></i>'+
                                '   </div>'+
                                '   <input type="text" class="txt'+valorenviado+' txt_'+detalle[i].split("=>")[0]+'" data-inputmask="'+"'alias'"+': '+"'email'"+'" data-mask/>'+
                                '</div>';*/
                    if(denegar==true){
                        imagen="";
                    }
                    else{

                        obs = "<textarea class='area"+valorenviado+"' name='area_"+detalle[i].split("=>")[0]+"' id='area_"+detalle[i].split("=>")[0]+"'></textarea>";
                        //imagen="<input type='checkbox' class='check"+valorenviado+"' onChange='validacheck("+valorenviado+",this.id);' value='"+detalle[i].split("=>")[0]+"' name='chk_verbo_"+detalle[i].split("=>")[0]+"' id='chk_verbo_"+detalle[i].split("=>")[0]+"_"+$.trim(detalle[i].split("=>")[12])+"'>";
                        //imagen="<input type='checkbox' class='check"+valorenviado+"' onChange='validacheck("+valorenviado+",this.id);' value='"+detalle[i].split("=>")[0]+"' name='chk_verbo_"+detalle[i].split("=>")[0]+"' id='chk_verbo_"+detalle[i].split("=>")[0]+"_"+$.trim(detalle[i].split("=>")[12])+"'>";

                        imagen='<div class="checkbox">'+
                                    '<label style="font-size: 1.5em">'+
                                        '<input class="check'+valorenviado+'" onChange="validacheck('+valorenviado+',this.id);" type="checkbox" value="'+detalle[i].split("=>")[0]+'" name="chk_verbo_'+detalle[i].split("=>")[0]+'" id="chk_verbo_'+detalle[i].split("=>")[0]+'_'+$.trim(detalle[i].split("=>")[12])+'">'+
                                        '<span class="cr" style="background-color: #fff;"><i class="cr-icon fa fa-check"></i></span>'+                                
                                    '</label>'+
                                '</div>';

                        imagenadd= '<input disabled type="text" class="form-control txt'+valorenviado+' txt_'+detalle[i].split("=>")[0]+'"/>';
                        if(verbo=="Generar"){
                            imagenadd= '<input data-pos="'+(i*1+1)+'" type="text" readonly class="form-control txt'+valorenviado+' txt_'+detalle[i].split("=>")[0]+'" id="documento_'+detalle[i].split("=>")[0]+'" name="documento_'+detalle[i].split("=>")[0]+'" value="" /><input type="hidden" id="txt_documento_id_'+detalle[i].split("=>")[0]+'" name="txt_documento_id_'+detalle[i].split("=>")[0]+'" value="">'+
                                        '<span class="btn btn-primary" data-toggle="modal" data-target="#docsModal" data-texto="documento_'+detalle[i].split("=>")[0]+'" data-id="txt_documento_id_'+detalle[i].split("=>")[0]+'" id="btn_buscar_indedocs">'+
                                            '<i class="fa fa-search fa-lg"></i>'+
                                         '</span>'+
                                         '<span class="btn btn-warning" onClick="Liberar(\'documento_'+detalle[i].split("=>")[0]+'\')" >'+
                                            '<i class="fa fa-pencil fa-lg"></i>'+
                                         '</span>';
                            archivo='<input class="form-control" id="archivo_'+detalle[i].split("=>")[0]+'" name="archivo_'+detalle[i].split("=>")[0]+'" type="file">';
                        }
                    }
                }

                html=  "<tr>"+
                            "<td style='vertical-align : middle;'>"+orden+"</td>"+
                            "<td style='vertical-align : middle;'>"+detalle[i].split("=>")[3]+"</td>"+
                            "<td style='vertical-align : middle;'>"+rol+"</td>"+
                            "<td style='vertical-align : middle;'>"+verbo+"</td>"+
                            "<td style='vertical-align : middle;'>"+documento+"</td>"+
                            "<td style='vertical-align : middle;'>"+detalle[i].split("=>")[1]+"</td>"+
                            "<td style='vertical-align : middle;' id='td_"+detalle[i].split("=>")[0]+"'>"+imagenadd+"</td>"+
                            "<td style='vertical-align : middle;'>"+obs+"</td>"+
                            //"<td>"+archivo+"</td>"+
                            "<td style='vertical-align : middle;'>"+persona+"</td>"+
                            "<td style='vertical-align : middle;'>"+fecha+"</td>"+
                            "<td style='vertical-align : middle;'>"+imagen+"</td>"+
                        "</tr>";
                $("#t_detalle_verbo").append(html);
                if( $.trim( detalle[i].split("=>")[12] )!='' && (RolIdG==8 || RolIdG==9) ){
                    $("#t_detalle_verbo select[data-id='"+detalle[i].split("=>")[0]+"'] option[value='"+detalle[i].split("=>")[12]+"']").attr("selected",true);
                }
            }
        }

}

Liberar=function(txt){
    $("#"+txt).removeAttr("readonly");
    $("#"+txt).val("");
    $("#txt_documento_id_"+txt.split("_")[1]).val('');
    $("#"+txt).focus();
}

guardarTodo=function(){
    var verboaux="";
    var codaux="";
    var obsaux="";
    var coddocaux="";
    var contcheck=0;
    var conttotalcheck=0;
    var alerta=false;
    var codauxd="";
    var validacheck=0;
    $("#t_detalle_verbo input[type='checkbox']").each(
        function( index ) { 
            if ( $(this).is(':checked') && alerta==false ) {
                codauxd="";
                $("#td_"+$(this).val()+" input[type='text']").each(
                    function( indx ) {
                        if( $(this).val()!="" ){
                            codauxd+="^"+$(this).val();
                        }
                    }
                );
                verboaux+="|"+$(this).val();
                codaux+= "|"+codauxd.substr(1);
                obsaux+="|"+$("#area_"+$(this).val()).val();
                coddocaux+="|"+$("#txt_documento_id_"+$(this).val()).val();
                contcheck++;

                if( $("#documento_"+$(this).val()).val()=="" ){
                    alert("Busque y Seleccione Nro del documento generado de la tarea "+$("#documento_"+$(this).val()).attr("data-pos"));
                    alerta=true;
                }
            }
            else if( !$(this).attr("disabled") ){
                validacheck=1;
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
        coddocaux=coddocaux.substr(1);
        $("#form_ruta_detalle>#coddocg").remove();
        $("#form_ruta_detalle").append("<input type='hidden' id='coddocg' name='coddocg' value='"+coddocaux+"'>");
    }

    if( $("#slct_tipo_respuesta").val()=='' && conttotalcheck>0 && contcheck==0 && alerta==false ) {
            alert("Seleccione al menos 1 check");
    }
    else if ( $("#slct_tipo_respuesta").val()=='' && validacheck==0 && alerta==false ) {
        alert("Seleccione Tipo de Respuesta");
    }
    else if ( $("#slct_tipo_respuesta_detalle").val()=='' && validacheck==0 && alerta==false ) {
        alert("Seleccione Detalle Tipo Respuesta");
    }
    else if ( $("#txt_observacion").val()=='' && validacheck==0 && alerta==false ) {
        alert("Ingrese Descripción de respuesta de la Actividad");
    }
    else if ( $("#slct_tipo_respuesta").val()!='' && validacheck==1 && alerta==false 
                && $("#slct_tipo_respuesta option[value='"+$("#slct_tipo_respuesta").val()+"']").attr("data-evento").split("_")[1]=='0'
            ) {
        alert("El tipo de respuesta seleccionada solo esta permitida cuando este activada todas las tareas habilitadas");
    }
    else if ( $("#slct_tipo_respuesta_detalle").val()=='' && $("#slct_tipo_respuesta").val()!='' ) {
        alert("Seleccione Detalle Tipo Respuesta");
    }
    else if ( $("#txt_observacion").val()!='' && $("#slct_tipo_respuesta").val()=='' ) {
        alert("La Descripción de respuesta de la Actividad, solo esta permitido cuando seleccione Tipo de respuesta");
    }
    else if( alerta==false ){
        if( confirm("Favor de confirmar para actualizar su información") ){
            if(validacheck==0 || $("#slct_tipo_respuesta").val()!=''){
                $('#slct_tipo_visualizacion').multiselect('deselectAll');
                $('#slct_tipo_visualizacion').multiselect('refresh');
                Validar.guardarValidacion();
            }
            else{
                Validar.guardarValidacion(mostrarDetallle,$("#form_ruta_detalle>#ruta_detalle_id").val() );
            }
        }
    }
}

eventoSlctGlobalSimple=function(slct,valores){
    if( slct=="slct_tipo_respuesta" ){
        var detval=valores.split("|").join("").split("_");
        fechaAux="";
        if ( detval[1]==1 ) {
        fechaAux=detval[2];
        }
    }
}

/*add new verb to generate*/
Addtr = function(e){
    e.preventDefault();
    var template = $("#tbldetalleverbo").find('.trNuevo').clone().removeClass('trNuevo').removeClass('hidden');
    $("#tbldetalleverbo tbody").append(template);
}
/*end add new verb to generate*/

/*delete tr*/
Deletetr = function(object){
    object.parentNode.parentNode.parentNode.remove();
}
/*end delete tr*/

/*poblate combo*/
HTMLCombo = function(obj,data){
    if(data){
         html='';
        $.each(data,function(index, el) {
            html+='<option value='+el.id+'>'+el.nombre+'</option>';
        });
        $('#'+obj).html(html);
    } 
}
/*end poblate combo */

/*save new ruta_detalle_verbo*/
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
/*end save new ruta_detalle_verbo */

/*delete rdv*/
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
/*end delete rdv*/

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<fieldset> <legend>    Agencies  </legend>   <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>agencies has to come from data attributes from tds</td>'+
        '</tr>'+
        '<tr>'+
            '<td>agencies has to come from data attributes from tds</td>'+
        '</tr>'+
        '<tr>'+
            '<td>agencies has to come from data attributes from tds</td>'+
        '</tr>'+
    '</table> </fieldset>' 
        
}
$(document).ready(function() {
     var table = $('#example').DataTable();
     
    
    function HTMLExpedienteUnico(){
        $('#example').dataTable().fnDestroy();
        if(data){
            var html ='';
            $.each(data,function(index, el) {
                html+="<tr>";
                html+=    "<td>"+el.pretramite +"</td>";
                html+=    "<td>"+el.usuario+"</td>";
                
                if(el.empresa){
                    html+=    "<td>"+el.empresa+"</td>";                
                }else{
                    html+=    "<td>"+el.usuario+"</td>";
                }
                
                html+=    "<td>"+el.solicitante+"</td>";
                html+=    "<td>"+el.tipotramite+"</td>";
                html+=    "<td>"+el.tipodoc+"</td>";
                html+=    "<td>"+el.tramite+"</td>";
                html+=    "<td>"+el.fecha+"</td>";
                html+=    '<td><span class="btn btn-primary btn-sm" id-pretramite="'+el.pretramite+'" onclick="Detallepret(this)"><i class="glyphicon glyphicon-th-list"></i></span></td>';
                html+=    '<td><span class="btn btn-primary btn-sm" id-pretramite="'+el.pretramite+'" onclick="Voucherpret(this)"><i class="glyphicon glyphicon-search"></i></span></td>';
                html+="</tr>";            
            });
            $("#tb_reporte").html(html);
            $("#t_reporte").dataTable(); 
        }else{
            alert('no hay nada');
        }
    }

// Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            console.log(row);
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
   // End add event 
    
    $("#divPopUp").dialog({
        resizable: true,
        autoOpen: false,
        width: 550,
        modal: true,
        buttons: {
            "Save": function() {
                var text = $(this).find( ":checkbox:checked" ).map(function() {
                    return this.value+' ';
                }).get().join();
                
                var obj = $(this).data("opener");
                $(obj).parents('td:first').siblings(':eq(2)').find(':text').val(text);
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        },
        close:function(){
            $(this).find( ":checkbox" ).removeAttr('checked');
            $( this ).dialog( "close" );
        }
    });
    
    $('button.btn').on('click', function(){
        var title = $(this).parents('td:first').siblings(':eq(0)').text();
        console.log("title is : "  + title);
        $( "#divPopUp" ).data('opener', this).dialog( "option", "title", title ).dialog( "open" );
        var text = $(this).parents('td:first').siblings(':eq(2)').find(':input').val();
        if($.trim(text) != ''){
            var texts = text.split(" ,"); 
            $.each(texts, function(i, value){ $("#divPopUp").find(':checkbox[value="'+$.trim(value)+'"]').prop('checked', true);
            });
        }
    });
} );
</script>
