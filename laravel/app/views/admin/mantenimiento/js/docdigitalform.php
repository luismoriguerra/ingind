<?php
$personat=Auth::user()->nombre." ".Auth::user()->paterno." ".Auth::user()->materno;
$dpersonat=explode(" ",$personat);
$siglast="";

    for ($i=0; $i < count($dpersonat); $i++) { 
        if( trim($dpersonat[$i])!='' ){
            $siglast.=substr($dpersonat[$i], 0,1); 
        }
    }
?>
<script>
  var Documento={tipo_documento_id:0,tipoenvio:0,csigla:0};  
  var SiglasArea='';
  var SiglasPersona='<?php echo $siglast; ?>'; 
  var CrearEditar=1;
$(document).ready(function() {
    
    slctGlobal.listarSlctFuncion('plantilladoc','cargar','slct_plantilla','simple',null,{'area':1,'activo':1});
    slctGlobal.listarSlctFuncion('area','areasgerenciapersona','slct_areas','multiple',null);
    slctGlobal.listarSlctFuncion('area','areasgerenciapersona','slct_copia','multiple',null);
    slctGlobalHtml('slct_tipoenvio','simple');
    slctGlobal.listarSlct('area','slct_areasp','simple',null,{estado:1});   
    /*slctGlobal.listarSlctFuncion('area','personasarea','slct_personaarea','simple',null);     */
    
    UsuarioArea='<?php echo Auth::user()->area_id; ?>';

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
        Documento.tipoenvio=$("#slct_tipoenvio").val();
        Plantillas.CargarInfo({'id':$(this).val()},HTMLPlantilla);
    });

    $(document).on('change', '#slct_tipoenvio', function(event) {
        event.preventDefault();
        TipoEnvio();

        if(CrearEditar==1){
            if($(this).val()==3 || $(this).val()==5){
            document.querySelector("#lblArea").innerHTML= " - "+new Date().getFullYear()+" - "+SiglasPersona+" - "+SiglasArea;
            Plantillas.CargarCorrelativo({'tipo_doc':Documento.tipo_documento_id,'tipo_corre':1},HTMLCargarCorrelativo);
            } 
            else if( Documento.csigla==0){
            document.querySelector("#lblArea").innerHTML= " - "+new Date().getFullYear()+" - "+" MDI";
            Plantillas.CargarCorrelativo({'tipo_doc':Documento.tipo_documento_id,'tipo_corre':2},HTMLCargarCorrelativo); 
            }
            else {
            document.querySelector("#lblArea").innerHTML= " - "+new Date().getFullYear()+" - "+SiglasArea;
            Plantillas.CargarCorrelativo({'tipo_doc':Documento.tipo_documento_id,'tipo_corre':2},HTMLCargarCorrelativo);
            }
        }
    });

    $(document).on('click', '#btnCrear', function(event) {
        event.preventDefault();       
        var id = $("#txt_iddocdigital").val();
        if(id){
            Editar();
            CrearEditar=0;
        }else{
            Agregar();
            CrearEditar=1;
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
        $("#slct_copia,#slct_areas,#slct_areasp").val(['']);
        $("#slct_copia,#slct_areas,#slct_areasp").multiselect('refresh');
        $("#slct_plantilla").val('');
        $('#slct_plantilla').multiselect('refresh');
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
        slctGlobalHtml('slct_tipoenvio','simple');
    });
});

NuevoDocumento=function(){
    CrearEditar=1;
    $("#txt_titulo").removeAttr("disabled");
}

TipoEnvio=function(){
    $(".araesgerencia").removeClass('hidden');
    $(".areaspersona").removeClass('hidden');
    $(".personasarea").removeClass('hidden');
    $(".asunto").removeClass('hidden');
    $(".asuntolbl").text('Asunto:');
    $(".personasarea").removeClass('hidden');
    $(".todassubg").removeClass('hidden');

    if($("#slct_tipoenvio").val() == 1 || $("#slct_tipoenvio").val() == 5 ){ //persona
        $(".araesgerencia").addClass('hidden');
        $(".todassubg").addClass('hidden');
    }
    else if($("#slct_tipoenvio").val() == 4){
        $(".araesgerencia").addClass('hidden');
        $(".areaspersona").addClass('hidden');
        $(".asunto").addClass('hidden');
        $(".asuntolbl").text('Descripción del Documento:');
        $(".personasarea").addClass('hidden');
    }
    else{ //gerencia
         $(".areaspersona").addClass('hidden');
         $(".personasarea").addClass('hidden');
    }
};

Editar=function(){
    Plantillas.AgregarEditar(AreaSeleccionadas(),1);
};

Agregar=function(){
    Plantillas.AgregarEditar(AreaSeleccionadas(),0);
};

HTML_Ckeditor=function(){
    CKEDITOR.replace( 'plantillaWord' );
};

openPlantilla=function(id,tamano,tipo){
    window.open("documentodig/vista/"+id+"/"+tamano+"/"+tipo,
                "PrevisualizarPlantilla",
                "toolbar=no,menubar=no,resizable,scrollbars,status,width=900,height=700");
};

HTMLPlantilla = function(data){
    if(data.length > 0){
        var result = data[0];
        var tittle = result.tipodoc + "N-XX-2016" + "/MDI";
        CKEDITOR.instances.plantillaWord.setData( result.cuerpo );
        
        Documento.tipo_documento_id=result.tipo_documento_id;
        Documento.csigla=result.csigla;
        if(CrearEditar==1){
            document.querySelector("#lblDocumento").innerHTML= result.tipodoc+" - Nº ";
            SiglasArea= result.nemonico_doc;
            document.querySelector('#txt_area_plantilla').value = result.area_id;
            
            if( Documento.tipoenvio==3  || Documento.tipoenvio==5){
            document.querySelector("#lblArea").innerHTML= " - "+new Date().getFullYear()+" - "+SiglasPersona+" - "+SiglasArea;
            Plantillas.CargarCorrelativo({'tipo_doc':Documento.tipo_documento_id,'tipo_corre':1},HTMLCargarCorrelativo);
            } 
            else if( result.area==0){
            document.querySelector("#lblArea").innerHTML= " - "+new Date().getFullYear()+" - "+" MDI";
            Plantillas.CargarCorrelativo({'tipo_doc':Documento.tipo_documento_id,'tipo_corre':2},HTMLCargarCorrelativo); 
            }
            else {
            document.querySelector("#lblArea").innerHTML= " - "+new Date().getFullYear()+" - "+SiglasArea;
            Plantillas.CargarCorrelativo({'tipo_doc':Documento.tipo_documento_id,'tipo_corre':2},HTMLCargarCorrelativo);
            }
        }
    }
}

HTMLCargarCorrelativo=function(obj){
    $("#txt_titulo").val("");
    var ano= obj.ano;
    var correlativo=obj.correlativo;
    $("#txt_titulo").val(correlativo);
}

editDocDigital = function(id){
    CrearEditar=0;
    Plantillas.CargarAreas();
    Plantillas.Cargar(HTMLEdit,{'id':id});
}

HTMLEdit = function(data){

    if(data.length > 0){
        if(data[0].envio_total == 1){
            $('input').iCheck('check');
        }else{
            $('input').iCheck('uncheck');
        }
        /*personas area envio*/
        if(data[0].tipo_envio == 1 || data[0].tipo_envio == 5){ //persona
            $(".areaspersona,.personasarea").removeClass('hidden');
            $(".todassubg").addClass('hidden');
            $("#slct_areasp").val(data[0].area_id);
            $('#slct_areasp').multiselect('refresh');

            var ids = [];
            ids.push(data[0].persona_id);
            $('#slct_personaarea').multiselect('destroy');
            slctGlobal.listarSlctFuncion('area','personaarea','slct_personaarea','simple',ids,{'area_id':data[0].area_id});  
        }else{ //gerencia
            $(".araesgerencia").removeClass('hidden');
        }

        originales = [];
        copias = [];
        $.each(data,function(index, el) {
            if(el.tipo == 1 || el.tipo == 5 ){
                originales.push(el.area_id+'|'+el.persona_id);
            }else if(el.tipo == 2){
                copias.push(el.area_id+'|'+el.persona_id);
            }
        });
        $(".todassubg").removeClass('hidden');
        $("#slct_areas").val(originales);
        $('#slct_areas').multiselect('refresh');
        $("#slct_copia").val(copias);
        $('#slct_copia').multiselect('refresh');

        $('#slct_tipoenvio').val(data[0].tipo_envio);
        $('#slct_tipoenvio').multiselect('refresh');

        $('#slct_plantilla').val(data[0].plantilla_doc_id);
        $('#slct_plantilla').multiselect('refresh');

        var titulo = data[0].titulo.split("-");
        var titulofinal= data[0].titulo.split(titulo[2]+"-");

        document.querySelector("#lblDocumento").innerHTML= titulo[0]+" - Nº ";
        if( data[0].tipo_envio==3 ||  data[0].tipo_envio==5){
            SiglasArea= $.trim( titulofinal[1].split(titulofinal[1].split("-")[0]+"-")[1] );
            document.querySelector("#lblArea").innerHTML= " - "+titulo[2]+" - "+SiglasPersona+" - "+SiglasArea;
        }
        else{
            SiglasArea= $.trim( titulofinal[1] );
            document.querySelector("#lblArea").innerHTML= " - "+titulo[2]+" - "+SiglasArea;
        }

        var tnombre= $.trim($.trim( titulo[1] ).substring(2));
        document.querySelector("#txt_titulo").value = tnombre;
        document.querySelector('#txt_area_plantilla').value = data[0].area_id;
        CKEDITOR.instances.plantillaWord.setData( data[0].cuerpo );
        document.querySelector("#txt_asunto").value = data[0].asunto;
        document.querySelector("#txt_iddocdigital").value = data[0].id;
        TipoEnvio();
        $("#txt_titulo").attr("disabled","true");
        $("#NuevoDocDigital").modal('show');
    }
}

AreaSeleccionadas = function(){
    areasSelect = [];
    if($('#slct_tipoenvio').val() == 1 || $('#slct_tipoenvio').val() == 5){ //persona
        areasSelect.push({'area_id':$('#slct_areasp').val(),'persona_id':$('#slct_personaarea').val(),'tipo':1});
    }else{ //gerencias
        $('#slct_areas  option:selected').each(function(index,el) {
            var area_id = $(el).val().split('|')[0];
            var persona_id  = $(el).val().split('|')[1];
            areasSelect.push({'area_id':area_id,'persona_id':persona_id,'tipo':1});
        });
    }

    if($("#slct_copia").val() != ''){
        $('#slct_copia  option:selected').each(function(index,el) {
            var area_id = $(el).val().split('|')[0];
            var persona_id  = $(el).val().split('|')[1];
            areasSelect.push({'area_id':area_id,'persona_id':persona_id,'tipo':2});
        });
    }
    return areasSelect;
}

copias = function(){
    $(".copias").removeClass('hidden');
}
function addZeros (n, length)
{
    var str = (n > 0 ? n : -n) + "";
    var zeros = "";
    for (var i = length - str.length; i > 0; i--)
        zeros += "0";
    zeros += str;
    return n >= 0 ? zeros : "-" + zeros;
}
eventoSlctGlobalSimple=function(){
}
</script>