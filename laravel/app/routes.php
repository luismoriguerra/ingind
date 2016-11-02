<?php
Route::get(
    'email/{email}', function($email){
        $i=4;
        $parametros=array(
            'paso'      => ($i+1),
            'persona'   => 'Prueba',
            'area'      => 'Area Prueba',
            'procesoe'  => 'Proceso Nuevo',
            'personae'  => 'Jorge Salcedo',
            'areae'     => 'Gerente de Modernización'
        );

        //try{
            Mail::queue('emails', $parametros ,
                function($message) use($email){
                $message
                ->to($email)
                ->subject('.::Se ha involucrado en nuevo proceso::.');
                }
            );

            echo 'Se realizó con éxito su registro, <strong>valide su email.</strong>';
        /*}
        catch(Exception $e){
            var_dump($e);
            echo 'No se pudo realizar el envio de Email; Favor de verificar su email e intente nuevamente.';
        }*/

    }
);

App::bind('Chat\Repositories\Conversation\ConversationRepository', 'Chat\Repositories\Conversation\DbConversationRepository');
App::bind('Chat\Repositories\User\UserRepository', 'Chat\Repositories\User\DbUserRepository');
App::bind('Chat\Repositories\Area\AreaRepository', 'Chat\Repositories\Area\DbAreaRepository');

/*
Route::get('/', function() {
    return Redirect::route('auth.postLogin');
});*/

Route::get('/loginchat', array(
    'as'   => 'auth.getLogin',
    'uses' => 'AuthController@getLogin'
));

Route::post('/loginchat', array(
    'as'   => 'auth.postLogin',
    'uses' => 'AuthController@postLogin'
));

Route::get('/logout', array(
    'as'   => 'auth.logout',
    'uses' => 'AuthController@logout'
));

Route::post('/chat/', array(
    'before' => 'authChat',
    'as'     => 'chat.index',
    'uses'   => 'ChatController@conversation'
));
Route::get('/admin.mantenimiento.chat/', array(
    'before' => 'authChat',
    'as'     => 'chat.index',
    'uses'   => 'ChatController@index'
));

Route::get('/messages/', array(
    'before' => 'authChat',
    'as'     => 'messages.index',
    'uses'   => 'MessageController@index'
));

Route::post('/messages/', array(
    'before' => 'authChat',
    'as'     => 'messages.store',
    'uses'   => 'MessageController@store'
));

Route::get('users/{user_id}/conversations', array(
    'before' => 'authChat',
    'as'     => 'conversations_users.index',
    'uses'   => 'ConversationUserController@index'
));

Route::post('/conversations/', array(
    'before' => 'authChat',
    'as'     => 'conversations.store',
    'uses'   => 'ConversationController@store'
));

Route::get('/conversations/', array(
    'before' => 'authChat',
    'as'     => 'conversations.index',
    'uses'   => 'ConversationController@index'
));
Route::get('areas/{area_id}/users', array(
    'before' => 'authChat',
    'as'     => 'areas_users.index',
    'uses'   => 'AreaController@index'
));

Route::get(
    '/', function () {
        if (Session::has('accesos')) {
            return Redirect::to('/admin.inicio');
        } else {
          return View::make('login');
        }
    }
);

Route::get(
    'salir', function () {
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }
);
Route::controller('password', 'RemindersController');
Route::controller('login', 'LoginController');
Route::get('register/confirm/{token}', 'LoginController@confirmEmail');
Route::controller('cargar', 'CargarController');

Route::get(
    '/{ruta}', array('before' => 'auth', function ($ruta) {
        if (Session::has('accesos')) {
            $accesos = Session::get('accesos');
            $menus = Session::get('menus');

            $val = explode("_", $ruta);
            $url='/chat/';
            $chat = Helpers::ruta($url, 'POST', [] );
            $valores =(array) json_decode($chat);
            $valores['valida_ruta_url'] = $ruta;
            $valores['menus'] = $menus;
                
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
                return Redirect::to('/');
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
Route::controller('rf', 'RFController');
Route::controller('software', 'SoftwareController');
Route::controller('tabla_relacion', 'TablaRelacionController');
Route::controller('tiempo', 'TiempoController');
Route::controller('tiporespuesta', 'TipoRespuestaController');
Route::controller('tiporespuestadetalle', 'TipoRespuestaDetalleController');
Route::controller('tiposolicitante', 'TipoSolicitanteController');
Route::controller('tramite', 'VisualizacionTramiteController');
Route::controller('usuario', 'UsuarioController');
Route::controller('verbo', 'VerboController');
Route::controller('carta', 'CartaController');
Route::controller('tiporecurso', 'TipoRecursoController');
Route::controller('tipoactividad', 'TipoActividadController');
Route::controller('reportef', 'ReporteFinalController');
Route::controller('categoria', 'Cronograma\Categoria\CategoriaController');
Route::controller('plantilla', 'Cronograma\PlantillasWord\PlantillaController');
Route::controller('documentoword', 'Cronograma\DocumentosWord\DocumentoController');
Route::controller('fechanolaborable', 'Cronograma\Fechanolaborable\FechanolaborableController');
Route::controller('llamadaatencion', 'Cronograma\LlamadaAtencion\LlamadaatencionController');
Route::controller('reportec', 'Cronograma\Reporte\EstadoCronogramaTareaController');
Route::controller('produccion', 'ProduccionController');
Route::controller('asignacion', 'AsignacionController');
