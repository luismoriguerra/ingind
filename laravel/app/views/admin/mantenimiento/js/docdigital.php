<script>
$(document).ready(function() {
    
    slctGlobal.listarSlctFuncion('plantilladoc','cargar','slct_plantilla','simple',null,{'area':1});
    
    UsuarioArea='<?php echo Auth::user()->area_id; ?>';
    Plantillas.Cargar(HTMLCargar);
    
    /*Plantillas.getArea();*/
    HTML_Ckeditor();

    $(document).on('change', '#slct_plantilla', function(event) {
        event.preventDefault();
        Plantillas.CargarInfo({'id':$(this).val()},HTMLPlantilla);
    });
/*
    $(document).on('change', '#slct_areas', function(event) {
        event.preventDefault();
        var area_id = $(this).val();
        var persona_id = $("#slct_areas option[value="+area_id.slice(-1)[0]+"]").attr('id-persona');
        areasSelect.push({'area_id':area_id.slice(-1)[0],'persona_id':persona_id});
    });*/

    $(document).on('click', '#btnCrear', function(event) {
        event.preventDefault();       
        var id = $("#txt_iddocdigital").val();
        if(id){
            Editar();
        }else{
            Agregar();
        }
    });

    /*validaciones*/
    function limpia(area) {
        $(area).find('input[type="text"],input[type="hidden"],input[type="email"],textarea,select').val('');
        $("#lblDocumento").text('');
        $("#lblArea").text('');
        $('#formNuevoDocDigital').data('bootstrapValidator').resetForm();
        CKEDITOR.instances.plantillaWord.setData('');
    };

    $('#NuevoDocDigital').on('hidden.bs.modal', function(){
        limpia(this);
    });

    $('#formNuevoDocDigital').bootstrapValidator({
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
        }
    });
    /*end validaciones*/


    $('#NuevoDocDigital').on('show.bs.modal', function (event) {

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
    $("#t_doc_digital").dataTable();
};
Editar=function(){
   /* if(validaPlantilla()){*/
        Plantillas.AgregarEditar(AreaSeleccionadas(),1);
/*    }*/
};
activar=function(id){
    Plantillas.CambiarEstado(id);
};
desactivar=function(id){
    Plantillas.CambiarEstado(id,0);
};
Agregar=function(){
    Plantillas.AgregarEditar(AreaSeleccionadas(),0);
};

HTMLCargar=function(datos){
    var html="";
    $('#t_plantilla').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        html+="<tr>"+
            "<td>"+data.titulo+"</td>"+
            "<td>"+data.asunto+"</td>"+
            "<td>"+data.plantilla+"</td>"+
           /* "<td>"+data.area+"</td>"+
            "<td>"+data.pnombre+" "+data.ppaterno+" "+data.pmaterno+"</td>"+*/
            "<td>"+
                "<a class='btn btn-primary btn-sm' onclick='editDocDigital("+data.id+"); return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a>"+
            "</td>"+
            "<td>"+
                "<a class='btn btn-default btn-sm' onclick='openPrevisualizarPlantilla("+data.id+"); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'></i> </a>"+
            "</td>";
        html+="</tr>";
    });
    $("#tb_doc_digital").html(html);
    activarTabla();
};

HTML_Ckeditor=function(){

    CKEDITOR.replace( 'plantillaWord' );

};
openPrevisualizarPlantilla=function(id){
    window.open("documentodig/vistaprevia/"+id,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};

HTMLAreas = function (data){
    if(data.length > 0){
        var html = '';
        $.each(data,function(index, el) {
            html+="<option value='"+el.idarea+"' id-persona='"+el.idpersona+"'>"+el.area+"("+el.persona+")"+"</option>";
        });
        $("#slct_areas").html(html);
    }
}

HTMLPlantilla = function(data){
    if(data.length > 0){
        var result = data[0];
        var tittle = result.tipodoc + "N-XX-2016" + "/MDI";
        document.querySelector("#lblDocumento").innerHTML= result.tipodoc+"-Nº";
        document.querySelector("#lblArea").innerHTML= "-"+new Date().getFullYear()+"-"+result.nemonico_doc;
        document.querySelector('#txt_area_plantilla').value = result.area_id;
        CKEDITOR.instances.plantillaWord.setData( result.cuerpo );
        Plantillas.CargarCorrelativo({'tipo_doc':result.tipo_documento_id},HTMLCargarCorrelativo);
    }
}

HTMLCargarCorrelativo=function(obj){
    $("#txt_titulo").val("");
    var ano= obj.ano;
    var correlativo=obj.correlativo;
    $("#txt_titulo").val(correlativo);
}

editDocDigital = function(id){
    Plantillas.CargarAreas(HTMLAreas);      
    Plantillas.Cargar(HTMLEdit,{'id':id});
}

HTMLEdit = function(data){
    if(data.length > 0){
        /*set areas*/
        $.each(data,function(index, el) {
            $("#slct_areas option[value='"+el.area_id+"']").prop("selected",true);
        });
        /*end set areas*/

        $('#slct_plantilla').val(data[0].plantilla_doc_id);
        $('#slct_plantilla').multiselect('refresh');

        var titulo = data[0].titulo.split("-");
        document.querySelector("#lblDocumento").innerHTML= titulo[0]+"-";
        document.querySelector("#lblArea").innerHTML= "-"+titulo[2]+"-"+titulo[3];
        document.querySelector("#txt_titulo").value = titulo[1];
        document.querySelector('#txt_area_plantilla').value = data[0].area_id;
        CKEDITOR.instances.plantillaWord.setData( data[0].cuerpo );
        document.querySelector("#txt_asunto").value = data[0].asunto;
        document.querySelector("#txt_iddocdigital").value = data[0].id;
        $("#NuevoDocDigital").modal('show');
    }
}

AreaSeleccionadas = function(){
    areasSelect = [];
    $('#slct_areas  option:selected').each(function(index,el) {
        var area_id = $(el).val();
        var persona_id  = $(el).attr('id-persona');
        areasSelect.push({'area_id':area_id,'persona_id':persona_id});
    });
    return areasSelect;
}

</script>