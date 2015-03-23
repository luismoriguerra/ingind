<script type="text/javascript">
$(document).ready(function() {  
    Persona.CargarPersonas(activarTabla);

    $('#personaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      var persona_id = button.data('id'); //extrae el id del atributo data
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Persona');
      $('#form_personas [data-toggle="tooltip"]').css("display","none");
      $("#form_personas input[type='hidden']").remove();

        if(titulo=='Nuevo'){
            slctGlobal.listarSlct('cargo','slct_cargos','simple');
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_personas #slct_estado').val(1); 
            $('#form_personas #txt_nombre').focus();
        }
        else{
/*            Persona.CargarQuiebres('editar',persona_id);
            Persona.cargarEmpresas('editar',persona_id);
            empresa_id=$('#t_personas #empresa_id_'+button.data('id') ).attr('empresa_id');
            perfil_id=$('#t_personas #perfil_id_'+button.data('id') ).attr('perfil_id');
            Persona.cargarEmpresa('editar',empresa_id);
            Persona.cargarPerfiles('editar',perfil_id);*/
            Persona.CargarAreas(persona_id); //no es multiselect
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_personas #txt_nombre').val( $('#t_personas #nombre_'+button.data('id') ).text() );
            $('#form_personas #txt_paterno').val( $('#t_personas #paterno_'+button.data('id') ).text() );
            $('#form_personas #txt_materno').val( $('#t_personas #materno_'+button.data('id') ).text() );
            $('#form_personas #txt_fecha_nac').val( $('#t_personas #fecha_nac_'+button.data('id') ).text() );
            $('#form_personas #txt_dni').val( $('#t_personas #dni_'+button.data('id') ).text() );
            $('#form_personas #slct_password').val( $('#t_personas #password_'+button.data('id') ).attr("data-sexo") );
            $('#form_personas #slct_email').val( $('#t_personas #email_'+button.data('id') ).attr("data-sexo") );
            $('#form_personas #txt_imagen').val( $('#t_personas #imagen_'+button.data('id') ).text() );
            $('#form_personas #slct_estado').val( $('#t_personas #estado_'+button.data('id') ).attr("data-estado") );
            $("#form_personas").append("<input type='hidden' value='"+button.data('id')+"' name='id'>");
        }
        $( "#form_personas #slct_estado" ).trigger('change');
        $( "#form_personas #slct_estado" ).change(function() {
            if ($( "#form_personas #slct_estado" ).val()==1) {
                $('#f_areas_cargo').removeAttr('disabled');
            }
            else {
                $('#f_areas_cargo').attr('disabled', 'disabled');
            }
        });
    });

    $('#personaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});

activarTabla=function(){
    $("#t_personas").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaPersonas()){
        Persona.AgregarEditarPersona(1);
    }
};

activar=function(id){
    Persona.CambiarEstadoPersonas(id,1);
};
desactivar=function(id){
    Persona.CambiarEstadoPersonas(id,0);
};

Agregar=function(){
    if(validaPersonas()){
        Persona.AgregarEditarPersona(0);
    }
};
AgregarArea=function(){
    //añadir registro "opcion" por usuario
    var cargo_id=$('#slct_cargos option:selected').val();
    var cargo=$('#slct_cargos option:selected').text();
    var buscar_cargo = $('#cargo_'+cargo_id).text();
    if (cargo_id!=='') {
        if (buscar_cargo==="") {

            var html='';
            html+="<li class='list-group-item'><div class='row'>";
            html+="<div class='col-sm-4' id='cargo_"+cargo_id+"'><h5>"+cargo+"</h5></div>";
            //$("#opcion_"+cargo_id+" option").attr("selected",false);

            html+="<div class='col-sm-6'>";
            html+="<select class='form-control' multiple='multiple' name='slct_areas"+cargo_id+"[]' id='slct_areas"+cargo_id+"'></select></div>";
            var envio = {cargo_id: cargo_id};

            html+='<div class="col-sm-2">';
            html+='<button type="button" id="'+cargo_id+'" Onclick="EliminarArea(this)" class="btn btn-danger btn-sm" >';
            html+='<i class="fa fa-minus fa-sm"></i> </button></div>';
            html+="</div></li>";

            $("#t_cargoPersona").append(html);
            slctGlobal.listarSlct('area','slct_areas'+cargo_id,'multiple',null,envio);
            cargos_selec.push(cargo_id);
        } else 
            alert("Ya se agrego este Cargo");
    } else 
        alert("Seleccione Cargo");

};
EliminarArea=function(obj){
    //console.log(obj);
    var valor= obj.id;
    obj.parentNode.parentNode.parentNode.remove();
    var index = cargos_selec.indexOf(valor);
    cargos_selec.splice( index, 1 );
};
validaPersonas=function(){
    $('#form_personas [data-toggle="tooltip"]').css("display","none");
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

HTMLCargarPersona=function(datos){
    var html="";
    $('#t_personas').dataTable().fnDestroy();

    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td id='paterno_"+data.id+"'>"+data.paterno+' '+"</td>"+
            "<td id='materno_"+data.id+"'>"+data.materno+"</td>"+
            "<td id='nombre_"+data.id+"'>"+data.nombre+"</td>"+
            "<td id='email_"+data.id+"'>"+data.email+"</td>"+
            "<td id='dni_"+data.id+"'>"+data.dni+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#personaModal" data-id="'+data.id+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_personas").html(html);
    activarTabla();
};
</script>