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
                        ->setCellValue('C3', 'FASE')
                        ->setCellValue('D3', 'MONTO')
                        ->setCellValue('E3', 'FECHA DOC.')
                        ->setCellValue('F3', 'DOCUMENTO')
                        ->setCellValue('G3', 'NRO. DOCUM.')
                        ->setCellValue('H3', 'RUC')
                        ->setCellValue('I3', 'PROVEEDOR')
                        ->setCellValue('J3', 'ESP. D')
                        ->setCellValue('K3', 'OBSERVACION')
                  ->mergeCells('A1:K1')
                  ->setCellValue('A1', 'LISTADO DETALLES DE PAGOS')
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
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('k')->setAutoSize(true);
            /*end head*/
            /*body*/
            if($result){
              foreach ($result as $key => $value) {
                $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValueExplicit('A' . ($key + 4), $key + 1)
                              ->setCellValueExplicit('B' . ($key + 4), $value->nro_expede)
                              ->setCellValueExplicit('C' . ($key + 4), $value->tipo_expede)
                              ->setCellValueExplicit('D' . ($key + 4), $value->monto_expede)
                              ->setCellValueExplicit('E' . ($key + 4), $value->fecha_documento)
                              ->setCellValueExplicit('F' . ($key + 4), $value->documento)
                              ->setCellValue('G' . ($key + 4), $value->nro_documento)
                              ->setCellValue('H' . ($key + 4), $value->ruc)
                              ->setCellValue('I' . ($key + 4), $value->proveedor)
                              ->setCellValue('J' . ($key + 4), $value->esp_d)
                              ->setCellValue('K' . ($key + 4), $value->observacion)
                              ;
              }
            }
            /*end body*/
            $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($styleThinBlackBorderAllborders);
            $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleAlignment);
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
