<?php

class TiempoController extends \BaseController 
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
                    $array['where'].=" AND t.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("apocope") ){
                $apocope=Input::get("apocope");
                if( trim( $apocope )!='' ){
                    $array['where'].=" AND t.apocope LIKE '%".$apocope."%' ";
                }
            }

            if( Input::has("totalminutos") ){
                $totalminutos=Input::get("totalminutos");
                if( trim( $totalminutos )!='' ){
                    $array['where'].=" AND t.totalminutos LIKE '%".$totalminutos."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND t.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY t.nombre ";

            $cant  = Tiempo::getCargarCount( $array );
            $aData = Tiempo::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    /**
     * cargar tiempos, mantenimiento
     * POST /tiempo/listar
     *
     * @return Response
     */
    public function postListar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tiempos = Tiempo::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tiempos));
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /tiempo/crear
     *
     * @return Response
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

            $tiempo = new Tiempo;
            $tiempo->nombre = Input::get('nombre');
            $tiempo->apocope = Input::get('apocope');
            if (Input::get('totalminutos')<>'') 
            $tiempo->totalminutos = Input::get('totalminutos');
            $tiempo->estado = Input::get('estado');
            $tiempo->usuario_created_at = Auth::user()->id;
            $tiempo->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'tiempo_id'=>$tiempo->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /tiempo/editar
     *
     * @return Response
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

            $tiempoId = Input::get('id');
            $tiempo = Tiempo::find($tiempoId);
            $tiempo->nombre = Input::get('nombre');
            $tiempo->apocope = Input::get('apocope');
            if (Input::get('totalminutos')<>'') 
            $tiempo->totalminutos = Input::get('totalminutos');
            $tiempo->estado = Input::get('estado');
            $tiempo->usuario_updated_at = Auth::user()->id;
            $tiempo->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /tiempo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tiempo = Tiempo::find(Input::get('id'));
            $tiempo->estado = Input::get('estado');
            $tiempo->usuario_updated_at = Auth::user()->id;
            $tiempo->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
