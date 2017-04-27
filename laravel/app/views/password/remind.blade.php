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
        <meta name="token" id="token" value="{{ csrf_token() }}">
        {{ HTML::style('lib/font-awesome-4.2.0/css/font-awesome.min.css') }}
        {{ HTML::style('lib/bootstrap-3.3.1/css/bootstrap.min.css') }}
        {{ HTML::script('lib/jquery-2.1.3.min.js') }}
        {{ HTML::script('lib/jquery-ui-1.11.2/jquery-ui.min.js') }}
        {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
        {{ HTML::style('css/login/login.css') }}
        {{ HTML::script('lib/cloudflare/cloudflare-vue-1.0.24.js') }}
        {{ HTML::script('lib/cloudflare/cloudflare-vue-0.7.2.js') }}

        <style type="text/css">
            .titulo {
                font-size: 24px;
                color: #fff;
                letter-spacing: -1.2px;
                text-align: center;
                margin-bottom: 25px;
            }
        </style>
    </head>

    <body id="sendEmail" bgcolor="#FFF">
        <div id="mainWrap">
            <div id="loggit">
                <h2 class="titulo">{{-- <i class="fa fa-lock"></i>  --}}MUN. INDEPENDENCIA </h2>
                
                <h3 v-if="mensaje_ok" id="mensaje_ok" class="label-success">
                    @{{ mensaje_ok }}
                </h3>
                <h3 v-if="mensaje_error" id="mensaje_error" class="label-danger">
                    @{{ mensaje_error }}
                </h3>

                <h3 id="mensaje_inicio">Por Favor <strong>Ingresa su email</strong></h3>
                <form v-on:submit.prevent='sendMessage(this)' style="text-align: center">
                    <input v-model="email" @keyup.prevent="handleKeypress" class="form-control input-md"  required placeholder="email" name="email" id="email" type="email">
                    <br>
                    {{ Form::submit('Enviar', array('class' => 'btn btn-primary btn-md')) }}
                </form>
                <br>
                <a href="{{ url('/') }}" class="text-center">Ya tengo un usuario</a>
        </div>
    </div>
</body>

<script>
    var vm = new Vue({
        http: {
            root: '/password',
            headers: {
                'csrftoken': document.querySelector('#token').getAttribute('value')
            }
        },
        el: '#sendEmail',
        data: {
            mensaje_ok:false,
            mensaje_error:false,
        },
        ready: function () {

        },
        methods: {
            handleKeypress: function(event) {
                if (event.keyCode == 13 && event.shiftKey) {
                } else if (event.keyCode == 13){
                    return;
                }
            },
            sendMessage: function() {
                data={email:this.email};
                this.$http.post("remind",data,function(data) {
                    $(".load").hide();
                    if (data.status) {
                        this.mensaje_ok= data.status
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
