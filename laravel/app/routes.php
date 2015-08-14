<?php

Route::get(
    '/', function () {
        return View::make('login');
    }
);

Route::get(
    'salir', function () {
        Auth::logout();

        return Redirect::to('/');
    }
);

Route::controller('check', 'LoginController');

Route::get(
    '/email/{email}', function($email){
        $parametros=array(
            'email'     => $email
        );

        try{
            Mail::send('emails', $parametros , 
                function($message){
                $message->to($email,'Administrador')->subject('.::Se ha involucrado en nuevo proceso::.');
                }
            );

            echo 'Se realizó con éxito su registro, <strong>valide su email.</strong>';
        }
        catch(Exception $e){
            echo 'No se pudo realizar el envio de Email; Favor de verificar su email e intente nuevamente.');
        }

    }
);

Route::get(
    '/{ruta}', array('before' => 'auth', function ($ruta) {
        if (Session::has('accesos')) {
            $accesos = Session::get('accesos');
            $menus = Session::get('menus');

            $val = explode("_", $ruta);
            $valores = array( 
                'valida_ruta_url' => $ruta,
                'menus' => $menus
            );
            if (count($val) == 2) {
                $dv = explode("=", $val[1]);
                $valores[$dv[0]] = $dv[1];
            }
            $rutaBD = substr($ruta, 6);
            //si tiene accesoo si accede al inicio o a misdatos
            if (in_array($rutaBD, $accesos) or 
                $rutaBD == 'inicio' or $rutaBD=='mantenimiento.misdatos') {
                return View::make($ruta)->with($valores);
            } else
                return Redirect::to('/admin.inicio');
        } else
            return Redirect::to('/');
        }
    )
);

Route::controller('area', 'AreaController');
Route::controller('cargo', 'CargoController');
Route::controller('documento', 'DocumentoController');
Route::controller('flujo', 'FlujoController');
Route::controller('flujotiporespuesta', 'FlujoTipoRespuestaController');
Route::controller('language', 'LanguageController');
Route::controller('lista', 'ListaController');
Route::controller('menu', 'MenuController');
Route::controller('opcion', 'OpcionController');
Route::controller('persona', 'PersonaController');
Route::controller('reporte', 'ReporteController');
Route::controller('rol', 'RolController');
Route::controller('ruta', 'RutaController');
Route::controller('ruta_detalle', 'RutaDetalleController');
Route::controller('ruta_flujo', 'RutaFlujoController');
Route::controller('software', 'SoftwareController');
Route::controller('tabla_relacion', 'TablaRelacionController');
Route::controller('tiempo', 'TiempoController');
Route::controller('tiporespuesta', 'TipoRespuestaController');
Route::controller('tiporespuestadetalle', 'TipoRespuestaDetalleController');
Route::controller('tiposolicitante', 'TipoSolicitanteController');
Route::controller('tramite', 'VisualizacionTramiteController');
Route::controller('usuario', 'UsuarioController');
Route::controller('verbo', 'VerboController');
