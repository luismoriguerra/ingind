<?php

class TipoRespuestaDetalleController extends BaseController
{

    /**
     * cargar modulos, mantenimiento
     * POST /tiporespuestadetalle/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $detalle = TipoRespuestaDetalle::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$detalle));
        }
    }
    /**
     * cargar modulos, mantenimiento
     * POST /tiporespuestadetalle/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $detalle = TipoRespuestaDetalle::getTipoRespuesta();
            return Response::json(array('rst'=>1,'datos'=>$detalle));
        }
    }
    
    /**
     * Store a newly created resource in storage.
     * POST /tiporespuestadetalle/crear
     *
     * @return Response
     */
    public function postCrear()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required.'|'.$regex,
                'tiporespuesta_id' => $required.'|numeric',
                //'path' =>$regex.'|unique:modulos,path,',
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
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

            $detalles = new TipoRespuestaDetalle;
            $detalles['nombre'] = Input::get('nombre');
            $detalles['tipo_respuesta_id'] = Input::get('tiporespuesta_id');
            $detalles['estado'] = Input::get('estado');
            $detalles['usuario_created_at'] = Auth::user()->id;
            $detalles->save();

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
     * POST /tiporespuestadetalle/editar
     *
     * @return Response
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required.'|'.$regex,
                'tiporespuesta_id' => $required.'|numeric',
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
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
            $detalleId = Input::get('id');
            $detalles = TipoRespuestaDetalle::find($detalleId);
            $detalles['nombre'] = Input::get('nombre');
            $detalles['tipo_respuesta_id'] = Input::get('tiporespuesta_id');
            $detalles['estado'] = Input::get('estado');
            $detalles['usuario_updated_at'] = Auth::user()->id;
            $detalles->save();

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
     * POST /tiporespuestadetalle/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $detalle = TipoRespuestaDetalle::find(Input::get('id'));
            $detalle->estado = Input::get('estado');
            $detalle->usuario_updated_at = Auth::user()->id;
            $detalle->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
