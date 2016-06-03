<script>
$(document).ready(function() {
    Plantillas.Cargar(activarTabla);
    HTMLtinymce();
    $('#plantillaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var titulo = button.data('titulo');
        plantilla_id = button.data('id');
        var Plantilla =PlantillaObj[plantilla_id];
        var modal = $(this);
        modal.find('.modal-title').text(titulo+' Plantilla');
        $('#form_plantilla [data-toggle="tooltip"]').css("display","none");
        $("#form_plantilla input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
        } else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_plantilla #txt_nombre').val( Plantilla.nombre );
            $('#form_plantilla #slct_estado').val( Plantilla.estado );
            Plantilla.cuerpo = ( Plantilla.cuerpo == null ) ? '' : Plantilla.cuerpo;
            tinyMCE.get('word').setContent( Plantilla.cuerpo );
            $("#form_plantilla").append("<input type='hidden' value='"+Plantilla.id+"' name='id'>");

        }
        $( "#form_plantilla #slct_estado" ).trigger('change');
        $( "#form_plantilla #slct_estado" ).change(function() {
            if ($( "#form_plantilla #slct_estado" ).val()==1) {
                $('#word').removeAttr('disabled');
            }
            else {
                $('#word').attr('disabled', 'disabled');
            }
        });
    });
    $('#plantillaModal').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body input').val('');
        tinyMCE.get('word').setContent( "" );
        $('#form_plantilla #slct_estado').val( 1 );
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
    $('#form_plantilla [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombre","");
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
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td>"+data.nombre+"</td>"+
            "<td>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#plantillaModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_plantilla").html(html);
    activarTabla();
};

HTMLtinymce=function(){

  tinyMCE.init({
    mode : 'textareas',
    theme : 'ribbon',
    //content_css : 'css/editor.css',
    height: 600,
    plugins : 'bestandsbeheer,tabfocus,advimagescale,loremipsum,image_tools,embed,tableextras,style,table,inlinepopups,searchreplace,contextmenu,paste,wordcount,advlist,autosave',
    inlinepopups_skin : 'ribbon_popup',
    theme_ribbon_tab1 : {
      title : "Start",
      items : [
              ["paste"],
              ["justifyleft,justifycenter,justifyright,justifyfull",
               "bullist,numlist",
               "|",
               "bold,italic,underline",
               "outdent,indent"],
              ["paragraph", "heading1", "heading2", "heading3"],
              ["search", "|", "replace", "|", "removeformat"]]
    },
    theme_ribbon_tab2 : {
      title : "Insert",
      items : [["tabledraw"],
              ["image", "bestandsbeheer_file", "bestandsbeheer_video", "bestandsbeheer_mp3"],
              ["embed"],
              ["link", "|", "unlink", "|", "anchor"],
              ["loremipsum", "|", "charmap", "|", "hr"]]
    },
    theme_ribbon_tab3 : {
      title : "Source",
      source : true
    },
    theme_ribbon_tab4 : {
      title : "Image",
      bind :  "img",
      items : [["image_float_left", "image_float_right", "image_float_none"],
              ["image_alt"],
              ["image_width_plus", "|", "image_width_min", "|", "image_width_original"],
              ["image_edit", "|", "image_remove"]]
    }

  });
};
</script>