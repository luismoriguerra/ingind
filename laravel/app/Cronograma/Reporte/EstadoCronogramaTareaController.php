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

        if (isset($filtro['semaforo'])) {
            if( $filtro['semaforo']=="FE0000" ){
                $filtro['semaforo']=" AND cda.ff<CURDATE() ";
            }
            elseif( $filtro['semaforo']=="F8BB00" ){
                $filtro['semaforo']=" AND cda.ff>CURDATE() AND cd.fecha_fin<CURDATE() ";
            }
            elseif( $filtro['semaforo']=="89C34B" ){
                $filtro['semaforo']=" AND cda.ff>CURDATE() AND cd.fecha_fin>CURDATE() ";
            }
        }
        else{
            $filtro['semaforo']='';
        }

        if (isset($filtro['tramite'])) {
            $filtro['tramite']=" AND tr.id_union='".$filtro['tramite']."' ";
        }
        else{
            $filtro['tramite']='';
        }

        if (isset($filtro['fecha'])) {
            $fecha=explode(" - ",$filtro['fecha']);
            $filtro['fecha']=" AND cda.fi between '".$fecha[0]."' AND '".$fecha[1]."' ";
        }
        else{
            $filtro['fecha']='';
        }

        $response = ['rst'=>1,
                    'data'=>EstadoCronogramaTarea::getTotal($filtro)
                    ];

        return Response::json($response);
    }
}
