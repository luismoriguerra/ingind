<script>
$(document).ready(function() {
    
    slctGlobal.listarSlctFuncion('plantilladoc','cargar','slct_plantilla','simple',null,{'area':1});
    slctGlobal.listarSlctFuncion('area','areasgerencia','slct_areas','multiple',null);
    slctGlobal.listarSlctFuncion('area','areasgerencia','slct_copia','multiple',null);
    slctGlobalHtml('slct_tipoenvio','simple');
    slctGlobal.listarSlct('area','slct_areasp','simple',null,{estado:1});   
    /*slctGlobal.listarSlctFuncion('area','personasarea','slct_personaarea','simple',null);     */
    
    UsuarioArea='<?php echo Auth::user()->area_id; ?>';
    Plantillas.Cargar(HTMLCargar);
    
    /*Plantillas.getArea();*/
    HTML_Ckeditor();

    $('.chk').on('ifChanged', function(event){
        if(event.target.value == 'allgesub'){
            if(event.target.checked == true){
                $(".copias").addClass('hidden');
                $(".araesgerencia").addClass('hidden');
                $('#slct_areas option').prop('selected', true);
                $('#slct_areas').multiselect('refresh');
            }else{
                $(".copias").removeClass('hidden');
                $(".araesgerencia").removeClass('hidden');

                $('#slct_areas option').prop('selected', false);
                $('#slct_areas').multiselect('refresh');
            }
        }
    });

    $(document).on('change', '#slct_plantilla', function(event) {
        event.preventDefault();
        Plantillas.CargarInfo({'id':$(this).val()},HTMLPlantilla);
    });

    $(document).on('change', '#slct_tipoenvio', function(event) {
        event.preventDefault();
        TipoEnvio();
    });

    $(document).on('click', '#btnCrear', function(event) {
        event.preventDefault();       
        var id = $("#txt_iddocdigital").val();
        if(id){
            Editar();
        }else{
            Agregar();
        }
    });

    $(document).on('change','#slct_areasp',function(event){
        $('#slct_personaarea').multiselect('destroy');
        slctGlobal.listarSlctFuncion('area','personaarea','slct_personaarea','simple',null,{'area_id':$(this).val()});  
        $(".personasarea").removeClass('hidden');
    });

    /*validaciones*/
    function limpia(area) {
        $(area).find('input[type="text"],input[type="hidden"],input[type="email"],textarea,select').val('');
        $("#lblDocumento").text('');
        $("#lblArea").text('');
       /* $('#formNuevoDocDigital').data('bootstrapValidator').resetForm();*/
        CKEDITOR.instances.plantillaWord.setData('');
        $(".araesgerencia,.areaspersona,.personasarea").addClass('hidden');
        $("#slct_copia").val(['']);
        $("#slct_copia").multiselect('refresh');
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
        $("#slct_tipoenvio").multiselect('destroy');
        $("#slct_tipoenvio").val('0');
        slctGlobalHtml('slct_tipoenvio','simple');
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
TipoEnvio=function(){
    $(".araesgerencia").removeClass('hidden');
    $(".areaspersona").removeClass('hidden');
    $(".personasarea").removeClass('hidden');
    $(".asunto").removeClass('hidden');
    $(".personasarea").addClass('hidden');

    if($("#slct_tipoenvio").val() == 1){ //persona
        $(".araesgerencia").addClass('hidden');
    }
    else if($("#slct_tipoenvio").val() == 4){
        $(".araesgerencia").addClass('hidden');
        $(".areaspersona").addClass('hidden');
        $(".asunto").addClass('hidden');
    }
    else{ //gerencia
         $(".areaspersona").addClass('hidden');
    }
};
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
    var eye = "";
    $.each(datos,function(index,data){

        if($.trim(data.ruta) == 0 && $.trim(data.rutadetallev) == 0){
            html+="<tr class='danger'>";
        }else{
            html+="<tr class='success'>";
        }
        html+="<td>"+data.persona_c+"</td>";
        html+="<td>"+data.persona_u+"</td>";
        html+="<td>"+data.titulo+"</td>";
        html+="<td>"+data.asunto+"</td>";
        html+="<td>"+data.plantilla+"</td>";

        if(data.estado == 1){
            html+="<td><a class='btn btn-primary btn-sm' onclick='editDocDigital("+data.id+"); return false;' data-titulo='Editar'><i class='glyphicon glyphicon-pencil'></i> </a></td>";

            if($.trim(data.ruta) != 0 || $.trim(data.rutadetallev)!= 0){
                html+="<td><a class='btn btn-default btn-sm' onclick='openPrevisualizarPlantilla("+data.id+"); return false;' data-titulo='Previsualizar'><i class='fa fa-eye fa-lg'></i> </a></td>";
                html+="<td></td>";
            }else{
                html+="<td></td>";
                html+= "<td><a class='btn btn-danger btn-sm' onclick='deleteDocumento("+data.id+"); return false;' data-titulo='Eliminar'><i class='glyphicon glyphicon-trash'></i> </a></td>";
            }
            
        }else{
            html+="<td><a class='btn btn-primary btn-sm' style='opacity:0.5'><i class='glyphicon glyphicon-pencil'></i> </a></td>";
            html+="<td><a class='btn btn-default btn-sm' style='opacity:0.5'><i class='fa fa-eye fa-lg'></i> </a></td>";
            html+= "<td><a class='btn btn-danger btn-sm' style='opacity:0.5'><i class='glyphicon glyphicon-trash'></i> </a></td>";
        }

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
      /*  var html = '';
        $.each(data,function(index, el) {
            html+="<option value='"+el.idarea+"' id-persona='"+el.idpersona+"'>"+el.area+"("+el.persona+")"+"</option>";
        });
        $("#slct_areas").html(html);
        $("#slct_areas2").html(html);*/
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

deleteDocumento = function(id){
    Plantillas.EliminarDocumento({'estado':0,'id':id});    
}


HTMLEdit = function(data){

    if(data.length > 0){
        if(data[0].envio_total == 1){
            $('input').iCheck('check');
        }else{
            $('input').iCheck('uncheck');
        }
        /*personas area envio*/
        if(data[0].tipo_envio == 1){ //persona
            $(".areaspersona,.personasarea").removeClass('hidden');
            $("#slct_areasp").val(data[0].area_id);
            $('#slct_areasp').multiselect('refresh');

            var ids = [];
            ids.push(data[0].persona_id);
            $('#slct_personaarea').multiselect('destroy');
            slctGlobal.listarSlctFuncion('area','personaarea','slct_personaarea','simple',ids,{'area_id':data[0].area_id});  
        }else{ //gerencia
            originales = [];
            copias = [];
            $.each(data,function(index, el) {
                if(el.tipo == 1 ){
                    originales.push(el.area_id);
                }else if(el.tipo == 2){
                    copias.push(el.area_id);
                }
            });
            $(".todassubg").removeClass('hidden');
            $("#slct_areas").val(originales);
            $('#slct_areas').multiselect('refresh');
            $("#slct_copia").val(copias);
            $('#slct_copia').multiselect('refresh');
            $(".araesgerencia").removeClass('hidden');
        }

        $('#slct_tipoenvio').val(data[0].tipo_envio);
        $('#slct_tipoenvio').multiselect('refresh');        
        /*end personas area envio */

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
        TipoEnvio();
        $("#NuevoDocDigital").modal('show');
    }
}

AreaSeleccionadas = function(){
    areasSelect = [];
    if($('#slct_tipoenvio').val() == 1){ //persona
        areasSelect.push({'area_id':$('#slct_areasp').val(),'persona_id':$('#slct_personaarea').val(),'tipo':1});
    }else{ //gerencias
        $('#slct_areas  option:selected').each(function(index,el) {
            var area_id = $(el).val();
            var persona_id  = $(el).attr('data-relation').split('|');
            areasSelect.push({'area_id':area_id,'persona_id':persona_id[1],'tipo':1});
        });
    }

    if($("#slct_copia").val() != ''){
        $('#slct_copia  option:selected').each(function(index,el) {
            var area_id = $(el).val();
            var persona_id  = $(el).attr('data-relation').split('|');
            areasSelect.push({'area_id':area_id,'persona_id':persona_id[1],'tipo':2});
        });
    }
    return areasSelect;
}

copias = function(){
    $(".copias").removeClass('hidden');
}

eventoSlctGlobalSimple=function(){
}
</script>
