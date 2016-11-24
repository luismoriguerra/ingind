<script type="text/javascript">
$(document).ready(function() {

    UsuarioId='<?php echo Auth::user()->id; ?>';
    DataUser = '<?php echo Auth::user(); ?>';
    /*Inicializar tramites*/
    var data={'persona':UsuarioId,'estado':1};
    Bandeja.MostrarPreTramites(data,HTMLPreTramite);
    /*end Inicializar tramites*/

    /*inicializate selects*/
    slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data);        
    slctGlobal.listarSlct('tiposolicitante','cbo_tiposolicitante','simple',null,data);
    /*end inicializate selects*/

    $(document).on('change', '#cbo_tiposolicitante', function(event) {
        var data={'id':$(this).val(),'estado':1};
        Bandeja.GetTipoSolicitante(data,Mostrar);
    });

    $(document).on('click', '#btnnuevo', function(event) {
        $(".crearPreTramite").removeClass('hidden');
        slctGlobal.listarSlct('tipotramite','cbo_tipotramite','simple',null,data);  
        window.scrollTo(0,document.body.scrollHeight);
    });

     /*validaciones*/
    $('#FormCrearPreTramite').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh',
        },
        excluded: ':disabled',
        fields: {
            txt_numfolio: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    },
                    digits:{
                        message: 'dato numerico'
                    }
                }
            },
            txt_tipodoc: {
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
        document.querySelector('#spanRepreL').innerHTML = result.reprelegal;
        document.querySelector('#spanDniRL').innerHTML = result.repredni;
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
    document.querySelector('#spanvncomprobante').innerHTML=result.pretramite;
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
    if(data.length > 1){
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr id='+el.id+'>';
            html+='<td name="ruc">'+el.ruc+'</td>';
            html+='<td name="tipo_id">'+el.tipo_id+'</td>';
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
        $('#empresasbyuser').modal('show');
    }else if(data.length == 1){
        poblateData('empresa',data[0]);
    }else{
        $(".empresa").addClass('hidden');
        alert('no cuenta con una empresa');
    }
}

selectEmpresa = function(obj){
    var idempresa = obj.parentNode.parentNode.getAttribute('id');
    var td = document.querySelectorAll("#t_empresa tr[id='"+idempresa+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idempresa+'}';
    poblateData('empresa',JSON.parse(data));
    $('#empresasbyuser').modal('hide');
}
   
poblateData = function(tipo,data){
/*    if(tipo == 'usuario'){*/
        var result = JSON.parse(DataUser);
        document.querySelector('#txt_userdni').value=result.dni;
        document.querySelector('#txt_usernomb').value=result.nombre;
        document.querySelector('#txt_userapepat').value=result.paterno;
        document.querySelector('#txt_userapemat').value=result.materno;
    /*    user_telf.value=data.;
        user_direc.value=data.;*/
    /*  */

    if(tipo == 'empresa'){
        document.querySelector('#txt_idempresa').value=data.id;
        document.querySelector('#txt_ruc').value=data.ruc;
        document.querySelector('#txt_tipoempresa').value=data.tipo_id;
        document.querySelector('#txt_razonsocial').value=data.razon_social;
        document.querySelector('#txt_nombcomercial').value=data.nombre_comercial;
        document.querySelector('#txt_domiciliofiscal').value=data.direccion_fiscal;
        document.querySelector('#txt_emptelefono').value=data.telefono;
        document.querySelector('#txt_empfechav').value=data.fecha_vigencia;
        document.querySelector('#txt_reprelegal').value=data.representante;
        document.querySelector('#txt_repredni').value=data.dnirepre;
    }

    if(tipo== 'tramite'){
        document.querySelector('#txt_nombretramite').value=data.nombre;
        document.querySelector('#txt_idclasitramite').value=data.id;
        document.querySelector('#txt_idarea').value=data.areaid;
    }

}

consultar = function(){
    var busqueda = document.querySelector("#txtbuscarclasificador");
    var tipotramite = document.querySelector('#cbo_tipotramite');

    var data = {};
    data.estado = 1;
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

HTMLClasificadores = function(data){
    var html = '';
    $.each(data,function(index, el) {
        html+='<tr>';
        html+='<td>'+el.id+'</td>';
        html+='<td>'+el.nombre_clasificador_tramite+'</td>';
        html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onClick="getRequisitos(this)">View</span></td>';
        html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onclick="selectClaTramite(this)">Select</span></td>';
        html+='</tr>';        
    });
    $("#tb_clasificador").html(html);
}

selectClaTramite = function(obj){
    data ={'id':obj.getAttribute('id'),'nombre':obj.getAttribute('nombre')};
    Bandeja.GetAreasbyCTramite({'idc':obj.getAttribute('id')},data);
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
        var cont = 0;
        $.each(data,function(index, el) {
            cont = index + 1;
            html+='<tr>';
            html+='<td>'+cont+'</td>';
            html+='<td>'+el.nombre+'</td>';
            html+='<td>'+el.cantidad+'</td>';
            html+='</tr>';
        });
        $("#tb_requisitos").html(html);
        $("#nombtramite").text(tramite);
        $("#requisitos").modal('show');
    }
}

generarPreTramite = function(){
    var tipodoc = document.querySelector('#cbo_tipodoc').value;
    if(tipodoc){
        datos=$("#FormCrearPreTramite").serialize().split("txt_").join("").split("slct_").join("").split("%5B%5D").join("[]").split("+").join(" ").split("%7C").join("|").split("&");
        data = '{';
        for (var i = 0; i < datos.length ; i++) {
            var elemento = datos[i].split('=');
            data+=(i == 0) ? '"'+elemento[0]+'":"'+elemento[1] : '","' + elemento[0]+'":"'+elemento[1];   
        }
        data+='"}';
        Bandeja.GuardarPreTramite(data,CargarPreTramites);
        
    }else{
        alert('complete data');
    }
}

</script>
