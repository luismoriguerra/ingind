<script type="text/javascript">
$(document).ready(function() {
    
});

htmlListarSlct=function(obj,slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id, funciones){
    var html="";var disabled='';
    if(tipo!="multiple"){
        html+= "<option value=''>.::Seleccione::.</option>";
    }

    if(obj.rst==1){                    
        $.each(obj.datos,function(index,data){
        disabled=''; 
        rel=''; rel2='';rel3='';x='';y='';direccion='';rel4='';
            if(data.block=='disabled'){ // validacion pra visualizacion
                disabled='disabled';
            }

            if( data.relation!='' && data.relation!=null ){
                rel='data-relation="|'+data.relation+'|"';
            }

            if( data.evento!='' && data.evento!=null ){
                rel2=' data-evento="|'+data.evento+'|"';
            }
            else  if ( $("#"+slct).attr('data-evento')=='1' ) { 
                rel2=' data-evento="|1|"';
            }

            if( data.select!='' && data.select!=null ){
                rel3=' data-select="|'+data.select+'|"';
            }
            if (data.coord_x!='' && data.coord_x!=null) {
                x=' data-coord_x="'+data.coord_x+'" ';
            }
            if (data.coord_y!='' && data.coord_y!=null) {
                y=' data-coord_y="'+data.coord_y+'" ';
            }
            if (data.direccion!='' && data.direccion!=null) {
                direccion=' data-direccion="'+data.direccion+'" ';
            }

            /*if send a concat data*/
            if(data.concat !=''&& data.concat !=null){
                rel4 = "("+data.concat+")";
            }
            /*end if  */
            /* */
                        //si se recibe estado
            /*if (data.estado==1 && tipo=='multiple')
                html += "<option selected"+rel+rel2+x+y+direccion+" value=\"" + data.id + "\" "+disabled+">" + data.nombre + "</option>";
            else*/
            
                html += "<option "+rel+rel2+rel3+x+y+direccion+" value=\"" + data.id + "\" "+disabled+">" + data.nombre + rel4 + "</option>";
        }); 
    }      
    $("#"+slct).html(html);
    
    slctGlobalHtml(slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id, funciones);
    
};

slctGlobalHtml=function(slct,tipo,valarray,afectado,afectados,slct_id,slctant,slctant_id, funciones){
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
            var select=$("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-select');
            if(slct_id!='' && slct_id!=null && afectados!='' && afectados!=null){
                filtroSlct(slct,tipo,slct_id,afectados,slctant,slctant_id,select);
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
        },
        onChange: function(option, checked, select) {
            if (funciones!=='' && funciones!==undefined) {
                if (funciones.change!=='' && funciones.change!==undefined) {
                    funciones.change($(option).val(), checked);
                }
            }
        }
    });
    if(valarray!=null && valarray.length>=1){

        if(afectado==1 && afectados!=null && afectados!='' && tipo!='multiple'){  // pre seleccion para simple y limpiar valores
            filtroSlct(afectados.split("|")[0],tipo,afectados.split("|")[2],afectados.split("|")[1],slctant,slctant_id,'',valarray);
        }
        else{
            $('#'+slct).multiselect('select', valarray);
            $('#'+slct).multiselect('refresh');
        }
            if( tipo!="multiple" && $("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-evento') ){
                eventoSlctGlobalSimple(slct,$("#"+slct+">option[value='"+$("#"+slct).val()+"']").attr('data-evento'));
            }
    }
    $("li.multiselect-all").removeAttr("data-select");
};

filtroSlct=function(slct,tipo,slct_id,afectados,slctant,slctant_id,select,valarray){
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
        
        var primerId=0;
        var primerSelect=""; var primerValor="";
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
                    else{
                        if(primerId==0 && tipo!="multiple" && $.trim(select)!='' && detafectados.length==1){
                            primerSelect=detafectados[i];
                            primerValor=$(this).val();
                        }
                        primerId++;
                    }
                }
            });
        }

        if(primerId==1 && primerSelect!='' && tipo!="multiple" && $.trim(select)!='' && detafectados.length==1){ // valida solo cuando tiene una sola opcion
            $(primerSelect+">option[value='"+primerValor+"']").attr("selected","true");
            if( tipo!="multiple" && $(primerSelect+">option[value='"+primerValor+"']").attr('data-evento') ){
                eventoSlctGlobalSimple(primerSelect.substr(1),$(primerSelect+">option[value='"+primerValor+"']").attr('data-evento'));
            }
        }

        if(valarray!=null && valarray.length>=1){
            $(afectados).multiselect('select', valarray);
        }

    }
    else{
        $(detafectados.join(" option, ")+" option").removeAttr('disabled');
    }

    $(afectados).multiselect('refresh');
};

enterGlobal=function(e,etiqueta,selecciona){
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==13){
        e.preventDefault();
        $("#"+etiqueta).click(); 
        if( typeof(selecciona)!='undefined' ){
            $("#"+etiqueta).focus(); 
        }
    }
}
</script>
