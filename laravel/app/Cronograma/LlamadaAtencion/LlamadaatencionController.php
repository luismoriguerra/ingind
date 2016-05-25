<?php

namespace Cronograma\LlamadaAtencion;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use LlamadaAtencion;

class LlamadaatencionController extends \BaseController {

    /**
     * cargar ultimo registro del numero maximo de llamada de atencion
     * POST /llamadaatencion/cargar
     */
    public function postCargar()
    {
        if ( Request::ajax() ) {

            $nro_maximo = LlamadaAtencion::where('estado', '=', 1)->orderBy('id', 'desc')->take(1)->get();

            return Response::json(array('rst'=>1, 'datos'=>$nro_maximo));
        }
    }

    /**
     * Actualizar registro del numero maximo de llamada de atencion
     * POST /llamadaatencion/editar
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {

            $reglas = array(
                'numeromaximo' => 'required|regex:/^[0-9]+$/',
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe contener numeros',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            DB::table('nro_max_alerta')
                ->update(
                    array(
                        'estado' => 0,
                        'usuario_updated_at' => Auth::user()->id
                    ));

            $llamadaatencion = new LlamadaAtencion;
            $llamadaatencion->nro_max = Input::get('numeromaximo');
            $llamadaatencion->estado = 1;
            $llamadaatencion->usuario_created_at = Auth::user()->id;
            $llamadaatencion->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

}