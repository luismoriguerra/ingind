<script type="text/javascript">
$(document).ready(function() {  
    Menus.CargarMenus(activarTabla);

    $('#menuModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Menu');
      $('#form_menus [data-toggle="tooltip"]').css("display","none");
      $("#form_menus input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_menus #slct_estado').val(1); 
            $('#form_menus #txt_nombre').focus();
        }
        else{
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_menus #txt_nombre').val( $('#t_menus #nombre_'+button.data('id') ).text() );
            $('#form_menus #txt_class_icono').val( $('#t_menus #class_icono_'+button.data('id') ).text() );
            $('#form_menus #slct_estado').val( $('#t_menus #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_menus").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

    });

    $('#menuModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_menus").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaMenus()){
        Menus.AgregarEditarMenu(1);
    }
};

activar=function(id){
    Menus.CambiarEstadoMenus(id,1);
};
desactivar=function(id){
    Menus.CambiarEstadoMenus(id,0);
};

Agregar=function(){
    if(validaMenus()){
        Menus.AgregarEditarMenu(0);
    }
};

validaMenus=function(){
    $('#form_menus [data-toggle="tooltip"]').css("display","none");
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
</script>