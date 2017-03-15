<?php

class TipoTramiteController extends \BaseController
{
    protected $_errorController;

    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }
    
           public function postListartipotramite()
    {
        if ( Request::ajax() ) {
            
            $a      = new TipoTramite;
            $listar = Array();
            $listar = $a->getCargar_tipo();

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

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND tt.nombre_tipo_tramite LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND tt.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY tt.nombre_tipo_tramite ";

            $cant  = TipoTramite::getCargarCount( $array );
            $aData = TipoTramite::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    
   public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new TipoTramite;
            $listar = Array();
            $listar = $a->getTipoTramite();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
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

            $tipotramite = new TipoTramite;
            $tipotramite->nombre_tipo_tramite = Input::get('nombre');
            $tipotramite->estado = Input::get('estado');
            $tipotramite->usuario_created_at = Auth::user()->id;
            $tipotramite->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'tipotramite_id'=>$tipotramite->id));
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

            $tipotramiteId = Input::get('id');
            $tipotramite = TipoTramite::find($tipotramiteId);
            $tipotramite->nombre_tipo_tramite = Input::get('nombre');
            $tipotramite->estado = Input::get('estado');
            $tipotramite->usuario_updated_at = Auth::user()->id;
            $tipotramite->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $tipotramite = TipoTramite::find(Input::get('id'));
            $tipotramite->usuario_created_at = Auth::user()->id;
            $tipotramite->estado = Input::get('estado');
            $tipotramite->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
