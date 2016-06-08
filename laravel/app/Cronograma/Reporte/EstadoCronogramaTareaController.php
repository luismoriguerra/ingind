<?php 

namespace Cronograma\Reporte;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Plantilla;
use Helpers;

class EstadoCronogramaTareaController extends \BaseController {
    
    /**
     * cargar plantillas
     * GET /reportec/cargar
     */
    public function postCargar()
    {
        $filtro = Input::all();
        $response = ['rst'=>1,
                    'data'=>EstadoCronogramaTarea::getTotal($filtro)
                    ];

        return Response::json($response);
    }
}