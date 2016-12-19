<?php

class DocsController extends \BaseController {

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
            
            if( Input::has('area_personal') ){
                $array['where'].=" AND dd.area_id='".Auth::user()->area_id."' ";
            }

            if( Input::has("titulo") ){
                $titulo=Input::get("titulo");
                if( trim( $titulo )!='' ){
                    $array['where'].=" AND dd.titulo LIKE '%".$titulo."%' ";
                }
            }
            if( Input::has("asunto") ){
                $asunto=Input::get("asunto");
                if( trim( $asunto )!='' ){
                    $array['where'].=" AND dd.asunto LIKE '%".$asunto."%' ";
                }
            }
            if( Input::has("created_at") ){
                $fecha=Input::get("created_at");
                if( trim( $fecha )!='' ){
                    $array['where'].=" AND dd.created_at LIKE '%".$fecha."%' ";
                }
            }

            
            $array['order']=" ORDER BY dd.titulo ";

            $cant  = DocumentoDigital::getListarCount( $array );
            $aData = DocumentoDigital::getListar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";   
            return Response::json($aParametro);

        }
    }
}
