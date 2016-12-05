<script>

$(document).ready(function() {

    var ids=[];
    var data = {estado:1};
    moment.locale('es');

    Documento.Cargar(activarTabla);
    HTML_Ckeditor();

    $('#documentoModal').on('show.bs.modal', function (event) {

        slctGlobal.listarSlct('plantilla','slct_plantilla','simple',null,data);

        var button = $(event.relatedTarget);
        var titulo = button.data('titulo');
        var documento_id = button.data('id');
        var documento = DocumentoObj[documento_id];
        var modal = $(this);

        $(this).find('form')[0].reset();
        modal.find('.modal-title').text(titulo+' Documento');
        $('#form_documento [data-toggle="tooltip"]').css("display","none");
        // $("#form_documento input[type='hidden']").remove();

        if (titulo=='Nuevo') {
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');

            Documento.GetEncargadoAreaDelUsuarioLogeado();
            slctGlobal.listarSlct('area','slct_area_a','simple',null,data);
            slctGlobalHtml('slct_encargado_area_a','simple',['Seleccione']);

        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');

            $('#form_documento #txt_titulo').val( documento.titulo );
            CKEDITOR.instances.plantillaWord.setData( documento.cuerpo || '' );
            $("#form_documento").append("<input type='hidden' value='"+documento.id+"' name='id'>");

            $("#divTitulo").show();
            $("#divPlantillaWord").show();

            if (documento.cabecera || false) {
                $("#divCebecera").show();
            }
        }

    });

    $('#documentoModal').on('hide.bs.modal', function (event) {
        var modal = $(this);
            modal.find('.modal-body input').val('');
        CKEDITOR.instances.plantillaWord.setData( "" );
        $("#slct_plantilla").multiselect('destroy');

        $("#divTitulo").hide();
        $('#divCebecera').hide();
        $("#divPlantillaWord").hide();
    });

    $('#form_documento #slct_plantilla').on('change', function (event) {
        var id = $(this).val();
        Documento.GetPlantilla(id);
    });

    $('#form_documento #slct_area_a').on('change', function (event) {

        var data = {estado:1, areaId: $(this).val()};

        $("#slct_encargado_area_a").multiselect('destroy');
        slctGlobal.listarSlctFuncion('documentoword','encargados-por-area','slct_encargado_area_a','simple',null,data);
    });

    $('.fecha').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
    },
    function(start, end, label) {

        var fecha = moment(start);
        $('.fecha span').html(fecha.format('LL'));
        $('#txt_fechaDocumento').val(fecha.format());
    });

});
eventoSlctGlobalSimple=function(){
}
activarTabla=function(){
    $("#t_plantilla").dataTable();
};
Editar=function(){
    if(validaDocumento()){
        Documento.AgregarEditar(1);
    }
};
activar=function(id){
    Documento.CambiarEstado(id,1);
};
desactivar=function(id){
    Documento.CambiarEstado(id,0);
};
Agregar=function(){
    if(validaDocumento()){
        Documento.AgregarEditar(0);
    }
};
validaDocumento=function(){
    $('#id [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("slct","plantilla","");
    a[1]=valida("txt","titulo","");
    var rpta=true;
    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};

valida=function(inicial,id,v_default){
    var texto="Seleccione";
    if(inicial=="txt"){
        texto="Ingrese";
    }
    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }
};
HTMLCargar=function(datos){
    var html="";
    $('#t_plantilla').dataTable().fnDestroy();
    $.each(datos,function(index,data){

        html+="<tr>"+
            "<td>"+data.titulo+"</td>"+
            "<td>"+data.asunto+"</td>"+
            "<td>"+data.fecha+"</td>"+
            "<td>"+
                "<div class='btn-group' role='group'>"+
                    "<a class='btn btn-primary btn-sm' data-toggle='modal' data-target='#documentoModal' data-id='"+index+"' data-titulo='Editar'><i class='fa fa-edit fa-lg'></i> </a>"+
                    "<a class='btn btn-default btn-sm' onclick='openPrevisualizarPlantilla("+data.id+"); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'></i> </a>"+
                "</div>"+
            "</td>";
        html+="</tr>";
    });
    $("#tb_plantilla").html(html);
    activarTabla();
};

HTML_Ckeditor=function(){

    CKEDITOR.replace( 'plantillaWord' );

};
openPrevisualizarPlantilla=function(id){
    window.open("plantilla/previsualizar/"+id,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};

</script>