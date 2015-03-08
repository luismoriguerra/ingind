<script type="text/javascript">
temporalBandeja=0;
$(document).ready(function() {
    $("#form_Personalizado").attr("onkeyup","return enterGlobal(event,'btn_personalizado')");
    $("#form_General").attr("onkeyup","return enterGlobal(event,'btn_general')");
	$("[data-toggle='offcanvas']").click();
    $("#slct_tipo").change(ValidaTipo);
    $("#btn_personalizado").click(personalizado);
    $("#btn_general").click(general);
    $('#fecha_agenda').daterangepicker(
    {
        format: 'YYYY-MM-DD'
    });
    // Con BD
    //  controlador,slct,tipo,usuarioV,afectado,afectados,slct_id
    var ids = []; //para seleccionar un id
    var data = {usuario: 1};
    slctGlobal.listarSlct('actividad','slct_actividad','multiple');
    slctGlobal.listarSlct('estado','slct_estado','multiple');
    slctGlobal.listarSlct('quiebre','slct_quiebre','multiple',ids,data);
    slctGlobal.listarSlct('empresa','slct_empresa','multiple',ids,data,0,'#slct_celula,#slct_tecnico','E');
    slctGlobal.listarSlct('celula','slct_celula','multiple',ids,0,1,'#slct_tecnico','C');
    slctGlobal.listarSlct('tecnico','slct_tecnico','multiple',ids,0,1);
    // Sin BD
    // Solo ingresar los ids, el primer registro es sin #.
    slctGlobalHtml('slct_tipo,#slct_legado,#slct_coordinado','simple');
    slctGlobalHtml('slct_transmision,#slct_cierre_estado','multiple');
    
});

personalizado=function(){
    if( $("#slct_tipo").val()=='' ){
        alert("Seleccione Tipo Filtro");
        $("#slct_tipo").focus();
    }
	else if( $("#txt_buscar").val()=='' ){
        alert("Ingrese datos");
        $("#txt_buscar").focus();
    }
    else{
		Bandeja.CargarBandeja("P",HTMLCargarBandeja);
	}
}

general=function(){
	Bandeja.CargarBandeja("G",HTMLCargarBandeja);
}

ValidaTipo=function(){
	$("#txt_buscar").val("");
	$("#txt_buscar").focus();
}

HTMLCargarBandeja=function(datos){
var html="";
     $('#t_bandeja').dataTable().fnDestroy();

	$.each(datos,function(index,data){
        if(data.id==''){
            temporalBandeja++;
            data.id="T_"+temporalBandeja;
        }
        else{
            data.id="ID_"+data.id;
        }
    
    html+="<tr>"+
        "<td>"+data.id+"</td>"+
        "<td>"+data.codactu+"</td>"+
        "<td>"+data.fecha_registro+"</td>"+
        "<td>"+data.actividad+"</td>"+
        "<td>"+data.quiebre+"</td>"+
        "<td>"+data.empresa+"</td>"+
        "<td>"+data.fecha_agenda+"</td>"+
        "<td>"+data.tecnico+"</td>"+
        "<td>"+data.estado+"</td>"+
        '<td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bandejaModal" data-codactu="'+data.codactu+'"><i class="fa fa-edit fa-lg"></i> </a>'+
        '</td>';
    html+="</tr>";

	});
	$("#tb_bandeja").html(html); 
    activarTabla();   
}

activarTabla=function(){
	$("#t_bandeja").dataTable(); // inicializo el datatable    
}

validaBandeja=function(){
	$('#form_roles [data-toggle="tooltip"]').css("display","none");
	var a=new Array();
	a[0]=valida("txt","descripcion","");
	var rpta=true;

	for(i=0;i<a.length;i++){
		if(a[i]==false){
			rpta=false;
			break;
		}
	}
	return rpta;
}

valida=function(inicial,id,v_default){
	var texto="Seleccione";
	if(inicial=="txt"){
		texto="Ingrese"
	}

	if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
		$('#error_'+id).attr('data-original-title',texto+' '+id);
		$('#error_'+id).css('display','');
		return false;
	}	
}
</script>
