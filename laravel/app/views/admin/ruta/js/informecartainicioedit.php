<script type="text/javascript">
    var PosCarta=[];
    PosCarta[0]=0;PosCarta[1]=0;PosCarta[2]=0;
    var recursos=[],
        recursosid=[],
        recursostype=[],
        recursoscopy=[],
        recursosstado=[];

    recursos.push("Seleccione Tipo Recurso");   recursosid.push("rec_tre");     recursostype.push("slct");      recursoscopy.push("slct_tipo_recurso_id");  recursosstado.push("disabled");
    recursos.push("Ingrese Descripcion");       recursosid.push("rec_des");     recursostype.push("txt");                                                   recursosstado.push("disabled");
    recursos.push("Ingrese Cantidad");          recursosid.push("rec_can");     recursostype.push("txt");                                                   recursosstado.push("disabled");
    recursos.push("Ingrese cuanto Sobró");      recursosid.push("inf_sob");     recursostype.push("txt");                                               recursosstado.push("");
//    recursos.push("Ingrese cuanto Sobró");          recursosid.push("rec_id");     recursostype.push("txt");                                               recursosstado.push("");

    var metricos=[],
        metricosid=[],
        metricostype=[],
        metricoscopy=[],
        metricosestado=[];

    metricos.push("Ingrese Métrico");           metricosid.push("met_met");     metricostype.push("txt");  metricosestado.push("disabled");
    metricos.push("Ingrese Actual");            metricosid.push("met_act");     metricostype.push("txt");metricosestado.push("disabled");
    metricos.push("Ingrese Objetivo");          metricosid.push("met_obj");     metricostype.push("txt");metricosestado.push("disabled");
    metricos.push("Ingrese Comentario");        metricosid.push("met_com");     metricostype.push("txt");metricosestado.push("disabled");
    metricos.push("Ingrese cuanto alcanzo");    metricosid.push("inf_alc");     metricostype.push("txt"); metricosestado.push("");


    var desgloses=[], desglosesid=[], desglosestype=[], desglosescopy=[], desgloseestado = [];
    desgloses.push("Seleccione Tipo Actividad");desglosesid.push("des_tac");    desglosestype.push("slct");     desglosescopy.push("slct_tipo_actividad_id");   desgloseestado.push("disabled");
    desgloses.push("Ingrese Actividad");        desglosesid.push("des_act");    desglosestype.push("txt");      desglosescopy.push("");                         desgloseestado.push("disabled");
    desgloses.push("Seleccione Responsable");   desglosesid.push("des_res");    desglosestype.push("slct");     desglosescopy.push("slct_persona_id");          desgloseestado.push("disabled");
    desgloses.push("Ingrese Recursos");         desglosesid.push("des_rec");    desglosestype.push("txt");desgloseestado.push("disabled");
    desgloses.push("Seleccione Fecha Inicio");  desglosesid.push("des_fin");    desglosestype.push("txt");desgloseestado.push("disabled");
    desgloses.push("Seleccione Fecha Fin");     desglosesid.push("des_ffi");    desglosestype.push("txt");desgloseestado.push("disabled");
    desgloses.push("Seleccione Hora Inicio");   desglosesid.push("des_hin");    desglosestype.push("txt");desgloseestado.push("disabled");
    desgloses.push("Seleccione Hora Fin");      desglosesid.push("des_hfi");    desglosestype.push("txt");desgloseestado.push("disabled");
    desgloses.push("Seleccione responsable");   desglosesid.push("inf_res");    desglosestype.push("txt");desgloseestado.push("");
    desgloses.push("Seleccione recuerso");      desglosesid.push("inf_rec");    desglosestype.push("txt");desgloseestado.push("");
    var AreaIdG='';
    $(document).ready(function() {
        AreaIdG='';
        AreaIdG='<?php echo Auth::user()->area_id; ?>';
        ValidaAreaRol();
        // OBJETO EN CARTAINICIO_AJAX
    });

    ValidaAreaRol=function(){
        if(AreaIdG!='' && AreaIdG*1>0){
            var data={area_id:AreaIdG};
            Carta.CargarCartas(HTMLCargarCartas,data);
            $("#btn_nuevo").click(Nuevo);
            $("#btn_close").click(Close);
            $("#btn_guardar").click(Guardar);

            var ids=[];
            var data={estado:1};
            slctGlobal.listarSlct('tiporecurso','slct_tipo_recurso_id','simple',ids,data);
            slctGlobal.listarSlct('tipoactividad','slct_tipo_actividad_id','simple',ids,data);
            data={estado_persona:1};
            slctGlobal.listarSlct('persona','slct_persona_id','simple',ids,data);
        }
        else{
            alert('.::No cuenta con area asignada::.');
        }
    }

    HTMLCargarDetalleCartas=function(datos){
        Nuevo();
        var html="";
        var rec=[];var met=[]; var des=[];

        $("#form_carta #txt_carta_id").remove();
        $.each(datos,function(index,data){
            $("#form_carta").append("<input type='hidden' name='txt_carta_id' id='txt_carta_id' value='"+data.id+"'>");
            $("#txt_nro_carta").val(data.nro_carta);
            $("#txt_objetivo").val(data.objetivo);
            $("#txt_entregable").val(data.entregable);
            $("#txt_alcance").val(data.alcance);

            $("#txt_objetivo_inf").val(data.informe_objetivo);
            $("#txt_entregable_inf").val(data.informe_entregable);
            $("#txt_alcance_inf").val(data.informe_alcance);

            if( data.recursos!=null && data.recursos.split("|").length>1 ){
                rec=data.recursos.split("*");
                for( i=0; i<rec.length; i++ ){
                    AddTr("btn_recursos_0",rec[i]);
                }
            }

            if( data.metricos!=null && data.metricos.split("|").length>1 ){
                met=data.metricos.split("*");
                for( i=0; i<met.length; i++ ){
                    AddTr("btn_metricos_1",met[i]);
                }
            }

            if( data.desgloses!=null && data.desgloses.split("|").length>1 ){
                des=data.desgloses.split("*");
                for( i=0; i<des.length; i++ ){
                    AddTr("btn_desgloses_2",des[i]);
                }
            }

        });

        $("input[name^='txt_inf_res'").keydown(function(e){
            if(e.which >57 || e.which < 48) {
                if(e.which != 8 && e.which != 9) {
                    e.preventDefault();
                    return;
                }

            }
        })

        $("input[name^='txt_inf_rec'").keydown(function(e){
            if(e.which >57 || e.which < 48) {
                if(e.which != 8 && e.which != 9 ) {
                    e.preventDefault();
                    return;
                }

            }
        })

        $("input[name^='txt_inf_res'").keyup(function(e){
            if(e.which >57 || e.which < 48) {
                e.preventDefault();
                return;

            }
            if($(this).val() > 20){
                $(this).val(20);
            }
        })

        $("input[name^='txt_inf_rec'").keyup(function(e){
            if(e.which >57 || e.which < 48) {
                e.preventDefault();
            }
            if($(this).val() > 5){
                $(this).val(5);
            }
        })



    }

    CargarRegistro=function(id){
        Limpiar();
        var datos={carta_id:id};
        Carta.CargarDetalleCartas(HTMLCargarDetalleCartas,datos);
    }

    Validacion=function(){
        var r=true;
        $("#cartainicio .form-control.col-sm-12").each(function(){
            if( $(this).val()=='' && r==true ){
                alert( $(this).attr("data-text") );
                $(this).focus();
                r=false;
            }
        });
        return r;
    }

    Limpiar=function(){
        $("#form_carta input[type='text'],#form_carta textarea,#form_carta select").val("");
        $("#t_recursos tbody,#t_metricos tbody,#t_desgloses tbody").html("");
        Close();
    }

    Guardar=function(){
        var datos=$("#form_carta").serialize().split("txt_").join("").split("slct_").join("");
        if( Validacion() ){
            Carta.GuardarCartas(Limpiar,datos);
        }
    }

    AddTr=function(id,value){
        var idf=id.split("_")[1];
        var pos=id.split("_")[2];
        PosCarta[pos]++;
        var datatext=""; var dataid=""; var val=""; var datastatus = '';
        var clase="";
        var ctype=""; var ccopy=""; var vcopy=[];

        var add="<tr id='tr_"+idf+"_"+PosCarta[pos]+"'>";
        add+="<td>";
        add+=$("#t_"+idf+" tbody tr").length+1;
        add+="</td>";

        for (var i = 0; i < ($("#t_"+idf+" thead tr th").length - 1); i++) {

            clase='';
            val='';
            if ( value != 0 && value.split("|")[i] ){
                val=value.split("|")[i].split("0000-00-00").join("0").split("00:00:00").join("0");
            }

            if ( idf=="recursos" ){
                datatext=recursos[i];
                dataid=recursosid[i];
                ctype=recursostype[i];
                ccopy="";
                if( typeof recursoscopy[i] != 'undefined' ){
                    ccopy = recursoscopy[i];
                }
                datastatus = recursosstado[i];
            }
            else if ( idf=="metricos" ){
                datatext=metricos[i];
                dataid=metricosid[i];
                ctype=metricostype[i];
                ccopy="";
                if( typeof metricoscopy[i] != 'undefined' ){
                    ccopy = metricoscopy[i];
                }
                datastatus = metricosestado[i];

            }
            else if ( idf=="desgloses" ){
                datatext=desgloses[i];
                dataid=desglosesid[i];
                ctype=desglosestype[i];
                ccopy="";
                if( typeof desglosescopy[i] != 'undefined' ){
                    ccopy = desglosescopy[i];
                }

                if( i==5 || i==4 ){ //para cargar la fecha
                    clase='fecha';
                }
                datastatus = desgloseestado[i];

            }

            if( ctype=="slct" ){
                add+="<td>";
                add+="<select class='form-control col-sm-12' data-text='"+datatext+"' data-type='slct' id='slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"' name='slct_"+dataid+"[]' "+ datastatus +">";
                add+="</select>";
                add+="</td>";
                
                vcopy.push("slct_"+idf+"_"+PosCarta[pos]+"_"+dataid+"|"+ccopy+"|"+val);
            }
            else{
                add+="<td>";
                add+="<input class='form-control col-sm-12 "+clase+"' type='text' data-text='"+datatext+"' data-type='txt' id='txt_"+idf+"_"+PosCarta[pos]+"_"+dataid+"' name='txt_"+dataid+"[]' value='"+val+"' "+ datastatus +">";
                add+="</td>";
            }

        };
        add+="<td>";
//        add+="<a class='btn btn-sm btn-danger' id='btn_"+idf+"_"+PosCarta[pos]+"' onClick='RemoveTr(this.id);'><i class='fa fa-lg fa-minus'></i></a>";
        add+=' <input type="hidden" data-type="text" id="txt_'+idf+'_'+PosCarta[pos]+'" name="txt_'+idf+'_id[]" value="'+value.split("|")[i]+'"/>';
                add+="</td>";

        add+="</tr>";

        $("#t_"+idf+" tbody").append(add);

        for (var i = 0; i < vcopy.length; i++) {
            $("#"+vcopy[i].split("|")[0]).html( $("#"+vcopy[i].split("|")[1]).html() );
            $("#"+vcopy[i].split("|")[0]).val( vcopy[i].split("|")[2] );

            slctGlobalHtml(vcopy[i].split("|")[0],'simple');
            $(".multiselect").css("font-size","11px").css("text-transform","lowercase");
            $(".multiselect-container>li").css("font-size","12px").css("text-transform","lowercase");
        };

        $('.fecha').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            showDropdowns: true
        });
    }

    RemoveTr=function(id){
        var idf=id.split("_")[1];
        var pos=id.split("_")[2];
        var i=0;

        $("#tr_"+idf+"_"+pos).remove();

        $("#t_"+idf+" tbody tr").each(function(){
            i++;
            $(this).find("td:eq(0)").html(i);
        });
    }

    Nuevo=function(){
        $("#cartainicio").css("display","");
        $("#txt_nro_carta").focus();
    }

    Close=function(){
        $("#cartainicio").css("display","none");
    }

    HTMLCargarCartas=function(datos){
        var html="";
        $('#t_carta').dataTable().fnDestroy();

        $.each(datos,function(index,data){
            html+="<tr>"+
            "<td >"+data.nro_carta+"</td>"+
            "<td >"+data.objetivo+"</td>"+
            "<td >"+data.entregable+"</td>"+
            "<td> " +
            "<a class='btn btn-primary btn-sm' onClick='CargarRegistro("+data.id+")'><i class='fa fa-edit fa-lg'></i></a>" +
            "    <a class='btn btn-primary btn-sm' href='carta/informecartainiciopdf?vista=1&carta_id="+data.id+"' >PDF</i></a>" +

            "</td>";
            html+="</tr>";
        });
        $("#tb_carta").html(html);
        $('#t_carta').dataTable();
    }
</script>
