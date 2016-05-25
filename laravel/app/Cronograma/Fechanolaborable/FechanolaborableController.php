<?php
namespace Cronograma\Fechanolaborable;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use FechaLaborable;
use FechaLaborableArea;
use Area;
use Categoria;

class FechanolaborableController extends \BaseController {

    /**
     * cargar categorias
     * GET /fechanolaborable/cargar
     */
    public function getCargar()
    {
        if ( Request::ajax() ) {

            $fechas = FechaLaborable::getFechas();
            $eventos = [];
            foreach ($fechas as $key => $value) {
                $eventos[] = [
                    'id' => $value->id,
                    'estado' => $value->estado,
                    'title' => (($value->general) ? 'General' : $value->nemonico) . ' - Dia no laborable',
                    'color' => '#e74c3c',
                    'start' => $value->fecha,
                    'general' => $value->general,
                    'area' => $value->area_id
                ];
            }

            return Response::json($eventos);
        }
    }

    /**
     * Crear categoria
     * POST /fechanolaborable/crear
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {

            $reglas = array(
                'fechanolaborable' => 'required|date_format:"Y-m-d"',
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'date_format' => ':attribute Formato invalido',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $areaId = Input::get('area');

            $fechalaborable = new FechaLaborable;
            $fechalaborable->fecha = Input::get('fechanolaborable');
            $fechalaborable->general = ( $areaId )? 0:1;
            $fechalaborable->estado = Input::get('estado');
            $fechalaborable->usuario_created_at = Auth::user()->id;
            $fechalaborable->save();

            if ( !empty($areaId) && isset($areaId) ) {
                $flArea = new FechaLaborableArea;
                $flArea->fecha_laborable_id = $fechalaborable->id;
                $flArea->area_id = $areaId;
                $flArea->estado = Input::get('estado');
                $flArea->save();
            }

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'fecha_id'=>$fechalaborable->id));
        }
    }


    /**
     * Actualizar categoria
     * POST /categoria/editar
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {

            $reglas = array(
                'fechanolaborable' => 'required|date_format:"Y-m-d"',
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'date_format' => ':attribute Formato invalido',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $areaId = Input::get('area');
            $flId = Input::get('id');

            $fechalaborable = FechaLaborable::find($flId);
            $fechalaborable->fecha = Input::get('fechanolaborable');
            $fechalaborable->general = ( $areaId )? 0:1;
            $fechalaborable->estado = Input::get('estado');
            $fechalaborable->usuario_updated_at = Auth::user()->id;
            $fechalaborable->save();

            if ( !empty($areaId) && isset($areaId) ) {

                $flArea = FechaLaborableArea::where('fecha_laborable_id', $flId)
                                            ->where('estado', 1)
                                            ->first();

                $newFlArea = new FechaLaborableArea;

                if($flArea) {
                    $newFlArea = $flArea;
                }

                $newFlArea->fecha_laborable_id = $fechalaborable->id;
                $newFlArea->area_id = $areaId;
                $newFlArea->estado = Input::get('estado');
                $newFlArea->save();
            }

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Listar areas
     * POST /area/listar
     */
    public function postListar()
    {
        if ( Request::ajax() ) {

            $areas = FechaLaborable::getAreas();

            return Response::json(array('rst' => 1, 'datos' => $areas));
        }
    }

}
