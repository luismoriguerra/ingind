<?php

class LoginController extends BaseController {

	public function postLogin()
	{
		if(Request::ajax())
		{

		$userdata= array(
			'dni' => Input::get('usuario'),
			'password' => Input::get('password'),
		);

			if( Auth::attempt($userdata, Input::get('remember',0)) )
			{
				Session::set('language', 'Español');
		        Session::set('language_id', 'es');
		        Lang::setLocale( Session::get('language_id') );
		        
				return Response::json(array(
					'rst'=>'1',
					'estado'=>Auth::user()->estado
				));
			}
			else
			{
				return Response::json(array(
					'rst'=>'2',
					'msj'=>'El <strong>Usuario</strong> y/o la <strong>contraseña</strong> son incorrectos.',
				));
			}

		}

	}

	public function postImagen()
	{
		if (isset($_FILES['imagen']) and $_FILES['imagen']['size'] > 0)
        {
        
            $upload_folder = 'img/user/' . md5( 'u' . Auth::user()->id );
            
            if ( !is_dir($upload_folder) ) 
            {
                mkdir($upload_folder);
            }

	    $nombre_archivo = $_FILES['imagen']['name'];
        $ext_archivo = end((explode(".", $nombre_archivo)));	
        $tmp_archivo = $_FILES['imagen']['tmp_name'];	
        $archivo_nuevo = "u".Auth::user()->id . "." . $ext_archivo;	
        $file = $upload_folder . '/' . $archivo_nuevo;

        @unlink($file);
    
        if (!move_uploaded_file($tmp_archivo, $file)) {
        	return Response::json( array(
                'upload' => FALSE, 
                'rst'	 => '2',
                'msj' 	 => "Ocurrio un error al subir el archivo. No pudo guardarse.", 
                'error'  => $_FILES['archivo'],
            ));
        } 
            
        $usuario = Usuario::find( Auth::user()->id );
        $usuario->imagen = $archivo_nuevo;		 
        $usuario->save();

        	return Response::json( array(
                'rst'		=> '1',
        		'msj'		=> 'Imagen subida correctamente',
        		'imagen'	=> $file,
                'upload' 	=> TRUE, 
                'data' 		=> "OK",
            ));
        
        }
	}

}
