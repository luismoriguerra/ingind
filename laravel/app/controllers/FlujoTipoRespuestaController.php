<?php

class FlujoTipoRespuestaController extends \BaseController
{

    /**
     * cargar modulos, mantenimiento
     * POST /flujotiporespuesta/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $flujoTipoRsp = FlujoTipoRespuesta::getFlujoTipoRsp();
            return Response::json(array('rst'=>1,'datos'=>$flujoTipoRsp));
        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /flujotiporespuesta/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $flujoTipoRsp = FlujoTipoRespuesta::getFlujoTipoRsp();
            return Response::json(array('rst'=>1,'datos'=>$flujoTipoRsp));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /flujotiporespuesta/crear
     *
     * @return Response
     */
    public function postCrear()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $reglas = array(
                'estado' => 'required|numeric',
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Numero',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>$validator->messages(),
                    )
                );
            }
            if (Input::has('tiempo_id')) {
                $tiempoId = Input::get('tiempo_id');
                $dtiempo = Input::get('dtiempo');
            } else {
                $tiempoId = 0;
                $dtiempo = 0;
            }
            $flujoTipoRespuesta = new FlujoTipoRespuesta;
            $flujoTipoRespuesta['flujo_id'] = Input::get('flujo_id');
            $flujoTipoRespuesta['tipo_respuesta_id'] = Input::get('tipo_respuesta_id');
            $flujoTipoRespuesta['tiempo_id'] = $tiempoId;
            $flujoTipoRespuesta['dtiempo'] = $dtiempo;
            $flujoTipoRespuesta['estado'] = Input::get('estado');
            $flujoTipoRespuesta->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                )
            );
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /flujotiporespuesta/editar
     *
     * @return Response
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $reglas = array(
                'estado' => 'required|numeric',
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Numero',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>$validator->messages(),
                    )
                );
            }
            if (Input::has('tiempo_id')) {
                $tiempoId = Input::get('tiempo_id');
                $dtiempo = Input::get('dtiempo');
            } else {
                $tiempoId = 0;
                $dtiempo = 0;
            }
            $flujoTipoRespuestaId = Input::get('id');
            $flujoTipoRespuesta = FlujoTipoRespuesta::find($flujoTipoRespuestaId);
            $flujoTipoRespuesta['flujo_id'] = Input::get('flujo_id');
            $flujoTipoRespuesta['tipo_respuesta_id'] = Input::get('tipo_respuesta_id');
            $flujoTipoRespuesta['tiempo_id'] = $tiempoId;
            $flujoTipoRespuesta['dtiempo'] = $dtiempo;
            $flujoTipoRespuesta['estado'] = Input::get('estado');
            $flujoTipoRespuesta->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /flujotiporespuesta/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $flujoTipoRespuesta = FlujoTipoRespuesta::find(Input::get('id'));
            $flujoTipoRespuesta->estado = Input::get('estado');
            $flujoTipoRespuesta->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
