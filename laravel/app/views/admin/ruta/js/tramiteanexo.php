<script type="text/javascript">

$(document).ready(function() {
    /*Inicializar tramites*/
    var data={estado:1};
    Bandeja.MostrarTramites(data,HTMLTramites);
    /*end Inicializar tramites*/

    slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data);

    function limpia(area) {
        $(area).find('input[type="text"],input[type="email"],textarea,select').val('');
        $('#FormNuevoAnexo').data('bootstrapValidator').resetForm();
    };

    $('#addAnexo').on('hidden.bs.modal', function(){
        limpia(this);
        $('#spanRuta').addClass('hidden');
    });

    /*validaciones*/
    $('#FormNuevoAnexo').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh',
        },
        excluded: ':disabled',
        fields: {
            txt_nombreP: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },
            txt_apeP: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },
            txt_apeM: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },
        /*    txt_tipodocP: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },*/
            txt_numdocP: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    },
                    digits:{
                        message: 'dato numerico'
                    }
                }
            },
            txt_codtramite: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    },
                    digits:{
                        message: 'dato numerico'
                    }
                },
            },
            txt_fechaingreso: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },
            cbo_tipodoc: {
                validators: {
                    choice: {
                        message: 'selecciona un tipo',
                        min:1
                    }
                }
            },
            txt_nombtramite: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },
            txt_numdocA: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    },
                    digits:{
                        message: 'dato numerico'
                    }
                }
            },
            txt_folio: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    },
                    digits:{
                        message: 'dato numerico'
                    }
                }
            }
        }
    });
    /*end validaciones */

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

    function readURLI(input, tipo) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (tipo == 'file') {                 
/*                    $('.img-tramite').attr('src',e.target.result);*/
                    $('#spanRuta').text(input.value);
                    $('#spanRuta').removeClass('hidden');
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
    if(busqueda){
        data.buscar = busqueda;
    }
    Bandeja.MostrarTramites(data,HTMLTramites);
}

HTMLTramites = function(data){
    if(data.length > 0){
        $("#t_reporte").dataTable().fnDestroy();
        var html ='';
        $.each(data,function(index, el) {
            html+="<tr id="+el.codigo+">"+
                "<td name='codigo'>"+el.codigo +"</td>"+
                "<td name='nombre'>"+el.tramite+"</td>"+
                "<td name='fechaingreso'>"+el.fecha_ingreso+"</td>"+
                "<td name='persona'>"+el.persona+"</td>"+
                "<td name='estado'>"+el.estado+"</td>"+
                "<td name='observacion'>"+el.observacion+"</td>"+
                "<td><span class='btn btn-primary btn-sm' onClick='seleccionado(this),mostrarAnexos(this)'><i class='glyphicon glyphicon-th-list'></i></span></td>"+
                "<td><span class='btn btn-primary btn-sm' idtramite='"+el.codigo+"' onclick='selectTramitetoDetail(this)'><i class='glyphicon glyphicon-search'></i></span></td>"+               
            "</tr>";            
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
    var idtramite = obj.parentNode.parentNode.getAttribute('id');
    Bandeja.TramiteById({'idtramite':idtramite},HTMLDetalleTramite);
    /*var td = document.querySelectorAll("#t_reporte tr[id='"+idtramite+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idtramite+'}';
    HTMLDetalleTramite(JSON.parse(data));
    $('#estadoTramite').modal('show');*/
}

HTMLDetalleTramite = function(data){
    var result = data[0];
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
   /* document.querySelector('#spanTelefonoU').innerHTML=result.prueba;
    document.querySelector('#spanDirecU').innerHTML=result.prueba;*/


/*
    document.querySelector('#txtcodtramite').value=data.codigo;
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
    document.querySelector('#txt_idtramite').value=id_tramite;
    Bandeja.MostrarAnexos(data,HTMLAnexos);
}

HTMLAnexos = function(data,$tipo_busqueda = ''){
    if(data.length > 0){
        $("#t_anexo").dataTable().fnDestroy();
        var html ='';
        $.each(data,function(index, el) {
            html+="<tr idanexo="+el.codigoanexo+">"+
                "<td name='codigo'>"+el.codigoanexo +"</td>"+
                "<td name='nombre'>"+el.nombreanexo+"</td>"+
                "<td name='fechaingreso'>"+el.fechaingreso+"</td>"+
                "<td name='persona'>"+el.usuarioregistrador+"</td>"+
                "<td name='estado'>"+el.estado+"</td>"+
                "<td name='observacion'>"+el.observacion+"</td>"+
                "<td name='area'>"+el.area+"</td>"+
                "<td><span class='btn btn-primary btn-sm' idanexo='"+el.codigoanexo+"' onclick='selectAnexotoDetail(this)'><i class='glyphicon glyphicon-search'></i></span></td>"+
                "<td><span class='btn btn-primary btn-sm' idanexo='"+el.codigoanexo+"' onclick='selectVoucher(this)'><i class='glyphicon glyphicon-open'></i></span></td>"+
            "</tr>";            
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
    var td = document.querySelectorAll("#t_anexo tr[idanexo='"+idanexo+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idanexo+'}';
    HTMLDetalleAnexo(JSON.parse(data));
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
    if(result.frecepcion){
        document.querySelector('.btnAnexoRecepcionar').classList.add('hidden');
    }else{
        document.querySelector('.btnAnexoRecepcionar').classList.remove('hidden');
    }
    document.querySelector('.observacion').classList.remove('hidden');

    document.querySelector('#txt_anexocodtramite').value=result.codtramite;
    document.querySelector('#txt_anexousuariore').value=result.nombrepersona+' '+result.apepersona+' '+result.apempersona;
    document.querySelector('#txt_anexonomtra').value=result.nombretramite;
    document.querySelector('#txt_anexocod').value=result.codanexo;
    document.querySelector('#txt_anexoarea').value=result.area;
    document.querySelector('#txt_anexofecha').value=result.fechaanexo;
    document.querySelector('#txt_anexoestado').value=result.estado;
    document.querySelector('#txt_anexoobser').value=result.observ;
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
    document.querySelector('#spanAreaa').innerHTML=result.area;
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

recepcionar = function(){
    var codanexo = document.querySelector('#txt_anexocod').value;
    var observacion = document.querySelector('#txt_anexoobser').value;
    var data = {'codanexo':codanexo,'observacion':observacion};
    Bandeja.Recepcionar(data,mostrarAnexos);
}
   
</script>
