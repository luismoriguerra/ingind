<script type="text/javascript">
$(document).ready(function() {
    $("#bandejaModal").attr("onkeyup","return enterGlobal(event,'btn_gestion_modal')");
    $("#btn_gestion_modal").click(gestionModal);
    $("#fecha_consolidacion").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});

    slctGlobal.listarSlct('solucion','slct_solucion_modal','simple');
    slctGlobal.listarSlct('feedback','slct_feedback_modal','simple');

    slctGlobalHtml('slct_coordinado_modal,#slct_contacto_modal,#slct_pruebas_modal','simple');

    $('#bandejaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // captura al boton
        var modal = $(this); //captura el modal

        $('#form_bandeja [data-toggle="tooltip"]').css("display","none");
        variables={ buscar:button.data('codactu'),
                    tipo:'gd.averia'
                  };
        
        Bandeja.CargarBandeja('M',verificaDataModal,variables);

    });

    $('#bandejaModal').on('hide.bs.modal', function (event) {
      var modal = $(this); //captura el modal

        $(".L0,.H0,.T0").css("display","none");
        $('#form_bandeja input[type="hidden"]').remove();
        $("#slct_motivo_modal,#slct_submotivo_modal,#slct_estado_modal").val("");
        $("#slct_motivo_modal,#slct_submotivo_modal,#slct_estado_modal").multiselect('refresh');
    });

    $(".L0,.H0,.T0").css("display","none");
});

verificaDataModal=function(obj){
    var datos={estado_id:obj[0].estado_id};
    Bandeja.validaEstado(datos,listarDataModal,obj);
}

listarDataModal=function(objnuev,obj){
    var verifica=objnuev[0].valida;
    if(verifica=="0-0"){
        alert('La averia esta inhabilitada para gestionar');
        $("#btn_close_modal").click();
    }
    else if( $("#slct_empresa option[value='"+obj[0].empresa_id+"']").attr("disabled") ){
        alert('Ud no cuenta con permiso para la Empresa: '+obj[0].empresa);
        $("#btn_close_modal").click();
    }
    else if( $("#slct_quiebre option[value='"+obj[0].quiebre_id+"']").attr("disabled") ){
        alert('Ud no cuenta con permiso para el Quiebre: '+obj[0].quiebre);
        $("#btn_close_modal").click();
    }
    else{
        var data = 0;
        if(verifica=="2-0"){
            data = { requerimiento: '1-0' }; // indica q se inicializa una gestion para un codactu
        }
        else if(verifica=="-1-0"){
            data = { requerimiento: '1-0","1-1',mas:'1' }; // aqui buscara mas de un registro por el indicador mas
        }
        else if(verifica=="1-0"){
            data = { requerimiento: '0-0","1-1","2-0',mas:'1' }; // aqui buscara mas de un registro por el indicador mas
        }
        $('#slct_motivo_modal,#slct_submotivo_modal,#slct_estado_modal').multiselect('destroy');
        var ids = [];
        slctGlobal.listarSlct('motivo','slct_motivo_modal','simple',ids,data,0,'#slct_submotivo_modal,#slct_estado_modal','M');
        slctGlobal.listarSlct('submotivo','slct_submotivo_modal','simple',ids,data,1,'#slct_estado_modal','S','slct_motivo_modal','M');
        slctGlobal.listarSlct('estado','slct_estado_modal','simple',ids,data,1);

        $("#txt_codactu_modal").val(obj[0].codactu);
        $("#txt_estado_modal").val(obj[0].estado);
        $("#txt_empresa_modal").val(obj[0].empresa);

        var data = { empresa_id: obj[0].empresa_id };
        $('#slct_celula_modal,#slct_tecnico_modal').multiselect('destroy');
        var tecnico = []; tecnico.push(obj[0].tecnico_id);
        var celula = []; celula.push(obj[0].celula_id);
        slctGlobal.listarSlct('celula','slct_celula_modal','simple',celula,data,0,'#slct_tecnico_modal','C');
        slctGlobal.listarSlct('tecnico','slct_tecnico_modal','simple',tecnico,data,1);

        // Preparando para la transacción
        $("#form_bandeja").append('<input type="hidden" name="txt_horario_id_modal" id="txt_horario_id_modal" value="">');
        $("#form_bandeja").append('<input type="hidden" id="txt_horario_aux_modal" value="abc">');
        $("#form_bandeja").append('<input type="hidden" name="txt_dia_id_modal" id="txt_dia_id_modal" value="">');
        $("#form_bandeja").append('<input type="hidden" id="txt_dia_aux_modal" value="123">');

        $("#form_bandeja").append('<input type="hidden" name="txt_empresa_id_modal" id="txt_empresa_id_modal" value="'+obj[0].empresa_id+'">');
        $("#form_bandeja").append('<input type="hidden" name="txt_zonal_id_modal" id="txt_zonal_id_modal" value="'+obj[0].zonal_id+'">');

        if(verifica=="-1-0"){
            $("#form_bandeja").append('<input type="hidden" name="txt_quiebre_id_modal" id="txt_quiebre_id_modal" value="'+obj[0].quiebre_id+'">');
            $("#form_bandeja").append('<input type="hidden" name="txt_actividad_id_modal" id="txt_actividad_id_modal" value="'+obj[0].actividad_id+'">');
            $("#form_bandeja").append('<input type="hidden" name="txt_nombre_cliente_critico_modal" id="txt_nombre_cliente_critico_modal" value="'+obj[0].nombre_cliente_critico+'">');
            $("#form_bandeja").append('<input type="hidden" name="txt_celular_cliente_critico_modal" id="txt_celular_cliente_critico_modal" value="'+obj[0].celular_cliente_critico+'">');
            $("#form_bandeja").append('<input type="hidden" name="txt_telefono_cliente_critico_modal" id="txt_telefono_cliente_critico_modal" value="'+obj[0].telefono_cliente_critico+'">');

            $("#form_bandeja").append('<input type="hidden" name="txt_fono1_modal" id="txt_fono1_modal" value="'+obj[0].celular_cliente_critico+'">');
            $("#form_bandeja").append('<input type="hidden" name="txt_telefono_modal" id="txt_telefono_modal" value="'+obj[0].telefono_cliente_critico+'">');
        }

        $('#slct_coordinado_modal').multiselect('select', [ obj[0].coordinado ] );
        $('#slct_coordinado_modal').multiselect('refresh');
    }
}

eventoSlctGlobalSimple=function(slct,valores){ // este evento "eventoSlctGlobalSimple" solo se dará cuando un select tenga como atributo data-evento
    if(slct=="slct_estado_modal"){
        var m=""; var s=""; var val=""; var dval=""
        $(".L0,.H0,.T0").css("display","none");
        M="M"+$("#slct_motivo_modal").val();
        S="S"+$("#slct_submotivo_modal").val();
        val=valores.split("|"+M+S+"-");
            if(val.length>1){
                dval=val[1].substr(0,3);
            }
        
        
        if(dval=='3-0'){ // para mantener a tecnico y horario
            $(".L0").css("display","none");
            $(".T0").css("display","none");
            $(".H0").css("display","none");

            $(".L1").attr("disabled",true);
            $(".T1").removeAttr("disabled");
            $(".H1").attr("disabled",true);

            $("select.L1").multiselect("disable");
            $("select.T1").multiselect("enable");
            $("select.H1").multiselect("disable");

            $("#txt_horario_id_modal").removeAttr('disabled');
            $("#txt_dia_modal").removeAttr('disabled');
            $("#txt_horario_id_modal").val($("#txt_horario_aux_modal").val());
            $("#txt_dia_modal").val($("#txt_dia_aux_modal").val());

        }
        else if(dval=='2-0'){ // para seleccionar tecnico en liquidados y mantener horario
            $(".L0").css("display","");
            $(".T0").css("display","");
            $(".H0").css("display","none");

            $(".L1").removeAttr("disabled");
            $(".T1").removeAttr("disabled");
            $(".H1").attr("disabled",true);

            $("select.L1").multiselect("enable");
            $("select.T1").multiselect("enable");
            $("select.H1").multiselect("disable");

            $("#txt_horario_id_modal").removeAttr('disabled');
            $("#txt_dia_modal").removeAttr('disabled');
            $("#txt_horario_id_modal").val($("#txt_horario_aux_modal").val());
            $("#txt_dia_modal").val($("#txt_dia_aux_modal").val());

        }
        else if(dval=='1-1'){ // para seleccionar tecnico y horario
            $(".L0").css("display","none");
            $(".T0").css("display","");
            $(".H0").css("display","");

            $(".L1").attr("disabled",true);
            $(".T1").removeAttr("disabled");
            $(".H1").removeAttr("disabled");

            $("select.L1").multiselect("disable");
            $("select.T1").multiselect("enable");
            $("select.H1").multiselect("enable");

            $("#txt_horario_id_modal").removeAttr('disabled');
            $("#txt_dia_modal").removeAttr('disabled');
            $("#txt_horario_id_modal").val('');
            $("#txt_dia_modal").val('');

        }
        else if(dval=='1-0'){ // para seleccionar solo tecnico sin guardar horario
            $(".L0").css("display","none");
            $(".T0").css("display","");
            $(".H0").css("display","none");

            $(".L1").attr("disabled",true);
            $(".T1").removeAttr("disabled");
            $(".H1").attr("disabled",true);

            $("select.L1").multiselect("disable");
            $("select.T1").multiselect("enable");
            $("select.H1").multiselect("disable");

            $("#txt_horario_id_modal").attr('disabled',true);
            $("#txt_dia_modal").attr('disabled',true);
        }
    }
    else if(slct=="slct_tecnico_modal"){
        var dval=valores.split("|C"+$("#slct_celula_modal").val()+"-")[1].substr(0,1);
        $("#txt_officetrack").val("No es Officetrack");
        if(dval=='1'){
            $("#txt_officetrack").val("Si es Officetrack");
        }
    }
    
}

gestionModal=function(){
    alert('guardando xd');
}

</script>
