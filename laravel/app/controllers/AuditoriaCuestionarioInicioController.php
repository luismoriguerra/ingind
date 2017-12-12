<?php

class AuditoriaCuestionarioInicioController extends \BaseController
{

    /**
     * cargar modulos, mantenimiento
     * POST /cargo/cargar
     *
     * @return Response
     */
    public function postCrear()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {

            Session::set('respuesta_id', Input::get('respuesta_id'));
            
            $aci = new AuditoriaCuestionarioInicio;
            $aci->persona_id = Auth::user()->id;
            $aci->area_id = Auth::user()->area_id;
            $aci->respuesta_id=Input::get('respuesta_id');
            $aci->estado=1;
            $aci->usuario_created_at = Auth::user()->id;
            $aci->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                )
            );
        }
    }



}
