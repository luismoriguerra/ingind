<script type="text/javascript">
$(document).ready(function() {  
    Usuario.CargarUsuarios(activarTabla);

    $('#usuarioModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      var usuario_id = button.data('id'); //extrae el id del atributo data
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Usuario');
      $('#form_usuarios [data-toggle="tooltip"]').css("display","none");
      $("#form_usuarios input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            Usuario.CargarQuiebres('nuevo',null);
            Usuario.cargarEmpresa('nuevo',null);
            Usuario.cargarPerfiles('nuevo',null);
            Usuario.cargarEmpresas('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_usuarios #slct_estado').val(1); 
            $('#form_usuarios #txt_nombre').focus();
        }
        else{
            Usuario.CargarQuiebres('editar',usuario_id);
            Usuario.cargarEmpresas('editar',usuario_id);
            empresa_id=$('#t_usuarios #empresa_id_'+button.data('id') ).attr('empresa_id');
            perfil_id=$('#t_usuarios #perfil_id_'+button.data('id') ).attr('perfil_id');
            Usuario.cargarEmpresa('editar',empresa_id);
            Usuario.cargarPerfiles('editar',perfil_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_usuarios #txt_nombre').val( $('#t_usuarios #nombre_'+button.data('id') ).text() );
            $('#form_usuarios #txt_apellido').val( $('#t_usuarios #apellido_'+button.data('id') ).text() );
            $('#form_usuarios #txt_usuario').val( $('#t_usuarios #usuario_'+button.data('id') ).text() );
            $('#form_usuarios #txt_dni').val( $('#t_usuarios #dni_'+button.data('id') ).text() );
            $('#form_usuarios #slct_sexo').val( $('#t_usuarios #sexo_'+button.data('id') ).attr("data-sexo") );
            $('#form_usuarios #txt_imagen').val( $('#t_usuarios #imagen_'+button.data('id') ).text() );
            $('#form_usuarios #slct_estado').val( $('#t_usuarios #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_usuarios").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
        $( "#slct_estado" ).change(function() {
            if ($( "#slct_estado" ).val()==1)
                $('#slct_quiebres').multiselect('enable');
            else
                $('#slct_quiebres').multiselect('disable');
        });
    });

    $('#usuarioModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
      $('#slct_quiebres').multiselect('destroy');
      $('#slct_empresas').multiselect('destroy');
    });
});

activarTabla=function(){
    $("#t_usuarios").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaUsuarios()){
        Usuario.AgregarEditarUsuario(1);
    }
};

activar=function(id){
    Usuario.CambiarEstadoUsuarios(id,1);
};
desactivar=function(id){
    Usuario.CambiarEstadoUsuarios(id,0);
};

Agregar=function(){
    if(validaUsuarios()){
        Usuario.AgregarEditarUsuario(0);
    }
};

validaUsuarios=function(){
    $('#form_usuarios [data-toggle="tooltip"]').css("display","none");
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

HTMLCargarUsuario=function(datos){
    var html="";
    $('#t_usuario').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td id='apellido_"+data.id+"'>"+data.apellido+"</td>"+
            "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
            "<td id='usuario_"+data.id+"'>"+data.usuario+"</td>"+
            "<td id='dni_"+data.id+"'>"+data.dni+"</td>"+
            "<td id='sexo_"+data.id+"' data-sexo='"+data.sexo+"'>"+data.sexo+"</td>"+
            "<td id='imagen_"+data.id+"'>"+data.imagen+"</td>"+
            "<td id='perfil_id_"+data.id+"' perfil_id='"+data.perfil_id+"'>"+data.perfil+"</td>"+
            "<td id='empresa_id_"+data.id+"' empresa_id='"+data.empresa_id+"'>"+data.empresa+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#usuarioModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_usuarios").html(html);
    activarTabla();
};
HTMLCargarEmpresas=function(obj,accion){
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
    $("#slct_empresas").html(html);

    $("#slct_empresas").multiselect({
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
    //estado de usuarios
    if ($( "#slct_estado" ).val() === '1')
        $('#slct_empresas').multiselect('enable');
    else 
        $('#slct_empresas').multiselect('disable');
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
    //estado de usuarios
    if ($( "#slct_estado" ).val() === '1')
        $('#slct_quiebres').multiselect('enable');
    else 
        $('#slct_quiebres').multiselect('disable');
};
</script>