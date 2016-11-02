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
        {{ HTML::script('http://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.js') }}
        {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
        {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
        {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
        {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
        {{ HTML::style('css/login/login.css') }}
        {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.min.js') }}
        {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.2/vue-resource.min.js') }}
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body id="registerUser" bgcolor="#FFF">
        <div id="mainWrap">
            <div id="register">
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

                <h3 id="mensaje_inicio">Por Favor <strong>registrese</strong></h3>


                <form v-on:submit.prevent='RegisterUser(this)' autocomplete="off" id="registerForm">
                    <fieldset>
                        <legend style="color:#e5e5e5">Datos personales</legend>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">NOMBRE:</label>
                                    <input type="text" name='nombre' v-model='user.nombre' class="form-control pull-right" placeholder="Nombre:" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">SEXO:</label>
                                    <select name='sexo' class="form-control  pull-right" placeholder="Seleccione" autocomplete="off">
                                        <option value="">.:: Seleccione genero ::.</option>
                                        <option value="0">MASCULINO</option>
                                        <option value="1">FEMENINO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">APELLIDO PATERNO:</label>
                                    <input type="text" name='paterno' v-model='user.paterno' class="form-control  pull-right" placeholder="APELLIDO PATERNO" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="control-group"  style="color:#e5e5e5">
                                    <label class="control-label">FECHA NACIMIENTO:</label>
                                    <input type="text" id='fecha_nacimiento' name='fecha_nacimiento' v-model='user.fecha_nacimiento' class="form-control  pull-right" placeholder="AAAA-MM-DD" onfocus="blur()" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">APELLIDO MATERNO:</label>
                                    <input type="text" name='materno' v-model='user.materno' class="form-control  pull-right" placeholder="APELLIDO MATERNO" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">DNI:</label>
                                    <input type="text" name='dni' v-model='user.dni' class="form-control  pull-right" placeholder="DNI" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">EMAIL:</label>
                                    <input type="email" name='email' v-model='user.email' class="form-control  pull-right" placeholder="EMAIL" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">PASSWORD:</label>
                                    <input type="password" name='password' v-model='user.password' class="form-control  pull-right" placeholder="PASSWORD" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">CONFIRMAR PASSWORD:</label>
                                    <input type="password" name='password_confirmation' v-model='user.password_confirmation' class="form-control  pull-right" placeholder="CONFIRMAR PASSWORD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">DIRECCION:</label>
                                    <input type="direccion" name='direccion' v-model='user.direccion' class="form-control  pull-right" placeholder="DIRECCION" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">TELEFONO:</label>
                                    <input type="telefono" name='telefono' v-model='user.telefono' class="form-control  pull-right" placeholder="TELEFONO" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">CELULAR:</label>
                                    <input type="celular" name='celular' v-model='user.celular' class="form-control  pull-right" placeholder="CELULAR" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="g-recaptcha" name='recaptcha' data-sitekey="{{Config::get('recaptcha.site')}}"></div>

                            </div>
                        </div>


                        <div class="row form-group form-inline formSubmit">
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name='terminos' autocomplete="off"> Acepto los terminos &amp; condiciones
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-5 submitWrap">
                                {{ Form::submit('Registrar', array('class' => 'btn btn-primary btn-lg')) }}
                            </div>
                        </div>
                        

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
                recaptcha:'',
            },
            newUser:{
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
                recaptcha:'',
            },

            errores:[],
        },
        ready: function () {
            $('#fecha_nacimiento').daterangepicker({
                format: 'YYYY-MM-DD',
                singleDatePicker: true,
                showDropdowns: true
            });
            jQuery.validator.addMethod("soloLetra", function(value, element) {
                return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
            }, "Solo letras");

            $('#registerForm').validate( {
                rules: {
                    nombre: {
                        minlength: 2,
                        maxlength: 80,
                        required: true,
                        soloLetra: true,
                    },
                    sexo: {
                        required: true 
                    },
                    paterno: {
                        minlength: 2,
                        maxlength: 80,
                        required: true,
                        soloLetra: true,
                    },
                    fecha_nacimiento: {
                        minlength: 2,
                        required: true
                    },
                    materno: {
                        minlength: 2,
                        required: true
                    },
                    dni: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        minlength: 2,
                        required: true
                    },
                    password_confirmation: {
                        minlength: 2,
                        required: true
                    },
                    direccion: {
                        minlength: 2,
                        required: true
                    },
                    telefono: {
                        minlength: 2,
                        required: true
                    },
                    celular: {
                        minlength: 2,
                        required: true
                    },
                    recaptcha: {
                        minlength: 2,
                        required: true
                    },
                    terminos: {
                        minlength: 2,
                        required: true
                    }
                },
                messages: {
                    nombre: {
                        required: "nombre es requerido",
                        minlength: jQuery.validator.format("¡Se requieren al menos {0} caracteres!")
                    }
                },
                highlight: function(element) {
                    $(element).closest('.control-group').removeClass('success').addClass('error');
                },
                success: function(element) {
                    //element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
                },
                errorClass: "my-error-class"
            });
        },
        methods: {
            handleKeypress: function(event) {
                if (event.keyCode == 13 && event.shiftKey) {
                } else if (event.keyCode == 13){
                    return;
                }
            },
            RegisterUser: function() {
                var isValid = $("#registerForm").valid();
                if(isValid){
                    this.user.usuario=this.user.dni;
                    this.user.recaptcha=grecaptcha.getResponse();
                    //var jnk=grecaptcha.getResponse();
                    this.$http.post("create",this.user,function(data) {
                        $(".load").hide();
                        
                        if(data.rst==1){
                            this.mensaje_ok=data.msj;
                            this.user= this.newUser;
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
                }
            },
        }
    });
</script>