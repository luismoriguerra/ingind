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
        {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.min.js') }}
        {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.2/vue-resource.min.js') }}
    </head>

    <body id="registerUser" bgcolor="#FFF">
        <div id="mainWrap">
            <div id="loggit">
                <h1><i class="fa fa-lock"></i> MUN.INDEP. </h1>
                <h3 id="mensaje_msj"  class="label-success">
                <?= Session::get('msj'); ?>
                </h3>
                <h3 v-if="mensaje_ok" class="label-success">
                    @{{ mensaje_ok }}
                </h3>
                <h3 id="mensaje_error" class="label-danger">
                    <ul>
                      <li v-for="error in errores">
                        @{{ error }}
                      </li>
                    </ul>
                </h3>

                <h3 id="mensaje_inicio">Por Favor <strong>Logeate</strong></h3>
                <form v-on:submit.prevent='RegisterUser(this)' autocomplete="off" id="registerForm">
                    <h2 class="form-signup-heading">Please Register</h2>
                    <input class="form-control input-lg" v-model='user.paterno' required placeholder="Paterno" type="text">
                    <input class="form-control input-lg" v-model='user.materno' required placeholder="Materno" type="text">
                    <input class="form-control input-lg" v-model='user.nombre' required placeholder="Nombre" type="text">
                    <input class="form-control input-lg" v-model='user.dni' required placeholder="Dni" type="text">
                    <input class="form-control input-lg" v-model='user.email' required placeholder="email"  type="email">
                    <input class="form-control input-lg" v-model='user.direccion' required placeholder="direccion"  type="direccion">
                    <input class="form-control input-lg" v-model='user.telefono' required placeholder="telefono"  type="telefono">
                    <input class="form-control input-lg" v-model='user.celular' required placeholder="celular"  type="celular">
                    <input class="form-control input-lg" v-model='user.password' required placeholder="Password" type="password" autocomplete="off" >
                    <input class="form-control input-lg" v-model='user.password_confirmation' required placeholder="Confirm Password" type="password" autocomplete="off" >

                    {{ Form::submit('Register', array('class' => 'btn btn-primary btn-lg')) }}
                </form>
                <a href="{{ url('/') }}" class="text-center">Ya tengo un usuario</a>
            </div>
        </div>
    </body>

<script>
    var vm = new Vue({
        http: {
            root: '/login',
            headers: {
                'csrftoken': document.querySelector('#token').getAttribute('value')
            }
        },
        el: '#registerUser',
        data: {
            mensaje_ok:false,
            mensaje_error:false,
            user:{
                paterno:'',
                materno:'',
                nombre:'',
                usuario:'',
                dni:'',
                email:'',
                direccion:'',
                telefono:'',
                celular:'',
                password:'',
                password_confirmation:'',
            },
            errores:[],
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
            RegisterUser: function() {
                this.user.usuario=this.user.dni;
                this.$http.post("create",this.user,function(data) {
                    $(".load").hide();
                    
                    if(data.rst==1){
                        this.mensaje_ok=data.msj;
                        this.user= {
                            paterno:'',
                            materno:'',
                            nombre:'',
                            usuario:'',
                            dni:'',
                            email:'',
                            direccion:'',
                            telefono:'',
                            celular:'',
                            password:'',
                            password_confirmation:'',
                        };
                    }
                    else if(data.rst==1){
                        this.errores=data.msj;
                        this.mensaje_error = data.error
                    }
                    else if(data.rst==2){

                        this.errores=data.msj;
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