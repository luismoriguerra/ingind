<script type="text/javascript">
$(document).ready(function() {
    Celulas.CargarCelulas(activarTabla);

    $('#celulaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        var celula_id = button.data('id'); //extrae el id del atributo data
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Celula');
        $('#form_celulas [data-toggle="tooltip"]').css("display","none");
        $("#form_celulas input[type='hidden']").remove();
        
        if(titulo=='Nuevo') {
            Celulas.cargarEmpresas('nuevo',null);
            Celulas.CargarQuiebres('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_celulas #slct_estado').val(1);
            $('#form_celulas #txt_nombre').focus();
        }
        else {
            Celulas.CargarQuiebres('editar',celula_id);
            empresa_id=$('#t_celulas #empresa_id_'+button.data('id') ).attr('empresa_id');
            Celulas.cargarEmpresas('editar',empresa_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_celulas #txt_nombre').val( $('#t_celulas #nombre_'+button.data('id') ).text() );
            $('#form_celulas #txt_responsable').val( $('#t_celulas #responsable_'+button.data('id') ).text() );
            $('#form_celulas #slct_estado').val( $('#t_celulas #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_celulas").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }

        $( "#slct_estado" ).change(function() {
            if ($( "#slct_estado" ).val()==='1')
                $('#slct_quiebres').multiselect('enable');
            else
                $('#slct_quiebres').multiselect('disable');
        });
    });

    $('#celulaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
      $('#slct_quiebres').multiselect('destroy');
    });
});

activarTabla=function(){
    $("#t_celulas").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaCelulas()){
        var quiebres_selec = $('select#slct_quiebres').val();
        Celulas.AgregarEditarCelula(1,quiebres_selec);
    }
};

activar=function(id){
    Celulas.CambiarEstadoCelulas(id,1);
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
    $("#slct_quiebres").html(html);

    $("#slct_quiebres").multiselect({
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
    //estado de celula
    if ($( "#slct_estado" ).val() === '1')
        $('#slct_quiebres').multiselect('enable');
    else 
        $('#slct_quiebres').multiselect('disable');
};
desactivar=function(id){
    Celulas.CambiarEstadoCelulas(id,0);
};

Agregar=function(){
    if(validaCelulas()){
        var quiebres_selec = $('select#slct_quiebres').val();
        Celulas.AgregarEditarCelula(0,quiebres_selec);
    }
};

validaCelulas=function(){
    $('#form_celula [data-toggle="tooltip"]').css("display","none");
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