<?php

class MenuController extends \BaseController
{

    /**
     * cargar modulos, mantenimiento
     * POST /menu/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $menus = DB::table('menus')
                        ->select('id', 'nombre', 'class_icono', 'estado')
                        ->get();

            return Response::json(array('rst'=>1,'datos'=>$menus));
        }
    }
    /**
     * Store a newly created resource in storage.
     * POST /menu/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            
            if (Input::get('usuario_id')) {
                $usuarioId = Input::get('usuario_id');
                $menus = DB::table('submodulo_usuario as su')
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
                $menus = DB::table('menus')
                            ->select('id', 'nombre')
                            ->where('estado', '=', '1')
                            ->orderBy('nombre')
                            ->get();
            }
            
            return Response::json(array('rst'=>1,'datos'=>$menus));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /menu/crear
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

            $menus = new Menu;
            $menus['nombre'] = Input::get('nombre');
            $menus['estado'] = Input::get('estado');
            $menus['class_icono'] = Input::get('class_icono');
            $menus->save();

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
     * POST /menu/editar
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
            $menuId = Input::get('id');
            $manu = Menu::find($menuId);
            $manu['nombre'] = Input::get('nombre');
            $manu['estado'] = Input::get('estado');
            $manu['class_icono'] = Input::get('class_icono');
            $manu->save();
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
     * POST /menu/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $manu = Manu::find(Input::get('id'));
            $manu->estado = Input::get('estado');
            $manu->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
