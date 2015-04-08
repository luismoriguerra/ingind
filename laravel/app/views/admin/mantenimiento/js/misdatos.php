<script type="text/javascript">
$(document).ready(function() {	
	$("#btn_guardar").click(Editar);   
	$("#slct_sexo").val("<?= Auth::user()->sexo; ?>");
});

Editar=function(){
	if(validaUsuario()){
		Usuario.MisDatos();
	}
}

validaUsuario=function(){
	$('#form_misdatos [data-toggle="tooltip"]').css("display","none");
	var a=new Array();
	
	a[0]=valida("txt","password","<?php echo trans('greetings.ingrese_contraseña'); ?>","");

	var rpta=true;

	for(i=0;i<a.length;i++){
		if(a[i]==false){
			rpta=false;
			break;
		}
	}

	if( $.trim($("#txt_newpassword").val())!=$.trim($("#txt_confirm_new_password").val()) ){
		$('#error_newpassword').attr('data-original-title','<?php echo trans("greetings.mensaje_no_coinciden"); ?>');
		$('#error_newpassword').css('display','');
		$("#txt_newpassword").focus();
		rpta=false;
	}
	return rpta;
}

valida=function(inicial,id,text_id,v_default){
	var texto="<?php echo trans('greetings.mensaje_seleccione'); ?>";
	if(inicial=="txt"){
		texto="<?php echo trans('greetings.mensaje_ingrese'); ?>"
	}

	if( $.trim($("#"+inicial+"_"+id).val())==v_default ){
		$('#error_'+id).attr('data-original-title',texto+' '+text_id);
		$('#error_'+id).css('display','');
		$("#"+inicial+"_"+id).focus();
		return false;
	}	
}
</script>