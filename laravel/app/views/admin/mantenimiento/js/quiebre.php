<script type="text/javascript">
$(document).ready(function() {
    Quiebres.CargarQuiebres(activarTabla);

    $('#quiebreModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        var quiebre_id = button.data('id'); //extrae el id del atributo data
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Quiebre');
        $('#form_quiebres [data-toggle="tooltip"]').css("display","none");
        $("#form_quiebres input[type='hidden']").remove();
        
        if(titulo=='Nuevo'){
            Quiebres.CargarActividades('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_quiebres #slct_estado').val(1);
            $('#form_quiebres #txt_nombre').focus();
        }
        else{
            Quiebres.CargarActividades('editar',quiebre_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_quiebres #txt_nombre').val( $('#t_quiebres #nombre_'+button.data('id') ).text() );
            $('#form_quiebres #txt_apocope').val( $('#t_quiebres #apocope_'+button.data('id') ).text() );
            $('#form_quiebres #slct_estado').val( $('#t_quiebres #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_quiebres").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
        $( "#slct_estado" ).change(function() {
            if ($( "#slct_estado" ).val()==='1')
                $('#slct_actividades').multiselect('enable');
            else
                $('#slct_actividades').multiselect('disable');
        });
    });

    $('#quiebreModal').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body input').val('');
        //reconstruye  multiselect
        $('#slct_actividades').multiselect('destroy');
    });
   
});

activarTabla=function(){
    $("#t_quiebres").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaQuiebres()){
        var actividades_selec = $('select#slct_actividades').val();
        Quiebres.AgregarEditarQuiebre(1, actividades_selec);
    }
};

activar=function(id){
    Quiebres.CambiarEstadoQuiebres(id,1);
};

HTMLListarSlct=function(obj,accion){

    var html="";
    if(obj.rst==1){
        $.each(obj.datos,function(index,data){
            if (accion=='editar') {
                if (data.estado==1)
                    html += "<option selected='selected' value=\"" + data.id + "\">" + data.nombre + "</option>";
                else
                   html += "<option value=\"" + data.id + "\">" + data.nombre + "</option>";
            }else
               html += "<option value=\"" + data.id + "\">" + data.nombre + "</option>";

        });
    }
    $("#slct_actividades").html(html);

    $("#slct_actividades").multiselect({
        maxHeight: 200,
        buttonContainer: '<div class="btn-group col-xxs-12" />',
        buttonClass: 'btn btn-primary col-xxs-12',
        templates: {
            ul: '<ul class="multiselect-container dropdown-menu col-xxs-12"></ul>',
        },
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonText: function(options, select) { // para multiselect indicar vacio...
            if (options.length === 0) {
                return '.::Seleccione::.';
            }
            else if (options.length > 2) {
                return options.length+' Seleccionados';//More than 3 options selected!
            }
            else {
                 var labels = [];
                 options.each(function() {
                     if ($(this).attr('label') !== undefined) {
                         labels.push($(this).attr('label'));
                     }
                     else {
                         labels.push($(this).html());
                     }
                 });
                 return labels.join(', ') + '';
            }
        }
    });
    //estado de actividades
    if ($( "#slct_estado" ).val() === '1')
        $('#slct_actividades').multiselect('enable');
    else 
        $('#slct_actividades').multiselect('disable');
};
desactivar=function(id){
    Quiebres.CambiarEstadoQuiebres(id,0);
};

Agregar=function(){
    if(validaQuiebres()){
        var actividades_selec = $('select#slct_actividades').val();
        Quiebres.AgregarEditarQuiebre(0,actividades_selec);
    }
};

validaQuiebres=function(){
    $('#form_quiebre [data-toggle="tooltip"]').css("display","none");
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