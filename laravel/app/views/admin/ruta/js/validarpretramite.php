<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '#btnImage', function(event) {
        $('#txt_file').click();
    });

    $(document).on('change', '#txt_file', function(event) {
        readURLI(this, 'file');
    });
    

    function readURLI(input, tipo) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (tipo == 'file') {                 
                    $('#btnImage').text('SUCCESS');
                    $('#btnImage').addClass('btn btn-success');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }












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
});


Detallepret = function(){
    var codpretramite = $('#txt_codpt').val();
    if(codpretramite){
        var data = {'idpretramite':codpretramite};
        Bandeja.GetPreTramitebyid(data,poblarDetalle);        
    }else{
        alert('ingrese codigo');
    }
}

poblarDetalle = function(data){
    var result = data[0];
    document.querySelector('#spanTipoT').innerHTML=result.tipotramite;
    document.querySelector('#spanTipoD').innerHTML=result.tipodoc;
    document.querySelector('#spanNumTP').innerHTML=result.nrotipodoc;
    document.querySelector('#spanTSoli').innerHTML=result.solicitante;
    document.querySelector('#spanFolio').innerHTML=result.folio;
    document.querySelector('#spanNombreU').innerHTML=result.nombusuario;
    document.querySelector('#spanTipoDIU').innerHTML=result.data;
                                
    document.querySelector('#spanPaternoU').innerHTML=result.apepusuario;
    document.querySelector('#spanMaternoU').innerHTML=result.apemusuario;
    document.querySelector('#spanDNIU').innerHTML=result.dniU;

    document.querySelector('#spanTE').innerHTML=result.data;
    document.querySelector('#spanRazonS').innerHTML=result.empresa;
    document.querySelector('#spanDF').innerHTML=result.edireccion;
    document.querySelector('#spanRUC').innerHTML=result.ruc;
    document.querySelector('#spanRepresentante').innerHTML=result.reprelegal;
    document.querySelector('#spanTelefono').innerHTML=result.etelf;

    document.querySelector('#spanNombreT').innerHTML=result.tramite;
    document.querySelector('#spanArea').innerHTML=result.area;
}

getCTramites  = function(){
    data = {};
    Bandeja.getClasificadoresTramite(data,HTMLClasificadores);
}

HTMLClasificadores = function(data){
    if(data){
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
        $("#buscartramite").modal('show');
    }else{
        alert('sin data');
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
    var data ={'id':cla_id,'nombre':cla_nomb,'area':area_nomb[0].textContent};
    poblateData('tramite',data);
    $('#buscartramite').modal('hide');
}

poblateData = function(tipo,data){
    if(tipo=='tramite'){
        document.querySelector('#spanNombreT').innerHTML=data.nombre;
        document.querySelector('#spanArea').innerHTML=data.area;
/*        document.querySelector('#txt_idarea').value=data.area;*/
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

</script>
