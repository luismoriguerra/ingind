<?php

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

/*
Route::get(
    'email/{email}', function($email){
        $i=4;
        $parametros=array(
            'paso'      => ($i+1),
            'persona'   => 'Salcedo Franco Jorge Luis',
            'area'      => 'Area TIC',
            'procesoe'  => 'Proceso Nuevo',
            'personae'  => 'Juan Luna Galvez',
            'areae'     => 'Gerente de la Calidad'
        );

        //try{
            Mail::send('emails', $parametros , 
                function($message){
                $message
                ->to('jorgeshevchenk@gmail.com')
                ->subject('.::Se ha involucrado en nuevo proceso::.');
                }
            );

            echo 'Se realizó con éxito su registro, <strong>valide su email.</strong>';
        //}
        //catch(Exception $e){
        //    var_dump($e);
        //    echo 'No se pudo realizar el envio de Email; Favor de verificar su email e intente nuevamente.';
        //}

    }
);
*/
Route::controller('check', 'LoginController');
Route::controller('cargar', 'CargarController');

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
Route::controller('fechanolaborable', 'Cronograma\Fechanolaborable\FechanolaborableController');
Route::controller('llamadaatencion', 'Cronograma\LlamadaAtencion\LlamadaatencionController');
Route::controller('reportec', 'Cronograma\Reporte\EstadoCronogramaTareaController');
