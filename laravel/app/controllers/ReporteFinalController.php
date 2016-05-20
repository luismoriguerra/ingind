<?php
class ReporteFinalController extends BaseController
{
    public function postTramiteproceso()
    {
      $array=array();
      if( Input::has('fecha_2') ){
        $fecha = Input::get('fecha_2');
      }
      else if( Input::has('fecha_3') ){
        $fecha = Input::get('fecha_3');
      }
      
      list($array['fechaini'],$array['fechafin']) = explode(" - ", $fecha);
      $array['proceso']='';$array['area']='';

      if( Input::has('proceso_3') AND Input::get('proceso_3')!='' ){
        $array['proceso']=implode("','",Input::get('proceso_3'));
        $array['proceso']=" AND f.id IN ('".$array['proceso']."') ";
      }

      if( Input::has('area_3') AND Input::get('area_3')!='' ){
        $array['area']=implode("','",Input::get('area_3'));
        $array['area']=" AND a.id IN ('".$array['area']."') ";
      }

      $r = Reporte::TramiteProceso( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }

    public function postTramite()
    {
      $array=array();
      $fecha='';
      $array['fecha']='';$array['ruta_flujo_id']='';$array['tramite']='';
      if( Input::has('fecha_2') ){
        $fecha = Input::get('fecha_2');
      }
      else if( Input::has('fecha_3') ){
        $fecha = Input::get('fecha_3');
      }
      
      if($fecha!=''){
        list($fechaini,$fechafin) = explode(" - ", $fecha);
        $array['fecha']=" AND DATE(r.fecha_inicio) BETWEEN '".$fechaini."' AND '".$fechafin."' ";
      }

      if( Input::has('ruta_flujo_id') AND Input::get('ruta_flujo_id')!='' ){
        $array['ruta_flujo_id']=" AND r.ruta_flujo_id='".Input::get('ruta_flujo_id')."' ";
      }

      if( Input::has('tramite_1') AND Input::get('tramite_1')!='' ){
        $tramite=explode(" ",trim(Input::get('tramite_1')));
        for($i=0; $i<count($tramite); $i++){
          $array['tramite'].=" AND tr.id_union LIKE '%".$tramite[$i]."%' ";
        }
      }

      $r = Reporte::Tramite( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }

    public function postTramitedetalle()
    {
      $array=array();
      $array['ruta_id']='';

      if( Input::has('ruta_id') AND Input::get('ruta_id')!='' ){
        $array['ruta_id']=Input::get('ruta_id');
        $array['ruta_id']=" AND r.id='".$array['ruta_id']."' ";
      }

      $r = Reporte::TramiteDetalle( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }

    public function postBandejatramite()
    {
      $array=array();
      $array['usuario']=Auth::user()->id;
      $array['limit']='';$array['order']='';
      $array['id_union']='';$array['id_ant']='';
      $array['referido']=' LEFT ';

      $retorno=array(
                  'rst'=>1
               );

        if (Input::has('draw')) {
            if (Input::has('order')) {
                $inorder=Input::get('order');
                $incolumns=Input::get('columns');
                $array['order']=  ' ORDER BY '.
                                  $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                  $inorder[0]['dir'];
            }

            $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
            $retorno["draw"]=Input::get('draw');
        }

        if( Input::has('id_union') AND Input::get('id_union')!='' ){
          $id_union=explode(" ",trim(Input::get('id_union')));
          for($i=0; $i<count($id_union); $i++){
            $array['id_union'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
          }
        }

        if( Input::has('id_ant') AND Input::get('id_ant')!='' ){
          $id_ant=explode(" ",trim(Input::get('id_ant')));
          for($i=0; $i<count($id_ant); $i++){
            $array['id_ant'].=" AND re.referido LIKE '%".$id_ant[$i]."%' ";
          }
          $array['referido']=' INNER ';
        }

      $cant= Reporte::BandejaTramiteCount( $array );
      $r = Reporte::BandejaTramite( $array );

      $retorno["data"]=$r;
      $retorno["recordsTotal"]=$cant;
      $retorno["recordsFiltered"]=$cant;

      return Response::json( $retorno );
    }

}
