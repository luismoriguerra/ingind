<?php

class TipoRecursoController extends \BaseController 
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

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND tr.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY tr.nombre ";

            $cant  = TipoRecurso::getCargarCount( $array );
            $aData = TipoRecurso::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    /**
     * listar tiporecursos para select
     * POST /tiporecurso/listar
     */
  /*  public function postListar()
    {
        if ( Request::ajax() ) {
            $tiporecurso = TipoRecurso::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tiporecurso));
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

            $tiporecurso = new TipoRecurso;
            $tiporecurso->nombre = Input::get('nombre');
            $tiporecurso->estado = Input::get('estado');
            $tiporecurso->usuario_created_at = Auth::user()->id;
            $tiporecurso->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'tiporecurso_id'=>$tiporecurso->id));
        }
    }


    /**
     * Actualizar tiporecurso
     * POST /tiporecurso/editar
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

            $tiporecursoId = Input::get('id');
            $tiporecurso = TipoRecurso::find($tiporecursoId);
            $tiporecurso->nombre = Input::get('nombre');
            $tiporecurso->estado = Input::get('estado');
            $tiporecurso->usuario_updated_at = Auth::user()->id;
            $tiporecurso->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tiporecurso = TipoRecurso::find(Input::get('id'));
            $tiporecurso->usuario_created_at = Auth::user()->id;
            $tiporecurso->estado = Input::get('estado');
            $tiporecurso->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
