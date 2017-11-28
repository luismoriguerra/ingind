<?php
class FlujoController extends \BaseController
{

    /**
     * cargar flujos, mantenimiento
     * POST /flujo/cargar
     *
     * @return Response
     */
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
                    $array['where'].=" AND f.nombre LIKE '%".$nombre."%' ";
                }
            }

            if( Input::has("area") ){
                $area=Input::get("area");
                if( trim( $area )!='' ){
                    $array['where'].=" AND a.nombre LIKE '%".$area."%' ";
                }
            }

            if( Input::has("categoria") ){
                $categoria=Input::get("categoria");
                if( trim( $categoria )!='' ){
                    $array['where'].=" AND c.nombre LIKE '%".$categoria."%' ";
                }
            }

            if( Input::has("tipo_flujo") ){
                $tipo_flujo=Input::get("tipo_flujo");
                if( trim( $tipo_flujo )!='' ){
                    $array['where'].=" AND f.tipo_flujo='".$tipo_flujo."' ";
                }
            }

            if( Input::has("estado") ){
                $estado=Input::get("estado");
                if( trim( $estado )!='' ){
                    $array['where'].=" AND f.estado='".$estado."' ";
                }
            }

            $array['order']=" ORDER BY f.nombre ";

            $cant  = Flujo::getCargarCount( $array );
            $aData = Flujo::getCargar( $array );

            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }

    /**
     * cargar flujos, mantenimiento
     * POST /flujo/listar
     *
     * @return Response
     */
    public function postListar()
    {
        if ( Request::ajax() ) {
           
            $f      = new Flujo();
            $listar = Array();
            $listar = $f->getFlujo();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }
        public function postListarmicroproceso()
    {
        if ( Request::ajax() ) {
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
             
             
            if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                $array['where'].=" AND f.tipo_flujo=2 ";
            }elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                $array['where'].=" AND f.tipo_flujo=1 ";
            }
            
            if( Input::has("micro")  AND Input::get('micro')==1 ){
                    $array['where'].=" AND f.categoria_id =16 "; 
            }
            
            if( Input::has("nombre")  AND Input::get('nombre')!='' ){
                $proceso=explode(" ",trim(Input::get('nombre')));
                 for($i=0; $i<count($proceso); $i++){
                    $array['where'].=" AND f.nombre LIKE '%".$proceso[$i]."%' ";
                }
            }
            
            $array['order']=" ORDER BY f.nombre ";
            
            $cant  = Flujo::getFlujoMicroProcesoCount( $array );
            $aData = Flujo::getFlujoMicroProceso( $array );
            
            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    
        public function postListarproceso()
    {
        if ( Request::ajax() ) {
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
             
             
            if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                $array['where'].=" AND f.tipo_flujo=2 ";
            }elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                $array['where'].=" AND f.tipo_flujo=1 ";
            }
            
            if( Input::has("nomicro")  AND Input::get('nomicro')==1 ){
                    $array['where'].=" AND f.categoria_id !=16 "; 
            }
            
            if( Input::has("nombre")  AND Input::get('nombre')!='' ){
                $proceso=explode(" ",trim(Input::get('nombre')));
                 for($i=0; $i<count($proceso); $i++){
                    $array['where'].=" AND f.nombre LIKE '%".$proceso[$i]."%' ";
                }
            }
            
            $array['order']=" ORDER BY f.nombre ";
            
            $cant  = Flujo::getFlujoProcesoCount( $array );
            $aData = Flujo::getFlujoProceso( $array );
            
            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";
            return Response::json($aParametro);

        }
    }
    
            public function postListarproceso2()
    {
        if ( Request::ajax() ) {
            $array=array();
            $array['where']='';$array['usuario']=Auth::user()->id;
            $array['limit']='';$array['order']='';
            
             
            if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                $array['where'].=" AND f.tipo_flujo=2 ";
            }elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                $array['where'].=" AND f.tipo_flujo=1 ";
            }
            
            if( Input::has("nomicro")  AND Input::get('nomicro')==1 ){
                    $array['where'].=" AND f.categoria_id !=16 "; 
            }
            
            $array['order']=" ORDER BY f.nombre ";
            
            $aData = Flujo::getFlujoProceso2( $array );
            
            return Response::json(
                            array(
                                'rst' => 1,
                                'datos' => $aData,
                            )
            );

        }
    }

/**
     * Store a newly created resource in storage.
     * POST /flujo/crear
     *
     * @return Response
     */
    public function postCrear()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required,
                //'path' =>$regex.'|unique:modulos,path,',
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>$validator->messages(),
                    )
                );
            }

            $flujos = new Flujo;
            $flujos['nombre'] = Input::get('nombre');
            $flujos['estado'] = Input::get('estado');
            $flujos['area_id'] = Input::get('area_id');
            $flujos['tipo_flujo'] = Input::get('tipo_flujo');
            $flujos['categoria_id'] = Input::get('categoria_id');
            $flujos['usuario_created_at'] = Auth::user()->id;
            $flujos->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                )
            );
        }
    }

    /**
     * Update the specified resource in storage.
     * POST /flujo/editar
     *
     * @return Response
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            //$regex='regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required='required';
            $reglas = array(
                'nombre' => $required,
            );

            $mensaje= array(
                'required'    => ':attribute Es requerido',
                'regex'        => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

            if ( $validator->fails() ) {
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>$validator->messages(),
                    )
                );
            }
            $flujoId = Input::get('id');
            $flujo = Flujo::find($flujoId);
            $flujo['nombre'] = Input::get('nombre');
            $flujo['area_id'] = Input::get('area_id');
            $flujo['tipo_flujo'] = Input::get('tipo_flujo');
            $flujo['categoria_id'] = Input::get('categoria_id');
            $flujo['estado'] = Input::get('estado');
            $flujo['usuario_updated_at'] = Auth::user()->id;
            $flujo->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('flujo_tipo_respuesta')
                    ->where('flujo_id', $flujoId)
                    ->update(
                        array(
                            'estado' => 0,
                            'usuario_updated_at' => Auth::user()->id
                        ));
            }
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /flujo/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {

        if ( Request::ajax() ) {

            $flujo = Flujo::find(Input::get('id'));
            $flujo->usuario_created_at = Auth::user()->id;
            $flujo->estado = Input::get('estado');
            $flujo->save();
            if (Input::get('estado') == 0 ) {
                //actualizando a estado 0 segun
                DB::table('flujo_tipo_respuesta')
                    ->where('flujo_id', Input::get('id'))
                    ->update(
                        array(
                            'estado' => 0,
                            'usuario_updated_at' => Auth::user()->id
                        )
                    );
            }
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }


        public function exportExcel($propiedades,$estilos,$cabecera,$data){
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

      $head=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');

      /*instanciar phpExcel*/            
      $objPHPExcel = new PHPExcel();
      /*end instanciar phpExcel*/

      /*configure*/
      $objPHPExcel->getProperties()->setCreator($propiedades['creador'])
                                  ->setSubject($propiedades['subject']);

      $objPHPExcel->getDefaultStyle()->getFont()->setName($propiedades['font-name']);
      $objPHPExcel->getDefaultStyle()->getFont()->setSize($propiedades['font-size']);
      $objPHPExcel->getActiveSheet()->setTitle($propiedades['tittle']);
      /*end configure*/

      /*set up structure*/
      array_unshift($data,(object) $cabecera);
      foreach($data as $key => $value){
        $cont = 0;

        if($key == 0){ // set style to header
          end($value);       
          $objPHPExcel->getActiveSheet()->getStyle('A1:'.$head[key($value)].'1')->applyFromArray($styleThinBlackBorderAllborders);
        }

        foreach($value as $index => $val){
          $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($head[$cont])->setAutoSize(true);
            
          if($index == 'norden' && $key > 0){ //set orden in excel
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $key);                
          }else{ //poblate info
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($head[$cont].($key + 1), $val);
          }

          $cont++;
        }          
      }
      /*end set up structure*/

      $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel5)
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte.xls"'); // file name of excel
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
    }

    public function postProduccionxproceso()
    {
        if ( Request::ajax() ) {
           
            $f      = new Flujo();
            $listar = Array();
            $listar = $f->getProdporproceso();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }


    public function getExportproduccionxproceso(){
        $rst=Flujo::getProdporproceso();
        

        $propiedades = array(
          'creador'=>'Gerencia Modernizacion',
          'subject'=>'Prod por Proceso',
          'tittle'=>'Prod por Proceso',
          'font-name'=>'Bookman Old Style',
          'font-size'=>8,
        );

         $cabecera = array(
          'N°',        
          'AREA',
          'PROCESO',
          'TIEMPO TOTAL',
          'NRO ASIGNACIONES',
          'ORDEN',
          'TIEMPO',
          'AREA',
          'ACCIONES',
          '% TIEMPO TOTAL',
          '% TIEMPO ACTIVIDAD',
          'ULT.USUARIO ACTUALIZO',
          'ULT.FECHA ACTUALIZACION',
        );

        $this->exportExcel($propiedades,'',$cabecera,$rst);
    }


    // -- 
    public function postRoluser()
    {
        $oData = Area::getRol();
        $valor = 0;
        $categoria = NULL;
        $cargo_master = false;
        if($oData)
        {
            foreach ($oData as $key => $lis)
            {
                $array[] = $lis->cargo_id;
                if (in_array(12, $array)){
                    $cargo_master = true;
                    break;
                }else
                    $cargo_master = false;                
            }

            if($cargo_master == true) // User Master
                $valor = 1;
            else
            {
                $sSql = "SELECT c.id, c.nombre
                            FROM categorias c
                            WHERE c.id = 20 AND estado = 1;";
                $categoria = DB::select($sSql);

                $valor = 0;
            }
        }

        return Response::json(
            array(
                'rst'=>1,
                'datos'=> $valor,
                'data_cat'=> $categoria
            )
        );
    }
    // --


  /*  public function postProduccionxproceso()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

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
               

                if( Input::has('id_union') AND Input::get('id_union')!='' ){
                  $id_union=explode(" ",trim(Input::get('id_union')));
                  for($i=0; $i<count($id_union); $i++){
                    $array['where'].=" AND tr.id_union LIKE '%".$id_union[$i]."%' ";
                  }
                }

                if( Input::has("usuario") ){
                    $usuario=Input::get("usuario");
                    if( trim( $usuario )!='' ){
                        $array['where'].=" AND CONCAT_WS(p.nombre,p.paterno,p.materno) LIKE '%".$usuario."%' ";
                    }
                }

                if( Input::has("fecha_tramite") ){
                    $fecha_t=Input::get("fecha_tramite");
                    if( trim( $fecha_inicio )!='' ){
                        $array['where'].=" AND DATE(tr.fecha_tramite)='".$fecha_t."' ";
                    }
                }

                $array['order']=" ORDER BY tr.fecha_tramite DESC ";

                $cant  = Flujo::getProdporprocesoCount( $array );
                $aData = Flujo::getProdporproceso( $array );

                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $aData;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);
        }
    }*/

}
