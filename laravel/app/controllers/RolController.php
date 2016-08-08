<?php

class RolController extends \BaseController 
{
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
                    $array['where'].=" AND r.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND r.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY r.nombre ";

            $cant  = Rol::getCargarCount( $array );
            $aData = Rol::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    /**
     * listar rols para select
     * POST /rol/listar
     */
  /*  public function postListar()
    {
        if ( Request::ajax() ) {
            $rol = Rol::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$rol));
        }
    }
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

            $rol = new Rol;
            $rol->nombre = Input::get('nombre');
            $rol->estado = Input::get('estado');
            $rol->usuario_created_at = Auth::user()->id;
            $rol->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'rol_id'=>$rol->id));
        }
    }


    /**
     * Actualizar rol
     * POST /rol/editar
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

            $rolId = Input::get('id');
            $rol = Rol::find($rolId);
            $rol->nombre = Input::get('nombre');
            $rol->estado = Input::get('estado');
            $rol->usuario_updated_at = Auth::user()->id;
            $rol->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $rol = Rol::find(Input::get('id'));
            $rol->usuario_created_at = Auth::user()->id;
            $rol->estado = Input::get('estado');
            $rol->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
