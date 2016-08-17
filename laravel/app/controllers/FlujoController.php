<?php
class FlujoController extends \BaseController
{

    /**
     * cargar flujos, mantenimiento
     * POST /flujo/cargar
     *
     * @return Response
     */
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
                    $array['where'].=" AND f.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("area") ){
                $area=Input::get("area");
                if( trim( $area )!='' ){
                    $array['where'].=" AND a.nombre LIKE '%".$area."%' ";
                }
            }

            if( Input::has("categoria") ){
                $categoria=Input::get("categoria");
                if( trim( $categoria )!='' ){
                    $array['where'].=" AND c.nombre LIKE '%".$categoria."%' ";
                }
            }

            if( Input::has("tipo_flujo") ){
                $tipo_flujo=Input::get("tipo_flujo");
                if( trim( $tipo_flujo )!='' ){
                    $array['where'].=" AND f.tipo_flujo='".$tipo_flujo."' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND f.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY f.nombre ";

            $cant  = Flujo::getCargarCount( $array );
            $aData = Flujo::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    /**
     * cargar flujos, mantenimiento
     * POST /flujo/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            $f      = new Flujo();
            $listar = Array();
            $listar = $f->getFlujo();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

/**
     * Store a newly created resource in storage.
     * POST /flujo/crear
     *
     * @return Response
     */
    public function postCrear()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required,
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

            $flujos = new Flujo;
            $flujos['nombre'] = Input::get('nombre');
            $flujos['estado'] = Input::get('estado');
            $flujos['area_id'] = Input::get('area_id');
            $flujos['tipo_flujo'] = Input::get('tipo');
            $flujos['categoria_id'] = Input::get('categoria_id');
            $flujos['usuario_created_at'] = Auth::user()->id;
            $flujos->save();

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
     * POST /flujo/editar
     *
     * @return Response
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            //$regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required,
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
            $flujoId = Input::get('id');
            $flujo = Flujo::find($flujoId);
            $flujo['nombre'] = Input::get('nombre');
            $flujo['area_id'] = Input::get('area_id');
            $flujo['tipo_flujo'] = Input::get('tipo_flujo');
            $flujo['categoria_id'] = Input::get('categoria_id');
            $flujo['estado'] = Input::get('estado');
            $flujo['usuario_updated_at'] = Auth::user()->id;
            $flujo->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('flujo_tipo_respuesta')
                    ->where('flujo_id', $flujoId)
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
     * POST /flujo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $flujo = Flujo::find(Input::get('id'));
            $flujo->usuario_created_at = Auth::user()->id;
            $flujo->estado = Input::get('estado');
            $flujo->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('flujo_tipo_respuesta')
                    ->where('flujo_id', Input::get('id'))
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
