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
            <div id="register" class="col-md-8 col-md-offset-2">
                <h1 style="text-align: center;"><i class="fa fa-lock"></i> MUN.INDEP. </h1>
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

                <h3 style="text-align: center;" id="mensaje_inicio">Por Favor <strong>registrese</strong></h3>


                <form v-on:submit.prevent='RegisterUser(this)' autocomplete="off" id="registerForm">
                    <fieldset>
                        <legend style="color:#e5e5e5">Datos personales</legend>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">NOMBRE:</label>
                                    <input type="text" name='nombre' v-model='user.nombre' maxlength="80" class="form-control pull-right" placeholder="Nombre:" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">SEXO:</label>
                                    <select v-model='user.sexo' name='sexo' class="form-control  pull-right" placeholder="Seleccione" autocomplete="off">
                                        <option value="">.:: Seleccione genero ::.</option>
                                        <option value="M">MASCULINO</option>
                                        <option value="F">FEMENINO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">APELLIDO PATERNO:</label>
                                    <input type="text" name='paterno' v-model='user.paterno' maxlength="50" class="form-control  pull-right" placeholder="APELLIDO PATERNO" autocomplete="off">
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
                                    <input type="text" name='materno' v-model='user.materno' maxlength="50" class="form-control  pull-right" placeholder="APELLIDO MATERNO" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">DNI:</label>
                                    <input type="text" name='dni' v-model='user.dni' maxlength="8" class="form-control  pull-right" placeholder="DNI" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">EMAIL:</label>
                                    <input type="email" name='email' v-model='user.email' maxlength="150" class="form-control  pull-right" placeholder="EMAIL" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">PASSWORD:</label>
                                    <input type="password" name='password' v-model='user.password' minlength="6" class="form-control  pull-right" placeholder="PASSWORD" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">CONFIRMAR PASSWORD:</label>
                                    <input type="password" name='password_confirmation' v-model='user.password_confirmation' minlength="6" class="form-control  pull-right" placeholder="CONFIRMAR PASSWORD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">DIRECCION:</label>
                                    <input type="text" name='direccion' v-model='user.direccion' maxlength="150" class="form-control  pull-right" placeholder="DIRECCION" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group form-inline">
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">TELEFONO:</label>
                                    <input type="text" name='telefono' v-model='user.telefono' maxlength="12" class="form-control  pull-right" placeholder="TELEFONO" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="control-group">
                                    <label class="control-label">CELULAR:</label>
                                    <input type="text" name='celular' v-model='user.celular' maxlength="12" class="form-control  pull-right" placeholder="CELULAR" autocomplete="off">
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
                                        <input type="checkbox" v-model='terminos' name='terminos' autocomplete="off"> Acepto los terminos &amp; condiciones
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-5 submitWrap" v-if="terminos">
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
                sexo:'',
                fecha_nacimiento:'',
            },

            errores:[],
        },
        ready: function () {
            $('#fecha_nacimiento').daterangepicker({
                format: 'YYYY-MM-DD',
                singleDatePicker: true,
                showDropdowns: true
            });
            jQuery.extend(jQuery.validator.messages, {
                required: "Este campo es requerido.",
                remote: "Por favor corrige este campo.",
                email: "Por favor, introduce una dirección de correo electrónico válida.",
                url: "Por favor introduzca una URL válido.",
                date: "Por favor introduzca una fecha valida.",
                dateISO: "Ingrese una fecha válida (ISO).",
                number: "Por favor ingrese un número valido.",
                digits: "Por favor ingrese solo dígitos.",
                creditcard: "Please enter a valid credit card number.",
                equalTo: "Por favor, introduzca un número de tarjeta de crédito válida",
                accept: "Introduzca un valor con una extensión válida.",
                maxlength: jQuery.validator.format("Por favor, introduzca no más de {0} caracteres."),
                minlength: jQuery.validator.format("¡Se requieren al menos {0} caracteres!"),
                rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
                range: jQuery.validator.format("Please enter a value between {0} and {1}."),
                max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
                min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
            });
            jQuery.validator.addMethod("soloLetra", function(value, element) {
                return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
            }, "Solo letras");

            $('#registerForm').validate( {
                rules: {
                    nombre: {
                        maxlength: 80,
                        required: true,
                        soloLetra: true,
                    },
                    sexo: {
                        required: true 
                    },
                    paterno: {
                        maxlength: 50,
                        required: true,
                        soloLetra: true,
                    },
                    fecha_nacimiento: {
                        required: true
                    },
                    materno: {
                        maxlength: 50,
                        required: true,
                        soloLetra: true,
                    },
                    dni: {
                        maxlength: 8,
                        required: true,
                        digits: true
                    },
                    email: {
                        maxlength: 150,
                        required: true,
                        email: true
                    },
                    password: {
                        minlength: 6,
                        required: true
                    },
                    password_confirmation: {
                        minlength: 6,
                        required: true
                    },
                    direccion: {
                        maxlength: 150,
                        required: true
                    },
                    telefono: {
                        maxlength: 12,
                        required: true,
                        digits: true
                    },
                    celular: {
                        maxlength: 12,
                        required: true,
                        digits: true
                    },
                    recaptcha: {
                        required: true
                    },
                    terminos: {
                        required: true
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
                    this.user.area_id=107; //vecino
                    this.user.recaptcha=grecaptcha.getResponse();
                    //var jnk=grecaptcha.getResponse();
                    this.$http.post("create",this.user,function(data) {
                        $(".load").hide();
                        
                        if(data.rst==1){
                            this.errores='';
                            this.mensaje_ok=data.msj;
                            this.user= this.newUser;
                        }
                        else if(data.rst==1){
                            this.mensaje_ok='';
                            this.errores=data.msj;
                            this.mensaje_error = data.error
                        }
                        else if(data.rst==2){
                            this.mensaje_ok='';
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