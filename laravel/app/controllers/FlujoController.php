<?php
class FlujoController extends \BaseController
{

    /**
     * cargar flujos, mantenimiento
     * POST /flujo/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $f      = new Flujo();
            $listar = Array();
            $listar = $f->getFlujo();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    /**
     * cargar flujos, mantenimiento
     * POST /flujo/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            $f      = new Flujo();
            $listar = Array();
            $listar = $f->getFlujo();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

/**
     * Store a newly created resource in storage.
     * POST /flujo/crear
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

            $flujos = new Flujo;
            $flujos['nombre'] = Input::get('nombre');
            $flujos['estado'] = Input::get('estado');
            $flujos['area_id'] = Input::get('area_id');
            $flujos['tipo_flujo'] = Input::get('tipo');
            $flujos['usuario_created_at'] = Auth::user()->id;
            $flujos->save();

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
     * POST /flujo/editar
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
            $flujoId = Input::get('id');
            $flujo = Flujo::find($flujoId);
            $flujo['nombre'] = Input::get('nombre');
            $flujo['area_id'] = Input::get('area_id');
            $flujo['tipo_flujo'] = Input::get('tipo');
            $flujo['estado'] = Input::get('estado');
            $flujo['usuario_updated_at'] = Auth::user()->id;
            $flujo->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('flujo_tipo_respuesta')
                    ->where('flujo_id', $flujoId)
                    ->update(
                        array(
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
     * POST /flujo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $flujo = Flujo::find(Input::get('id'));
            $flujo->usuario_created_at = Auth::user()->id;
            $flujo->estado = Input::get('estado');
            $flujo->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('flujo_tipo_respuesta')
                    ->where('flujo_id', Input::get('id'))
                    ->update(
                        array(
                            'estado' => 0,
                            'usuario_updated_at' => Auth::user()->id
                        )
                    );
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
