<script type="text/javascript">
$(document).ready(function() {
    Flujo_tr.CargarFlujo_tr(activarTabla);

    $('#flujo_trModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var titulo = button.data('titulo'); // extrae del atributo data-
        var flujo_tr_id = button.data('id');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this); //captura el modal
        modal.find('.modal-title').text(titulo+' Respuesta del Proceso');
        $('#form_flujo_tr [data-toggle="tooltip"]').css("display","none");
        $("#form_flujo_tr input[type='hidden']").remove();
        
        if(titulo=='Nuevo') {
            Flujo_tr.cargarFlujos('nuevo',null);
            Flujo_tr.cargarTiempos('nuevo',null);
            Flujo_tr.cargarTipoRespuestas('nuevo',null);
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_flujo_tr #slct_estado').val(1);
            $('#form_flujo_tr #txt_nombre').focus();
        }
        else {
            flujo_id=FlujoObj[flujo_tr_id].flujo_id;
            tiempo_id=FlujoObj[flujo_tr_id].tiempo_id;
            tipo_respuesta_id=FlujoObj[flujo_tr_id].tipo_respuesta_id;
            Flujo_tr.cargarFlujos('editar',flujo_id);
            Flujo_tr.cargarTiempos('editar',tiempo_id);
            Flujo_tr.cargarTipoRespuestas('editar',tipo_respuesta_id);
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_flujo_tr #txt_dtiempo').val( FlujoObj[flujo_tr_id].dtiempo );
            $('#form_flujo_tr #slct_estado').val( FlujoObj[flujo_tr_id].estado );
            $("#form_flujo_tr").append("<input type='hidden' value='"+FlujoObj[flujo_tr_id].id+"' name='id'>");
        }
        $('#slct_tipo_respuesta_id').on("change", function(){
            alternarFieldSetTiempo();
        });
    });

    $('#flujo_trModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal
      modal.find('.modal-body input').val(''); // busca un input para copiarle texto
    });
});
alternarFieldSetTiempo=function(){
    var id = $('#slct_tipo_respuesta_id').val();
    var tiempo;
    for (var i = tiporespuesta.length - 1; i >= 0; i--) {
        tiporespuesta[i]
        if (tiporespuesta[i].id==id) {
            tiempo = tiporespuesta[i].tiempo;
            break;
        }
    };
    if (tiempo==1) {//mostrar
        $('#f_tiempo').css('display','block');
    } else {
        $('#f_tiempo').css('display','none');
        $('#slct_tiempo_id').val('');
        $('#txt_dtiempo').val('');
    }
};
activarTabla=function(){
    $("#t_flujo_tr").dataTable(); // inicializo el datatable    
};

Editar=function(){
    if(validaFlujo_tr()){
        Flujo_tr.AgregarEditarFlujo_tr(1);
    }
};

activar=function(id){
    Flujo_tr.CambiarEstadoFlujo_tr(id,1);
};

desactivar=function(id){
    Flujo_tr.CambiarEstadoFlujo_tr(id,0);
};

Agregar=function(){
    if(validaFlujo_tr()){
        Flujo_tr.AgregarEditarFlujo_tr(0);
    }
};

validaFlujo_tr=function(){
    $('#form_flujo_tr [data-toggle="tooltip"]').css("display","none");
    var a=[];
    a[0]=valida("slct","estado","");
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
    if(inicial=="slct"){
        texto="Ingrese";
    }

    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }   
};
HTMLCargarFlujo=function(datos){
    var html="";
    var estadohtml="", tiempo='';
    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
            tiempo = (data.tiempo=='')? '':data.tiempo+': '+data.dtiempo;
        } else {
            tiempo='';
        }
        
        html+="<tr>"+
            "<td>"+data.flujo+"</td>"+
            "<td>"+data.tipo_respuesta+"</td>"+
            "<td>"+tiempo+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#flujo_trModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_flujo_tr").html(html); 
    activarTabla();
};
</script>
