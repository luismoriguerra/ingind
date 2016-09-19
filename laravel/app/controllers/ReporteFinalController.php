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
      $array['referido']=' LEFT ';
      $array['w']='';
      $array['id_union']='';$array['id_ant']='';
      $array['solicitante']='';$array['areas']='';
      $array['proceso']='';$array['tiempo_final']='';

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
            $array['w'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
          }
        }

        if( Input::has('id_ant') AND Input::get('id_ant')!='' ){
          $id_ant=explode(" ",trim(Input::get('id_ant')));
          for($i=0; $i<count($id_ant); $i++){
            $array['w'].=" AND re.referido LIKE '%".$id_ant[$i]."%' ";
          }
          $array['referido']=' INNER ';
        }

        if( Input::has('solicitante') AND Input::get('solicitante')!='' ){
          $solicitante=explode(" ",trim(Input::get('solicitante')));
          $dsol=array();$dsol[0]=array();$dsol[1]=array();$dsol[2]=array();
          $array['w'].=" AND ( ";
          for($i=0; $i<count($solicitante); $i++){
            array_push($dsol[0]," CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre) like '%".$solicitante[$i]."%' ");
            array_push($dsol[1]," CONCAT(tr.razon_social,' | RUC:',tr.ruc) like '%".$solicitante[$i]."%' ");
            array_push($dsol[2]," tr.area_id IN (SELECT nombre FROM areas WHERE nombre like '%".$solicitante[$i]."%') ");
          }
          $array['w'].=" (".implode(" AND ",$dsol[0]).") ";
          $array['w'].=" OR (".implode(" AND ",$dsol[1]).") ";
          $array['w'].=" OR (".implode(" AND ",$dsol[2]).") ";
          $array['w'].=" )";
        }

        if( Input::has('areas') ){ // Filtra por área
          $reporte=Input::get('areas');
          $array['w'].=" AND rd.area_id=".$reporte." ";
        }
        elseif( Input::has('areast') ){ /*Todas las areas*/ }
        else{
          $array['w'].=" AND FIND_IN_SET(rd.area_id,  
                                        (SELECT GROUP_CONCAT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id= ".$array['usuario'].")
                                      )>0 ";
        }

        if( Input::has('proceso') AND Input::get('proceso')!='' ){
          $proceso=trim(Input::get('proceso'));
          $array['w'].=" AND f.nombre LIKE '%".$proceso."%' ";
        }

        if( Input::has('tiempo_final') AND Input::get('tiempo_final')!='' ){
          $estadofinal=">=CURRENT_TIMESTAMP()";
           if( Input::get('tiempo_final')=='0' ){
            $estadofinal="<CURRENT_TIMESTAMP()";
           }
          $array['w'].="  AND CalcularFechaFinal(
                            rd.fecha_inicio, 
                            (rd.dtiempo*t.totalminutos),
                            rd.area_id 
                            )$estadofinal ";
        }

        if( Input::has('fecha_inicio_b') AND Input::get('fecha_inicio_b')!='' ){
          $fecha_inicio=explode(" - ",Input::get('fecha_inicio_b'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
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
      $array['area']='';$array['sino']='';$array['fecha']='';


      if( Input::has('fecha_4') ){
        $fecha = explode(" - ",Input::get('fecha_4'));
        $array['fecha']=" AND date(rd.fecha_inicio) BETWEEN '".$fecha[0]."' AND '".$fecha[1]."' ";
      }

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

    public function postBandejatramiteenvioalertas()
    {
      $array=array();
      $array['usuario']=Auth::user()->id;
      $array['limit']='';$array['order']='';
      $array['id_union']='';$array['id_ant']='';
      $array['referido']=' LEFT ';
      $array['solicitante']='';$array['areas']='';
      $array['proceso']='';$array['tiempo_final']='';

      $retorno=array(
                  'rst'=>1
               );

        if (Input::has('start')) {
            $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
        }

        if( Input::has('tiempo_final') AND Input::get('tiempo_final')!='' ){
          $estadofinal=">=CURRENT_TIMESTAMP()";
           if( Input::get('tiempo_final')=='0' ){
            $estadofinal="<CURRENT_TIMESTAMP()";
           }
          $array['tiempo_final']="  AND CalcularFechaFinal(
                                    rd.fecha_inicio, 
                                    (rd.dtiempo*t.totalminutos),
                                    rd.area_id 
                                    )$estadofinal ";
        }

      $r = Reporte::BandejaTramiteEnvioAlertas( $array );
      $html="";
      $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');

      foreach ($r as $key => $value) {
        $html.="<tr>";
        $html.="<td>".$value->tipo_tarea."</td>";
        $html.="<td>".$value->descripcion."</td>";
        $html.="<td>".$value->nemonico."</td>";
        $html.="<td>".$value->responsable."</td>";
        $html.="<td>".$value->email."</td>";
        $html.="<td>".$value->recursos."</td>";
        $html.="<td>".$value->proceso."</td>";
        $html.="<td>".$value->id_union."</td>";
        $html.="<td>".$value->norden."</td>";
        $html.="<td>".$value->tiempo."</td>";
        $html.="<td>".$value->fecha_inicio."</td>";
        $html.="</tr>";

        $alerta=explode("|",$value->alerta);
        $texto="";
        $tipo=0;
        if($alerta[1]==''){
          $tipo=1;
          $texto=".::Notificación::.";
        }
        elseif($alerta[1]!='' AND $alerta[1]==1){
          $tipo=$alerta[1]+1;
          $texto=".::Reiterativo::.";
        }
        elseif($alerta[1]!='' AND $alerta[1]==2){
          $tipo=$alerta[1]+1;
          $texto=".::Relevo::.";
        }
        elseif($alerta[1]!='' AND $alerta[1]==3){
          $tipo=1;
          $texto=".::Notificación::.";
        }

        $plantilla=Plantilla::where('tipo','=',$tipo)->first();
        $buscar=array('persona:','dia:','mes:','año:','paso:','tramite:','area:','personajefe:');
        $reemplazar=array($value->responsable,date('d'),$meses[date('n')],date("Y"),$value->norden,$value->id_union,$value->nemonico,$value->jefe);
        $parametros=array(
          'cuerpo'=>str_replace($buscar,$reemplazar,$plantilla->cuerpo)
        );
        try{
            if( $value->email==$value->email_jefe ){
              Mail::send('notreirel', $parametros , 
                  function($message) use( $value,$texto ) {
                      $message
                      ->to('jorgeshevchenk@gmail.com')
                      ->subject($texto);
                  }
              );
            }
            else{
              Mail::send('notreirel', $parametros , 
                  function($message) use( $value,$texto ) {
                      $message
                      ->to('jorgeshevchenk@gmail.com')
                      ->cc('jorgeshevchenk1988@gmail.com')
                      ->subject($texto);
                  }
              );
            }
            $alerta=new Alerta;
            $alerta['ruta_id']=$value->ruta_id;
            $alerta['ruta_detalle_id']=$value->ruta_detalle_id;
            $alerta['persona_id']=$value->persona_id;
            $alerta['tipo']=$tipo;
            $alerta['fecha']=DATE("Y-m-d");
            $alerta->save();
        }
        catch(Exception $e){
            //echo $qem[$k]->email."<br>";
        }
      }
      $retorno["data"]=$html;

      return Response::json( $retorno );
    }

}
