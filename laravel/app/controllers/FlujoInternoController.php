<?php
class FlujoInternoController extends \BaseController
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

            if( Input::has("nombre_interno") ){
                $nombre_interno=Input::get("nombre_interno");
                if( trim( $nombre_interno )!='' ){
                    $array['where'].=" AND fi.nombre_interno LIKE '%".$nombre_interno."%' ";
                }
            }

   

            if( Input::has("nombre") ){
                $nombre=Input::get("nombre");
                if( trim( $nombre )!='' ){
                    $array['where'].=" AND fi.nombre LIKE '%".$nombre."%' ";
                }
            }

         
            if( Input::has("flujo") ){
                $flujo=Input::get("flujo");
                if( trim( $flujo )!='' ){
                    $array['where'].=" AND f.nombre LIKE '%".$flujo."%' ";
                }
            }
            

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND fi.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY fi.nombre ";

            $cant  = FlujoInterno::getCargarCount( $array );
            $aData = FlujoInterno::getCargar( $array );

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
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre_interno' => $required.'|'.$regex,
                'nombre' => $required.'|'.$regex,

            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
                'exists'       => ':attribute ya existe',
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

            $flujointernos = new FlujoInterno;
            $flujointernos['nombre_interno'] = Input::get('nombre_interno');

            $flujointernos['nombre'] = Input::get('nombre');
            
            $flujointernos['flujo_id'] = Input::get('flujo_id');
            $flujointernos['estado'] = Input::get('estado');   
            $flujointernos['usuario_created_at'] = Auth::user()->id;
            $flujointernos->save();
            $flujointernosId = $flujointernos->id;
            $estado = Input::get('estado');
            if($estado == 0){
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                )
            );
        }
        }
    }

    public function postEditar()
    {
        if ( Request::ajax() ) {
            $regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre_interno' => $required.'|'.$regex,
 
                'nombre' => $required.'|'.$regex,

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
            $flujointernoId = Input::get('id');
            $flujointerno = FlujoInterno::find($flujointernoId);
            $flujointerno['nombre_interno'] = Input::get('nombre_interno');

            $flujointerno['nombre'] = Input::get('nombre');

            $flujointerno['flujo_id'] = Input::get('flujo_id');

            $flujointerno['estado'] = Input::get('estado');

            $flujointerno['usuario_updated_at'] = Auth::user()->id;
            $flujointerno->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );
        }
    }


    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $flujointerno = FlujoInterno::find(Input::get('id'));
            $flujointerno->usuario_created_at = Auth::user()->id;
            $flujointerno->estado = Input::get('estado');
            $flujointerno->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
