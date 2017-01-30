<?php

class ContratacionController extends \BaseController
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
     * cargar verbos, mantenimiento
     * POST /rol/cargar
     *
     * @return Response
     */
    
       public function postListardetallecontratacion()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';
            
             if( Input::has("id") ){
                $contratacion_id=Input::get("id");
                if( trim( $contratacion_id )!='' ){
                    $array['where'].=" AND cr.contratacion_id=".$contratacion_id;
                }
            }
            $a      = new DetalleContratacion;
            $listar = Array();
            $listar = $a->getCargar($array);

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }
    
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

            if( Input::has("titulo") ){
                $titulo=Input::get("titulo");
                if( trim( $titulo )!='' ){
                    $array['where'].=" AND c.titulo LIKE '%".$titulo."%' ";
                }
            }
            if( Input::has("monto_total") ){
                $monto_total=Input::get("monto_total");
                if( trim( $monto_total )!='' ){
                    $array['where'].=" AND c.monto_total LIKE '%".$monto_total."%' ";
                }
            }
            if( Input::has("fecha_conformidad") ){
                $fecha_conformidad=Input::get("fecha_conformidad");
                if( trim( $fecha_conformidad )!='' ){
                    $array['where'].=" AND c.fecha_conformidad LIKE '%".$fecha_conformidad."%' ";
                }
            }
            
            if( Input::has("fecha_aviso") ){
                $fecha_aviso=Input::get("fecha_aviso");
                if( trim( $fecha_aviso )!='' ){
                    $array['where'].=" AND c.fecha_aviso LIKE '%".$fecha_aviso."%' ";
                }
            }
            
            if( Input::has("fecha_inicio") ){
                $fecha_inicio=Input::get("fecha_inicio");
                if( trim( $fecha_inicio )!='' ){
                    $array['where'].=" AND c.fecha_inicio LIKE '%".$fecha_inicio."%' ";
                }
            }
            
            if( Input::has("fecha_fin") ){
                $fecha_fin=Input::get("fecha_fin");
                if( trim( $fecha_fin )!='' ){
                    $array['where'].=" AND c.fecha_fin LIKE '%".$fecha_fin."%' ";
                }
            }
            
            if( Input::has("area") ){
                $area=Input::get("area");
                if( trim( $area )!='' ){
                    $array['where'].=" AND a.nombre LIKE '%".$area."%' ";
                }
            }
            
            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND c.estado='".$estado."' ";
                }
            }
            
            if( Input::has("area_usuario") ){
                $area_usuario=Auth::user()->area_id;
                    $array['where'].=" AND a.id=".$area_usuario;
          
            }

            $array['order']=" ORDER BY c.titulo ";

            $cant  = Contratacion::getCargarCount( $array );
            $aData = Contratacion::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    /**
     * cargar verbos, mantenimiento
     * POST /rol/listar
     *
     * @return Response
     */
   public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new Contratacion;
            $listar = Array();
            $listar = $a->getContratacion();

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
                'titulo' => $required,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $contratacion = new Contratacion;
            $contratacion->titulo = Input::get('titulo');
            $contratacion->monto_total = Input::get('monto_total');
            $contratacion->objeto = Input::get('objeto');
            $contratacion->justificacion = Input::get('justificacion');
            $contratacion->actividades = Input::get('actividades');
            $contratacion->fecha_inicio = Input::get('fecha_inicio');
            $contratacion->fecha_fin = Input::get('fecha_fin');
            $contratacion->fecha_aviso = Input::get('fecha_aviso');
            $contratacion->programacion_aviso = Input::get('programacion_aviso');
            $contratacion->nro_doc = Input::get('nro_doc');
            $contratacion->area_id = Input::get('area');
            $contratacion->estado = Input::get('estado');
            $contratacion->usuario_created_at = Auth::user()->id;
            $contratacion->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'contratacion_id'=>$contratacion->id));
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
                'titulo' => $required,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $contratacionId = Input::get('id');
            $contratacion = Contratacion::find($contratacionId);
            $contratacion->titulo = Input::get('titulo');
            $contratacion->monto_total = Input::get('monto_total');
            $contratacion->objeto = Input::get('objeto');
            $contratacion->justificacion = Input::get('justificacion');
            $contratacion->actividades = Input::get('actividades');
            $contratacion->fecha_inicio = Input::get('fecha_inicio');
            $contratacion->fecha_fin = Input::get('fecha_fin');
            $contratacion->fecha_aviso = Input::get('fecha_aviso');
            $contratacion->programacion_aviso = Input::get('programacion_aviso');
            $contratacion->nro_doc = Input::get('nro_doc');
            $contratacion->area_id = Input::get('area');
            $contratacion->estado = Input::get('estado');
            $contratacion->usuario_updated_at = Auth::user()->id;
            $contratacion->save();

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

            $contratacion = Contratacion::find(Input::get('id'));
            $contratacion->usuario_created_at = Auth::user()->id;
            $contratacion->estado = Input::get('estado');
            $contratacion->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
    public function postConfirmardetalle()
    {

        if ( Request::ajax() ) {

            $detallecontratacion = DetalleContratacion::find(Input::get('id'));
            $detallecontratacion->usuario_updated_at = Auth::user()->id;
            $detallecontratacion->fecha_conformidad =date('Y-m-d');
            $detallecontratacion->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
    public function postDenegardetalle()
    {

        if ( Request::ajax() ) {

            $detallecontratacion = DetalleContratacion::find(Input::get('id'));
            $detallecontratacion->usuario_updated_at = Auth::user()->id;
            $detallecontratacion->nro_doc = '';
            $detallecontratacion->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
    public function postConfirmar()
    {

        if ( Request::ajax() ) {

            $contratacion = Contratacion::find(Input::get('id'));
            $contratacion->usuario_updated_at = Auth::user()->id;
            $contratacion->fecha_conformidad =date('Y-m-d');
            $contratacion->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
     public function postEditarnrodoc()
    {

        if ( Request::ajax() ) {

            $contratacion = Contratacion::find(Input::get('id'));
            $contratacion->usuario_updated_at = Auth::user()->id;
            $contratacion->nro_doc =Input::get('nro_doc');
            $contratacion->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
     public function postEditarnrodocdetalle()
    {

        if ( Request::ajax() ) {

            $detallecontratacion = DetalleContratacion::find(Input::get('id'));
            
            $detallecontratacion->usuario_updated_at = Auth::user()->id;
            $detallecontratacion->nro_doc =Input::get('nro_doc');
            $detallecontratacion->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
    public function postDenegar()
    {

        if ( Request::ajax() ) {

            $contratacion = Contratacion::find(Input::get('id'));
            $contratacion->usuario_updated_at = Auth::user()->id;
            $contratacion->nro_doc ='';
            $contratacion->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
    public function postCambiarestadodetalle()
    {

        if ( Request::ajax() ) {

            $detallecontratacion = DetalleContratacion::find(Input::get('id'));
            $detallecontratacion->usuario_created_at = Auth::user()->id;
            $detallecontratacion->estado = Input::get('estado');
            $detallecontratacion->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
        public function postCreardetalle()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'texto' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $contratacion = new DetalleContratacion();
            $contratacion->texto = Input::get('texto');
            $contratacion->contratacion_id = Input::get('contratacion_id');
            $contratacion->fecha_inicio = Input::get('fecha_inicio');
            $contratacion->fecha_fin = Input::get('fecha_fin');
            $contratacion->fecha_aviso = Input::get('fecha_aviso');
            $contratacion->monto = Input::get('monto');
            $contratacion->programacion_aviso = Input::get('programacion_aviso');
            $contratacion->nro_doc = '';
            $contratacion->tipo = Input::get('tipo');
            $contratacion->usuario_created_at = Auth::user()->id;
            $contratacion->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'contratacion_id'=>$contratacion->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
   public function postEditardetalle()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'texto' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $DetallecontratacionId = Input::get('id');
            $Detallecontratacion = DetalleContratacion::find($DetallecontratacionId);
            $Detallecontratacion->texto = Input::get('texto');
            $Detallecontratacion->monto = Input::get('monto');
            $Detallecontratacion->fecha_inicio = Input::get('fecha_inicio');
            $Detallecontratacion->fecha_fin = Input::get('fecha_fin');
            $Detallecontratacion->fecha_aviso = Input::get('fecha_aviso');
            $Detallecontratacion->programacion_aviso = Input::get('programacion_aviso');
            $Detallecontratacion->tipo = Input::get('tipo');
            $Detallecontratacion->usuario_updated_at = Auth::user()->id;
            $Detallecontratacion->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /rol/cambiarestado
     *
     * @return Response
     */

}
