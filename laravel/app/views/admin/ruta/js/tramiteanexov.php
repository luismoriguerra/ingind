<script type="text/javascript">

$(document).ready(function() {
    /*Inicializar tramites*/

    UsuarioId='<?php echo Auth::user()->id; ?>';
    var data={estado:1};
    Bandeja.MostrarTramites(data,HTMLTramites);
    /*end Inicializar tramites*/
    slctGlobal.listarSlctFuncion('tiposolicitante','listar?pretramite=1','cbo_tiposolicitante','simple',null,{'estado':1,'validado':1});
    slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data);

    function limpia(area) {
       /* $(area).find('input[type="text"],input[type="email"],textarea,select').val('');*/
        $('#spanRuta').addClass('hidden');
        $('.img-anexo').attr('src','index.img');
        $('#txt_folio,#txt_anexoid,#txt_observ').val('');
        $('#cbo_tipodoc').multiselect('destroy');
        slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,{estado:1},1);
    };

    $('#addAnexo').on('hidden.bs.modal', function(){
        limpia(this);
    });


    $("form[name='FormNuevoAnexo']").submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: 'anexo/create',
            data: new FormData($(this)[0]),
            processData: false,
            contentType: false,
            success: function (obj) {
                if(obj.rst==1){
                   $('#addAnexo').modal('hide');
                   mostrarAnexos('',document.querySelector('#txt_idtramite').value);
                }
            }
        });
     });

    $(document).on('click', '#btnImagen', function(event) {
        $('#txt_file').click();
    });
    
    $(document).on('change', '#txt_file', function(event) {
        readURLI(this,'file');
    });
    
    $(document).on('click', '#btnTipoSolicitante', function(event) {
            Bandeja.GetPersons({'apellido_nombre':1},HTMLPersonas);
        
    });
    function readURLI(input, tipo) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (tipo == 'file') {                 
                    $('.img-anexo').attr('src',e.target.result);
                    /*$('#spanRuta').text(input.value);
                    $('#spanRuta').removeClass('hidden');*/
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
});

mostrarTramites = function(){
    var busqueda = document.querySelector('#txtbuscar').value;
    var data ={};
    data.estado = 1;
    data.persona = UsuarioId;
    if(busqueda){
        data.buscar = busqueda;
    }
    Bandeja.MostrarTramites(data,HTMLTramites);
}

HTMLTramites = function(data){
    if(data.length > 0){
        $("#t_reporte").dataTable().fnDestroy();
        var html ='';pos=1;
        $.each(data,function(index, el) {
            html+="<tr id="+el.codigo+" numdoc="+el.numdoc+" tramite="+el.id_union+">"+
                "<td name='item'>"+pos+"</td>"+  
                "<td name='codigo'>"+el.id_union +"</td>"+
                "<td name='nombre'>"+el.tramite+"</td>"+
                "<td name='fechaingreso'>"+el.fecha_ingreso+"</td>"+
                "<td name='persona'>"+el.persona+"</td>"+
                "<td name='observacion'>"+el.observacion+"</td>"+
                "<td><span class='btn btn-primary btn-sm' onClick='seleccionado(this),mostrarAnexos(this)'><i class='glyphicon glyphicon-th-list'></i></span></td>"+
                "<td><span class='btn btn-primary btn-sm' idtramite='"+el.codigo+"' onclick='selectTramitetoDetail(this)'><i class='glyphicon glyphicon-search'></i></span></td>"+
            "</tr>"; 
            pos++;
        });
        $("#tb_reporte").html(html);
        $("#t_reporte").dataTable(
            {
                "order": [[ 0, "asc" ],[1, "asc"]],
            }
        ); 
        $("#t_reporte").show();
    }else{
        alert('no hay nada');
    }
}

selectTramitetoDetail = function(obj){
    /*var idtramite = obj.parentNode.parentNode.getAttribute('id');
    var td = document.querySelectorAll("#t_reporte tr[id='"+idtramite+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idtramite+'}';
    HTMLDetalleTramite(JSON.parse(data));
    $('#estadoTramite').modal('show');*/
      var idtramite = obj.parentNode.parentNode.getAttribute('id');
    Bandeja.TramiteById({'idtramite':idtramite},HTMLDetalleTramite);
}

HTMLDetalleTramite = function(data){
    var result = data[0];
    document.querySelector('#spanTramite').innerHTML=result.id_union;
    document.querySelector('#spanTipoTramite').innerHTML=result.tipotramite;
    document.querySelector('#spanTipoDoc').innerHTML=result.tipodoc;
    document.querySelector('#spanNombreTramite').innerHTML=result.tramite;
    document.querySelector('#spanNumFolio').innerHTML=result.folio;
    document.querySelector('#spanNumTipoDoc').innerHTML=result.nrotipodoc;
    document.querySelector('#spanArea').innerHTML=result.area;
    document.querySelector('#spanTipoSolicitante').innerHTML=result.solicitante;
    document.querySelector('#spanImprimir2').setAttribute('idtramite',result.tramiteid);

    if(result.empresaid){
        document.querySelector('#spanRuc').innerHTML=result.ruc;
        document.querySelector('#spanTipoEmpresa').innerHTML=result.tipoempresa;
        document.querySelector('#spanRazonSocial').innerHTML=result.empresa;
        document.querySelector('#spanNombComer').innerHTML=result.nomcomercial;
        document.querySelector('#spanDomiFiscal').innerHTML=result.edireccion;
        document.querySelector('#spanTelefonoE').innerHTML=result.etelf;
        document.querySelector('#spanFechavE').innerHTML=result.fregistro;
        document.querySelector('#spanRepreL').innerHTML=result.reprelegal;
        document.querySelector('#spanDniRL').innerHTML=result.repredni;
        document.querySelector('.empresadetalle').classList.remove('hidden');    
    }else{
        document.querySelector('.empresadetalle').classList.add('hidden'); 
    }


    document.querySelector('#spanDniU').innerHTML=result.dniU;
    document.querySelector('#spanNombreU').innerHTML=result.nombusuario;
    document.querySelector('#spanNombreApeP').innerHTML=result.apepusuario;
    document.querySelector('#spanNombreApeM').innerHTML=result.apemusuario;
    $('#estadoTramite').modal('show');
   /* document.querySelector('#txtcodtramite').value=data.codigo;
    document.querySelector('#txtfechaIngresado').value=data.fechaingreso;
    document.querySelector('#txtnombtramite').value=data.nombre;
    document.querySelector('#txtdetalle').value=data.observacion;*/
}

seleccionado = function(obj){
    if(obj){
        var tr = document.querySelectorAll("#t_reporte tr");
        for (var i = 0; i < tr.length; i++) {
            tr[i].setAttribute("style","background-color:#f9f9f9;");
        }
        obj.parentNode.parentNode.setAttribute("style","background-color:#9CD9DE;");

        /*poblate info acoording to select to create new anexo*/
        var idtramite = obj.parentNode.parentNode.getAttribute("id");
        var nombret = document.querySelectorAll("#t_reporte tr[id='"+idtramite+"'] td[name='nombre']");
        var numdoc = obj.parentNode.parentNode.getAttribute("numdoc");
        var tramite = obj.parentNode.parentNode.getAttribute("tramite");
        document.querySelector('#txt_idtramite').value=idtramite;
        document.querySelector('#txt_codtramite').value=idtramite;
        document.querySelector('#txt_tramite').value=tramite;
        $('#txt_nombtramite').val(nombret[0].innerHTML);
        $('#txt_fechaingreso').val(new Date().toLocaleString());
        document.querySelector('#txt_numdocA').value= numdoc;
        /*end poblate info acoording to select to create new anexo*/
    }
}

mostrarAnexos = function(obj,idtramite = ''){
    var id_tramite = '';
    if(idtramite){
        id_tramite = idtramite;
    }else{
        id_tramite = obj.parentNode.parentNode.getAttribute("id");        
    }

    var data={'idtramite':id_tramite};
    Bandeja.MostrarAnexos(data,HTMLAnexos);
}

/*mostrarAnexos = function(obj){
    var idtramite = obj.parentNode.parentNode.getAttribute("id");*/
  /*  var nombret = document.querySelectorAll("#t_reporte tr[id='"+idtramite+"'] td[name='nombre']");
    var numdoc = obj.parentNode.parentNode.getAttribute("numdoc");*/

    /*poblate info in new anexo*/
   /* document.querySelector('#txt_idtramite').value=idtramite;
    document.querySelector('#txt_codtramite').value=idtramite;
    document.querySelector('#txt_nombtramite').value=nombret[0].innerHTML;
    document.querySelector('#txt_fechaingreso').value= new Date().toLocaleString();
    document.querySelector('#txt_numdocA').value= numdoc;*/
    /*end poblate info in new anexo*/

/*    var data={'idtramite':idtramite};
    Bandeja.MostrarAnexos(data,HTMLAnexos);
}*/

HTMLAnexos = function(data,$tipo_busqueda = ''){
    $('.nuevoanexo').removeClass('hidden');
    if(data.length > 0){
        $("#t_anexo").dataTable().fnDestroy();
        var html ='';
        pos=1;
        $.each(data,function(index, el) {
            html+="<tr idanexo="+el.codigoanexo+">";
            html+="<td name='codigo'>"+pos +"</td>";
            html+="<td name='nombre'>"+el.nombreanexo+"</td>";
            html+="<td name='fechaingreso'>"+el.fechaingreso+"</td>";
            html+="<td name='persona'>"+el.usuarioregistrador+"</td>";
            html+="<td name='observacion'>"+el.observacion+"</td>";
            html+="<td name='area'>"+el.area+"</td>";
            html+="<td><span class='btn btn-primary btn-sm' idanexo='"+el.codigoanexo+"' onclick='selectAnexotoDetail(this)'><i class='glyphicon glyphicon-search'></i></span></td>";
            html+="<td><span class='btn btn-primary btn-sm' idanexo='"+el.codigoanexo+"' onclick='selectVoucher(this)'><i class='glyphicon glyphicon-open'></i></span></td>";
            html+="<td><span class='btn btn-primary btn-sm' idanexo='"+el.codigoanexo+"' onclick='selectToEdit(this)'><i class='glyphicon glyphicon-pencil'></i></span></td>";
            if(el.observacion){
                html+="<td><span class='btn btn-danger btn-sm' idanexo='"+el.codigoanexo+"' style='opacity:0.5'><i class='glyphicon glyphicon-trash'></i></span></td>";                     
            }else{
                 html+="<td><span class='btn btn-danger btn-sm' idanexo='"+el.codigoanexo+"' onclick='deleteAnexo(this)'><i class='glyphicon glyphicon-trash'></i></span></td>";          
            }

            html+="</tr>";   
            pos++;
        });
        $("#tb_anexo").html(html);
        $("#t_anexo").dataTable(
            {
                "order": [[ 0, "asc" ],[1, "asc"]],
            }
        ); 
        $("#t_anexo").show();
        var div = document.querySelector(".anexo");
        div.classList.remove("hidden");
    }else{
        if($tipo_busqueda == 'interno'){
            alert('no se encontro anexo');
            $("#tb_anexo").html('');            
        }else{
            alert('no cuenta con anexos');
            var div = document.querySelector(".anexo");
            div.classList.add("hidden");
            $("#tb_anexo").html('');
        }
    }
}

buscarAnexo = function(){
    var busca_anexo = document.querySelector('#txt_anexobuscar').value;
    var id_tramite = document.querySelector('#txt_idtramite').value;
    if(id_tramite){
        var data = {};
        data.estado = 1;
        data.idtramite = id_tramite;

        if(busca_anexo){
            data.buscar = busca_anexo;
        }
        Bandeja.MostrarAnexos(data,HTMLAnexos,'interno');        
    }
}

selectAnexotoDetail = function(obj){
   /* var idanexo = obj.parentNode.parentNode.getAttribute('idanexo');
>>>>>>> externo
    var td = document.querySelectorAll("#t_anexo tr[idanexo='"+idanexo+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idanexo+'}';
    HTMLDetalleAnexo(JSON.parse(data));
<<<<<<< HEAD
    $('#estadoAnexo').modal('show');
}

HTMLDetalleAnexo = function(data){
    document.querySelector('#txt_anexocodtramite').value=data.prueba;
    document.querySelector('#txt_anexousuariore').value=data.persona;
    document.querySelector('#txt_anexonomtra').value=data.nombre;
    document.querySelector('#txt_anexocod').value=data.id;
    document.querySelector('#txt_anexoarea').value=data.area;
    document.querySelector('#txt_anexofecha').value=data.fechaingreso;
    document.querySelector('#txt_anexoestado').value=data.estado;
    document.querySelector('#txt_anexoobser').value=data.observacion;
=======
    $('#estadoAnexo').modal('show');*/
    var codanexo = obj.getAttribute('idanexo');
    if(codanexo){
        var data = {estado:1,codanexo:codanexo};
        Bandeja.AnexoById(data,HTMLDetalleAnexo);
        $("#estadoAnexo").modal('show');
    }
}

HTMLDetalleAnexo = function(data){
    var result = data[0];
    document.querySelector('#txt_anexocodtramite').value=result.codtramite;
    document.querySelector('#txt_anexousuariore').value=result.nombrepersona+' '+result.apepersona+' '+result.apempersona;
    document.querySelector('#txt_anexonomtra').value=result.nombretramite;
    document.querySelector('#txt_anexocod').value=result.codanexo;
    document.querySelector('#txt_anexoarea').value=result.area;
    document.querySelector('#txt_anexofecha').value=result.fechaanexo;
    document.querySelector('#txt_anexoestado').value=result.estado;
    document.querySelector('#txt_anexoobser').value=result.observ;
}

selectToEdit = function(obj){
    var codanexo = obj.getAttribute('idanexo');
    if(codanexo){
        var data = {estado:1,codanexo:codanexo};
        Bandeja.AnexoById(data,HTMLEdit);
        $("#addAnexo").modal('show');
    }
}

HTMLEdit = function(data){
    if(data.length > 0){
        var result = data[0];
        document.querySelector('#txt_codtramite').value=result.codtramite;
        $('#txt_fechaingreso').val(result.fechaanexo);
       /* document.querySelector('#cbo_tipodoc').value=result.tipodoc;*/
        $('#txt_nombtramite').val(result.nombretramite);
        document.querySelector('#txt_numdocA').value=result.numdoc;
        document.querySelector('#txt_folio').value=result.folios;
        document.querySelector('#txt_anexoid').value=result.codanexo;
        document.querySelector('#txt_observ').value=result.observ;
        $("#txt_persona").val(result.apepersona+" "+result.apempersona+" "+result.nombrepersona);
        $("#paterno2").val(result.apepersona);
        $("#materno2").val(result.apempersona);
        $("#nombre2").val(result.nombrepersona);
        $("#txt_persona_id").val(result.persona_id);
        var ids = [];
        ids.push(result.documento_id);
        $('#cbo_tipodoc').multiselect('destroy');
        slctGlobal.listarSlct('documento','cbo_tipodoc','simple',ids,{estado:1},1);

        $('.img-anexo').attr('src','img/anexo/'+result.img);
    }else{
        alert('no se pudo cargar informacion');
    }
}

deleteAnexo = function(obj){
    var codanexo = obj.getAttribute('idanexo');
    if(codanexo){
        var data = {codanexo:codanexo};
        var r = confirm("¿Esta seguro de eliminar?");
        if (r == true) {
            Bandeja.deleteAnexo(data,mostrarAnexos);           
        }
    }
}

selectVoucher = function(obj){
    var codanexo = obj.getAttribute('idanexo');
    if(codanexo){
        var data = {estado:1,codanexo:codanexo};
        Bandeja.AnexoById(data,HTMLVoucherAnexo);
        $("#voucherAnexo").modal('show');
    }
}

HTMLVoucherAnexo = function(data){
    var result = data[0];
    document.querySelector('#spanvfecha').innerHTML=result.fechaanexo;
    document.querySelector('#spanvncomprobante').innerHTML=result.codanexo;
    document.querySelector('#spanImprimir').setAttribute('codanexo',result.codanexo);

    document.querySelector('#spanvcodtramite').innerHTML=result.codtramite;

    document.querySelector('#spanvudni').innerHTML=result.dnipersona;
    document.querySelector('#spanvunomb').innerHTML=result.nombrepersona;
    document.querySelector('#spanvuapep').innerHTML=result.apepersona;
    document.querySelector('#spanvuapem').innerHTML=result.apempersona;
    
    if(result.ruc){
        document.querySelector('#spanveruc').innerHTML=result.ruc;
        document.querySelector('#spanvetipo').innerHTML=result.tipoempresa;
        document.querySelector('#spanverazonsocial').innerHTML=result.razonsocial;
        document.querySelector('#spanvenombreco').innerHTML=result.nombcomercial;
        document.querySelector('#spanvedirecfiscal').innerHTML=result.direcfiscal;
        document.querySelector('#spanvetelf').innerHTML=result.etelefono;
        document.querySelector('#spanverepre').innerHTML=result.representantelegal;
        document.querySelector('.vempresa').classList.remove('hidden'); 
    }else{
        document.querySelector('.vempresa').classList.add('hidden'); 
    }

    document.querySelector('#spanvnombtramite').innerHTML=result.nombretramite;
    document.querySelector('#spanFechaTramite').innerHTML=result.fechatramite;
    document.querySelector('#spanArea').innerHTML=result.area;
}

exportPDF = function(obj){
    var anexo = obj.getAttribute('codanexo');
    if(anexo){
        obj.setAttribute('href','anexo/voucheranexo'+'?codanexo='+anexo);
       /* $(this).attr('href','reporte/exportprocesosactividades'+'?estado='+data[0]['estado']+'&area_id='+data[0]['area_id']);*/
    }else{
        event.preventDefault();
    }
}

exportPDFTramite = function(obj){
    var idtramite = obj.getAttribute('idtramite');
    if(idtramite){
        obj.setAttribute('href','tramitec/vouchertramite'+'?idtramite='+idtramite);
       /* $(this).attr('href','reporte/exportprocesosactividades'+'?estado='+data[0]['estado']+'&area_id='+data[0]['area_id']);*/
    }else{
        event.preventDefault();
    }
}

HTMLPersonas = function(data){
     $('#t_persona').dataTable().fnDestroy();
    if(data.length > 1){
        var html = '';
        $.each(data,function(index, el) {
            html+="<tr id='trid_"+el.id+"'>";
            html+='<td class="nombre">'+el.name+'</td>';
            html+='<td class="paterno">'+el.paterno+'</td>';
            html+='<td class="materno">'+el.materno+'</td>';
            html+='<td class="nombre_comercial">'+el.dni+'</td>';
            html+='<td class="direccion_fiscal">'+el.email+'</td>';
           /* html+='<td name="telefono">'+el.telefono+'</td>';*/
            html+='<td><span class="btn btn-primary btn-sm" id-user='+el.id+' onClick="selectUser(this,'+el.id+')">Seleccionar</span></td>';
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

selectUser = function(boton,id){

        var paterno=$("#t_persona #trid_"+id+" .paterno").text();
        var materno=$("#t_persona #trid_"+id+" .materno").text();
        var nombre=$("#t_persona #trid_"+id+" .nombre").text();
        $("#txt_persona").val(paterno+" "+materno+" "+nombre);
        $("#paterno2").val(paterno);
        $("#materno2").val(materno);
        $("#nombre2").val(nombre);
        $("#txt_persona_id").val(id);
        $('#selectPersona').modal('hide');
    
    }
   
</script>
