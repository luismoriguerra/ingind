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
    '/{ruta}', function ($ruta) {
        $val = explode("_", $ruta);
        $valores = array( 'valida_ruta_url' => $ruta );
        if (count($val) == 2) {
            $dv = explode("=", $val[1]);
            $valores[$dv[0]] = $dv[1];
        }

        return View::make($ruta)->with($valores);
    }
);

Route::controller('language', 'LanguageController');

Route::controller('area', 'AreaController');
Route::controller('cargo', 'CargoController');
Route::controller('flujo', 'FlujoController');
Route::controller('flujotiporespuesta', 'FlujoTipoRespuestaController');
Route::controller('menu', 'MenuController');
Route::controller('opcion', 'OpcionController');
Route::controller('persona', 'PersonaController');
Route::controller('reporte', 'ReporteController');
Route::controller('ruta_flujo', 'RutaFlujoController');
Route::controller('software', 'SoftwareController');
Route::controller('tabla_relacion', 'TablaRelacionController');
Route::controller('tiempo', 'TiempoController');
Route::controller('tiporespuesta', 'TipoRespuestaController');
Route::controller('tiporespuestadetalle', 'TipoRespuestaDetalleController');
Route::controller('ruta', 'RutaController');
Route::controller('ruta_detalle', 'RutaDetalleController');
