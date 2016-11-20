<script>

$(document).ready(function() {

    var ids=[];
    var data = {estado:1};

    Plantillas.Cargar(activarTabla);
    HTML_Ckeditor();

    $('#plantillaModal').on('show.bs.modal', function (event) {

        slctGlobal.listarSlct('plantilla','slct_plantilla','simple',null,data);

        var button = $(event.relatedTarget);
        var titulo = button.data('titulo');
            plantilla_id = button.data('id');
        var Plantilla = PlantillaObj[plantilla_id];
        var modal = $(this);

        $(this).find('form')[0].reset();
        modal.find('.modal-title').text(titulo+' Documento');
        $('#form_plantilla [data-toggle="tooltip"]').css("display","none");
        $("#form_plantilla input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_plantilla #txt_nombre').val( Plantilla.nombre );
            $('#form_plantilla #slct_estado').val( Plantilla.estado );
            $('#form_plantilla #slct_cabecera').val( Plantilla.cabecera );
            Plantilla.cuerpo = ( Plantilla.cuerpo == null ) ? '' : Plantilla.cuerpo;
            CKEDITOR.instances.plantillaWord.setData( Plantilla.cuerpo );
            $("#form_plantilla").append("<input type='hidden' value='"+Plantilla.id+"' name='id'>");

        }
        $( "#form_plantilla #slct_cabecera" ).trigger('change');
        $( "#form_plantilla #slct_estado" ).trigger('change');
        $( "#form_plantilla #slct_estado" ).change(function() {
            if ($( "#form_plantilla #slct_estado" ).val()==1) {
                $('#word').removeAttr('disabled');
            } else {
                $('#word').attr('disabled', 'disabled');
            }
        });
    });
    $('#plantillaModal').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body input').val('');
        CKEDITOR.instances.plantillaWord.setData( "" );
        $('#form_plantilla #slct_estado').val( 1 );
    });
    $('#form_plantilla #slct_cabecera').on('change', function (event) {
        if ( $(this).val() == '1' ) {
            $('#partesCabecera').show();
        } else {
            $('#partesCabecera').hide();
        }
    });
});
activarTabla=function(){
    $("#t_plantilla").dataTable();
};
Editar=function(){
    if(validaPlantilla()){
        Plantillas.AgregarEditar(1);
    }
};
activar=function(id){
    Plantillas.CambiarEstado(id,1);
};
desactivar=function(id){
    Plantillas.CambiarEstado(id,0);
};
Agregar=function(){
    if(validaPlantilla()){
        Plantillas.AgregarEditar(0);
    }
};
validaPlantilla=function(){
    $('#id [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("slct","plantilla","");
    // a[1]=valida("txt","nombre","");
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
                    "<a class='btn btn-primary btn-sm' data-toggle='modal' data-target='#plantillaModal' data-id='"+index+"' data-titulo='Editar'><i class='fa fa-edit fa-lg'></i> </a>"+
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
eventoSlctGlobalSimple=function(slct,valores){
};
</script>