<?php

class ReporteBitacoraPController extends BaseController
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

    public function postReportebitacorapersona()
    {
        ini_set('max_execution_time', 300);
        AuditoriaAcceso::getAuditoria();
        $result = file_get_contents("http://www.muniindependencia.gob.pe/personal/index.php?opcion=marcacion");
        $result = json_decode(utf8_encode($result));

        DB::table('bitacora_personal_marcaciones')->where('usuario_created_at', '=', Auth::user()->id)->delete();

        foreach($result->listado as $key => $lis) 
        {
            $fecha = substr($lis->fecha, 6, 4).'-'.substr($lis->fecha, 3, 2).'-'.substr($lis->fecha, 0, 2); // 07/12/2017

            DB::beginTransaction();
            $obj = new BitacoraMarcaciones;
            $obj->tipo = $lis->tipo;
            $obj->centro_costo = $lis->centroCosto;
            $obj->cargo = $lis->cargo;
            $obj->dni = $lis->dni;
            $obj->apellidos = $lis->apellidos;
            $obj->nombres = $lis->nombres;
            $obj->fecha = $fecha;
            $obj->hora = $lis->hora;
            $obj->nro_papeleta = $lis->nro_papeleta;
            $obj->anio_papeleta = $lis->anio_papeleta;
            $obj->operadorreg = $lis->operadorreg;
            $obj->nombrereg = $lis->nombrereg;
            $obj->fechareg = $lis->fechareg;
            $obj->estacionreg = $lis->estacionreg;

            $obj->estado = 1;
            $obj->usuario_created_at = Auth::user()->id;
            $obj->save();

            DB::commit();
        }

        $sql = "SELECT bpm.*
                    FROM bitacora_personal_marcaciones bpm;";

        $lis = DB::select($sql);

        return Response::json(
                    array(
                        'rst'=>1,
                        'reporte'=> $lis
                    )
                );
    }
    
    public function postReportebitacorapersonapapeleta()
    {
        ini_set('max_execution_time', 300);
        AuditoriaAcceso::getAuditoria();
        $result = file_get_contents("http://www.muniindependencia.gob.pe/personal/index.php?opcion=papeleta");
        $result = json_decode(utf8_encode($result));

        DB::table('bitacora_personal_papeleta')->where('usuario_created_at', '=', Auth::user()->id)->delete();

        foreach($result->papeleta as $key => $lis) 
        {
            DB::beginTransaction();
            $obj = new BitacoraPapeleta;
            $obj->nropapeleta = $lis->nropapeleta;
            $obj->solicitante = $lis->solicitante;
            $obj->motivo_modificacion = $lis->motivo_modificacion;
            $obj->usuario = $lis->usuario;

            $obj->estado = 1;
            $obj->usuario_created_at = Auth::user()->id;
            $obj->save();

            DB::commit();
        }

        $sql = "SELECT bpp.*
                    FROM bitacora_personal_papeleta bpp;";

        $lis = DB::select($sql);

        return Response::json(
                    array(
                        'rst'=>1,
                        'papeleta'=> $lis
                    )
                );
    }

    public function postBuscarbitacorapersona()
    {
        $fecha_ini = Input::get('fecha_ini'); // 2017-09-01
        $fecha_fin = Input::get('fecha_fin'); // 2017-09-15

        $sql = "SELECT bpm.*
                    FROM bitacora_personal_marcaciones bpm
                    WHERE date(created_at) BETWEEN '$fecha_ini' AND '$fecha_fin';";

        $lis = DB::select($sql);

        return Response::json(
                    array(
                        'rst'=>1,
                        'reporte'=> $lis
                    )
                );
    }


    public function postBuscarbitacorapersonapapeleta()
    {
        $fecha_ini = Input::get('fecha_ini'); // 2017-09-01
        $fecha_fin = Input::get('fecha_fin'); // 2017-09-15

        $sql = "SELECT bpm.*
                    FROM bitacora_personal_papeleta bpm
                    WHERE date(created_at) BETWEEN '$fecha_ini' AND '$fecha_fin';";

        $lis = DB::select($sql);

        return Response::json(
                    array(
                        'rst'=>1,
                        'reporte'=> $lis
                    )
                );
    }
    // -- METODO PARA GENERAR EXCEL
    public function getExportreportepersonal()
    {
          AuditoriaAcceso::getAuditoria();
          $fecha_i = Input::get('fecha_ini');
          $fecha_f = Input::get('fecha_fin');

          $sql = " ";

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
