<?php

class ReporteGastosController extends BaseController
{
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }
  

  public function postReportedetallegastos() //Importante que los nombres de los metodos solo deben ser Mayuscula al iniciar!
  {
      $rst = GastosDetallesContables::ReporteDetalleGastos();
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$rst
              //'datos' => array('data' => $rst)
          )
      );
  }

  // Exportar Detalle de Gastos a excel
  public function getExportdetallegastos(){
        $ruc = Input::get('ruc');
        $nro_expede = Input::get('nro_expede');
        $proveedor = Input::get('proveedor');
        $observacion = Input::get('observacion');
        $fecha_ini = Input::get('fecha_ini');
        $fecha_fin = Input::get('fecha_fin');
        $saldos_pago = Input::get('saldos_pago');

        $result = GastosDetallesContables::ReporteDetalleGastos();

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
               ->setSubject("Pagos a Proveedores");

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
            /*end configure*/

            /*head*/
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'N°')
                        ->setCellValue('B3', 'EXPEDIENTE')
                        ->setCellValue('C3', 'GC')
                        ->setCellValue('D3', 'GD')
                        ->setCellValue('E3', 'GG')
                        ->setCellValue('F3', 'FECHA EXP.')
                        ->setCellValue('G3', 'DOCUMENTO')
                        ->setCellValue('H3', 'NRO. DOCUM.')
                        ->setCellValue('I3', 'RUC')
                        ->setCellValue('J3', 'PROVEEDOR')
                        ->setCellValue('K3', 'ESP. D')
                        ->setCellValue('L3', 'FECHA PAGO')
                        ->setCellValue('M3', 'DOC. PAGO')
                        ->setCellValue('N3', 'DOC. PERSON')
                        ->setCellValue('N3', 'PERSON PAGO')
                        ->setCellValue('O3', 'PERSON PAGO')
                        ->setCellValue('P3', 'OBSERVACION')
                  ->mergeCells('A1:P1')
                  ->setCellValue('A1', 'LISTADO DETALLES DE PAGOS')
                  ->getStyle('A1:P1')->getFont()->setSize(18);

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
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('k')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('l')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('m')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('n')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('o')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('p')->setAutoSize(true);
            /*end head*/
            /*body*/
            if($result){

              $AC_GC = 0;
              $AC_GD = 0;
              $AC_GG = 0;
              $aux_id = '';
              $ini = 4;

              foreach ($result as $key => $value) {

                if( $aux_id != $value->contabilidad_gastos_id ){
                    if($aux_id != ''){

                      $objPHPExcel->setActiveSheetIndex(0)
                                  ->setCellValue('A' . $ini, "T")
                                  ->setCellValue('B' . $ini, "SALDOS")
                                  ->setCellValue('C' . $ini, round($AC_GC, 2))
                                  ->setCellValue('D' . $ini, round($AC_GD, 2))
                                  ->setCellValue('E' . $ini, round($AC_GG, 2))
                                  /*->setCellValue('F' . $ini, "CPP")
                                  ->setCellValue('G' . $ini, round(($AC_GC-$AC_GG), 2))
                                  ->setCellValue('H' . $ini, "DPP")
                                  ->setCellValue('I' . $ini, round(($AC_GC-$AC_GD), 2))*/
                                  ->setCellValue('J' . $ini, "")
                                  ->setCellValue('J' . $ini, "")
                                  ->setCellValue('J' . $ini, "")
                                  ->setCellValue('J' . $ini, "")

                                  ->setCellValue('J' . $ini, "")
                                  ->setCellValue('K' . $ini, "")
                                  ->setCellValue('L' . $ini, "")
                                  ->setCellValue('M' . $ini, "")
                                  ->setCellValue('N' . $ini, "")
                                  ->setCellValue('O' . $ini, "")
                                  ->setCellValue('P' . $ini, "")
                                  ->getStyle('A'.$ini.':P'.$ini)->getFont()->setSize(13);
                                  ;
                        $AC_GC = 0;
                        $AC_GD = 0;
                        $AC_GG = 0;

                        $ini++;
                    }
                    $aux_id = $value->contabilidad_gastos_id;
                }
                
                  $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValue('A' . $ini, $key + 1)
                              ->setCellValue('B' . $ini, $value->nro_expede)
                              ->setCellValue('C' . $ini, $value->gc)
                              ->setCellValue('D' . $ini, $value->gd)
                              ->setCellValue('E' . $ini, $value->gg)
                              ->setCellValue('F' . $ini, $value->fecha_documento)
                              ->setCellValue('G' . $ini, $value->documento)
                              ->setCellValue('H' . $ini, $value->nro_documento)
                              ->setCellValue('I' . $ini, $value->ruc)
                              ->setCellValue('J' . $ini, $value->proveedor)
                              ->setCellValue('K' . $ini, $value->esp_d)
                              ->setCellValue('L' . $ini, $value->fecha_doc_b)
                              ->setCellValue('M' . $ini, $value->doc_b)
                              ->setCellValue('N' . $ini, $value->nro_doc_b)
                              ->setCellValue('O' . $ini, $value->persona_doc_b)
                              ->setCellValue('P' . $ini, $value->observacion)
                              ;
                // Acumuladores
                $AC_GC += $value->gc*1;
                $AC_GD += $value->gd*1;
                $AC_GG += $value->gg*1;

                $ini++;
              }
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $ini, "T")
                            ->setCellValue('B' . $ini, "SALDOS")
                            ->setCellValue('C' . $ini, round($AC_GC, 2))
                            ->setCellValue('D' . $ini, round($AC_GD, 2))
                            ->setCellValue('E' . $ini, round($AC_GG, 2))
                            /*->setCellValue('F' . $ini, "CPP")
                            ->setCellValue('G' . $ini, round(($AC_GC-$AC_GG), 2))
                            ->setCellValue('H' . $ini, "DPP")
                            ->setCellValue('I' . $ini, round(($AC_GC-$AC_GD), 2))*/
                            ->setCellValue('J' . $ini, "")
                            ->setCellValue('J' . $ini, "")
                            ->setCellValue('J' . $ini, "")
                            ->setCellValue('J' . $ini, "")
                            
                            ->setCellValue('J' . $ini, "")
                            ->setCellValue('K' . $ini, "")
                            ->setCellValue('L' . $ini, "")
                            ->setCellValue('M' . $ini, "")
                            ->setCellValue('N' . $ini, "")
                            ->setCellValue('O' . $ini, "")
                            ->setCellValue('P' . $ini, "")
                            ->getStyle('A'.$ini.':P'.$ini)->getFont()->setSize(13);
              
            }
            /*end body*/
            $objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($styleThinBlackBorderAllborders);
            $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleAlignment);
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Proveedores');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="reportedpp.xls"'); // file name of excel
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


  public function postReportedetallegastostotales()
  {
      $rst = GastosDetallesContables::ReporteDetalleGastosTotales();
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$rst
          )
      );
  }
  

  // PROCESO DE REPORTES DE SALDOS POR PAGAR A PROVEEDORES
  public function postReportesaldosporpagar()
  {
      $rst = GastosDetallesContables::ReporteSaldosPagar();
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$rst
          )
      );
  }

   public function getExportsaldosporpagar(){
        $ruc = Input::get('ruc');
        $fecha = Input::get('fecha');
        $result = GastosDetallesContables::ReporteSaldosPagar();

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
               ->setSubject("Pagos a Proveedores");

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
            /*end configure*/

            /*head*/
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'N°')
                        ->setCellValue('B3', 'RUC')
                        ->setCellValue('C3', 'PROVEEDOR')
                        ->setCellValue('D3', 'EXPEDIENTE')
                        ->setCellValue('E3', 'TOTAL GC')
                        ->setCellValue('F3', 'TOTAL GD')
                        ->setCellValue('G3', 'TOTAL GG')
                        ->setCellValue('H3', 'DEVENGADO POR PAGAR')
                        ->setCellValue('I3', 'COMPROMISO POR PAGAR')
                        //->setCellValue('J3', 'TIPO DE AVISO')
                        //->setCellValue('K3', 'PROCESO')
                        //->setCellValue('L3', 'ASUNTO')
                        //->setCellValue('M3', 'AREA')
                  ->mergeCells('A1:I1')
                  ->setCellValue('A1', 'LISTADO DE SALDOS A PAGAR')
                  ->getStyle('A1:I1')->getFont()->setSize(18);

            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
            //$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
            //$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('k')->setAutoSize(true);
            //$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('l')->setAutoSize(true);
            //$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
            /*end head*/
            /*body*/
            if($result){
              foreach ($result as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValueExplicit('A' . ($key + 4), $key + 1)
                              ->setCellValueExplicit('B' . ($key + 4), $value->ruc)
                              ->setCellValueExplicit('C' . ($key + 4), $value->proveedor)
                              ->setCellValueExplicit('D' . ($key + 4), $value->nro_expede)
                              ->setCellValueExplicit('E' . ($key + 4), $value->total_gc)
                              ->setCellValueExplicit('F' . ($key + 4), $value->total_gd)
                              ->setCellValue('G' . ($key + 4), $value->total_gg)
                              ->setCellValue('H' . ($key + 4), $value->total_pagar_gd)
                              ->setCellValue('I' . ($key + 4), $value->total_pagar_gc)
                              //->setCellValue('J' . ($key + 4), $value->tipo_aviso)
                              //->setCellValue('K' . ($key + 4), $value->proceso)
                              //->setCellValue('L' . ($key + 4), $value->asunto)
                              //->setCellValue('M' . ($key + 4), $value->area)
                              ;
              }
            }
            /*end body*/
            $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($styleThinBlackBorderAllborders);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleAlignment);
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Proveedores');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="reportespp.xls"'); // file name of excel
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
