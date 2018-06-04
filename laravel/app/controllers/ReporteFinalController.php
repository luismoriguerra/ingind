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
      AuditoriaAcceso::getAuditoria();
        
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
        $array['ruta_flujo_id'].=" AND r.ruta_flujo_id='".Input::get('ruta_flujo_id')."' ";
      }

      if( Input::has('tramite_1') AND Input::get('tramite_1')!='' ){
        $tramite=explode(" ",trim(Input::get('tramite_1')));
        for($i=0; $i<count($tramite); $i++){
          $array['tramite'].=" AND tr.id_union LIKE '%".$tramite[$i]."%' ";
        }
      }
      
      if( Input::has('envio_meta')){

        $array['tramite'].=" AND r.id IN (".Input::get('id').") ";

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

    public function postVerificarfueratiempo()
    {
      $array=array();
      $array['usuario']=Auth::user()->id;
      $array['w']='';
      $array['areas']='';

      $sql="SELECT GROUP_CONCAT(DISTINCT(a.id) ORDER BY a.id) areas
                FROM area_cargo_persona acp
                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                WHERE acp.estado=1
                AND cp.persona_id= ".$array['usuario'];
          $totalareas=DB::select($sql);
          $areas = $totalareas[0]->areas;
          $array['w'].=" AND rd.area_id IN (".$areas.") ";

      $array['order']=' ORDER BY rd.fecha_inicio DESC ';

      $r = Reporte::verificarFueraTiempo( $array );
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$r
          )
      );
    }

    ////////// query para lo solicitado
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
                /*$array['order']=  ' ORDER BY '.
                                  $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                  $inorder[0]['dir'];*/
            }

            //$array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
            $retorno["draw"]=Input::get('draw');
            $array['order']=' ORDER BY rd.fecha_inicio DESC ';
        }

        if( !Input::has('totaldatos') ){
          $array['w']=" AND rd.dtiempo_final IS NULL ";
        }

        if( Input::has('id_union') AND Input::get('id_union')!='' ){
          $id_union=explode(" ",trim(Input::get('id_union')));
          for($i=0; $i<count($id_union); $i++){
            $array['w'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
          }
        }
        
        if( Input::has('id_res') AND Input::get('id_res')!='' ){
          $array['w'].=" AND CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) LIKE '%".Input::get('id_res')."%' ";
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
          $sql="SELECT GROUP_CONCAT(DISTINCT(a.id) ORDER BY a.id) areas
                FROM area_cargo_persona acp
                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                WHERE acp.estado=1
                AND cp.persona_id= ".$array['usuario'];
          $totalareas=DB::select($sql);
          $areas = $totalareas[0]->areas;
          $array['w'].=" AND rd.area_id IN (".$areas.") ";
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
          $array['w'].="  AND rd.fecha_proyectada$estadofinal ";
        }

        if(Input::has('fecha_inicio_b') AND Input::get('fecha_inicio_b')!=''){
          $fecha_inicio=explode(" - ",Input::get('fecha_inicio_b'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
        }

        if(Input::has('fechaRange') AND Input::get('fechaRange')!=''){
          $fecha_inicio=explode(" - ",Input::get('fechaRange'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
        }

      //$cant= Reporte::BandejaTramiteCount( $array );
      $r = Reporte::BandejaTramite( $array );
      $cant= count($r);
      $cant2=$cant;
      $max= Input::get('start')+Input::get('length');

      if( $cant-($cant%10) == Input::get('start') AND $cant%10>0 ){
        $max=$cant;

      }
      $nf = "";
      $r2= array(); 
      if( $cant>10 ){
        for ($i=Input::get('start'); $i < $max; $i++) { 
          if(isset($r[$i])){
            array_push($r2, $r[$i]);
          }else{
            $nf .= " - NTF:".$i;
          }
        }
      }
      else{
        $r2=$r;
      }


      $retorno["data"]=$r2;
      $retorno["recordsTotal"]=$cant;
      $retorno["recordsFiltered"]=$cant;
      $retorno["UNDEFINEDOFFSET"]=$nf;
      $retorno["cant2"]=$cant2;

      return Response::json( $retorno );
    }
    
        ////////// query para lo solicitado
    public function postBandejatramitearea()
    {
      AuditoriaAcceso::getAuditoria();
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

        if( !Input::has('totaldatos') ){
          $array['w']=" AND rd.dtiempo_final IS NULL ";
        }

        if( Input::has('id_union') AND Input::get('id_union')!='' ){
          $id_union=explode(" ",trim(Input::get('id_union')));
          for($i=0; $i<count($id_union); $i++){
            $array['w'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
          }
        }
        
        if( Input::has('id_res') AND Input::get('id_res')!='' ){
          $array['w'].=" AND CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) LIKE '%".Input::get('id_res')."%' ";
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
          $array['w'].=" AND rd.area_id IN
                            (SELECT DISTINCT(a.id)
                            FROM area_cargo_persona acp
                            INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                            INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                            WHERE acp.estado=1
                            AND cp.persona_id= ".$array['usuario'].") ";
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

        if(Input::has('fecha_inicio_b') AND Input::get('fecha_inicio_b')!=''){
          $fecha_inicio=explode(" - ",Input::get('fecha_inicio_b'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
        }

        if(Input::has('fechaRange') AND Input::get('fechaRange')!=''){
          $fecha_inicio=explode(" - ",Input::get('fechaRange'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
        }

      $cant= Reporte::BandejaTramiteAreaCount( $array );
      $r = Reporte::BandejaTramiteArea( $array );

      $retorno["data"]=$r;
      $retorno["recordsTotal"]=$cant;
      $retorno["recordsFiltered"]=$cant;

      return Response::json( $retorno );
    }
    
    /////////////////// export de lo solicitado 

    public function getExportbandejatramite(){
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

        if( !Input::has('totaldatos') ){
          $array['w']=" AND rd.dtiempo_final IS NULL ";
        }
        
        if( Input::has('id_res') AND Input::get('id_res')!='' ){
          $array['w'].=" AND CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) LIKE '%".Input::get('id_res')."%' ";
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

        if( Input::has('area_id') ){ // Filtra por área
          $reporte=Input::get('area_id');
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

        if(Input::has('fecha_inicio_b') AND Input::get('fecha_inicio_b')!=''){
          $fecha_inicio=explode(" - ",Input::get('fecha_inicio_b'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
        }

        if(Input::has('fechaRange') AND Input::get('fechaRange')!=''){
          $fecha_inicio=explode(" - ",Input::get('fechaRange'));
          $array['w'].=" AND DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
        }
  
      $result = Reporte::BandejaTramiteArea( $array );

/*         if( Input::has('area_id') ){ // Filtra por área
          $reporte=Input::get('area_id');
          $array['w']=" AND rd.area_id=".$reporte." ";

        }*/
/*

         $result = Reporte::BandejaTramite( $array );
        */

        /*style*/
        $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

          /*export*/
            /* instanciar phpExcel!*/
            
            $objPHPExcel = new PHPExcel();

            /*configure*/
            $objPHPExcel->getProperties()->setCreator("Gerencia Modernizacion")
               ->setSubject("Trámites Inconclusos");

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
            /*end configure*/

            /*head*/
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'N°')
                        ->setCellValue('B3', 'RESPONSABLE')
                        ->setCellValue('C3', 'DOCUMENTO GENERADO POR EL PASO ANTERIOR')
                        ->setCellValue('D3', 'PRIMER DOCUMENTO INGRESADO')
                        ->setCellValue('E3', 'TIEMPO')
                        ->setCellValue('F3', 'FECHA DE INICIO')
                        ->setCellValue('G3', 'HORA DE INICIO')
                        ->setCellValue('H3', 'ESTADO DEL PASO')
                        ->setCellValue('I3', 'PASO')
                        ->setCellValue('J3', 'PROCESO')
                        ->setCellValue('K3', 'SOLICITANTE')
                   
                  ->mergeCells('A1:K1')
                  ->setCellValue('A1', 'Trámites Inconclusos')
                  ->getStyle('A1:K1')->getFont()->setSize(18);

            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
         
            /*end head*/
            /*body*/
            if($result){
              foreach ($result as $key => $value) {
                list($fecha_inicio,$hora_inicio) = explode(' ',$value->fecha_inicio);  
                $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValueExplicit('A' . ($key + 4), $key + 1)
                              ->setCellValueExplicit('B' . ($key + 4), $value->responsable)
                              ->setCellValueExplicit('C' . ($key + 4), $value->id_union_ant)
                              ->setCellValueExplicit('D' . ($key + 4), $value->id_union)
                              ->setCellValueExplicit('E' . ($key + 4), $value->tiempo)
                              ->setCellValueExplicit('F' . ($key + 4), $fecha_inicio)
                              ->setCellValueExplicit('G' . ($key + 4), $hora_inicio)
                              ->setCellValueExplicit('H' . ($key + 4), $value->tiempo_final_n)
                              ->setCellValue('I' . ($key + 4), $value->norden)
                              ->setCellValue('J' . ($key + 4), $value->proceso)
                              ->setCellValue('K' . ($key + 4), $value->persona)
                    
                              ;
              }
            }
            /*end body*/
            $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($styleThinBlackBorderAllborders);
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleAlignment);
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Tràmites Inconclusos');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="reporteti.xls"'); // file name of excel
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
          /* end export*/
     /* }else{
        echo 'no hay data';
      }*/
    }


    public function postTramitependiente()
    {
      ini_set('max_execution_time', 300);
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

      $estadofinal="<CURRENT_TIMESTAMP()";
      $datehoy=date("Y-m-d");
      $datesp=date("Y-m-d",strtotime("-10 days")); 
      $array['tiempo_final']="  AND CalcularFechaFinal(
                                rd.fecha_inicio, 
                                (rd.dtiempo*t.totalminutos),
                                rd.area_id 
                                )$estadofinal 
                                AND DATE(rd.fecha_inicio) BETWEEN '$datesp' AND '$datehoy' 
                                AND ValidaDiaLaborable('$datehoy',rd.area_id)=0 ";

      $r = Reporte::BandejaTramiteEnvioAlertas( $array );
      $html="";
      $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');

      foreach ($r as $key => $value) {

        $alerta=explode("|",$value->alerta);
        $texto="";
        $tipo=0;
        
        DB::beginTransaction();
        if( ($value->rol_id==8 OR $value->rol_id==9) AND ($value->responsable!=$value->jefe) ){
          $value->responsable=$value->jefe;
          $value->email_mdi=$value->email_jefe;
          $value->email='';
          $value->persona_id=$value->jefe_id;
          $alerta[1]='';

          $rutaDetalle= RutaDetalle::find($value->ruta_detalle_id);
          $rutaDetalle->persona_responsable_id=$value->jefe_id;
          $rutaDetalle->save();
        }
        else if(  trim($value->responsable_auto_id)!='' AND $value->responsable_auto_id!= $value->persona_id){
          $value->responsable=$value->responsable_auto;
          $value->email_mdi=$value->email_mdi_responsable_auto;
          $value->email=$value->email_responsable_auto;
          $value->persona_id=$value->responsable_auto_id;
          $alerta[1]='';

          $rutaDetalle= RutaDetalle::find($value->ruta_detalle_id);
          $rutaDetalle->persona_responsable_id=$value->responsable_auto_id;
          $rutaDetalle->save();
        }

        $html.="<tr>";
        $html.="<td>".$value->nemonico."</td>";
        $html.="<td>".$value->responsable."</td>";
        $html.="<td>".$value->email_mdi."<br>".$value->email."</td>";
        $html.="<td>".$value->proceso."</td>";
        $html.="<td>".$value->id_union."</td>";
        $html.="<td>".$value->norden."</td>";
        $html.="<td>".$value->tiempo."</td>";
        $html.="<td>".$value->fecha_inicio."</td>";
        $html.="</tr>";

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
          $rutaDetalle= RutaDetalle::find($value->ruta_detalle_id);
          $rutaDetalle->persona_responsable_id=$value->jefe_id;
          $rutaDetalle->save();
        }
        elseif($alerta[1]!='' AND $alerta[1]==3){
          $tipo=1;
          $texto=".::Notificación::.";
        }

        $retorno['texto'][]=$texto;
        $retorno['tipo'][]=$tipo;

        if( trim($alerta[0])=='' OR $alerta[0]!=DATE("Y-m-d") ){
          $retorno['retorno']=$alerta[0];
            $plantilla=Plantilla::where('tipo','=',$tipo)->first();
            $buscar=array('persona:','dia:','mes:','año:','paso:','tramite:','area:','personajefe:');
            $reemplazar=array($value->responsable,date('d'),$meses[date('n')],date("Y"),$value->norden,$value->id_union,$value->nemonico,$value->jefe);
            $parametros=array(
              'cuerpo'=>str_replace($buscar,$reemplazar,$plantilla->cuerpo)
            );
            /*
            $value->email_mdi='jorgeshevchenk1988@gmail.com';
            $value->email='';
            $value->email_jefe='jorge_shevchenk@hotmail.com';
            if($key%2==0){
              $value->email_jefe='jorgeshevchenk1988@gmail.com';
            }
            $value->email_seguimiento='jorgeshevchenk@gmail.com,jorgesalced0@gmail.com';*/

            $email=array();
            if(trim($value->email_mdi)!=''){
              array_push($email, $value->email_mdi);
            }
            if(trim($value->email)!=''){
              array_push($email, $value->email);
            }
            $emailseguimiento=explode(",",$value->email_seguimiento);
            try{
                if(count($email)>0){
                  if( $value->email_mdi!=$value->email_jefe ){
                    array_push($emailseguimiento, $value->email_jefe);
                  }
                    Mail::queue('notreirel', $parametros , 
                        function($message) use( $email,$emailseguimiento,$texto ) {
                            $message
                            ->to($email)
                            ->cc($emailseguimiento)
                            ->subject($texto);
                        }
                    );
                  $alerta=new Alerta;
                  $alerta['ruta_id']=$value->ruta_id;
                  $alerta['ruta_detalle_id']=$value->ruta_detalle_id;
                  $alerta['persona_id']=$value->persona_id;
                  $alerta['tipo']=$tipo;
                  $alerta['fecha']=DATE("Y-m-d");
                  $alerta->save();
                  $retorno['persona_id'][]=$value->persona_id;
                  $retorno['jefe_id'][]=$value->jefe_id;
                }
                else{
                  /*$FaltaEmail=new FaltaEmail;
                  $FaltaEmail['persona_id']=$value->persona_id;
                  $FaltaEmail['ruta_detalle_id']=$value->ruta_detalle_id;
                  $FaltaEmail->save();*/
                }
            }
            catch(Exception $e){
              DB::rollback();
              $retorno['id_union'][]=$value->id_union;
                //echo $qem[$k]->email."<br>";
            }
            DB::commit();
        }
      }
      $retorno["data"]=$html;

      return Response::json( $retorno );
    }
    
     public function postSeguridadciudadanaalertas()
    {    date('Y-m-d');    
//     $array=array();
//     $array['usuario']=Auth::user()->id;
//     
//     $retorno=array(
//                 'rst'=>1
//              );
//
//     $url ='http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=faltas';
//     $curl_options = array(
//                   //reemplazar url 
//                   CURLOPT_URL => $url,
//                   CURLOPT_HEADER => 0,
//                   CURLOPT_RETURNTRANSFER => TRUE,
//                   CURLOPT_TIMEOUT => 0,
//                   CURLOPT_SSL_VERIFYPEER => 0,
//                   CURLOPT_FOLLOWLOCATION => TRUE,
//                   CURLOPT_ENCODING => 'gzip,deflate',
//           );
//
//           $ch = curl_init();
//           curl_setopt_array( $ch, $curl_options );
//           $output = curl_exec( $ch );
//           curl_close($ch);
//
//     $r = json_decode(utf8_encode($output),true);
//     
//     $html="";
//     $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
//     
//     $n=1;
//     $fecha=date("Y-m-d"); 
//     $dias= 1; 
//     $fecha_inicio=date("Y-m").'-01';
//     $fecha_fin=date("Y-m-d", strtotime("$fecha -$dias day")); 
//     
//     $Ssql='select area_id,id,email, email_mdi
//            from personas
//            where area_id in (31,19)
//            and rol_id in (9,8)
//            and estado=1
//            order by area_id;';
//     $e= DB::select($Ssql);
//
//     $email_copia = [$e[0]->email, $e[0]->email_mdi,$e[1]->email, $e[1]->email_mdi];
//      
//     foreach ($r["faltas"] as $rr) {
//  
//       $html.="<tr>";
//       $html.="<td>".$n."</td>";
//       $html.="<td>".$rr["Persona"]."</td>";
//       $html.="<td>".$rr["Dni"]."</td>";
//       $html.="<td>".$rr["Email"]."</td>";
//       $html.="<td>".$rr["Area"]."</td>";
//       $html.="<td>".$rr["faltas"]."</td>";
//       $html.="</tr>";
//       
//       $faltas_dia=floor($rr["faltas"]/3);
//       $email=trim($rr["Email"]);
//       
//       $plantilla=Plantilla::where('tipo','=','4')->first();
//       $buscar=array('persona:','dia:','mes:','año:','inasistencias:','fechainicial:','fechafinal:','faltas:');
//       $reemplazar=array($rr["Persona"],date('d'),$meses[date('n')],date("Y"),$rr["faltas"],$fecha_inicio,$fecha_fin,$faltas_dia);
//       $parametros=array(
//         'cuerpo'=>str_replace($buscar,$reemplazar,$plantilla->cuerpo)
//       );
//       
//       $Ssql='SELECT COUNT(aasc.id) as count
//                    FROM alertas_seguridad_ciudadana aasc
//                    WHERE aasc.idpersona='.$rr["idpersona"].' AND aasc.nro_inasistencias='.$rr["faltas"];
//                    $r= DB::select($Ssql);
//                    
//       if($email=='')  {$email=$e[0]->email;} //colocar correo de gerente seguridad ciudadana 
//       
//       if( $email!='' AND $r[0]->count==0 AND $rr["faltas"]>=3){
//         
//           DB::beginTransaction();   
//           $update='update alertas_seguridad_ciudadana set ultimo_registro=0
//                   where idpersona='.$rr["idpersona"];
//                   DB::update($update); 
//       
//           $insert='INSERT INTO alertas_seguridad_ciudadana (idpersona,persona,nro_faltas,nro_inasistencias,fecha_notificacion) 
//                    VALUES ('.$rr["idpersona"].',"'.$rr["Persona"].'","'.$faltas_dia.'","'.$rr["faltas"].'","'.date("Y-m-d h:m:s").'")';
//                    DB::insert($insert); 
////       $email="rcapchab@gmail.com";    $email_copia="rcapchab@gmail.com";                           
//       try{
//           Mail::queue('notreirel', $parametros , 
//               function($message) use ($email,$email_copia){
//                   $message
//                   ->to($email)
//                   ->cc($email_copia)
//                   ->subject('.::Notificación::.');
//               }
//           );
//      }
//       catch(Exception $e){
//           //echo $qem[$k]->email."<br>";
//            DB::rollback();
//       }
//       DB::commit();
//       }
//       $n++;
//     }
//     $retorno["data"]=$html;
//
//     return Response::json( $retorno );
    }
    
     public function postGenerarqr()
    { 
         
     $html="";

        $retorno=array(
                  'rst'=>1
               );

        $png = QrCode::format('png')->size(100)->generate("procesos.munindependencia.gob.pe");
        $png = base64_encode($png);
        $png= "<img src='data:image/png;base64," . $png . "'>";
        
        $html.='<div>'.$png.'</div>';

       $retorno["data"]=$html;

       return Response::json( $retorno );
    }
    
    public function getExportsgcfaltas()
    { 
        $url ='http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=faltas';
     $curl_options = array(
                   //reemplazar url 
                   CURLOPT_URL => $url,
                   CURLOPT_HEADER => 0,
                   CURLOPT_RETURNTRANSFER => TRUE,
                   CURLOPT_TIMEOUT => 0,
                   CURLOPT_SSL_VERIFYPEER => 0,
                   CURLOPT_FOLLOWLOCATION => TRUE,
                   CURLOPT_ENCODING => 'gzip,deflate',
           );

           $ch = curl_init();
           curl_setopt_array( $ch, $curl_options );
           $output = curl_exec( $ch );
           curl_close($ch);

            $result = json_decode(utf8_encode($output),true);

             $styleThinBlackBorderAllborders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleAlignmentBold= array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $styleAlignment= array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        /*end style*/

          /*export*/
            /* instanciar phpExcel!*/
            
            $objPHPExcel = new PHPExcel();

            /*configure*/
            $objPHPExcel->getProperties()->setCreator("Gerencia Modernizacion")
               ->setSubject("Faltas de Agentes");

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
            /*end configure*/

            /*head*/
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'N°')
                        ->setCellValue('B3', 'PERSONA')
                        ->setCellValue('C3', 'DNI')
                        ->setCellValue('D3', 'EMAIL')
                        ->setCellValue('E3', 'AREA')
                        ->setCellValue('F3', 'Reportes incumplidos')
                        ->setCellValue('G3', 'Faltas')

                  ->mergeCells('A1:G1')
                  ->setCellValue('A1', 'FALTAS DE AGENTES DE SEGURIDAD CIUDADANA - '. date('Y-m-d'))
                  ->getStyle('A1:G1')->getFont()->setSize(18);

            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);

            /*end head*/
            /*body*/
            if($result){
              foreach ($result["faltas"] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValueExplicit('A' . ($key + 4), $key + 1)
                              ->setCellValueExplicit('B' . ($key + 4), $value["Persona"])
                              ->setCellValueExplicit('C' . ($key + 4), $value["Dni"])
                              ->setCellValueExplicit('D' . ($key + 4), $value["Email"])
                              ->setCellValueExplicit('E' . ($key + 4), $value["Area"])
                              ->setCellValueExplicit('F' . ($key + 4), $value["faltas"])
                              ->setCellValueExplicit('G' . ($key + 4), floor($value["faltas"]/3))
                              ;
              }
            }
            /*end body*/
            $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleThinBlackBorderAllborders);
            $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleAlignment);
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Faltas');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="reporteni.xls"'); // file name of excel
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
          /* end export*/
     /* }else{
        echo 'no hay data';
      }*/
    }
    
    public function postTramiteasignacion(){
        $array['where']='';$array['where2']='';
        $array['usuario']=Auth::user()->id;
        $array['w']='';
        $sql="SELECT GROUP_CONCAT(DISTINCT(a.id) ORDER BY a.id) areas
                FROM area_cargo_persona acp
                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                WHERE acp.estado=1
                AND cp.persona_id= ".$array['usuario'];
          $totalareas=DB::select($sql);
          $areas = $totalareas[0]->areas;
          $array['w'].=" AND rd.area_id IN (".$areas.") ";
          
        if( Input::has('id_union') AND Input::get('id_union')!='' ){
          $id_union=explode(" ",trim(Input::get('id_union')));
          for($i=0; $i<count($id_union); $i++){
            if($i==0){
                $array['where'].=" ( 1=1";
                $array['where2'].=" ( 1=1 ";
            }  
            $array['where'].="  and rf.id_union LIKE '%".$id_union[$i]."%' ";
            $array['where2'].=" and  rf.referido LIKE '%".$id_union[$i]."%' ";
          }
          $array['where'].=" ) ";
          $array['where2'].=" ) ";
        }
        
      $rst=Reporte::getTramiteasignacion($array); 
      return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
    }
}
