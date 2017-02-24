<?php

class PoiController extends \BaseController
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
    
       public function postListarcostopersonal()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';
            
             if( Input::has("id") ){
                $poi_id=Input::get("id");
                if( trim( $poi_id )!='' ){
                    $array['where'].=" AND pcp.poi_id=".$poi_id;
                }
            }
            $a      = new PoiCostopersonal;
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
    
       public function postListarestratpei()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';
            
             if( Input::has("id") ){
                $poi_id=Input::get("id");
                if( trim( $poi_id )!='' ){
                    $array['where'].=" AND pep.poi_id=".$poi_id;
                }
            }
            $a      = new PoiEstratpei;
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
    
       public function postListaractividad()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';
            
             if( Input::has("id") ){
                $poi_id=Input::get("id");
                if( trim( $poi_id )!='' ){
                    $array['where'].=" AND pa.poi_id=".$poi_id;
                }
            }
            $a      = new PoiActividad;
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

            $array['order']=" ORDER BY p.objetivo_general ";

            $cant  = Poi::getCargarCount( $array );
            $aData = Poi::getCargar( $array );

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
       public function postListarsestratpei()
    {
        if ( Request::ajax() ) {
            $a      = new PoiEstratpei;
            $listar = Array();
            $listar = $a->getEstratpei();

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
                'objetivo_general' => $required,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $poi = new Poi;
            $poi->objetivo_general = Input::get('objetivo_general');
            $poi->ano = Input::get('anio');
            $poi->tipo_organo = Input::get('tipo_organo');
            $poi->centro_apoyo = Input::get('centro_apoyo');
            $poi->meta_siaf = Input::get('meta_siaf');
            $poi->unidad_medida = Input::get('unidad_medida');
            $poi->cantidad_programada_semestral = Input::get('cp_semestral');
            $poi->cantidad_programada_anual = Input::get('cp_anual');
            $poi->linea_estrategica_pdlc = Input::get('linea_estrat');
            $poi->area_id = Input::get('area');
            $poi->estado = Input::get('estado');
            $poi->usuario_created_at = Auth::user()->id;
            $poi->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'poi_id'=>$poi->id));
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
                'objetivo_general' => $required,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $poiId = Input::get('id');
            $poi =Poi::find($poiId);
            $poi->objetivo_general = Input::get('objetivo_general');
            $poi->ano = Input::get('anio');
            $poi->tipo_organo = Input::get('tipo_organo');
            $poi->centro_apoyo = Input::get('centro_apoyo');
            $poi->meta_siaf = Input::get('meta_siaf');
            $poi->unidad_medida = Input::get('unidad_medida');
            $poi->cantidad_programada_semestral = Input::get('cp_semestral');
            $poi->cantidad_programada_anual = Input::get('cp_anual');
            $poi->linea_estrategica_pdlc = Input::get('linea_estrat');
            $poi->area_id = Input::get('area');
            $poi->estado = Input::get('estado');
            $poi->usuario_updated_at = Auth::user()->id;
            $poi->save();

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

            $poi = Poi::find(Input::get('id'));
            $poi->usuario_created_at = Auth::user()->id;
            $poi->estado = Input::get('estado');
            $poi->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    


    public function postCambiarestadocostopersonal()
    {

        if ( Request::ajax() ) {

            $costopersonal = PoiCostopersonal::find(Input::get('id'));
            $costopersonal->usuario_created_at = Auth::user()->id;
            $costopersonal->estado = Input::get('estado');
            $costopersonal->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
        public function postCambiarestadoestratpei()
    {

        if ( Request::ajax() ) {

            $estratpei = PoiEstratpei::find(Input::get('id'));
            $estratpei->usuario_created_at = Auth::user()->id;
            $estratpei->estado = Input::get('estado');
            $estratpei->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
        public function postCrearcostopersonal()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'modalidad' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $costopersonal = new PoiCostopersonal;
            $costopersonal->poi_id = Input::get('poi_id');
            $costopersonal->rol_id = Input::get('rol');
            $costopersonal->modalidad = Input::get('modalidad');
            $costopersonal->monto = Input::get('monto');
            $costopersonal->estimacion = Input::get('estimacion');
            $costopersonal->essalud = Input::get('essalud');
            $costopersonal->subtotal = Input::get('subtotal');
            $costopersonal->estado = Input::get('estado');
            $costopersonal->usuario_created_at = Auth::user()->id;
            $costopersonal->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'costo_personal_id'=>$costopersonal->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
   public function postEditarcostopersonal()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'modalidad' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $costopersonalId = Input::get('id');
            $costopersonal = PoiCostopersonal::find($costopersonalId);
            $costopersonal->rol_id = Input::get('rol');
            $costopersonal->modalidad = Input::get('modalidad');
            $costopersonal->monto = Input::get('monto');
            $costopersonal->estimacion = Input::get('estimacion');
            $costopersonal->essalud = Input::get('essalud');
            $costopersonal->subtotal = Input::get('subtotal');
            $costopersonal->estado = Input::get('estado');
            $costopersonal->usuario_updated_at = Auth::user()->id;
            $costopersonal->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /rol/cambiarestado
     *
     * @return Response
     */
    
            public function postCrearestratpei()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'descripcion' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $estratpei = new PoiEstratpei;
            $estratpei->poi_id = Input::get('poi_id');
            $estratpei->descripcion = Input::get('descripcion');
            $estratpei->estado = Input::get('estado');
            $estratpei->usuario_created_at = Auth::user()->id;
            $estratpei->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'estrat_pei_id'=>$estratpei->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
   public function postEditarestratpei()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'descripcion' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $estratpeiId = Input::get('id');
            $estratpei = PoiEstratpei::find($estratpeiId);
            $estratpei->descripcion = Input::get('descripcion');
            $estratpei->estado = Input::get('estado');
            $estratpei->usuario_updated_at = Auth::user()->id;
            $estratpei->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }
    
            public function postCambiarestadoactividad()
    {

        if ( Request::ajax() ) {

            $actividad = PoiActividad::find(Input::get('id'));
            $actividad->usuario_created_at = Auth::user()->id;
            $actividad->estado = Input::get('estado');
            $actividad->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }
    
        public function postCrearactividad()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'actividad' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $actividad = new PoiActividad;
            $actividad->poi_id = Input::get('poi_id');
            $actividad->poi_estrat_pei_id = Input::get('poi_estrat_pei');
            $actividad->orden = Input::get('orden');
            $actividad->actividad = Input::get('actividad');
            $actividad->unidad_medida = Input::get('unidad_medida');
            $actividad->indicador_cumplimiento = Input::get('indicador_cumplimiento');
            $actividad->estado = Input::get('estado');
            $actividad->usuario_created_at = Auth::user()->id;
            $actividad->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'actividad_id'=>$actividad->id));
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /rol/editar
     *
     * @return Response
     */
   public function postEditaractividad()
    {
        if ( Request::ajax() ) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'actividad' => $required.'|'.$regex,
            );

            $mensaje= array(
                'required' => ':attribute Es requerido',
                'regex'    => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json( array('rst'=>2, 'msj'=>$validator->messages()) );
            }

            $actividadId = Input::get('id');
            $actividad = PoiActividad::find($actividadId);
            $actividad->poi_estrat_pei_id = Input::get('poi_estrat_pei');
            $actividad->orden = Input::get('orden');
            $actividad->actividad = Input::get('actividad');
            $actividad->unidad_medida = Input::get('unidad_medida');
            $actividad->indicador_cumplimiento = Input::get('indicador_cumplimiento');
            $actividad->estado = Input::get('estado');
            $actividad->usuario_updated_at = Auth::user()->id;
            $actividad->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }
}
