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
        {{ HTML::style('lib/customCheckbox/skins/minimal/grey.css') }}
        {{ HTML::style('lib/customCheckbox/skins/minimal/green.css') }}

        {{ HTML::script('lib/jquery-2.1.3.min.js') }}
        {{ HTML::script('lib/jquery-ui-1.11.2/jquery-ui.min.js') }}
        {{ HTML::script('lib/jquery.validate.js') }}
        {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
        {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
        {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
        {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
        {{ HTML::style('css/login/login.css') }}
        {{ HTML::script('lib/cloudflare/cloudflare-vue-1.0.24.js') }}
        {{ HTML::script('lib/cloudflare/cloudflare-vue-0.7.2.js') }}
        {{ HTML::script('lib/icheck.js') }}
        <script src='lib/recaptcha/api.js'></script>

        <style type="text/css">
            .padding-10{
                padding: 15px;
            }

            .btnEnviar {
                max-width: 182px;
                margin: -20px auto 0px auto;
                font-size: 17px;
                position: relative;
                height: 38px;
                background-color: #0a6dc6;
                text-align: center;
                color: #fff;
                display: block;
                width: 100%;
            }

            .g-recaptcha{
                float: right;
            }

            .radio{
                margin-left:-18px;
            }

            .titulo {
                font-size: 24px;
                color: #fff;
                letter-spacing: -1.2px;
                text-align: center;
                margin-bottom: 20px;
            }

            .form-control{
                height: 38px;
            }

            legend{
                padding: 15px;
            }

            .control-label{
                font-size:12px;
            }
        </style>
    </head>

    <body id="registerUser" bgcolor="#FFF">
        <div id="mainWrap">
            <div id="register" class="col-md-8 col-md-offset-2">
                <h2 class="titulo">{{-- <i class="fa fa-lock"></i> --}} MUNICIPALIDAD DE INDEPENDENCIA</h2>
                {{-- <h1 style="text-align: center;"><i class="fa fa-lock"></i> MUN.INDEP. </h1> --}}
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

             {{--    <h3 class="titulo" style="text-align: center;" id="mensaje_inicio">Por Favor <strong>registrese</strong></h3> --}}


                <form v-on:submit.prevent='RegisterUser(this)' autocomplete="off" id="registerForm">
                    <fieldset>
                        <legend style="color:#e5e5e5">Datos personales</legend>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group padding-10">
                                    <label class="control-label">Nombre:</label>
                                    <input type="text" name='nombre' v-model='user.nombre' maxlength="80" class="form-control pull-right" placeholder="Nombre:" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Apellido Paterno:</label>
                                    <input type="text" name='paterno' v-model='user.paterno' maxlength="50" class="form-control  pull-right" placeholder="Apellido Paterno" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Apellido Materno:</label>
                                    <input type="text" name='materno' v-model='user.materno' maxlength="50" class="form-control  pull-right" placeholder="Apellido Materno" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Dni:</label>
                                    <input type="text" name='dni' v-model='user.dni' maxlength="8" class="form-control  pull-right" placeholder="DNI" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group padding-10">
                                    <label class="control-label">Email:</label>
                                    <input type="email" name='email' v-model='user.email' maxlength="150" class="form-control  pull-right" placeholder="Email" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Password:</label>
                                    <input type="password" name='password' v-model='user.password' minlength="6" class="form-control  pull-right" placeholder="Password" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Confirmar Password:</label>
                                    <input type="password" name='password_confirmation' v-model='user.password_confirmation' minlength="6" class="form-control  pull-right" placeholder="Confirmar Password" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Direccion:</label>
                                    <input type="text" name='direccion' v-model='user.direccion' maxlength="150" class="form-control  pull-right" placeholder="Direccion" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group padding-10">
                                    <label class="control-label">Sexo:</label>
                                    <select v-model='user.sexo' name='sexo' class="form-control  pull-right" placeholder="Sexo" autocomplete="off">
                                        <option value="" selected="selected">.:: Seleccione genero ::.</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Fecha Nacimiento:</label>
                                    <input type="text" id='fecha_nacimiento' name='fecha_nacimiento' v-model='user.fecha_nacimiento' class="form-control  pull-right" placeholder="AAAA-MM-DD" onfocus="blur()" autocomplete="off" placeholder="Fecha de Nacimiento">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Telefono:</label>
                                    <input type="text" name='telefono' v-model='user.telefono' maxlength="12" class="form-control  pull-right" placeholder="Telefono" autocomplete="off">
                                </div>
                                <div class="form-group padding-10">
                                    <label class="control-label">Celular:</label>
                                    <input type="text" name='celular' v-model='user.celular' maxlength="12" class="form-control  pull-right" placeholder="Celular" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group padding-10">
                            <div class="col-md-6">
                              {{--   <div class="radio checkbox">
                                    <label class="clsRepeat">
                                        <input class="chkbx" type="checkbox" v-model='terminos' name='terminos' autocomplete="off"> Acepto los terminos &amp; condiciones
                                    </label>
                                </div> --}}
                                <div class="checkbox">
                                    <label>
                                        <input class="chkbx" type="checkbox" v-model='terminos' name='terminos' autocomplete="off"> Acepto los terminos &amp; condiciones
                                    </label>
                                </div>
                            </div>
                           {{--  <div class="col-md-6">
                                <div class="g-recaptcha" name='recaptcha' data-sitekey="{{Config::get('recaptcha.site')}}"></div>

                            </div> --}}
                            <div class="col-xs-6">
                                <div class="g-recaptcha" name='recaptcha' data-sitekey="{{Config::get('recaptcha.site')}}"></div>

                            </div>
                        </div>  
                        {{-- <button type="submit" class="btn btnEnviar">Enviar<img src="img/web/check.png"></button> --}}
                        <div class="submitWrap">
                            <!-- <a href="#">RegÃ&shy;strate</a> -->
                            {{ Form::submit('Regístrate', array('class' => 'btn btn-primary btnEnviar')) }}
{{--                             <button class="btn btn-primary btnEnviar" id="btnRegistrar" type="submit" style="" disabled="disabled">Regístrate </button> --}}
                        </div>




                      
                      
                    
                    </fieldset>
                </form>
                <a href="{{ url('/') }}" class="text-center">Ya tengo un usuario</a>
            </div>
        </div>
    </body>

<script>
  /*  $(".chkbx").iCheck({
        checkboxClass: 'icheckbox_minimal-green',
        increaseArea: '20%' ,
        indeterminateClass: 'indeterminate',
    });*/

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
