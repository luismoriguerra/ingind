<?php

class TipoSolicitanteController extends \BaseController
{
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }
    /**
     * cargar TipoSolicitante, mantenimiento
     * POST /tiposolicitante/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tiposol = TipoSolicitante::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tiposol));
        }
    }
    /**
     * cargar TipoSolicitante, mantenimiento
     * POST /tiposolicitante/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            $tiposol      = TipoSolicitante::getTipoSolicitante();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $tiposol
                )
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /tiposolicitante/crear
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

            $tiposol = new TipoSolicitante;
            $tiposol['nombre'] = Input::get('nombre');
            $tiposol['estado'] = Input::get('estado');
            $tiposol['usuario_created_at'] = Auth::user()->id;
            $tiposol->save();

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
     * POST /tiposolicitante/editar
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
            $tiposolId = Input::get('id');
            $tiposol = TipoSolicitante::find($tiposolId);
            $tiposol['nombre'] = Input::get('nombre');
            $tiposol['estado'] = Input::get('estado');
            $tiposol['usuario_updated_at'] = Auth::user()->id;
            $tiposol->save();

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
     * POST /tiposolicitante/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tiposol = TipoSolicitante::find(Input::get('id'));
            $tiposol['estado'] = Input::get('estado');
            $tiposol['usuario_updated_at'] = Auth::user()->id;
            $tiposol->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );
        }
    }

}
