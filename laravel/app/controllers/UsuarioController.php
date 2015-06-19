<?php

class UsuarioController extends BaseController
{
    /**
     * Constructor de la clase
     *
     */
    public function __construct()
    {
        $this->beforeFilter('auth'); // bloqueo de acceso
    }
    /**
     * Mostrar los datos del contacto actual
     * POST /usuario/misdatos
     *
     * @return Response
     */
    public function postMisdatos()
    {
        if (Request::ajax()) {
            $reglas = array(
                'password'      => 'required|min:6',
                'newpassword'   => 'min:6'
            );

            $validator = Validator::make(Input::all(), $reglas);

            if ($validator->fails()) {
                $final='';
                $datosfinal=array();
                $msj=(array) $validator->messages();

                foreach ($msj as $key => $value) {
                    $datos=$msj[$key];
                    foreach ($datos as $keyI => $valueI) {
                        $datosfinal[$keyI]=str_replace(
                            $keyI, trans('greetings.'.$keyI), $valueI
                        );
                    }
                    break;
                }

                return Response::json(
                    array(
                        'rst'=>2,
                        'msj'=>$datosfinal,
                    )
                );
            }

            $userdata= array(
                'dni' => Auth::user()->dni,
                'password' => Input::get('password'),
            );

            if ( Auth::attempt($userdata) ) {
                
                if ( Input::get('newpassword')!='' ) {
                $usuarios = Persona::find(Auth::user()->id);
                $usuarios->password = Hash::make(Input::get('newpassword'));
                $usuarios->save();
                }

                return Response::json(
                    array(
                        'rst'=>1,
                        'msj'=>'Registro actualizado correctamente',
                    )
                );
            } else {
                return Response::json(
                    array(
                        'rst'=>2,
                        'msj'=>array('password'=>'Contraseña incorrecta'),
                    )
                );
            }
        }
    }

}
