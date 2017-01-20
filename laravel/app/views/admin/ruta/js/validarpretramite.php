<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '#btnImage', function(event) {
        $('#txt_file').click();
    });

    $(document).on('change', '#txt_file', function(event) {
        readURLI(this, 'file');
    });
    
     $('#buscartramite').on('hidden.bs.modal', function(){
        $(".rowArea").addClass('hidden');
    });

    function readURLI(input, tipo) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (tipo == 'file') {                 
                    $('#btnImage').text('IMAGEN CARGADA');
                    $('#btnImage').addClass('btn btn-success');
                    $('.img-tramite').attr('src',e.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("form[name='FormTramite']").submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: 'tramitec/create',
            data: new FormData($(this)[0]),
            processData: false,
            contentType: false,
            success: function (obj) {
                if(obj.rst==1){
                    limpiar();
                }
            }
        });
     });

    function limpiar(){
        $('#FormTramite').find('input[type="text"],input[type="email"],textarea,select').val('');
        $('#FormTramite').find('span').text('');
        $('#FormTramite').find('img').attr('src','index.img');
        $('#btnImage').removeClass('btn-success'); 
        $('.content-body').addClass('hidden');
    }

    $(document).on('click', '#btnCancelar', function(event) {
        event.preventDefault();
        limpiar();  
    });

    UsuarioId='<?php echo Auth::user()->id; ?>';
    DataUser = '<?php echo Auth::user(); ?>';
    /*Inicializar tramites*/
    var data={'persona':UsuarioId,'estado':1};
/*    Bandeja.MostrarPreTramites(data,HTMLPreTramite);*/
    /*end Inicializar tramites*/

    /*inicializate selects*/
    slctGlobal.listarSlct('tipotramite','cbo_tipotramite','simple',null,data);  
    slctGlobal.listarSlct('documento','cbo_tipodoc','simple',null,data);        
    slctGlobal.listarSlct('tiposolicitante','cbo_tiposolicitante','simple',null,data);
    /*end inicializate selects*/

    $(document).on('change', '#cbo_tiposolicitante', function(event) {
        var data={'id':$(this).val(),'estado':1};
        Bandeja.GetTipoSolicitante(data,Mostrar);
    });

    $(document).on('click', '#btnnuevo', function(event) {
        $(".crearPreTramite").removeClass('hidden');
        window.scrollTo(0,document.body.scrollHeight);
    });


/*     $('#FormTramite').bootstrapValidator({
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh',
                    },
                    excluded: ':disabled',
                    fields: {
                        txt_tdoc: {
                           validators: {
                                notEmpty: {
                                    message: 'select a date'
                                }
                            }
                        },
                        txt_folio: {
                            validators: {
                                notEmpty: {
                                    message: 'select a date'
                                }
                            }
                        }
                    }
                });*/
                /* end validanting info*/
});


Detallepret = function(){
    var codpretramite = $('#txt_codpt').val();
    if(codpretramite){
        var data = {'idpretramite':codpretramite,'validacion':true};
        Bandeja.GetPreTramitebyid(data,poblarDetalle);        
    }else{
        alert('ingrese codigo');
    }
}

poblarDetalle = function(data){
    if(data.length > 0){
        var result = data[0];
        if(!result.tramiteid){
            document.querySelector('#spanTipoT').innerHTML=result.tipotramite;
            document.querySelector('#spanTipoD').innerHTML=result.tipodoc;
            document.querySelector('#txt_tdoc').value=result.nrotipodoc;
            document.querySelector('#spanTSoli').innerHTML=result.solicitante;
            document.querySelector('#txt_folio').value=result.folio;
            document.querySelector('#spanNombreU').innerHTML=result.nombusuario;
            /*document.querySelector('#spanTipoDIU').innerHTML=result.data;*/
                                        
            document.querySelector('#spanPaternoU').innerHTML=result.apepusuario;
            document.querySelector('#spanMaternoU').innerHTML=result.apemusuario;
            document.querySelector('#spanDNIU').innerHTML=result.dniU;

            if(result.empresaid){
                document.querySelector('#spanTE').innerHTML=result.data;
                document.querySelector('#spanRazonS').innerHTML=result.empresa;
                document.querySelector('#spanDF').innerHTML=result.edireccion;
                document.querySelector('#spanRUC').innerHTML=result.ruc;
                document.querySelector('#spanRepresentante').innerHTML=result.reprelegal;
                document.querySelector('#spanTelefono').innerHTML=result.etelf;
                document.querySelector('.empresa').classList.remove('hidden');            
            }else{
                document.querySelector('.empresa').classList.add('hidden'); 
            }

            document.querySelector('#spanNombreT').innerHTML=result.tramite;
            document.querySelector('#spanArea').innerHTML=result.area;
            document.querySelector('.content-body').classList.remove('hidden');


            document.querySelector('#txt_pretramiteid').value=result.pretramite;
            document.querySelector('#txt_personaid').value=result.personaid;
            document.querySelector('#txt_ctramite').value=result.ctid;
            document.querySelector('#txt_empresaid').value=result.empresaid;
            document.querySelector('#txt_tsolicitante').value=result.tsid;
            document.querySelector('#txt_tdocumento').value=result.tdocid;
            document.querySelector('#txt_area').value=result.areaid;            
        }else{
            document.querySelector('.content-body').classList.add('hidden');
            alert('Ya fue gestionado!');
        }
    }else{
        document.querySelector('.content-body').classList.add('hidden');
        alert('no se encontro el pre tramite');
    }
}

getCTramites  = function(){
    data = {};
    Bandeja.getClasificadoresTramite(data,HTMLClasificadores);
}

HTMLClasificadores = function(data){
    if(data){
        $('#t_clasificador').dataTable().fnDestroy();
        var html = '';
        $.each(data,function(index, el) {
            html+='<tr>';
            html+='<td>'+el.id+'</td>';
            html+='<td>'+el.nombre_clasificador_tramite+'</td>';
            html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onClick="getRequisitos(this)">Ver</span></td>';
            html+='<td><span class="btn btn-primary btn-sm" id="'+el.id+'" nombre="'+el.nombre_clasificador_tramite+'" onclick="selectClaTramite(this)">Seleccionar</span></td>';
            html+='</tr>';        
        });
        $("#tb_clasificador").html(html);
        $("#t_clasificador").dataTable(
        {
            "order": [[ 0, "asc" ]],
        }
    ); 
        $("#buscartramite").modal('show');
    }else{
        alert('sin data');
    }
}

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

poblateData = function(tipo,data){
    if(tipo=='tramite'){
        document.querySelector('#spanNombreT').innerHTML=data.nombre;
        document.querySelector('#spanArea').innerHTML=data.area;
        document.querySelector('#txt_ctramite').value=data.id;
        document.querySelector('#txt_area').value=data.areaid;
    }
}

consultar = function(){
    var busqueda = document.querySelector("#txtbuscarclasificador");

    var data = {};
    data.estado = 1;
    if(busqueda){
       data.buscar = busqueda.value;
    }
    Bandeja.getClasificadoresTramite(data,HTMLClasificadores);
}

generarTramite = function(){
    datos=$("#FormTramite").serialize().split("txt_").join("").split("slct_").join("").split("%5B%5D").join("[]").split("+").join(" ").split("%7C").join("|").split("&");
    data = '{';
    for (var i = 0; i < datos.length ; i++) {
        var elemento = datos[i].split('=');
        data+=(i == 0) ? '"'+elemento[0]+'":"'+elemento[1] : '","' + elemento[0]+'":"'+elemento[1];   
    }
    data+='"}';
/*    img  = document.querySelector('#txt_file').files[0];*/
    var form = new FormData($("#FormTramite")[0]);
    console.log(form);
/*    Bandeja.GuardarTramite(data);*/
}

</script>
