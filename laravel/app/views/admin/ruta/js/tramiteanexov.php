<script type="text/javascript">

$(document).ready(function() {
    /*Inicializar tramites*/

    UsuarioId='<?php echo Auth::user()->id; ?>';
    var data={estado:1,persona:UsuarioId};
    Bandeja.MostrarTramites(data,HTMLTramites);
    /*end Inicializar tramites*/

    slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data);

    function limpia(area) {
       /* $(area).find('input[type="text"],input[type="email"],textarea,select').val('');*/
        $('#spanRuta').addClass('hidden');
        $('.img-anexo').attr('src','index.img');
        $('#txt_folio,#txt_anexoid').val('');
        $('#FormNuevoAnexo').data('bootstrapValidator').resetForm();
    };

    $('#addAnexo').on('hidden.bs.modal', function(){
        limpia(this);
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
        var html ='';
        $.each(data,function(index, el) {
            html+="<tr id="+el.codigo+" numdoc="+el.numdoc+">"+
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
    var td = document.querySelectorAll("#t_reporte tr[id='"+idtramite+"'] td");
    var data = '{';
    for (var i = 0; i < td.length; i++) {
        if(td[i].getAttribute('name')){
          data+=(i==0) ? '"'+td[i].getAttribute('name')+'":"'+td[i].innerHTML : '","' + td[i].getAttribute('name')+'":"'+td[i].innerHTML;   
        }
    }
    data+='","id":'+idtramite+'}';
    HTMLDetalleTramite(JSON.parse(data));
    $('#estadoTramite').modal('show');
}

HTMLDetalleTramite = function(data){
    document.querySelector('#txtcodtramite').value=data.codigo;
    document.querySelector('#txtfechaIngresado').value=data.fechaingreso;
    document.querySelector('#txtnombtramite').value=data.nombre;
    document.querySelector('#txtdetalle').value=data.observacion;
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

mostrarAnexos = function(obj){
    var idtramite = obj.parentNode.parentNode.getAttribute("id");
    var nombret = document.querySelectorAll("#t_reporte tr[id='"+idtramite+"'] td[name='nombre']");
    var numdoc = obj.parentNode.parentNode.getAttribute("numdoc");

    /*poblate info in new anexo*/
    document.querySelector('#txt_idtramite').value=idtramite;
    document.querySelector('#txt_codtramite').value=idtramite;
    document.querySelector('#txt_nombtramite').value=nombret[0].innerHTML;
    document.querySelector('#txt_fechaingreso').value= new Date().toLocaleString();
    document.querySelector('#txt_numdocA').value= numdoc;
    /*end poblate info in new anexo*/

    var data={'idtramite':idtramite};
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
                "<td><span class='btn btn-primary btn-sm' idanexo='"+el.codigoanexo+"' onclick='selectToEdit(this)'><i class='glyphicon glyphicon-pencil'></i></span></td>"+
                 "<td><span class='btn btn-danger btn-sm' idanexo='"+el.codigoanexo+"' onclick='deleteAnexo(this)'><i class='glyphicon glyphicon-trash'></i></span></td>"+
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
        document.querySelector('#txt_fechaingreso').value=result.fechaanexo;
       /* document.querySelector('#cbo_tipodoc').value=result.tipodoc;*/
        document.querySelector('#txt_nombtramite').value=result.nombretramite;
        document.querySelector('#txt_numdocA').value=result.numdoc;
        document.querySelector('#txt_folio').value=result.folios;
        document.querySelector('#txt_anexoid').value=result.codanexo;

        var ids = [];
        ids.push(result.idtipodoc);
        $('#cbo_tipodoc').multiselect('destroy');
        slctGlobal.listarSlct('documento','cbo_tipodoc','simple',ids,{estado:1},1);

      /*  $('.img-tramite').attr('src','C:/xampp/htdocs/ingind/public/img/anexo/'+result.img);*/
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
            Bandeja.deleteAnexo(data);           
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
   
</script>
