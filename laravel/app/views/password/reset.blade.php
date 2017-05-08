<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">       
        <meta name="author" content="Jorge Salcedo (Shevchenko)">
        
        <link rel="shortcut icon" href="assets/ico/favicon.ico">
        <meta name="description" content="">
        <title>
                M. Independencia
        </title>
        {{ HTML::style('lib/font-awesome-4.2.0/css/font-awesome.min.css') }}
        {{ HTML::style('lib/bootstrap-3.3.1/css/bootstrap.min.css') }}
        {{ HTML::script('lib/jquery-2.1.3.min.js') }}
        {{ HTML::script('lib/jquery-ui-1.11.2/jquery-ui.min.js') }}
        {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
        {{ HTML::style('css/login/login.css') }}
        {{ HTML::script('lib/cloudflare/cloudflare-vue-1.0.24.js') }}
        {{ HTML::script('lib/cloudflare/cloudflare-vue-0.7.2.js') }}
    </head>

    <body id="resetPassword" bgcolor="#FFF">
        <div id="mainWrap">
            <div id="loggit">
                <h1><i class="fa fa-lock"></i> MUN.INDEP. </h1>
                
                <h3 v-if="mensaje_ok" id="mensaje_ok" class="label-success">
                    @{{ mensaje_ok }}
                </h3>
                <h3 v-if="mensaje_error" id="mensaje_error" class="label-danger">
                    @{{ mensaje_error }}
                </h3>

                <h3 id="mensaje_inicio">Por Favor <strong>Ingresa su nueva contraseña</strong></h3>

                <form v-on:submit.prevent='ResetPass(this)' autocomplete="off" id="sendReset">
                    <div class="row form-group">
                        <label class="control-label">PASSWORD:</label>
                        <input class="form-control input-lg" @keyup.prevent="handleKeypress" required type="password" v-model='password' id="password" name="password">
                    </div>
                    <div class="row form-group">
                        <label class="control-label">CONFIRMAR PASSWORD:</label>
                        <input class="form-control input-lg" @keyup.prevent="handleKeypress" required type="password" v-model='password_confirmation' id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="row form-group">
                        {{ Form::submit('Restablecer', array('class' => 'btn btn-primary btn-lg')) }}
                    </div>
                </form>
        </div>
    </div>
</body>
<script>
    var vm = new Vue({
        http: {
            root: '/password'
        },
        el: '#resetPassword',
        data: {
            mensaje_ok:false,
            mensaje_error:false,
        },
        ready: function () {
            this.email="{{ $email }}";
            this.token="{{ $token }}";
        },
        methods: {
            handleKeypress: function(event) {
                if (event.keyCode == 13 && event.shiftKey) {
                } else if (event.keyCode == 13){
                    return;
                }
            },
            ResetPass: function() {
                data={
                    email:this.email, 
                    password:this.password ,
                    password_confirmation:this.password_confirmation,
                    token:this.token
                };
                this.$http.post("reset",data,function(data) {
                    $(".load").hide();
                    if (data.rst==1) {
                        alert("Se restauro su password con exito");
                        window.location='/';
                    }
                    if (data.error) {
                        this.mensaje_error = data.error
                    }
                    this.handle = setInterval( ( ) => {
                        this.mensaje_ok=false;
                        this.mensaje_error=false;
                    },5000);
                });
            },
        }
    });
</script>
