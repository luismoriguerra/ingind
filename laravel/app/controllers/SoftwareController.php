<?php

class SoftwareController extends \BaseController
{

    /**
     * Store a newly created resource in storage.
     * POST /software/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {

            $softwares = Software::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$softwares));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /software/crear
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

            $softwares = new Software;
            $softwares['nombre'] = Input::get('nombre');
            $softwares['tabla'] = Input::get('tabla');
            $softwares['campo'] = Input::get('campo');
            $softwares['estado'] = Input::get('estado');
            $softwares['usuario_created_at'] = Auth::user()->id;
            $softwares->save();

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
     * POST /software/editar
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
            $softwareId = Input::get('id');
            $software = Software::find($softwareId);
            $software['nombre'] = Input::get('nombre');
            $software['tabla'] = Input::get('tabla');
            $software['campo'] = Input::get('campo');
            $software['estado'] = Input::get('estado');
            $software['usuario_updated_at'] = Auth::user()->id;
            $software->save();

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
     * POST /software/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $software = Software::find(Input::get('id'));
            $software->estado = Input::get('estado');
            $software->usuario_updated_at = Auth::user()->id;
            $software->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
