<script type="text/javascript">
$(document).ready(function() {
    
});

htmlListarSlct=function(obj,slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id){
    var html="";var disabled='';
    if(tipo!="multiple"){
        html+= "<option value=''>.::Seleccione::.</option>";
    }

    if(obj.rst==1){                    
        $.each(obj.datos,function(index,data){
        disabled=''; 
        rel=''; rel2='';
            if(data.block=='disabled'){ // validacion pra visualizacion
                disabled='disabled';
            }

            if( data.relation!='' && data.relation!=null ){
                rel='data-relation="|'+data.relation+'|"';
            }

            if( data.evento!='' && data.evento!=null ){
                rel2=' data-evento="|'+data.evento+'|"';
            }

            //si se recibe estado
            if (data.select==1)// aqui enviar el selct = estado para pre seleccionar
                html += "<option selected"+rel+rel2+" value=\"" + data.id + "\" "+disabled+">" + data.nombre + "</option>";
            else
                html += "<option "+rel+rel2+" value=\"" + data.id + "\" "+disabled+">" + data.nombre + "</option>";
        }); 
        
        if(slct=='slct_estado'){
            html += "<option value=\"-1\">Temporal</option>";
        }
    }      
    $("#"+slct).html(html);
    
    slctGlobalHtml(slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id);
    
}

slctGlobalHtml=function(slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id){
    $("#"+slct).multiselect({
        maxHeight: 200,             // max altura...
        enableCaseInsensitiveFiltering: true, // Insensitive
        buttonContainer: '<div class="btn-group col-xxs-12" />', // actualiza la clase del grupo
        buttonClass: 'btn btn-primary col-xxs-12', // clase boton
        templates: {
            ul: '<ul data-select="'+slct+'" class="multiselect-container dropdown-menu col-xxs-12"></ul>',
            li: '<li ><a tabindex="0"><label></label></a></li>'
        },
        includeSelectAllOption: true, //opcion para seleccionar todo
        enableFiltering: true,    // activa filtro
        onDropdownShow: function() {
            if(afectado==1 && afectado!=null){
                $("[data-select='"+slct+"'] li").css('display','');
                $("[data-select='"+slct+"'] li.disabled").css('display','none');
            }
        },
        onDropdownHidden:function(){
            if(slct_id!='' && slct_id!=null && afectados!='' && afectados!=null){
                filtroSlct(slct,tipo,slct_id,afectados,slctant,slctant_id);
            }

            if( tipo!="multiple" && $("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-evento') ){
                eventoSlctGlobalSimple(slct,$("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-evento'));
            }
        },
        buttonText: function(options, select) { // para multiselect indicar vacio...
            if(tipo=="multiple"){
                if (options.length === 0) {
                    return '.::Todo::.';
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
            else{
                return $(options).html();
            }
        }
    });
    if(valarray!=null && valarray.length>=1){
        $('#'+slct).multiselect('select', valarray);
        //$('#'+slct).multiselect('deselectAll', false);
        $('#'+slct).multiselect('refresh');
            if( tipo!="multiple" && $("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-evento') ){
                eventoSlctGlobalSimple(slct,$("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-evento'));
            }
    }
    
    $("li.multiselect-all").removeAttr("data-select");
}

filtroSlct=function(slct,tipo,slct_id,afectados,slctant,slctant_id){
    detafectados=afectados.split(",");
    $(afectados).multiselect('deselectAll', false);
    $(afectados).multiselect('updateButtonText');
    valores='||';
    valores2='';
    if( $("#"+slct).val()!=null ){
        if(tipo=="multiple"){
            if(slctant!=null && slctant!=''){
                valores2='|'+slctant_id+$("#"+slctant).val().join('|'+slctant_id)+'|';
            }
            valores='|'+slct_id+$("#"+slct).val().join('|'+slct_id)+'|';
        }
        else{
            if(slctant!=null && slctant!=''){
                valores2='|'+slctant_id+$("#"+slctant).val()+'|';
            }
            valores='|'+slct_id+$("#"+slct).val()+'|';
        }
        

        for(i=0;i<detafectados.length;i++){
            $('option', $(detafectados[i])).each(function(element) {
                $(this).removeAttr('disabled');
                val=$(this).attr('data-relation');
                if(val!='' && val!=null){
                detval=val.split(",");
                valida=0;
                    for(j=0;j<detval.length;j++){
                        if( valores.split(detval[j]).length>1 ){
                            valida++;
                            break;
                        }
                    }

                    if(valores2!='' && valida>0){
                        valida=0;
                        for(j=0;j<detval.length;j++){
                            if( valores2.split(detval[j]).length>1 ){
                                valida++;
                                break;
                            }
                        }

                    }

                    if(valida==0){
                        $(this).attr('disabled','true');
                    }
                }
            });
        }

    }
    else{
        $(detafectados.join(" option, ")+" option").removeAttr('disabled');
    }

    $(afectados).multiselect('refresh');
}

enterGlobal=function(e,etiqueta,selecciona){
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==13){
        $("#"+etiqueta).click(); 
        if( typeof(selecciona)!='undefined' ){
            $("#"+etiqueta).focus(); 
        }
    }
}
</script>
