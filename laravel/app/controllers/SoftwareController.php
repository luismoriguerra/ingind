<?php

class SoftwareController extends \BaseController 
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
                    $array['where'].=" AND s.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("tabla") ){
                $tabla=Input::get("tabla");
                if( trim( $tabla )!='' ){
                    $array['where'].=" AND s.tabla LIKE '%".$tabla."%' ";
                }
            }

            if( Input::has("campo") ){
                $campo=Input::get("campo");
                if( trim( $campo )!='' ){
                    $array['where'].=" AND s.campo LIKE '%".$campo."%' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND s.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY s.nombre ";

            $cant  = Software::getCargarCount( $array );
            $aData = Software::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    /**
     * listar softwares para select
     * POST /software/listar
     */
  /*  public function postListar()
    {
        if ( Request::ajax() ) {
            $software = Software::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$software));
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

            $software = new Software;
            $software->nombre = Input::get('nombre');
            $software->tabla = Input::get('tabla');
            $software->campo = Input::get('campo');
            $software->estado = Input::get('estado');
            $software->usuario_created_at = Auth::user()->id;
            $software->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente', 'software_id'=>$software->id));
        }
    }


    /**
     * Actualizar software
     * POST /software/editar
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

            $softwareId = Input::get('id');
            $software = Software::find($softwareId);
            $software->nombre = Input::get('nombre');
            $software->tabla = Input::get('tabla');
            $software->campo = Input::get('campo');
            $software->estado = Input::get('estado');
            $software->usuario_updated_at = Auth::user()->id;
            $software->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $software = Software::find(Input::get('id'));
            $software->usuario_created_at = Auth::user()->id;
            $software->estado = Input::get('estado');
            $software->save();
           
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
