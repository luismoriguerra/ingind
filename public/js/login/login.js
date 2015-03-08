var clickbtn="btnIniciar";
$(document).ready(function() {	
	$('.formNotice span').click(function() {
		$("body").attr("onkeyup","return validaEnter(event,'"+clickbtn+"')");
	});

	$("#btnIniciar").click(IniciarSession);
	$("#mensaje_msj").fadeOut(3500);
});

validaEnter=function(e,id){
	tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==13){
    	$("#"+id).click();	
    }	    
}

IniciarSession=function(){
	if($.trim($("#usuario").val())==''){
		MostrarMensaje("Ingrese su <strong>Usuario</strong>");
	}
	else if($.trim($("#password").val())==''){
		MostrarMensaje("Ingrese su <strong>Password</strong>");
	}
	else{
		Login.IniciarLogin();	
	}
}

MostrarMensaje=function(msj){

	$("#mensaje_error").html(msj);

    $("#mensaje_inicio").fadeOut(1500, function()
    {
		$("#mensaje_error").fadeIn(1500,function()
		{
	    	$("#mensaje_error").fadeOut(6000,function()
	    	{
	    		$("#mensaje_inicio").fadeIn(1500);
	    		$("#mensaje_error").attr("class","label-danger");
	    	});	    	
    	});
	}); 
}