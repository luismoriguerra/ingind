<script type="text/javascript">
$(document).ready(function() {


    UsuarioId='<?php echo Auth::user()->id; ?>';
    DataUser = '<?php echo Auth::user(); ?>';
    poblateData('usuario',DataUser);
    /*Inicializar tramites*/
    var data={'persona':UsuarioId,'estado':1};
    Bandeja.MostrarPreTramites(data,HTMLPreTramite);
    /*end Inicializar tramites*/


    /*inicializate selects*/
/*    inicializateSelect();
    inicializateSelect = function(){*/
        slctGlobal.listarSlct('tipotramite','cbo_tipotramite','simple',null,data);  
        slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data);        
        slctGlobal.listarSlct('tiposolicitante','cbo_tiposolicitante','simple',null,data);
/*    }*/
    /*end inicializate selects*/

    $(document).on('change', '#cbo_tiposolicitante', function(event) {
        var data={'id':$(this).val(),'estado':1};
        Bandeja.GetTipoSolicitante(data,Mostrar);
    });

    $(document).on('click', '#btnnuevo', function(event) {
        $(".crearPreTramite").removeClass('hidden');
    });

    $("#t_reporte").dataTable(
        {
            "order": [[ 0, "asc" ],[1, "asc"]],
        }
    ); 
    $("#t_reporte").show();
});

CargarPreTramites = function(){
    var data={'persona':UsuarioId,'estado':1};
    Bandeja.MostrarPreTramites(data,HTMLPreTramite);
}

HTMLPreTramite = function(data){
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

            if(el.solicitante == 'Juridica'){
                html+=    '<td><span class="btn btn-primary btn-sm" id-pretramite="'+el.pretramite+'" onclick="Detallepret(this)"><i class="glyphicon glyphicon-th-list"></i></span></td>';
                html+=    '<td><span class="btn btn-primary btn-sm" id-pretramite="'+el.pretramite+'" onclick="Voucherpret(this)"><i class="glyphicon glyphicon-search"></i></span></td>';
            }else{
             /*   html+=    "<td><span class='btn btn-primary btn-sm' id-pretramite='"+el.pretramite+"' onclick="'Detallepret(this)'" data-toggle='modal' data-target='#detallepretramite'><i class='glyphicon glyphicon-th-list'></i></span></td>";
                html+=    "<td><span class='btn btn-primary btn-sm' id-pretramite='"+el.pretramite+"' data-toggle='modal' data-target='#voucherusuario'><i class='glyphicon glyphicon-search'></i></span></td>";*/
            }

            html+="</tr>";            
        });
        $("#tb_reporte").html(html);
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

    if(result.statusemp == 1){
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
    document.querySelector('#spanvfecha').innerHTML='';
    document.querySelector('#spanvncomprobante').innerHTML='';
    document.querySelector('#spanvcodpretramite').innerHTML=result.pretramite;

   if(result.statusemp == 1){
        document.querySelector('#spanveruc').innerHTML=result.ruc;
        document.querySelector('#spanvetipo').innerHTML=result.tipoempresa;
        document.querySelector('#spanverazonsocial').innerHTML=result.empresa;
        document.querySelector('#spanvenombreco').innerHTML=result.nomcomercial;
        document.querySelector('#spanvedirecfiscal').innerHTML=result.edireccion;
        document.querySelector('#spanvetelf').innerHTML=result.etelf;
        document.querySelector('#spanverepre').innerHTML=result.efvigencia;
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

Mostrar = function(data){
    if(data[0].pide_empresa == 1){
        $(".usuario").removeClass('hidden');
        $(".empresa").removeClass('hidden');
        Bandeja.getEmpresasByPersona({'persona':UsuarioId},ValidacionEmpresa);
    }else{
        $(".empresa").addClass('hidden');
        $(".usuario").removeClass('hidden');
    }
}

ValidacionEmpresa = function(data){
    if(data.length > 1){
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr id-empresa='+el.id+'>';
            html+='<td name="ruc">'+el.ruc+'</td>';
            html+='<td name="tipoemp">'+el.tipo_id+'</td>';
            html+='<td name="razonsocial">'+el.razon_social+'</td>';
            html+='<td name="nombcomercial">'+el.nombre_comercial+'</td>';
            html+='<td name="direcfiscal">'+el.direccion_fiscal+'</td>';
            html+='<td name="telfemp">'+el.telefono+'</td>';
            html+='<td name="empfv">'+el.fecha_vigencia+'</td>';
            html+='<td name="empestado">'+el.estado+'</td>';
            html+='<td name="reprelegal">'+el.representante+'</td>';
            html+='<td name="dnirepre">'+el.dnirepre+'</td>';
            html+='<td><span class="btn btn-primary btn-sm" id-empresa='+el.id+' onClick="selectEmpresa(this)">Seleccionar</span></td>';
            html+='</tr>';
        });
        $('#tb_empresa').html(html);
        $('#empresasbyuser').modal('show');
    }else if(data.length == 1){

    }
}

selectEmpresa = function(obj){
    var idempresa = obj.parentNode.parentNode.getAttribute('id-empresa');
    var td = document.querySelectorAll("#t_empresa tr[id-empresa='"+idempresa+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","empresa_id":'+idempresa+'}';
    poblateData('empresa',JSON.parse(data));
    $('#empresasbyuser').modal('hide');
}
   
poblateData = function(tipo,data){
    if(tipo == 'usuario'){
        var result = JSON.parse(data);
        document.querySelector('#txt_userdni').value=result.dni;
        document.querySelector('#txt_usernomb').value=result.nombre;
        document.querySelector('#txt_userapepat').value=result.paterno;
        document.querySelector('#txt_userapemat').value=result.materno;
    /*    user_telf.value=data.;
        user_direc.value=data.;*/
    }

    if(tipo == 'empresa'){
        document.querySelector('#txt_idempresa').value=data.empresa_id;
        document.querySelector('#txt_ruc').value=data.ruc;
        document.querySelector('#txt_tipoempresa').value=data.tipoemp;
        document.querySelector('#txt_razonsocial').value=data.razonsocial;
        document.querySelector('#txt_nombcomercial').value=data.nombcomercial;
        document.querySelector('#txt_domiciliofiscal').value=data.direcfiscal;
        document.querySelector('#txt_emptelefono').value=data.telfemp;
        document.querySelector('#txt_empfechav').value=data.empfv;
        document.querySelector('#txt_reprelegal').value=data.reprelegal;
        document.querySelector('#txt_repredni').value=data.dnirepre;
    }

    if(tipo== 'tramite'){
        document.querySelector('#txt_nombretramite').value=data.nombre;
        document.querySelector('#txt_idclasitramite').value=data.id;
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
    poblateData('tramite',data);
    $('#buscartramite').modal('hide');
}

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
    datos=$("#FormCrearPreTramite").serialize().split("txt_").join("").split("slct_").join("").split("%5B%5D").join("[]").split("+").join(" ").split("%7C").join("|").split("&");
    data = '{';
    for (var i = 0; i < datos.length ; i++) {
        var elemento = datos[i].split('=');
        data+=(i == 0) ? '"'+elemento[0]+'":"'+elemento[1] : '","' + elemento[0]+'":"'+elemento[1];   
    }
    data+='"}';
    Bandeja.GuardarPreTramite(data,CargarPreTramites);
}

</script>
