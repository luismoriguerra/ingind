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
            $menuId = Input::get('id');
            $menu = Menu::find($menuId);
            $menu['nombre'] = Input::get('nombre');
            $menu['estado'] = Input::get('estado');
            $menu['class_icono'] = Input::get('class_icono');
            $menu->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('opciones')
                    ->where('menu_id', $menuId)
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
     * POST /software/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $software = Software::find(Input::get('id'));
            $software->estado = Input::get('estado');
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
