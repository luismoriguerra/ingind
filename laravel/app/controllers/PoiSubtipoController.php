<?php

class PoiSubtipoController extends \BaseController
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
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';
            
            if( Input::has("id") ){
                $tipo_id=Input::get("id");
                if( trim( $tipo_id )!='' ){
                    $array['where'].=" AND ps.tipo_id=".$tipo_id;
                }
            }
            $a      = new PoiSubtipo;
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
    /**
     * cargar verbos, mantenimiento
     * POST /rol/listar
     *
     * @return Response
     */
   public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new PoiSubtipo;
            $listar = Array();
            $listar = $a->getPoiSubtipo();

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

            $poi_subtipo = new PoiSubtipo;
            $poi_subtipo->nombre = Input::get('nombre');
            $poi_subtipo->estado = Input::get('estado');
            $poi_subtipo->tipo_id = Input::get('tipo_id');
            $poi_subtipo->color = Input::get('color');
            $poi_subtipo->tamano = Input::get('tamano');
            $poi_subtipo->costo_actual = Input::get('costo_actual');
            $poi_subtipo->usuario_created_at = Auth::user()->id;
            $poi_subtipo->save();
            
            
            $update='update poi_subtipos_historico set ultimo=0
                     where subtipo_id='.$poi_subtipo->id;
                     DB::update($update); 
                     
            $poi_subtipo_h= new PoiSubtipohistorico;
            
            $poi_subtipo_h->subtipo_id = $poi_subtipo->id;
            $poi_subtipo_h->costo = Input::get('costo_actual');
            $poi_subtipo_h->color = Input::get('color');
            $poi_subtipo_h->tamano = Input::get('tamano');
            $poi_subtipo_h->fecha_cambio = date("Y-m-d h:m:s");
            $poi_subtipo_h->usuario_created_at = Auth::user()->id;
            $poi_subtipo_h->save();
            
            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'poi_subtipo_id'=>$poi_subtipo->id));
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

            $poi_subtipoId = Input::get('id');
            $poi_subtipo = PoiSubtipo::find($poi_subtipoId);
            $poi_subtipo->nombre = Input::get('nombre');
            $poi_subtipo->estado = Input::get('estado');
            $poi_subtipo->color = Input::get('color');
            $poi_subtipo->tamano = Input::get('tamano');
            $poi_subtipo->costo_actual = Input::get('costo_actual');
            $poi_subtipo->usuario_updated_at = Auth::user()->id;
            $poi_subtipo->save();
            
            $update='update poi_subtipos_historico set ultimo=0
                     where subtipo_id='.$poi_subtipo->id;
                     DB::update($update); 
                     
            $poi_subtipo_h= new PoiSubtipohistorico;
            $poi_subtipo_h->subtipo_id = $poi_subtipo->id;
            $poi_subtipo_h->costo = Input::get('costo_actual');
            $poi_subtipo_h->fecha_cambio = date("Y-m-d h:m:s");
            $poi_subtipo_h->color = Input::get('color');
            $poi_subtipo_h->tamano = Input::get('tamano');
            $poi_subtipo_h->usuario_updated_at = Auth::user()->id;
            
            $poi_subtipo_h->save();
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

            $poi_subtipo = PoiSubtipo::find(Input::get('id'));
            $poi_subtipo->usuario_created_at = Auth::user()->id;
            $poi_subtipo->estado = Input::get('estado');
            $poi_subtipo->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
