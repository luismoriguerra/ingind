<script type="text/javascript">
$(document).ready(function() {

    slctGlobal.listarSlctFuncion('plantilladoc','cargar','slct_plantilla','simple',null,{'area':1});
/*
    slctGlobal.listarSlct('area','slct_areas','multiple',null,{estado:1,areagestion:1});
    slctGlobal.listarSlct('area','slct_copia','multiple',null,{estado:1,areagestion:1});*/

    slctGlobal.listarSlctFuncion('area','areasgerencia','slct_areas','multiple',null,{estado:1,areagestion:1});
    slctGlobal.listarSlctFuncion('area','areasgerencia','slct_copia','multiple',null,{estado:1,areagestion:1});

    slctGlobalHtml('slct_tipoenvio','simple');
    slctGlobal.listarSlct('area','slct_areasp','simple',null,{estado:1,areagestion:1}); 
    HTML_Ckeditor(); 

    $(document).on('change', '#slct_tipoenvio', function(event) {
        event.preventDefault();
        if($(this).val() == 1){ //persona
            $(".araesgerencia").addClass('hidden');
            $(".areaspersona").removeClass('hidden');
        }else{ //gerencia
             $(".araesgerencia").removeClass('hidden');
             $(".areaspersona").addClass('hidden');
             $(".personasarea").addClass('hidden');
        }
    });

    $(document).on('change','#slct_areasp',function(event){
        $('#slct_personaarea').multiselect('destroy');
        slctGlobal.listarSlctFuncion('area','personaarea','slct_personaarea','simple',null,{'area_id':$(this).val()});  
        $(".personasarea").removeClass('hidden');
    });

    $(document).on('change', '#slct_plantilla', function(event) {
        event.preventDefault();
        docdigital.CargarInfo({'id':$(this).val()},HTMLPlantilla);
    });

    $(document).on('click', '#btnCrear', function(event) {
        event.preventDefault();       
        Agregar();
    });


    $('#NuevoDocDigital').on('show.bs.modal', function (event) {
        $("#slct_tipoenvio").multiselect('destroy');
        slctGlobalHtml('slct_tipoenvio','simple');
        var button = $(event.relatedTarget); // captura al boton
	    var text = $.trim( button.data('texto') );
	    var id= $.trim( button.data('id') );
	    $("#formNuevoDocDigital input[name='txt_campos']").remove();
        $("#formNuevoDocDigital").append("<input type='hidden' c_text='"+text+"' c_id='"+id+"' id='txt_campos' name='txt_campos'>");
    });

     $('#listDocDigital').on('show.bs.modal', function (event) {
     	var button = $(event.relatedTarget); // captura al boton
	    var text = $.trim( button.data('texto') );
	    var id= $.trim( button.data('id') );
	    var camposP = {'nombre':text,'id':id};
        docdigital.Cargar(HTMLCargar,camposP);
    });

    function limpia(area) {
        $(area).find('input[type="text"],input[type="hidden"],input[type="email"],textarea,select').val('');
        $("#lblDocumento").text('');
        $("#lblArea").text('');
        CKEDITOR.instances.plantillaWord.setData('');
        $(".araesgerencia,.areaspersona,.personasarea").addClass('hidden');
        $("#slct_copia").val(['']);
        $("#slct_copia").multiselect('refresh');
    };

    $('#NuevoDocDigital').on('hidden.bs.modal', function(){
        limpia(this);
    });
});


/*doc digital */
HTML_Ckeditor=function(){
    CKEDITOR.replace( 'plantillaWord' );
};

HTMLPlantilla = function(data){
    if(data.length > 0){
        var result = data[0];
        var tittle = result.tipodoc + "N-XX-2016" + "/MDI";
        document.querySelector("#lblDocumento").innerHTML= result.tipodoc+"-Nº";
        document.querySelector("#lblArea").innerHTML= "-"+new Date().getFullYear()+"-"+result.nemonico_doc;
        document.querySelector('#txt_area_plantilla').value = result.area_id;
        CKEDITOR.instances.plantillaWord.setData( result.cuerpo );
        docdigital.CargarCorrelativo({'tipo_doc':result.tipo_documento_id},HTMLCargarCorrelativo);
    }
}

HTMLCargar=function(datos,campos){
	var c_text = campos.nombre;
	var c_id = campos.id;

        console.log(datos);
    var html="";
    $('#t_doc_digital').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        
        if($.trim(data.ruta) == 0 && $.trim(data.rutadetallev) == 0){
            html+="<tr class='danger'>";
        }else{
            html+="<tr class='success'>";
        }
      
        html+="<td>"+data.titulo+"</td>";
        html+="<td>"+data.asunto+"</td>";
        html+="<td>"+data.plantilla+"</td>";
        html+="<td><a class='btn btn-success btn-sm' c_text='"+c_text+"' c_id='"+c_id+"'  id='"+data.id+"' title='"+data.titulo+"' onclick='SelectDocDig(this)'><i class='glyphicon glyphicon-ok'></i> </a></td>";
        html+="</tr>";
    });
    $("#tb_doc_digital").html(html);
    $("#t_doc_digital").dataTable();
};

SelectDocDig = function(obj){	
	var id = obj.getAttribute('id');
	var nombre = obj.getAttribute('title');
	$("#"+obj.getAttribute('c_text')).val(nombre);
	$("#"+obj.getAttribute('c_id')).val(id);
	$("#listDocDigital").modal('hide');
}

HTMLCargarCorrelativo=function(obj){
    $(".txttittle").val("");
    var ano= obj.ano;
    var correlativo=obj.correlativo;
    $(".txttittle").val(correlativo);
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

Agregar=function(){
    docdigital.AgregarEditar(AreaSeleccionadas(),0,1);
};
/*end doc digital */
</script>