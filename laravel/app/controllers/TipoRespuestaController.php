<?php

class TipoRespuestaController extends \BaseController
{

    /**
     * cargar menus, mantenimiento
     * POST /tiporespuesta/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tipoRespuesta = TipoRespuesta::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tipoRespuesta));
        }
    }
    /**
     * cargar flujos, mantenimiento
     * POST /tiporespuesta/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            if( Input::get('fecha_inicio') ){
                $a      = new TipoRespuesta;
                $listar = Array();
                $listar = $a->getTipoRespuesta();

                return Response::json(
                    array(
                        'rst'   => 1,
                        'datos' => $listar
                    )
                );
            }
            else {
                $tipoRespuesta = TipoRespuesta::get(Input::all());
                return Response::json(array('rst'=>1,'datos'=>$tipoRespuesta));
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /tiporespuesta/crear
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

            $tipoRespuesta = new TipoRespuesta;
            $tipoRespuesta['nombre'] = Input::get('nombre');
            $tipoRespuesta['tiempo'] = Input::get('tiempo');
            $tipoRespuesta['estado'] = Input::get('estado');
            $tipoRespuesta['usuario_created_at'] = Auth::user()->id;
            $tipoRespuesta->save();

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
     * POST /tiporespuesta/editar
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
            $tiporespuestaId = Input::get('id');
            $tipoRespuesta = TipoRespuesta::find($tiporespuestaId);
            $tipoRespuesta['nombre'] = Input::get('nombre');
            $tipoRespuesta['tiempo'] = Input::get('tiempo');
            $tipoRespuesta['estado'] = Input::get('estado');
            $tipoRespuesta['usuario_updated_at'] = Auth::user()->id;
            $tipoRespuesta->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('tipos_respuesta_detalle')
                    ->where('tipo_respuesta_id', $tiporespuestaId)
                    ->update(array(
                        'estado' => 0,
                        'usuario_updated_at' => Auth::user()->id
                        ));
            }
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
     * POST /tiporespuesta/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {
            $tiporespuestaId=Input::get('id');
            $tipoRespuesta = TipoRespuesta::find($tiporespuestaId);
            $tipoRespuesta->estado = Input::get('estado');
            $tipoRespuesta->usuario_created_at = Auth::user()->id;
            $tipoRespuesta->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('tipos_respuesta_detalle')
                    ->where('tipo_respuesta_id', $tiporespuestaId)
                    ->update(array(
                        'estado' => 0,
                        'usuario_updated_at' => Auth::user()->id
                        ));
            }
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
