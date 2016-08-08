<?php

class TipoSolicitanteController extends \BaseController 
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
                    $array['where'].=" AND ts.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND ts.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY ts.nombre ";

            $cant  = TipoSolicitante::getCargarCount( $array );
            $aData = TipoSolicitante::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    /**
     * listar tiposolicitantes para select
     * POST /tiposolicitante/listar
     */
  /*  public function postListar()
    {
        if ( Request::ajax() ) {
            $tiposolicitante = TipoSolicitante::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tiposolicitante));
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

            $tiposolicitante = new TipoSolicitante;
            $tiposolicitante->nombre = Input::get('nombre');
            $tiposolicitante->estado = Input::get('estado');
            $tiposolicitante->usuario_created_at = Auth::user()->id;
            $tiposolicitante->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'tiposolicitante_id'=>$tiposolicitante->id));
        }
    }


    /**
     * Actualizar tiposolicitante
     * POST /tiposolicitante/editar
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

            $tiposolicitanteId = Input::get('id');
            $tiposolicitante = TipoSolicitante::find($tiposolicitanteId);
            $tiposolicitante->nombre = Input::get('nombre');
            $tiposolicitante->estado = Input::get('estado');
            $tiposolicitante->usuario_updated_at = Auth::user()->id;
            $tiposolicitante->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tiposolicitante = TipoSolicitante::find(Input::get('id'));
            $tiposolicitante->usuario_created_at = Auth::user()->id;
            $tiposolicitante->estado = Input::get('estado');
            $tiposolicitante->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
