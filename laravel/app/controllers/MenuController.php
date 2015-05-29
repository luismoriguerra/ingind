<?php

class MenuController extends \BaseController
{

    /**
     * cargar menus, mantenimiento
     * POST /menu/cargar
     *
     * @return Response
     */
    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $menus = Menu::get(Input::all());
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
            
            if (Input::get('cargo_id')) {
                $cargoId = Input::get('usuario_id');
                $menus = DB::table('cargo_opcion as co')
                        ->rightJoin(
                            'opciones as o', function($join) use ($cargoId)
                            {
                            $join->on('co.opcion_id', '=', 'o.id')
                            ->on('co.cargo_id', '=', DB::raw($cargoId));
                            }
                        )
                        ->rightJoin(
                            'menus as m', 
                            'o.menu_id', '=', 'm.id'
                        )
                        ->select('m.nombre', DB::raw('MAX(co.estado) as estado'))
                        ->where('m.estado', '=', 1)
                        ->groupBy('m.nombre')
                        ->orderBy('m.nombre')
                        ->get();
            } else {
                $menus = DB::table('menus')
                            ->select('id', 'nombre','estado as block')
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
            $menus['usuario_created_at'] = Auth::user()->id;
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
            $menu = Menu::find($menuId);
            $menu['nombre'] = Input::get('nombre');
            $menu['estado'] = Input::get('estado');
            $menu['class_icono'] = Input::get('class_icono');
            $menu['usuario_updated_at'] = Auth::user()->id;
            $menu->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('opciones')
                    ->where('menu_id', $menuId)
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
     * POST /menu/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $menu = Menu::find(Input::get('id'));
            $menu->estado = Input::get('estado');
            $menu->usuario_updated_at = Auth::user()->id;
            $menu->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('opciones')
                    ->where('menu_id', Input::get('id'))
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
