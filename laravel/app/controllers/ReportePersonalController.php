<?php

class ReportePersonalController extends BaseController
{   // extends \BaseController
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }

    public function postReportepersonal()
    {
        $fecha = explode('-', Input::get('fecha_ini'));

        $result = file_get_contents("http://10.0.120.13:8088/spersonal/index.php?mes=".$fecha[1]."&anno=".$fecha[0]);

        return utf8_encode($result);
        /*
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
                //'datos' => array('data' => $rst)
            )
        );
        */
    }

    /*
    private function verDiasTranscurridos($fecha_ini, $fecha_fin)
    {
        $fecha_i = str_replace('/', '-', $fecha_ini);
        $fecha_f = str_replace('/', '-', $fecha_fin);
        $dias = (strtotime($fecha_i) - strtotime($fecha_f))/86400;
        $dias = abs($dias); 
        $dias = floor($dias);
        return ($dias + 1);
    }
    */

    public function postReportepersonaladm()
    {
        //try 
        //{
            ini_set('max_execution_time', 300);

            $fecha_ini = Input::get('fecha_ini'); // 2017/09/01
            $fecha_fin = Input::get('fecha_fin'); // 2017/09/15
            $area_ws = Input::get('area_ws');

            $dias=20-1;
            $fecha_i = str_replace('/', '-', $fecha_ini);
            $fecha_f = str_replace('/', '-', $fecha_fin);
            $fecha_iaux =$fecha_i;
            $fecha_faux = date("Y-m-d", strtotime($fecha_i ."+".$dias." days"));

            if($area_ws <> 0)
                $bus_area = "&area=".$area_ws;
            else
                $bus_area = "";

            //$dias = $this->verDiasTranscurridos($fecha_ini, $fecha_fin);

            //DB::table('sw_asistencias')->truncate();
            DB::table('sw_asistencias')->where('usuario_created_at', '=', Auth::user()->id)->delete();

            while ( $fecha_iaux <= $fecha_f ) {
                
                if( $fecha_faux>$fecha_f ){
                    $fecha_faux=$fecha_f;
                }

                $fini=date("Y/d/m",$fecha_iaux);
                $ffin=date("Y/d/m",$fecha_faux);

                $res = file_get_contents("http://10.0.120.13:8088/spersonal/consulta.php?inicio=".$fini.""."&fin=".$ffin.$bus_area);
                $result = json_decode(utf8_encode($res));

                foreach($result->reporte as $key => $lis) 
                {
                    DB::beginTransaction();
                    $obj = new ReportePersonal;
                    $obj->foto = $lis->foto;
                    $obj->area = $lis->AREA;
                    $obj->nombres = $lis->nombres_completos;
                    $obj->dni = $lis->dni;
                    $obj->cargo = $lis->cargo;
                    $obj->regimen = $lis->condicion;
                    $obj->faltas = $lis->FALTAS;
                    $obj->tardanza = $lis->TARDANZAS;
                    $obj->lic_sg = $lis->SLSG;
                    $obj->sancion_dici = $lis->Sancion_Dici;
                    $obj->lic_sindical = $lis->Licencia_Sindical;
                    $obj->descanso_med = $lis->DESCANSO_MEDICO;
                    $obj->min_permiso = $lis->MINPERMISO;
                    $obj->comision = $lis->comision;
                    $obj->citacion = $lis->CITACION;
                    $obj->essalud = $lis->ESSALUD;
                    $obj->permiso = $lis->PERMISO;
                    $obj->compensatorio = $lis->COMPENSATORIO;
                    $obj->onomastico = $lis->ONOMASTICO;

                    $obj->estado = 1;
                    $obj->usuario_created_at = Auth::user()->id;
                    $obj->save();

                    DB::commit();
                }

                $fecha_iaux= date("Y-m-d", strtotime($fecha_faux ."+1 days"));
                $fecha_faux= date("Y-m-d", strtotime($fecha_iaux ."+".$dias." days"));
            }

            // Actualiza campo "persona_id" en base al "id" de la tabla "personas".            
            $sql = "UPDATE sw_asistencias sa
                        INNER JOIN personas p ON sa.dni=p.dni
                        SET sa.persona_id = p.id;";
            DB::update($sql);
            // --

            // Actualiza campo "persona_id" en base que no tenga asociado un "id" de la tabla "personas". 
            DB::table('sw_asistencias')
                ->whereNull('persona_id')
                ->update(array('persona_id' => 1272));
            // --
            
            //$fecha_ini = $fecha_i;
            //$fecha_fin = $fecha_f;

            $sql = "SELECT sw.*,
                        ca.cant_act,
                        doc.docu,
                        tt.total_tramites,
                        t.tareas
                        FROM (
                            SELECT a.foto, a.area, a.nombres, a.dni, a.cargo, a.regimen,
                                                SUM(a.faltas) faltas, SUM(a.tardanza) tardanza, SUM(a.lic_sg) lic_sg, SUM(a.sancion_dici) sancion_dici,
                                                SUM(a.lic_sindical) lic_sindical, SUM(a.descanso_med) descanso_med, SUM(a.min_permiso) min_permiso, SUM(a.comision) comision,
                                                SUM(a.citacion) citacion, SUM(a.essalud) essalud, SUM(a.permiso) permiso, SUM(a.compensatorio) compensatorio,
                                                SUM(a.onomastico) onomastico, a.usuario_created_at,a.persona_id
                                FROM sw_asistencias a
                                WHERE NOT a.dni = '07135876'
                                AND a.usuario_created_at = '".Auth::user()->id."'
                                GROUP BY a.area, a.nombres, a.dni, a.cargo
                        ) sw
                        LEFT JOIN (SELECT COUNT(rdv.id) tareas, rdv.usuario_updated_at persona_id
                                FROM rutas_detalle_verbo rdv
                                WHERE rdv.finalizo=1 
                                AND rdv.updated_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                GROUP BY rdv.usuario_updated_at
                        ) AS t ON t.persona_id=sw.persona_id
                        LEFT JOIN (SELECT ROUND((SUM(ap.ot_tiempo_transcurrido) / 60), 2) cant_act, ap.persona_id
                                FROM actividad_personal ap
                                WHERE ap.persona_id=ap.usuario_created_at
                                AND ap.fecha_inicio BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                GROUP BY ap.persona_id
                            ) AS ca ON ca.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(r.id) total_tramites, r.usuario_created_at persona_id
                                FROM rutas r
                                WHERE r.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                AND r.estado=1
                                GROUP BY r.usuario_created_at
                            ) AS tt ON tt.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(dd.id) docu, dd.usuario_created_at persona_id
                                FROM doc_digital_temporal dd
                                WHERE dd.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                AND dd.estado = 1
                                GROUP BY dd.usuario_created_at
                            ) AS doc ON doc.persona_id=sw.persona_id; ";

            $lis = DB::select($sql);

            return Response::json(
                        array(
                            'rst'=>1,
                            'reporte'=> $lis
                        )
                    );
        /*}
        catch (\Exception $e) 
        {
            DB::rollback();
            return Response::json(
                        array(
                            'rst'=>2,
                            'reporte'=> 'not_data'
                        )
                    );
        }*/
    }

    public function postAreasadm()
    {
        $result = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/consul.php?opcion=area");

        return utf8_encode($result);
    }


    // -- METODO PARA GENERAR EXCEL
    public function getExportreportepersonal()
    {
          $fecha_i = Input::get('fecha_ini');
          $fecha_f = Input::get('fecha_fin');

          $sql = "SELECT sw.*,
                        ca.cant_act,
                        doc.docu,
                        tt.total_tramites,
                        t.tareas
                        FROM (
                            SELECT a.foto, a.area, a.nombres, a.dni, a.cargo, a.regimen,
                                                SUM(a.faltas) faltas, SUM(a.tardanza) tardanza, SUM(a.lic_sg) lic_sg, SUM(a.sancion_dici) sancion_dici,
                                                SUM(a.lic_sindical) lic_sindical, SUM(a.descanso_med) descanso_med, SUM(a.min_permiso) min_permiso, SUM(a.comision) comision,
                                                SUM(a.citacion) citacion, SUM(a.essalud) essalud, SUM(a.permiso) permiso, SUM(a.compensatorio) compensatorio,
                                                SUM(a.onomastico) onomastico, a.usuario_created_at,a.persona_id
                                FROM sw_asistencias a
                                WHERE NOT a.dni = '07135876'
                                AND a.usuario_created_at = '".Auth::user()->id."'
                                GROUP BY a.area, a.nombres, a.dni, a.cargo
                        ) sw
                        LEFT JOIN (SELECT COUNT(rdv.id) tareas, rdv.usuario_updated_at persona_id
                                FROM rutas_detalle_verbo rdv
                                WHERE rdv.finalizo=1 
                                AND rdv.updated_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                GROUP BY rdv.usuario_updated_at
                        ) AS t ON t.persona_id=sw.persona_id
                        LEFT JOIN (SELECT ROUND((SUM(ap.ot_tiempo_transcurrido) / 60), 2) cant_act, ap.persona_id
                                FROM actividad_personal ap
                                WHERE ap.persona_id=ap.usuario_created_at
                                AND ap.fecha_inicio BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                GROUP BY ap.persona_id
                            ) AS ca ON ca.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(r.id) total_tramites, r.usuario_created_at persona_id
                                FROM rutas r
                                WHERE r.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                AND r.estado=1
                                GROUP BY r.usuario_created_at
                            ) AS tt ON tt.persona_id=sw.persona_id
                        LEFT JOIN (SELECT COUNT(dd.id) docu, dd.usuario_created_at persona_id
                                FROM doc_digital_temporal dd
                                WHERE dd.created_at BETWEEN '$fecha_i 00:00:00' AND '$fecha_f 23:59:59'
                                AND dd.estado = 1
                                GROUP BY dd.usuario_created_at
                            ) AS doc ON doc.persona_id=sw.persona_id; ";

            $result = DB::select($sql);

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
                 ->setSubject("Asistencias de Personal");

              $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
              $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
              /*end configure*/

              /*head*/
              $objPHPExcel->setActiveSheetIndex(0)
                          ->setCellValue('A3', 'N°')
                          ->setCellValue('B3', 'AREA')
                          ->setCellValue('C3', 'NOMBRES')
                          ->setCellValue('D3', 'DNI')
                          ->setCellValue('E3', 'CARGO')
                          ->setCellValue('F3', 'REGIMEN')
                          ->setCellValue('G3', 'FALTAS')
                          ->setCellValue('H3', 'TARDE')
                          ->setCellValue('I3', 'LIC. S.G')
                          ->setCellValue('J3', 'SANCION DICI')
                          ->setCellValue('K3', 'LIC. SINDICAL')
                          ->setCellValue('L3', 'DCSO. MED')
                          ->setCellValue('M3', 'MIN. PERM')
                          ->setCellValue('N3', 'COMISION')
                          ->setCellValue('O3', 'CITACION')
                          ->setCellValue('P3', 'ES-SALUD')
                          ->setCellValue('Q3', 'PERM')
                          ->setCellValue('R3', 'COMPEM')
                          ->setCellValue('S3', 'ONOMAS')
                          ->setCellValue('T3', 'C. ACT')
                          ->setCellValue('U3', 'TAREA')
                          ->setCellValue('V3', 'T. TRAMI')
                          ->setCellValue('W3', 'DOC')
                    ->mergeCells('A1:W1')
                    ->setCellValue('A1', 'LISTADO ASISTENCIAS DE PERSONALES')
                    ->getStyle('A1:W1')->getFont()->setSize(18);

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
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('U')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('V')->setAutoSize(true);
              $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('W')->setAutoSize(true);
              /*end head*/
              /*body*/
              if($result){
                $ini = 4;
                foreach ($result as $key => $value) {

                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A' . $ini, $key + 1)
                                ->setCellValue('B' . $ini, $value->area)
                                ->setCellValue('C' . $ini, $value->nombres)
                                ->setCellValue('D' . $ini, $value->dni)
                                ->setCellValue('E' . $ini, $value->cargo)
                                ->setCellValue('F' . $ini, $value->regimen)
                                ->setCellValue('G' . $ini, $value->faltas)
                                ->setCellValue('H' . $ini, $value->tardanza)
                                ->setCellValue('I' . $ini, $value->lic_sg)
                                ->setCellValue('J' . $ini, $value->sancion_dici)
                                ->setCellValue('K' . $ini, $value->lic_sindical)
                                ->setCellValue('L' . $ini, $value->descanso_med)
                                ->setCellValue('M' . $ini, $value->min_permiso)
                                ->setCellValue('N' . $ini, $value->comision)
                                ->setCellValue('O' . $ini, $value->citacion)
                                ->setCellValue('P' . $ini, $value->essalud)
                                ->setCellValue('Q' . $ini, $value->permiso)
                                ->setCellValue('R' . $ini, $value->compensatorio)
                                ->setCellValue('S' . $ini, $value->onomastico)
                                ->setCellValue('T' . $ini, $value->cant_act)
                                ->setCellValue('U' . $ini, $value->docu)
                                ->setCellValue('V' . $ini, $value->total_tramites)
                                ->setCellValue('W' . $ini, $value->tareas)
                                ;
                    $ini++;
                }
                
              }
              /*end body*/
              $objPHPExcel->getActiveSheet()->getStyle('A3:W3')->applyFromArray($styleThinBlackBorderAllborders);
              $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray($styleAlignment);
              // Rename worksheet
              $objPHPExcel->getActiveSheet()->setTitle('Asistencias');
              // Set active sheet index to the first sheet, so Excel opens this as the first sheet
              $objPHPExcel->setActiveSheetIndex(0);
              // Redirect output to a client’s web browser (Excel5)
              header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="reporteasper.xls"'); // file name of excel
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
    }
    // --

}
