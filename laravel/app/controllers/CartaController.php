<?php

class CartaController extends \BaseController
{
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $r = Carta::Cargar();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    /*public function postCrear()
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

            $documento = new Documento;
            $documento['nombre'] = Input::get('nombre');
            $documento['estado'] = Input::get('estado');
            $documento['usuario_created_at'] = Auth::user()->id;
            $documento->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                )
            );
        }
    }*/
}
