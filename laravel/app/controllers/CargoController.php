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
            $cargos = Cargo::get(Input::all());
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
                        ->select(
                            'm.nombre',
                            DB::raw('MAX(su.estado) as estado')
                        )
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

            $cargo = new Cargo;
            $cargo->nombre = Input::get('nombre');
            $cargo->estado = Input::get('estado');
            $cargo->usuario_created_at = Auth::user()->id;
            $cargo->save();

            $menus = Input::get('menus_selec');
            $estado = Input::get('estado');
            if ($estado == 0 ) {
                return Response::json(
                    array(
                    'rst'=>1,
                    'msj'=>'Registro actualizado correctamente',
                    )
                );
            }
            if ($menus) {//si selecciono algun menu
                $menus = explode(',', $menus);
                $opciones = array();
                $opcionId = array();
                for ($i=0; $i<count($menus); $i++) {
                    $menuId = $menus[$i];
                    //almacenar las opciones seleccionadas
                    $opciones[] = Input::get('opciones'.$menuId);
                }
                for ($i=0; $i<count($opciones); $i++) {
                    for ($j=0; $j <count($opciones[$i]); $j++) {
                        //buscar la opcion en ls BD
                        $opcionId[] = $opciones[$i][$j];
                    }
                }

                for ($i=0; $i<count($opcionId); $i++) {
                    $opcion = Opcion::find($opcionId[$i]);
                    $cargo->opciones()->save(
                        $opcion, array('estado' => 1)
                    );
                }
            }


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
            $cargos->usuario_updated_at = Auth::user()->id;
            $cargos->save();
            
            $menus = Input::get('menus_selec');
            $estado = Input::get('estado');

            DB::table('cargo_opcion')
                    ->where('cargo_id', $cargoId)
                    ->update(
                        array(
                            'estado' => 0,
                            'usuario_updated_at' => Auth::user()->id
                            )
                        );

            if ($estado == 0 ) {
                return Response::json(
                    array(
                    'rst'=>1,
                    'msj'=>'Registro actualizado correctamente',
                    )
                );
            }

            if ($menus) {//si selecciono algun menu

                $menus = explode(',', $menus);
                $opciones=array();

                for ($i=0; $i<count($menus); $i++) {
                    $menuId = $menus[$i];
                    //almacenar las opciones seleccionadas
                    $opciones[] = Input::get('opciones'.$menuId);
                }

                for ($i=0; $i<count($opciones); $i++) {
                    for ($j=0; $j <count($opciones[$i]); $j++) {
                        //buscar la opcion en ls BD
                        $opcionId = $opciones[$i][$j];
                        $opcion = Opcion::find($opcionId);
                        $cargoOpciones = DB::table('cargo_opcion')
                            ->where('cargo_id', '=', $cargoId)
                            ->where('opcion_id', '=', $opcionId)
                            ->first();
                        if (is_null($cargoOpciones)) {
                            $cargos->opciones()->save(
                                $opcion, array('estado' => 1,'usuario_created_at' => Auth::user()->id)
                            );
                        } else {
                            //update a la tabla cargo_opcion
                            DB::table('cargo_opcion')
                                ->where('cargo_id', '=', $cargoId)
                                ->where('opcion_id', '=', $opcionId)
                                ->update(array(
                                    'estado' => 1,
                                    'usuario_updated_at' => Auth::user()->id
                                    )
                                );
                        }
                    }
                }
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
     * POST /cargo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {
            $estado = Input::get('estado');
            $cargoId = Input::get('id');
            $cargo = Cargo::find($cargoId);
            $cargo->usuario_updated_at = Auth::user()->id;
            $cargo->estado = Input::get('estado');
            $cargo->save();

            //estado 0, en la tabla cargo_opcion, para este cargo
            if ($estado == 0) {
                DB::table('cargo_opcion')
                    ->where('cargo_id', $cargoId)
                    ->update(
                        array(
                            'estado' => $estado,
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
