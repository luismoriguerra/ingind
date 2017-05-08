<script>
$(document).ready(function() {
    Plantillas.Cargar(activarTabla,{'area':1});
    /*Plantillas.getArea();*/
    HTML_Ckeditor();

     /*inicializate selects*/
    slctGlobal.listarSlct('documento','slct_tipodoc','simple',null,{estado:1});
    slctGlobal.listarSlctFuncion('area','listara','slct_area','simple',null,{estado:1,areapersona:1,areagestionall:1});
    /*end inicializate selects*/

    $(document).on('click', '#btnEditar', function(event) {
        event.preventDefault();
        $("#txt_id").val($(this).attr('data-id'));
        Plantillas.CargarInfo({'id':$(this).attr('data-id')},HTMLEditar);
        $('#plantillaModal').modal('show');
    });

    $(document).on('click', '#btnCrear', function(event) {
        event.preventDefault();       
        var id = $("#txt_id").val();
        if(id){
            Editar();
        }else{
            Agregar();
        }
    });

    /*validaciones*/
    function limpia(area) {
        $(area).find('input[type="text"],input[type="hidden"],input[type="email"],textarea,select').val('');
        $('#form_plantilla').data('bootstrapValidator').resetForm();
        CKEDITOR.instances.plantillaWord.setData('');
    };

    $('#plantillaModal').on('hidden.bs.modal', function(){
        limpia(this);
    });

    $('#form_plantilla').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh',
        },
        excluded: ':disabled',
        fields: {
            txt_nombre: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            },
            slct_tipodoc: {
                validators: {
                    choice: {
                        min:1,
                        message: 'campo requerido'
                    }
                }
            },
            slct_area: {
                validators: {
                    choice: {
                        min:1,
                        message: 'campo requerido'
                    }
                }
            },
         /*   word: {
                validators: {
                    notEmpty: {
                        message: 'campo requerido'
                    }
                }
            }*/
        }
    });
    /*end validaciones*/


    $('#plantillaModal').on('show.bs.modal', function (event) {
     /*   var button = $(event.relatedTarget);
        var titulo = button.data('titulo');
            plantilla_id = button.data('id');
        var Plantilla = PlantillaObj[plantilla_id];*/
     /*   var modal = $(this);

        titulo = "Nuevo";
        var id = $("#txt_id").val();
        if(id){
            titulo = "Editar";
        }*/

    /*    $(this).find('form')[0].reset();
        modal.find('.modal-title').text(titulo+' Plantilla');
        $('#form_plantilla [data-toggle="tooltip"]').css("display","none");
        $("#form_plantilla input[type='hidden']").remove();*/

     /*   if(titulo=='Nuevo'){
            modal.find('.modal-footer .btn-primary').text('Guardar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Agregar();');
        } else {
            modal.find('.modal-footer .btn-primary').text('Actualizar');
            modal.find('.modal-footer .btn-primary').attr('onClick','Editar();');
            $('#form_plantilla #txt_nombre').val( Plantilla.nombre );
            $('#form_plantilla #slct_estado').val( Plantilla.estado );
            $('#form_plantilla #txt_titulo').val( Plantilla.titulo );
            $('#form_plantilla #slct_cabecera').val( Plantilla.cabecera );
            Plantilla.cuerpo = ( Plantilla.cuerpo == null ) ? '' : Plantilla.cuerpo;
            CKEDITOR.instances.plantillaWord.setData( Plantilla.cuerpo );
            $("#form_plantilla").append("<input type='hidden' value='"+Plantilla.id+"' name='id'>");

        }*/
 /*       $( "#form_plantilla #slct_cabecera" ).trigger('change');
        $( "#form_plantilla #slct_estado" ).trigger('change');
        $( "#form_plantilla #slct_estado" ).change(function() {
            if ($( "#form_plantilla #slct_estado" ).val()==1) {
                $('#word').removeAttr('disabled');
            } else {
                $('#word').attr('disabled', 'disabled');
            }
        });*/
    });

   /* $('#plantillaModal').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body input').val('');
        CKEDITOR.instances.plantillaWord.setData( "" );
        $('#form_plantilla #slct_estado').val( 1 );
    });*/
/*    $('#form_plantilla #slct_cabecera').on('change', function (event) {
        if ( $(this).val() == '1' ) {
            $('#partesCabecera').show();
        } else {
            $('#partesCabecera').hide();
        }
    });*/
});
activarTabla=function(){
    $("#t_plantilla").dataTable();
};
Editar=function(){
   /* if(validaPlantilla()){*/
        Plantillas.AgregarEditar(1);
/*    }*/
};
activar=function(id){
    var c= confirm("¿Está seguro de activar Plantilla?");
    if(c){
    Plantillas.CambiarEstado(id,1);
    }
};
desactivar=function(id){
    var c= confirm("¿Está seguro de Desactivar Plantilla?");
    if(c){
    Plantillas.CambiarEstado(id,0);
    }
};
Agregar=function(){
   /* if(validaPlantilla()){*/
        Plantillas.AgregarEditar(0);
   /* }*/
};
/*validaPlantilla=function(){
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
};*/

HTMLCargar=function(datos){
    var html="";
    $('#t_plantilla').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        estadohtml='<span id="'+data.id+'" onClick="activar('+data.id+')" class="btn btn-danger">Inactivo</span>';
        if(data.estado==1){
            estadohtml='<span id="'+data.id+'" onClick="desactivar('+data.id+')" class="btn btn-success">Activo</span>';
        }
        html+="<tr>"+
            "<td>"+data.descripcion+"</td>"+
            "<td>"+data.tipodoc+"</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+estadohtml+"</td>"+
            "<td>"+
                "<a class='btn btn-primary btn-sm' id='btnEditar' data-id='"+data.id+"' data-titulo='Editar'><i class='fa fa-edit fa-lg'></i> </a>"+
            "</td>"+
            "<td>"+
                "<a class='btn btn-default btn-sm' onclick='openPrevisualizarPlantilla("+data.id+"); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'></i> </a>"+
            "</td>";
        html+="</tr>";
    });
    $("#tb_plantilla").html(html);
    activarTabla();
};

HTMLEditar = function(data){
    if(data.length > 0){
        var result = data[0];
        document.querySelector("#txt_nombre").value = result.descripcion;
        $("#slct_tipodoc>option[value='"+result.tipo_documento_id+"']").prop('selected',true);
        $("#slct_area>option[value='"+result.area_id+"']").prop('selected',true);
        CKEDITOR.instances.plantillaWord.setData( result.cuerpo );
    }
}

HTML_Ckeditor=function(){

    CKEDITOR.replace( 'plantillaWord' );

};
openPrevisualizarPlantilla=function(id){
    window.open("plantilladoc/vistaprevia/"+id,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};
</script>
