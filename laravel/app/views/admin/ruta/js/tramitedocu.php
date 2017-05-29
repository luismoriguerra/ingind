<script type="text/javascript">
$(document).ready(function() {

     $('#fecha_nacimiento').daterangepicker({
                format: 'YYYY-MM-DD',
                singleDatePicker: true,
                showDropdowns: true
    });


    UsuarioId='<?php echo Auth::user()->id; ?>';
    DataUser = '<?php echo Auth::user(); ?>';
    poblateData('x',DataUser);
    /*Inicializar tramites*/
    var data={'persona':UsuarioId,'estado':1};
    Bandeja.MostrarPreTramites(data,HTMLPreTramite);
    /*end Inicializar tramites*/

    /*inicializate selects*/
    slctGlobalHtml('cbo_tipodocumento','simple');
    slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data); 
    slctGlobal.listarSlct('tipotramite','cbo_tipotramite','simple',null,data);
    slctGlobal.listarSlct('persona','cbo_persona','simple',null,{estado_persona:1});
    slctGlobal.listarSlct('empresa','cbo_empresa','simple',null,{estado:1});    
    slctGlobal.listarSlctFuncion('tiposolicitante','listar?pretramite=1','cbo_tiposolicitante','simple',null,{'estado':1,'validado':1});
    /*end inicializate selects*/
    
        data = {estado:1};
    var ids = [];
    slctGlobal.listarSlct('software','slct_software_id_modal','simple',ids,data);
    slctGlobal.listarSlct2('rol','slct_rol_modal',data);
    slctGlobal.listarSlct2('verbo','slct_verbo_modal',data);
    slctGlobal.listarSlct2('documento','slct_documento_modal',data);
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


    $(document).on('click', '#btnTipoSolicitante', function(event) {
        var tiposolicitante = $("#cbo_tiposolicitante").val();
        if(tiposolicitante == 1){
            Bandeja.GetPersons({'apellido_nombre':1},HTMLPersonas);
        }else if(tiposolicitante == 2){
            Bandeja.getEmpresasByPersona({'estado':1},ValidacionEmpresa);
        }
        else {
            alert("Seleccionar Tipo de Solicitante");
        }
    });

    $(document).on('click', '#btnAgregarP', function(event) {
        $("#selectPersona").modal('hide');
        $("#CrearUsuario").modal('show');
        /* Act on the event */
    });

    $(document).on('click', '#btnAgregarEmpresa', function(event) {
        $("#empresasbyuser").modal('hide');
        $("#crearEmpresa").modal('show');
        /* Act on the event */
    });
    
    $(document).on('click', '#btnSeleccionarPersona', function(event) {
//        $("#crearEmpresa").modal('hide');
        
        $("#selectPersona").modal('show');
        Bandeja.GetPersons({'apellido_nombre':1},HTMLPersonas);
        /* Act on the event */
    });

    $(document).on('click', '#btnnuevo', function(event) {
        $(".crearPreTramite").removeClass('hidden');
        
        window.scrollTo(0,document.body.scrollHeight);
    });
    
    $('#buscartramite').on('hide.bs.modal', function (event) {
//      var modal = $(this); //captura el modal
//      $("#form_ruta_tiempo input[type='hidden']").remove();
//      $("#form_ruta_verbo input[type='hidden']").remove();
      $("#buscartramite #reporte").show();
    });
     /*validaciones*/



    $(document).on('click', '.btnEnviar', function(event) {
        generarUsuario();
    });
    
    $("#cbo_tiposolicitante").change(function(){
          $('.empresa').addClass('hidden');
          $('#txt_ruc').val(''); 
          $('#txt_userdni2').val(''); 
          $('.usuarioSeleccionado').addClass('hidden');  
	});
});

CargarPreTramites = function(){
    var data={'persona':UsuarioId,'estado':1};
    Bandeja.MostrarPreTramites(data,HTMLPreTramite);
}

HTMLPreTramite = function(data){
    $('#t_reporte').dataTable().fnDestroy();
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

Detallepret = function(obj){
    var id_pretramite = obj.getAttribute('id-pretramite');
    var data = {'idpretramite':id_pretramite};
    Bandeja.GetPreTramitebyid(data,poblarDetalle);

}

poblarDetalle = function(data){
    var result = data[0];
    document.querySelector('#spanTipoTramite').innerHTML = result.tipotramite;
    document.querySelector('#spanTipoDoc').innerHTML = result.tipodoc;
    document.querySelector('#spanNombreTramite').innerHTML = result.tramite;
    document.querySelector('#spanNumFolio').innerHTML = result.folio;
    document.querySelector('#spanNumTipoDoc').innerHTML = result.nrotipodoc;
    document.querySelector('#spanTipoSolicitante').innerHTML = result.solicitante;
    document.querySelector('#spanArea').innerHTML = result.area;

    if(result.empresa){
        document.querySelector('#spanRuc').innerHTML = result.ruc;
        document.querySelector('#spanTipoEmpresa').innerHTML = result.tipoempresa;
        document.querySelector('#spanRazonSocial').innerHTML = result.empresa;
        document.querySelector('#spanNombComer').innerHTML = result.nomcomercial;
        document.querySelector('#spanDomiFiscal').innerHTML = result.edireccion;
        document.querySelector('#spanTelefonoE').innerHTML = result.etelf;
        document.querySelector('#spanFechavE').innerHTML = result.efvigencia;
/*        document.querySelector('#spanRepreL').innerHTML = result.representante_legal;
        document.querySelector('#spanDniRL').innerHTML = result.repredni;*/
        $('.empresadetalle').removeClass('hidden');        
    }else{
        $('.empresadetalle').addClass('hidden');
    }

    document.querySelector('#spanDniU').innerHTML = result.dniU;
    document.querySelector('#spanNombreU').innerHTML = result.nombusuario;
    document.querySelector('#spanNombreApeP').innerHTML = result.apepusuario;
    document.querySelector('#spanNombreApeM').innerHTML = result.apemusuario;
    document.querySelector('#spanTelefonoU').innerHTML = '';
    document.querySelector('#spanDirecU').innerHTML = '';
    $('#detallepretramite').modal('show');
}

Voucherpret = function(obj){
    var id_pretramite = obj.getAttribute('id-pretramite');
    var data = {'idpretramite':id_pretramite};
    Bandeja.GetPreTramitebyid(data,poblarVoucher);
}

poblarVoucher = function(data){
    var result = data[0];
    document.querySelector('#spanvfecha').innerHTML=result.fregistro;
    document.querySelector('#spanvcodpretramite').innerHTML=result.pretramite;
    document.querySelector('#spantArea').innerHTML=result.area;
    document.querySelector('#spanImprimir').setAttribute('idpretramite',result.pretramite);

   if(result.empresa){
        document.querySelector('#spanveruc').innerHTML=result.ruc;
        document.querySelector('#spanvetipo').innerHTML=result.tipoempresa;
        document.querySelector('#spanverazonsocial').innerHTML=result.empresa;
        document.querySelector('#spanvenombreco').innerHTML=result.nomcomercial;
        document.querySelector('#spanvedirecfiscal').innerHTML=result.edireccion;
        document.querySelector('#spanvetelf').innerHTML=result.etelf;
        document.querySelector('#spanverepre').innerHTML=result.reprelegal;
        $('.vempresa').removeClass('hidden');
    }else{
        $('.vempresa').addClass('hidden');
    }

    document.querySelector('#spanvudni').innerHTML=result.dniU;
    document.querySelector('#spanvunomb').innerHTML=result.nombusuario;
    document.querySelector('#spanvuapep').innerHTML=result.apepusuario;
    document.querySelector('#spanvuapem').innerHTML=result.apemusuario;
    document.querySelector('#spanvnombtramite').innerHTML=result.tramite;
    
    $('#voucher').modal('show');
}

exportPDF = function(obj){
    var idpretramite = obj.getAttribute('idpretramite');
    if(idpretramite){
        obj.setAttribute('href','pretramite/voucherpretramite'+'?idpretramite='+idpretramite);
       /* $(this).attr('href','reporte/exportprocesosactividades'+'?estado='+data[0]['estado']+'&area_id='+data[0]['area_id']);*/
    }else{
        event.preventDefault();
    }
}

Mostrar = function(data){
    if(data[0].pide_empresa == 1){
        $(".usuario").removeClass('hidden');
        $(".empresa").removeClass('hidden');
        Bandeja.getEmpresasByPersona({'persona':UsuarioId},ValidacionEmpresa);
    }else{
        $(".empresa").addClass('hidden');
        $(".usuario").removeClass('hidden');
        poblateData('usuario',DataUser);
    }
}

ValidacionEmpresa = function(data){
     $('#t_empresa').dataTable().fnDestroy();
    if(data.length > 1){
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr id='+el.id+'>';
            html+='<td name="ruc">'+el.ruc+'</td>';
            html+='<td name="tipo_id">'+el.tipo+'</td>';
            html+='<td name="razon_social">'+el.razon_social+'</td>';
            html+='<td name="nombre_comercial">'+el.nombre_comercial+'</td>';
            html+='<td name="direccion_fiscal">'+el.direccion_fiscal+'</td>';
            html+='<td name="telefono">'+el.telefono+'</td>';
            html+='<td name="fecha_vigencia">'+el.fecha_vigencia+'</td>';
            html+='<td name="estado">'+el.estado+'</td>';
            html+='<td name="representante">'+el.representante+'</td>';
            html+='<td name="dnirepre">'+el.dnirepre+'</td>';
            html+='<td><span class="btn btn-primary btn-sm" id-empresa='+el.id+' onClick="selectEmpresa(this)">Seleccionar</span></td>';
            html+='</tr>';
        });
        $('#tb_empresa').html(html);
         $("#t_empresa").dataTable(); 
        $('#empresasbyuser').modal('show');
    }else if(data.length == 1){
        poblateData('empresa',data[0]);
    }else{
        $(".empresa").addClass('hidden');
        alert('no cuenta con una empresa');
    }
}

selectEmpresa = function(obj){
    var idempresa = obj.getAttribute('id-empresa');
    if(idempresa != ''){
        Bandeja.GetEmpresabyId({id:idempresa});
        $('#empresasbyuser').modal('hide');
    }else{
        alert('Seleccione empresa');
    }
/*    var td = document.querySelectorAll("#t_empresa tr[id='"+idempresa+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idempresa+'}';
    poblateData('empresa',JSON.parse(data));
    $('#empresasbyuser').modal('hide');*/
}

HTMLPersonas = function(data){
     $('#t_persona').dataTable().fnDestroy();
    if(data.length > 1){
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr id='+el.id+'>';
            html+='<td name="ruc">'+el.name+'</td>';
            html+='<td name="tipo_id">'+el.paterno+'</td>';
            html+='<td name="razon_social">'+el.materno+'</td>';
            html+='<td name="nombre_comercial">'+el.dni+'</td>';
            html+='<td name="direccion_fiscal">'+el.email+'</td>';
           /* html+='<td name="telefono">'+el.telefono+'</td>';*/
            html+='<td><span class="btn btn-primary btn-sm" id-user='+el.id+' onClick="selectUser(this)">Seleccionar</span></td>';
            html+='</tr>';
        });
        $('#tb_persona').html(html);
        $("#t_persona").dataTable(); 
        $('#selectPersona').modal('show'); 
    }else{
        $(".empresa").addClass('hidden');
        alert('Error');
    }
}

selectUser = function(obj){
    var iduser = obj.getAttribute('id-user');
    if(iduser){
        Bandeja.GetPersonabyId({persona_id:iduser});
        $('#selectPersona').modal('hide');
    }else{
        alert('Seleccione persona');
    }
    }

poblateData = function(tipo,data){
/*    if(tipo == 'usuario'){*/
     /*   var result = JSON.parse(DataUser);*/
        document.querySelector('#txt_userdni').value=  '<?php echo Auth::user()->dni; ?>';
        document.querySelector('#txt_usernomb').value='<?php echo Auth::user()->nombre; ?>';
        document.querySelector('#txt_userapepat').value='<?php echo Auth::user()->paterno; ?>';
        document.querySelector('#txt_userapemat').value='<?php echo Auth::user()->materno; ?>';
    /*    user_telf.value=data.;
        user_direc.value=data.;*/
    /*  */
    if(tipo == 'empresa'){
        document.querySelector('#txt_idarea').value=data.area_id;
        document.querySelector('#txt_persona_id').value=data.persona_id;
        document.querySelector('#txt_idempresa').value=data.id;
        document.querySelector('#txt_ruc').value=data.ruc;
        document.querySelector('#txt_tipoempresa').value=data.tipo_id;
        document.querySelector('#txt_tipo').value=data.tipo;
        document.querySelector('#txt_razonsocial').value=data.razon_social;
        document.querySelector('#txt_nombcomercial').value=data.nombre_comercial;
        document.querySelector('#txt_domiciliofiscal').value=data.direccion_fiscal;
        document.querySelector('#txt_emptelefono').value=data.telefono;
        document.querySelector('#txt_empfechav').value=data.fecha_vigencia;
/*        document.querySelector('#txt_reprelegal').value=data.representante;
        document.querySelector('#txt_repredni').value=data.dnirepre;*/
        $('.empresa').removeClass('hidden');
        $('.usuarioSeleccionado').addClass('hidden');
    }

    if(tipo== 'persona'){
        document.querySelector('#txt_idarea').value=data.area_id;
        document.querySelector('#txt_persona_id').value=data.id;
        document.querySelector('#txt_userdni2').value=data.dni;
        document.querySelector('#txt_usernomb2').value=data.nombre;
        document.querySelector('#txt_userapepat2').value=data.paterno;
        document.querySelector('#txt_userapemat2').value=data.materno;
        document.querySelector('#txt_usertelf2').value=data.telefono;
        document.querySelector('#txt_userdirec2').value=data.direccion;
        $('.usuarioSeleccionado').removeClass('hidden');
        $('.empresa').addClass('hidden');
    }
    
    if(tipo== 'selectpersona'){
        document.querySelector('#FrmCrearEmpresa #txt_persona_id2').value=data.id;
        document.querySelector('#FrmCrearEmpresa #txt_persona2').value=data.nombre+" "+data.paterno+" "+data.materno;
        document.querySelector('#txt_idclasitramite').value=data.id;
//        document.querySelector('#txt_idarea').value=data.areaid;
    }


    if(tipo== 'tramite'){
        document.querySelector('#txt_nombretramite').value=data.nombre;
        document.querySelector('#txt_idclasitramite').value=data.id;
//        document.querySelector('#txt_idarea').value=data.areaid;
    }

}

consultar = function(){
    var busqueda = document.querySelector("#txtbuscarclasificador");
    var tipotramite = document.querySelector('#cbo_tipotramite');

    var data = {};
    data.estado = 1;
    if( $("#cbo_tipotramite").val()!==""){
        if(busqueda){
        data.buscar = busqueda.value;
        }
        if(tipotramite){
        data.tipotra = tipotramite.value;
        }
        Bandeja.getClasificadoresTramite(data,HTMLClasificadores);
        $(".rowArea").addClass('hidden');
        $('#buscartramite').modal('show');
    }
    else{
       alert("Seleccione tipo de documento"); 
    }
    
}

HTMLClasificadores = function(data){
    if(data.length > 0){
        $("#t_clasificador").dataTable().fnDestroy();
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr>';
            html+='<td>'+el.id+'</td>';
            html+='<td style="text-align: left">'+el.nombre_clasificador_tramite+'</td>';
            html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onClick="getRequisitos(this)">Ver</span></td>';
            html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onclick="selectClaTramite(this)">Seleccionar</span></td>';
            html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onclick="cargarRutaId('+el.ruta_flujo_id+',2)">Ver Ruta</span></td>';
            html+='</tr>';        
        });
        $("#tb_clasificador").html(html);
        $("#t_clasificador").dataTable(
                {
                    "order": [[ 0, "asc" ],[1, "asc"]],
                }
        ); 
        $("#t_clasificador").show();        
    }else{
        alert('no hay data');
    }
}

selectClaTramite = function(obj){
    data ={'id':obj.getAttribute('id'),'nombre':obj.getAttribute('nombre')};
    poblateData('tramite',data);
    $('#buscartramite').modal('hide');
   /* Bandeja.GetAreasbyCTramite({'idc':obj.getAttribute('id')},data);*/
}

selectCA = function(obj){
    var areaid= obj.value;
    var area_nomb = document.querySelectorAll("#slcAreasct option[value='"+areaid+"']");
    var cla_id = document.querySelector('#txt_clasificador_id').value;
    var cla_nomb = document.querySelector('#txt_clasificador_nomb').value;
    var data ={'id':cla_id,'nombre':cla_nomb,'area':area_nomb[0].textContent,'areaid':areaid};
    poblateData('tramite',data);
    $('#buscartramite').modal('hide');

}
/*
confirmInfo = function(data,tipo){
    if(tipo == 'incompleto'){ //falta seleccionar su area
        var areaSelect = document.querySelector("#slcAreasct");
        if(areaSelect.value != ''){
            data.area = areaSelect.value;
            poblateData('tramite',data);
            $('#buscartramite').modal('hide');
        }else{
            alert('seleccione una area');
        }
    }else{
        poblateData('tramite',data);
        $('#buscartramite').modal('hide');
    }
}
*/
getRequisitos = function(obj){
    data = {'idclatramite':obj.getAttribute('id'),'estado':1};
    Bandeja.getRequisitosbyclatramite(data,HTMLRequisitos,obj.getAttribute('nombre'));
}

HTMLRequisitos = function(data,tramite){
    $("#tb_requisitos").html('');
    if(data){
        var html ='';
        $.each(data,function(index, el) {
            html+='<tr><ul>';
            html+='<td style="text-align: left;"><li>'+el.nombre+'</li></td>';
            html+='<td>'+el.cantidad+'</td>';
            html+='<ul></tr>';
        });
        $("#tb_requisitos").html(html);
        $("#nombtramite").text(tramite);
        $("#requisitos").modal('show');
    }
}

generarPreTramite = function(){

    if($("#cbo_tipodocumento").val()==''){
        alert('Selecciona Tipo');
    }
    else if($("#cbo_tiposolicitante").val()==''){
        alert('Selecciona Tipo de Solicitante');
    }
    else if($("#cbo_tipotramite").val()==''){
        alert('Seleccione Tipo de Trámite');
    }
    else if($("#cbo_tipodoc").val()==''){
        alert('Seleccione Tipo de Documento');
    }
    else if($("#txt_nombretramite").val()==''){
        alert('Seleccione Nombre de trámite');
    }
    else if($("#txt_ruc").val()=='' && $("#txt_userdni2").val()==''){
        alert('Seleccione Empresa o Persona');
    }
        else{
        datos=$("#FormCrearPreTramite").serialize().split("txt_").join("").split("slct_").join("").split("%5B%5D").join("[]").split("+").join(" ").split("%7C").join("|").split("&");
        data = '{';
        for (var i = 0; i < datos.length ; i++) {
            var elemento = datos[i].split('=');
            data+=(i == 0) ? '"'+elemento[0]+'":"'+elemento[1] : '","' + elemento[0]+'":"'+elemento[1];   
        }
        data+='"}';
        Bandeja.GuardarPreTramite(data);
       
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

generarUsuario = function(){
    if($("#nombre").val() == ''){
        alert('Digite su nombre');
    }else if($("#paterno").val() == ''){
        alert('Digite su apellido paterno');
    }else if($("#materno").val() == ''){
        alert('Digite su apellido materno');
    }else if($("#dni").val() == ''){
        alert('Digite su dni');
    }else if($("#email").val() == ''){
        alert('Digite su email');
    }else{
        Bandeja.guardarUsuario();        
    }
}

generarEmpresa = function(){
    if($("#txt_ruc2").val() == ''){
        alert('Digite su ruc');
    }else if($("#txt_razonsocial2").val() == ''){
        alert('Digite su razon social');
    }else if($("#txt_nombcomer").val() == ''){
        alert('Digite su nombre comercial');
    }else if($("#txt_direcfiscal").val() == ''){
        alert('Digite su direccion fiscal');
    }else if($("#cbo_tipoempresa").val() == ''){
        alert('Seleccione un tipo de empresa');
    }else{
        Bandeja.guardarEmpresa();        
    }
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
