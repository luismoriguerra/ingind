<?php
namespace Cronograma\Categoria;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Categoria;

class CategoriaController extends \BaseController {

    /**
     * cargar categorias
     * POST /categoria/cargar
     */
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $categoria = Categoria::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$categoria));
        }
    }

    /**
     * listar categorias para select
     * POST /categoria/listar
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            $categoria = Categoria::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$categoria));
        }
    }

    /**
     * Crear categoria
     * POST /categoria/crear
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'nombre' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $categoria = new Categoria;
            $categoria->nombre = Input::get('nombre');
            $categoria->estado = Input::get('estado');
            $categoria->usuario_created_at = Auth::user()->id;
            $categoria->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'categoria_id'=>$categoria->id));
        }
    }


    /**
     * Actualizar categoria
     * POST /categoria/editar
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'nombre' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $categoriaId = Input::get('id');
            $categoria = Categoria::find($categoriaId);
            $categoria->nombre = Input::get('nombre');
            $categoria->estado = Input::get('estado');
            $categoria->usuario_updated_at = Auth::user()->id;
            $categoria->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Cambiar estado
     * POST /categoria/cambiarestado
     */
    public function postCambiarestado()
    {
        if ( Request::ajax() ) {
            $categoriaId = Input::get('id');
            $categoria = Categoria::find($categoriaId);
            $categoria->usuario_updated_at = Auth::user()->id;
            $categoria->estado = Input::get('estado');
            $categoria->save();
            if (Input::get('estado') == 0) {
                DB::table('categorias')
                    ->where('id','=',$categoriaId)
                    ->update(
                            array(
                                'estado' => 0,
                                'usuario_updated_at' => Auth::user()->id
                                )
                        );
            }
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente') );
        }
    }

}
