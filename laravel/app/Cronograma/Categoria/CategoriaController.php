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
    public function postCargar()
    {
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';$array['usuario']=Auth::user()->id;
            $array['limit']='';$array['order']='';
            
            if (Input::has('draw')) {
                if (Input::has('order')) {
                    $inorder=Input::get('order');
                    $incolumns=Input::get('columns');
                    $array['order']=  ' ORDER BY '.
                                      $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                      $inorder[0]['dir'];
                }

                $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                $aParametro["draw"]=Input::get('draw');
            }
            /************************************************************/

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND c.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND c.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY c.nombre ";

            $cant  = Categoria::getCargarCount( $array );
            $aData = Categoria::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

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

        public function postListarc()
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
