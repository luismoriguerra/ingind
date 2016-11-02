<?php

class LoginController extends BaseController
{
    use CaptchaTrait;
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('getDashboard')));
    }
    /**
     * view register
     */
    public function getRegister() {
        return View::make('register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['captcha'] = $this->captchaCheck();
        $validator = Validator::make($data,Persona::$rules, Persona::$messajes);
        return $validator;
    }
    /**
     * create user
     */
    public function postCreate() {
        $validator = $this->validator(Input::all());

        if ( $validator->fails() ) {
            return Response::json(
                array(
                'rst'=>2,
                'msj'=>$validator->messages(),
                )
            );
        }
        $user = Persona::create(Input::all());
        //enviar email
        Mail::queue('emails.auth.confirm', compact('user') , function($m) use( $user ) {
            $m->to($user->getReminderEmail())
              //->cc($emailseguimiento)
              ->subject('Bienvenido!');
        });

        $cargoId = 13; //vecino
        $areaId=107;//area

        $cargo = Cargo::find($cargoId);
        $cargoPersona=$user->cargos()->save($cargo, 
            [
                'estado' => 1,
                'usuario_created_at' => $user->id
                ]
            );

        DB::table('area_cargo_persona')->insert(
            [
                'area_id' => $areaId,
                'cargo_persona_id' => $cargoPersona->id,
                'estado' => 1,
                'usuario_created_at' => $user->id
            ]
        );
        return  ['rst'=>1,'msj'=>'Se envio un mensaje de confirmacion a su cuenta de email'];
        return  LoginController::postSignin();

    }
    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token)
    {
        Persona::whereToken($token)->firstOrFail()->confirmEmail();
        return Redirect::to('/');
    }
    /**
     * Attempt to sign in the user.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function signIn($request)
    {
        return Auth::attempt($this->getCredentials($request), $request['remember'] );
    }
    /**
     * Get the login credentials and requirements.
     *
     * @param  Request $request
     * @return array
     */
    protected function getCredentials( $request )
    {
        return [
            'dni'    => $request['usuario'],
            'password' => $request['password'],
            'verified' => true
        ];
    }
    /**
     * login
     */
    public function postSignin()
    {
        if (Request::ajax()) {
            if ($this->signIn(Input::all())) {
                //buscar los permisos de este usuario y guardarlos en sesion
                $query = "SELECT m.nombre as menu, o.nombre as opcion,
                        IF(LOCATE('.', o.ruta)>0,
                            o.ruta,
                            CONCAT(m.ruta,'.',o.ruta)
                        ) as ruta, m.class_icono as icon
                        FROM personas p
                        JOIN cargo_persona cp ON p.id=cp.persona_id
                        JOIN cargos c ON cp.cargo_id=c.id
                        JOIN cargo_opcion co ON c.id=co.cargo_id
                        JOIN opciones o ON co.opcion_id=o.id
                        JOIN menus m ON o.menu_id=m.id
                        WHERE p.estado=1 AND cp.estado=1 AND c.estado=1
                        AND co.estado=1 AND o.estado=1 AND m.estado=1
                        AND p.id=?
                        GROUP BY m.id, o.id
                        ORDER BY m.nombre, o.nombre";
                $res = DB::select($query, array(Auth::user()->id));

                $menus = array();
                $accesos = array();
                foreach ($res as $data) {
                    $menu = $data->menu;
                    //$accesos[] = $data->ruta;
                    array_push($accesos, $data->ruta);
                    if (isset($menus[$menu])) {
                        $menus[$menu][] = $data;
                    } else {
                        $menus[$menu] = array($data);
                    }
                }

                Session::set('language', 'Español');
                Session::set('language_id', 'es');
                Session::set('menus', $menus);
                Session::set('accesos', $accesos);
                Lang::setLocale(Session::get('language_id'));

                return Response::json(
                    array(
                        'rst'=>'1',
                        'estado'=>Auth::user()->estado
                    )
                );
            } else {
                $m = ' y/o la <strong>contraseña</strong> son incorrectos.';
                return Response::json(
                    array(
                    'rst'=>'2',
                    'msj'=>'El <strong>Usuario</strong>'.$m,
                    )
                );
            }

        }

    }

    public function postImagen()
    {
        if (isset($_FILES['imagen']) and $_FILES['imagen']['size'] > 0) {

            $uploadFolder = 'img/user/'.md5('u'.Auth::user()->id);
            
            if ( !is_dir($uploadFolder) ) {
                mkdir($uploadFolder);
            }

            $nombreArchivo = $_FILES['imagen']['name'];
            $tmp = explode(".", $nombreArchivo);
            $extArchivo = end($tmp);
            $tmpArchivo = $_FILES['imagen']['tmp_name'];
            $archivoNuevo = "u".Auth::user()->id . "." . $extArchivo;
            $file = $uploadFolder . '/' . $archivoNuevo;

            @unlink($file);

            $m="Ocurrio un error al subir el archivo. No pudo guardarse.";
            if (!move_uploaded_file($tmpArchivo, $file)) {
                return Response::json(
                    array(
                        'upload' => FALSE,
                        'rst'    => '2',
                        'msj'    => $m,
                        'error'  => $_FILES['archivo'],
                    )
                );
            }

            $usuario = Persona::find(Auth::user()->id);
            $usuario->imagen = $archivoNuevo;
            $usuario->save();

            return Response::json(
                array(
                    'rst'       => '1',
                    'msj'       => 'Imagen subida correctamente',
                    'imagen'    => $file,
                    'upload'    => TRUE, 
                    'data'      => "OK",
                )
            );
        }
    }

}
