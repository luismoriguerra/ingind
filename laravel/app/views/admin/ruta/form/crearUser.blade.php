<div class="modal-dialog modal-md">
<div class="modal fade" id="CrearUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
      <div class="modal-header logo">
             <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Crear Usuario</h4>
      </div>
      <div class="modal-body">

          {{-- <form v-on:submit.prevent='RegisterUser(this)' autocomplete="off" id="registerForm"> --}}
          <form class="FrmCrearUsuario" id="FrmCrearUsuario" method="post" action="">
                    <fieldset>

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
                                {{-- <div class="g-recaptcha" name='recaptcha' data-sitekey="{{Config::get('recaptcha.site')}}"></div> --}}

                            </div>
                        </div>  
                        {{-- <button type="submit" class="btn btnEnviar">Enviar<img src="img/web/check.png"></button> --}}
                        <div class="submitWrap">
                            <!-- <a href="#">RegÃ&shy;strate</a> -->
                            {{-- {{ Form::submit('Regístrate', array('class' => 'btn btn-primary btnEnviar')) }} --}}
                             <span class="btn btn-primary btn-sm btnEnviar" id="btnRegistrar">Regístrate</span>
                {{--             <button class="btn btn-primary btnEnviar" id="btnRegistrar" type="submit" style="">Regístrate </button> --}}
                        </div>




                      
                      
                    
                    </fieldset>
                </form>
  
      </div>
      <div class="modal-footer" style="border-top: 0px;">
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
