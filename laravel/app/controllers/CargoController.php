<?php

class CargoController extends \BaseController
{

    /**
     * cargar modulos, mantenimiento
     * POST /cargo/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $cargos = DB::table('cargos')
                        ->select('id', 'nombre', 'estado')
                        ->get();
            return Response::json(array('rst'=>1,'datos'=>$cargos));
        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /cargo/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            
            if (Input::get('usuario_id')) {
                $usuarioId = Input::get('usuario_id');
                $cargos = DB::table('submodulo_usuario as su')
                        ->rightJoin(
                            'submodulos as s', function($join) use ($usuarioId)
                            {
                            $join->on('su.submodulo_id', '=', 's.id')
                            ->on('su.usuario_id', '=', DB::raw($usuarioId));
                            }
                        )
                        ->rightJoin(
                            'modulos as m', 
                            's.modulo_id', '=', 'm.id'
                        )
                        ->select('m.nombre', DB::raw('MAX(su.estado) as estado'))
                        ->where('m.estado', '=', 1)
                        ->groupBy('m.nombre')
                        ->orderBy('m.nombre')
                        ->get();
            } else {
                $cargos = DB::table('cargos')
                            ->select('id', 'nombre')
                            ->where('estado', '=', '1')
                            ->orderBy('nombre')
                            ->get();
            }
            
            return Response::json(array('rst'=>1,'datos'=>$cargos));
        }
    }
        /**
     * Store a newly created resource in storage.
     * POST /cargo/cargaropciones
     *
     * @return Response
     */
    public function postCargaropciones()
    {
        $cargoId = Input::get('cargo_id');
        $cargo = new Cargo;
        $opciones = $cargo->getOpciones($cargoId);
        return Response::json(array('rst'=>1,'datos'=>$opciones));
    }
    /**
     * Store a newly created resource in storage.
     * POST /cargo/crear
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

            $modulos = new Cargo;
            $modulos->nombre = Input::get('nombre');
            $modulos->estado = Input::get('estado');
            $modulos->save();

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
     * POST /cargo/editar
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
            $cargoId = Input::get('id');
            $cargos = Cargo::find($cargoId);
            $cargos->nombre = Input::get('nombre');
            $cargos->estado = Input::get('estado');
            $cargos->save();
            /*if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('submodulos')
                    ->where('modulo_id', $moduloId)
                    ->update(array('estado' => 0));
            }*/
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
     * POST /cargo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $cargo = Cargo::find(Input::get('id'));
            $cargo->estado = Input::get('estado');
            $cargo->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
