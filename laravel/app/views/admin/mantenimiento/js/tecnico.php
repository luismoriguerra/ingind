<script type="text/javascript">
$(document).ready(function() {  
    Tecnicos.CargarTecnicos(activarTabla);

    $('#tecnicoModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      var tecnico_id = button.data('id');
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Tecnico');
      $('#form_tecnicos [data-toggle="tooltip"]').css("display","none");
      $("#form_tecnicos input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            Tecnicos.CargarEmpresas('nuevo',null);
            Tecnicos.CargarCelulas('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_tecnicos #slct_estado').val(1); 
            $('#form_tecnicos #txt_ape_paterno').focus();
        }
        else{
            Tecnicos.CargarCelulas('editar',tecnico_id);
            empresa_id=$('#t_tecnicos #empresa_id_'+button.data('id') ).attr('empresa_id');
            Tecnicos.CargarEmpresas('editar',empresa_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_tecnicos #txt_ape_paterno').val( $('#t_tecnicos #ape_paterno_'+button.data('id') ).text() );
            $('#form_tecnicos #txt_ape_materno').val( $('#t_tecnicos #ape_materno_'+button.data('id') ).text() );
            $('#form_tecnicos #txt_nombres').val( $('#t_tecnicos #nombres_'+button.data('id') ).text() );
            $('#form_tecnicos #txt_dni').val( $('#t_tecnicos #dni_'+button.data('id') ).text() );
            $('#form_tecnicos #txt_carnet').val( $('#t_tecnicos #carnet_'+button.data('id') ).text() );
            $('#form_tecnicos #txt_carnet_tmp').val( $('#t_tecnicos #carnet_tmp_'+button.data('id') ).text() );
            $('#form_tecnicos #slct_estado').val( $('#t_tecnicos #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_tecnicos").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
        $( "#slct_estado" ).change(function() {
            if ($( "#slct_estado" ).val()==='1')
                $('#slct_celulas').multiselect('enable');
            else
                $('#slct_celulas').multiselect('disable');
        });

    });

    $('#tecnicoModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
      $('#slct_celulas').multiselect('destroy');
    });
});

activarTabla=function(){
    $("#t_tecnicos").dataTable(); // inicializo el datatable
};

Editar=function(){
    if(validaTecnicos()){
        Tecnicos.AgregarEditarTecnico(1);
    }
};

activar=function(id){
    Tecnicos.CambiarEstadoTecnicos(id,1);
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
    $("#slct_celulas").html(html);

    $("#slct_celulas").multiselect({
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
        $('#slct_celulas').multiselect('enable');
    else 
        $('#slct_celulas').multiselect('disable');
};
desactivar=function(id){
    Tecnicos.CambiarEstadoTecnicos(id,0);
};

Agregar=function(){
    if(validaTecnicos()){
        Tecnicos.AgregarEditarTecnico(0);
    }
};

validaTecnicos=function(){
    $('#form_tecnicos [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("txt","nombres","");
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

HTMLCargarTecnico=function(datos){
    var html="";
    $('#t_tecnicos').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td id='ape_paterno_"+data.id+"'>"+data.ape_paterno+"</td>"+
            "<td id='ape_materno_"+data.id+"'>"+data.ape_materno+"</td>"+
            "<td id='nombres_"+data.id+"'>"+data.nombres+"</td>"+
            "<td id='dni_"+data.id+"'>"+data.dni+"</td>"+
            "<td id='carnet_"+data.id+"'>"+data.carnet+"</td>"+
            "<td id='carnet_tmp_"+data.id+"'>"+data.carnet_tmp+"</td>"+
            "<td id='empresa_id_"+data.id+"' empresa_id='"+data.empresa_id+"'>"+data.empresa+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tecnicoModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_tecnicos").html(html);
    activarTabla();
};
</script>