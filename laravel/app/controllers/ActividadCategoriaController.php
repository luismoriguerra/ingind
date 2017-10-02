<?php

class ActividadCategoriaController extends \BaseController
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
     * POST /ActividadCategoria/cargar
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

            if( Input::has("area") ){
                $area=Input::get("area");
                if( trim( $area )!='' ){
                    $array['where'].=" AND vv.nombre LIKE '%".$area."%' ";
                }
            }

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND v.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND v.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY v.nombre ";

            $cant  = ActividadCategoria::getCargarCount( $array );
            $aData = ActividadCategoria::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    /**
     * cargar ActividadCategoriaes, mantenimiento
     * POST /ActividadCategoria/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new ActividadCategoria;
            $listar = Array();
            $listar = $a->getListar();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    /*
    public function postListar(){
		if ( Request::ajax() ) {
			//$bien = new ActividadCategoria;
            $listar = ActividadCategoria::getListar();
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
	}
	*/

    /**
     * Store a newly created resource in storage.
     * POST /ActividadCategoria/crear
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

            $ActividadCategoria = new ActividadCategoria;
            $ActividadCategoria->area_id = Input::get('area_id');
            $ActividadCategoria->nombre = Input::get('nombre');
            $ActividadCategoria->estado = Input::get('estado');
            $ActividadCategoria->usuario_created_at = Auth::user()->id;
            $ActividadCategoria->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'ActividadCategoria_id'=>$ActividadCategoria->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /ActividadCategoria/editar
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

            $ActividadCategoriaId = Input::get('id');
            $ActividadCategoria = ActividadCategoria::find($ActividadCategoriaId);
            $ActividadCategoria->area_id = Input::get('area_id');
            $ActividadCategoria->nombre = Input::get('nombre');
            $ActividadCategoria->estado = Input::get('estado');
            $ActividadCategoria->usuario_updated_at = Auth::user()->id;
            $ActividadCategoria->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /ActividadCategoria/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $ActividadCategoria = ActividadCategoria::find(Input::get('id'));
            $ActividadCategoria->usuario_created_at = Auth::user()->id;
            $ActividadCategoria->estado = Input::get('estado');
            $ActividadCategoria->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
