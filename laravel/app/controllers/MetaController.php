<?php

class MetaController extends \BaseController
{
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }
    /**
     * cargar roles, mantenimiento
     * POST /rol/cargar
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

            if( Input::has("meta") ){
                $nombre=Input::get("meta");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND m.nombre LIKE '%".$nombre."%' ";
                }
            }
            
            if( Input::has("fecha") ){
                $fecha=Input::get("fecha");
                if( trim( $fecha )!='' ){
                    $array['where'].=" AND m.fecha = '".$fecha."' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND m.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY m.nombre ";

            $cant  = Meta::getCargarCount( $array );
            $aData = Meta::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    /**
     * cargar roles, mantenimiento
     * POST /rol/listar
     *
     * @return Response
     */
        public function postListar() {
        if (Request::ajax()) {
            $a = new Meta;
            $listar = Array();
            $listar = $a->getMeta();

            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $listar
                            )
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /rol/crear
     *
     * @return Response
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'area_id' => $required,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

//            if ( $validator->fails() ) {
//                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
//            }

            $meta = new Meta;
            $area_id = implode(",",Input::get('area_id'));
            $meta->nombre = Input::get('nombre');
            if(Input::has('fecha') AND trim(Input::get('fecha'))!=''){
                $meta->fecha = Input::get('fecha');
            } else {
                $meta->fecha = null;
            }
            $meta->area_multiple_id =$area_id;
            $meta->estado = Input::get('estado');
            $meta->usuario_created_at = Auth::user()->id;
            $meta->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'meta_id'=>$meta->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
   public function postEditar()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                 'area_id' => $required,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }
            $area_id = implode(",",Input::get('area_id'));
            $metaId = Input::get('id');
            $meta = Meta::find($metaId);
            $meta->nombre = Input::get('nombre');
            if(Input::has('fecha') AND trim(Input::get('fecha'))!=''){
                $meta->fecha = Input::get('fecha');
            } else {
                $meta->fecha = null;
            }
            $meta->area_multiple_id =$area_id;
            $meta->estado = Input::get('estado');
            $meta->usuario_updated_at = Auth::user()->id;
            $meta->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /rol/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $meta = Meta::find(Input::get('id'));
            $meta->usuario_created_at = Auth::user()->id;
            $meta->estado = Input::get('estado');
            $meta->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
