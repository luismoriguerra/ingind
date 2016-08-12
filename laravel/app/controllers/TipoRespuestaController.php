<?php

class TipoRespuestaController extends \BaseController 
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
                    $array['where'].=" AND tr.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("tiempo") ){
                $tiempo=Input::get("tiempo");
                if( trim( $tiempo )!='' ){
                    $array['where'].=" AND tr.tiempo='".$tiempo."' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND tr.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY tr.nombre ";

            $cant  = TipoRespuesta::getCargarCount( $array );
            $aData = TipoRespuesta::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }


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

            $tiporespuesta = new TipoRespuesta;
            $tiporespuesta->nombre = Input::get('nombre');
            $tiporespuesta->tiempo =Input::get('tiempo');
            $tiporespuesta->estado = Input::get('estado');
            $tiporespuesta->usuario_created_at = Auth::user()->id;
            $tiporespuesta->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'tiporespuesta_id'=>$tiporespuesta->id));
        }
    }

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

            $tiporespuestaId = Input::get('id');
            $tiporespuesta = TipoRespuesta::find($tiporespuestaId);
            $tiporespuesta->nombre = Input::get('nombre');
            $tiporespuesta->tiempo = Input::get('tiempo');
            $tiporespuesta->estado = Input::get('estado');
            $tiporespuesta->usuario_updated_at = Auth::user()->id;
            $tiporespuesta->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tiporespuesta = TipoRespuesta::find(Input::get('id'));
            $tiporespuesta->usuario_created_at = Auth::user()->id;
            $tiporespuesta->estado = Input::get('estado');
            $tiporespuesta->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
