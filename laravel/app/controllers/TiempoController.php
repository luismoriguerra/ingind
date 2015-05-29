<?php

class TiempoController extends \BaseController
{

    /**
     * cargar tiempos, mantenimiento
     * POST /tiempo/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tiempos = Tiempo::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tiempos));
        }
    }
    /**
     * cargar tiempos, mantenimiento
     * POST /tiempo/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tiempos = Tiempo::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tiempos));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /tiempo/crear
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

            $tiempos = new Tiempo;
            $tiempos['nombre'] = Input::get('nombre');
            $tiempos['apocope'] = Input::get('apocope');
            $tiempos['totalminutos'] = Input::get('minutos');
            $tiempos['estado'] = Input::get('estado');
            $tiempos['usuario_created_at'] = Auth::user()->id;
            $tiempos->save();

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
     * POST /tiempo/editar
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
            $tiempoId = Input::get('id');
            $tiempo = Tiempo::find($tiempoId);
            $tiempo['nombre'] = Input::get('nombre');
            $tiempo['apocope'] = Input::get('apocope');
            $tiempo['totalminutos'] = Input::get('minutos');
            $tiempo['estado'] = Input::get('estado');
            $tiempo['usuario_updated_at'] = Auth::user()->id;
            $tiempo->save();

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
     * POST /tiempo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tiempo = Tiempo::find(Input::get('id'));
            $tiempo->estado = Input::get('estado');
            $tiempo->usuario_updated_at = Auth::user()->id;
            $tiempo->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
