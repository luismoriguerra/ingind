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
      $array['where']='';$where=array();

      if( Input::has('categoria_3') AND Input::get('categoria_3')!='' ){
        $categoria=implode("','",Input::get('categoria_3'));
        $where[]=" f.categoria_id IN ('".$categoria."') ";
      }

      if( Input::has('proceso_3') AND Input::get('proceso_3')!='' ){
        $proceso=implode("','",Input::get('proceso_3'));
        $where[]=" f.id IN ('".$proceso."') ";
      }

      if( Input::has('area_3') AND Input::get('area_3')!='' ){
        $area=implode("','",Input::get('area_3'));
        $where[]=" a.id IN ('".$area."') ";
      }

      if( count($where)>0 ){
        $array['where']=" AND (".implode("OR",$where).") ";
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
      $array['solicitante']='';$array['areas']='';
      $array['proceso']='';

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

        if( Input::has('solicitante') AND Input::get('solicitante')!='' ){
          $solicitante=explode(" ",trim(Input::get('solicitante')));
          $dsol=array();$dsol[0]=array();$dsol[1]=array();$dsol[2]=array();
          $array['solicitante']=" AND ( ";
          for($i=0; $i<count($solicitante); $i++){
            array_push($dsol[0]," CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre) like '%".$solicitante[$i]."%' ");
            array_push($dsol[1]," CONCAT(tr.razon_social,' | RUC:',tr.ruc) like '%".$solicitante[$i]."%' ");
            array_push($dsol[2]," tr.area_id IN (SELECT nombre FROM areas WHERE nombre like '%".$solicitante[$i]."%') ");
          }
          $array['solicitante'].=" (".implode(" AND ",$dsol[0]).") ";
          $array['solicitante'].=" OR (".implode(" AND ",$dsol[1]).") ";
          $array['solicitante'].=" OR (".implode(" AND ",$dsol[2]).") ";
          $array['solicitante'].=" )";
        }

        if( Input::has('areas') ){ // Filtra por área
          $reporte=Input::get('areas');
          $array['areas']=" AND rd.area_id=".$reporte." ";
        }
        else{
          $array['areas']=" AND rd.area_id IN (
                                SELECT a.id
                                FROM area_cargo_persona acp
                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                WHERE acp.estado=1
                                AND cp.persona_id= ".$array['usuario']."
                            ) ";
        }

        if( Input::has('proceso') AND Input::get('proceso')!='' ){
          $proceso=trim(Input::get('proceso'));
          $array['proceso'].=" AND f.nombre LIKE '%".$proceso."%' ";
        }

      $cant= Reporte::BandejaTramiteCount( $array );
      $r = Reporte::BandejaTramite( $array );

      $retorno["data"]=$r;
      $retorno["recordsTotal"]=$cant;
      $retorno["recordsFiltered"]=$cant;

      return Response::json( $retorno );
    }

    public function postTramitependiente()
    {
      $array=array();
      $array['area']='';$array['sino']='';
      if( Input::has('area_4') AND Input::get('area_4')!='' ){
        $array['area']=implode("','",Input::get('area_4'));
        $array['area']=" AND rd.area_id IN ('".$array['area']."') ";
      }

      if( Input::has('sino') AND Input::get('sino')=='1' ){
        $array['sino']=", f.id";
      }

      $r = Reporte::TramitePendiente( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }

}
