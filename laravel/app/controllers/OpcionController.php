<?php

class OpcionController extends \BaseController
{

    /**
     * cargar modulos, mantenimiento
     * POST /opcion/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $opciones = Opcion::getOpciones();
            return Response::json(array('rst'=>1,'datos'=>$opciones));
        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /opcion/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            
            if (Input::get('cargo_id')) {
                $cargoId = Input::get('cargo_id');
                $opciones = DB::table('cargo_opcion as co')
                        ->rightJoin(
                            'opciones as o', function($join) use ($cargoId)
                            {
                            $join->on('co.opcion_id', '=', 'o.id')
                            ->on('co.cargo_id', '=', DB::raw($cargoId));
                            }
                        )
                        ->select('o.id', 'o.nombre', 'co.estado')
                        ->where('o.estado', '=', 1)
                        ->get();
            } elseif (Input::get('menu_id')) {
                $menuId = Input::get('menu_id');
                $opciones = DB::table('opciones as o')
                        ->select(
                            'id',
                            'nombre',
                            'ruta'
                        )
                        ->where('menu_id','=',$menuId)
                        ->where('o.estado', '=', 1)
                        ->get();
            }
            else {
                $opciones = DB::table('opciones')
                            ->select(
                                'id',
                                'nombre',
                                'ruta',
                                DB::raw(
                                    'CONCAT("M",menu_id) as relation'
                                )
                                )
                            ->where('estado', '=', '1')
                            ->orderBy('nombre')
                            ->get();
            }
            
            return Response::json(array('rst'=>1,'datos'=>$opciones));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /opcion/crear
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

            $opciones = new Opcion;
            $opciones['nombre'] = Input::get('nombre');
            $opciones['ruta'] = Input::get('ruta');
            $opciones['menu_id'] = Input::get('menu_id');
            $opciones['estado'] = Input::get('estado');
            $opciones->save();

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
     * POST /opcion/editar
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
            $opcionId = Input::get('id');
            $opciones = Opcion::find($opcionId);
            $opciones['nombre'] = Input::get('nombre');
            $opciones['ruta'] = Input::get('ruta');
            $opciones['menu_id'] = Input::get('menu_id');
            $opciones['estado'] = Input::get('estado');
            $opciones->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('cargo_opcion')
                    ->where('opcion_id', $opcionId)
                    ->update(array('estado' => 0));
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
     * POST /opcion/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $opcion = Opcion::find(Input::get('id'));
            $opcion->estado = Input::get('estado');
            $opcion->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('cargo_opcion')
                    ->where('opcion_id', Input::get('id'))
                    ->update(array('estado' => 0));
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
