<script type="text/javascript">

$(document).ready(function() {

    Categorias.CargarCategorias(activarTabla);

    $('#categoriaModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // captura al boton
      var titulo = button.data('titulo'); // extrae del atributo data-
      var categoria_id = button.data('id');

      var modal = $(this); //captura el modal
      modal.find('.modal-title').text(titulo+' Categoria');
      $('#form_categorias [data-toggle="tooltip"]').css("display","none");
      $("#form_categorias input[type='hidden']").remove();

        if(titulo=='Nuevo'){

            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
            $('#form_categorias #slct_estado').val(1);
            $('#form_categorias #txt_nombre').focus();

        } else {
            var id = CategoriaObj[categoria_id].id;

            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_categorias #txt_nombre').val( CategoriaObj[categoria_id].nombre );
            $('#form_categorias #slct_estado').val( CategoriaObj[categoria_id].estado );
            $("#form_categorias").append("<input type='hidden' value='"+id+"' name='id'>");
        }

    });

    $('#categoriaModal').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body input').val('');
    });
});
beforeSubmit = function (){};
success = function (){};

HTMLCargarCategorias = function(datos){
    var html="", estadohtml="";
    $('#t_categorias').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }

        html+="<tr>"+
            "<td>"+data.nombre+"</td>"+
            "<td id='estado_"+data.id+"' data-estado='"+data.estado+"'>"+estadohtml+"</td>"+
            '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoriaModal" data-id="'+index+'" data-titulo="Editar"><i class="fa fa-edit fa-lg"></i> </a></td>';

        html+="</tr>";
    });
    $("#tb_categorias").html(html);
    activarTabla();
};
activarTabla = function(){
    $("#t_categorias").dataTable(); // inicializo el datatable
};
activar = function(id){
    Categorias.CambiarEstadoCategorias(id, 1);
};
desactivar = function(id){
    Categorias.CambiarEstadoCategorias(id, 0);
};
Editar = function(){
    if(validaCategorias()){
        Categorias.AgregarEditarCategoria(1);
    }
};
Agregar = function(){
    if(validaCategorias()){
        Categorias.AgregarEditarCategoria(0);
    }
};
validaCategorias = function(){
    $('#form_categorias [data-toggle="tooltip"]').css("display","none");
    var a = [];
    a[0] = valida("txt", "nombre", "");
    var rpta = true;

    for(i=0;i<a.length;i++){
        if(a[i]===false){
            rpta=false;
            break;
        }
    }
    return rpta;
};
valida = function(inicial, id, v_default){
    var texto = "Seleccione";

    if(inicial=="txt"){
        texto = "Ingrese";
    }
    if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
        $('#error_'+id).attr('data-original-title',texto+' '+id);
        $('#error_'+id).css('display','');
        return false;
    }
};
</script>
