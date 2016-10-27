var clickbtn="btnIniciar";
$(document).ready(function() {	
	$('.formNotice span').click(function() {
		$("body").attr("onkeyup","return validaEnter(event,'"+clickbtn+"')");
	});

	$("#btnIniciar").click(IniciarSession);
	$("#btnRegister").click(function(event) {
  	    event.preventDefault();
  	    Register()
  	});
	$("#btnSend").click(function(event) {
  	    event.preventDefault();
  	    EnviarEmail()
  	});
	$("#btnReset").click(function(event){
  	    event.preventDefault();
  	    ResetPass()
  	});
	$("#mensaje_msj").fadeOut(3500);
});

validaEnter=function(e,id){
	tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==13){
    	$("#"+id).click();	
    }	    
};

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
};
Register=function(){
	if($.trim($("#usuario_register").val())==''){
		MostrarMensaje("Ingrese su <strong>Usuario</strong>");
	}
	else if($.trim($("#password_register").val())==''){
		MostrarMensaje("Ingrese su <strong>Password</strong>");
	}
	else if($.trim($("#password_confirmation_register").val())==''){
		MostrarMensaje("Ingrese su <strong>Password</strong>");
	}
	else{
		Login.Register();	
	}
};
EnviarEmail=function(){
	if($.trim($("#email").val())==''){
		MostrarMensaje("Ingrese su <strong>Email</strong>");
	}
	else{
		Login.EnviarEmail();	
	}
};
ResetPass=function(){
	if($.trim($("#password").val())==''){
		MostrarMensaje("Ingrese su <strong>Password</strong>");
	}
	else if($.trim($("#password_confirmation").val())==''){
		MostrarMensaje("Ingrese su <strong>Password confirmation</strong>");
	}
	else{
		Login.ResetPass();	
	}
};
MostrarMensaje=function(msj, status){
	if (status=='ok') {
		$mensaje =$("#mensaje_ok");
	} else {
		$mensaje =$("#mensaje_error");
	}
	$mensaje.html(msj);

    $("#mensaje_inicio").fadeOut(1000, function()
    {
		$mensaje.fadeIn(1500,function()
		{
	    	$mensaje.fadeOut(6000,function()
	    	{
	    		$("#mensaje_inicio").fadeIn(1000);
	    		$mensaje.attr("class","label-danger");
	    	});
    	});
	}); 
};
