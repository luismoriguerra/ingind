<?php

class DocumentoDigitalController extends \BaseController {

	public function postCargar()
    {
        if ( Request::ajax() ) {
            $documento_digital = DocumentoDigital::getDocumentosDigitales();
            return Response::json(array('rst'=>1,'datos'=>$documento_digital));
        }
    }

    public function postCorrelativo()
    {
        if ( Request::ajax() ) {
            $r = DocumentoDigital::Correlativo();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postCambiarestado()
    {
        if (Request::ajax() && Input::has('id') && Input::has('estado')) {
            $plantilla_doc = PlantillaDocumento::find(Input::get('id'));
            $plantilla_doc->estado = Input::get('estado');
            $plantilla_doc->save();
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro inhabilitado correctamente',
                )
            );
        }
    }
    
        public function postEditarfecha()
    {
        if (Request::ajax() && Input::has('id') && Input::has('fecha') && Input::has('comentario') )  {
            $a      = new DocumentoDigital;
            $listar = Array();
            $listar = $a->getEditarFecha();
            
            if($listar==1){
            $created=Input::get('fecha').' '.date ("h:i:s");     
            $DocDigital = new DocumentoFechaH;
            $DocDigital->documento_id = Input::get('id');
            $DocDigital->fecha_documento = $created;
            $DocDigital->comentario = Input::get('comentario');
            $DocDigital->usuario_created_at = Auth::user()->id;
            $DocDigital->save();
            
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro Editado correctamente',
                )
            );
            }

        }
    }

    public function postCambiarestadodoc()
    {
        if (Request::ajax() && Input::has('id') && Input::has('estado')) {
            $DocDigital = DocumentoDigital::find(Input::get('id'));
            $DocDigital->estado = Input::get('estado');
            $DocDigital->save();
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro actualizado correctamente',
                )
            );
        }
    }

    public function postEditar()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');

            $jefe = DB::table('personas')
             ->where(         
                        function($query){
                            $query->where('area_id', '=', Auth::user()->area_id)
                            ->orwhereRaw('FIND_IN_SET(' . Auth::user()->area_id . ',area_responsable)');
                        }
                    )
                    ->whereIn('rol_id', array(8,9,6))
                    ->where('estado',1)
                    ->get();
                    
            $DocDigital = DocumentoDigital::find(Input::get('iddocdigital'));
            $DocDigital->titulo = Input::get('titulofinal');
            $DocDigital->correlativo = Input::get('titulo');
            $DocDigital->asunto = Input::get('asunto');
            $DocDigital->cuerpo = $html;
            $DocDigital->plantilla_doc_id = Input::get('plantilla');
            $DocDigital->area_id = Auth::user()->area_id;

            if(Input::has('chk_todasareas') && Input::get('chk_todasareas') == 'allgesub'){
                $DocDigital->envio_total = 1;
            }else{
                $DocDigital->envio_total = 0;
            }

            $DocDigital->tipo_envio = Input::get('tipoenvio');
            if(Input::get('tipoenvio')==3 or Input::get('tipoenvio')==5){
                $DocDigital->persona_id = Auth::user()->id;    
            }else{
                $DocDigital->persona_id = $jefe[0]->id;                
            }
            
            $DocDigital->usuario_updated_at = Auth::user()->id;
            $DocDigital->save();

            if($DocDigital->id){
                $affectedRows = DocumentoDigitalArea::where('doc_digital_id', '=', $DocDigital->id)->get();
                foreach ($affectedRows as $docd) {
                    $dd = DocumentoDigitalArea::find($docd->id);
                    $dd->estado = 0;
                    $dd->usuario_updated_at = Auth::user()->id;
                    $dd->save();
                }

                $areas_envio = json_decode(Input::get('areasselect'));
                foreach ($areas_envio as $key => $value) {
                    $DocDigitalArea = new DocumentoDigitalArea();
                    $DocDigitalArea->doc_digital_id = $DocDigital->id;
                    $DocDigitalArea->persona_id = $value->persona_id;
                    $DocDigitalArea->area_id = $value->area_id;
                    $DocDigitalArea->tipo = $value->tipo;
                    $DocDigitalArea->usuario_created_at = Auth::user()->id;
                    $DocDigitalArea->save();
                }                    
            }

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Actualizar plantilla
     * POST /plantilla/editar
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');
            $jefe = DB::table('personas')
             ->where(         
                        function($query){
                            $query->where('area_id', '=', Auth::user()->area_id)
                            ->orwhereRaw('FIND_IN_SET(' . Auth::user()->area_id . ',area_responsable)');
                        }
                    )
                    ->whereIn('rol_id', array(8,9,6))
                    ->where('estado',1)
                    ->get();

            $DocDigital = new DocumentoDigital;
            $DocDigital->titulo = Input::get('titulofinal');
            $DocDigital->asunto = Input::get('asunto');
            $DocDigital->correlativo = Input::get('titulo');
            $DocDigital->cuerpo = $html;
            $DocDigital->plantilla_doc_id = Input::get('plantilla');
            $DocDigital->area_id = Auth::user()->area_id;

            if(Input::has('chk_todasareas') && Input::get('chk_todasareas') == 'allgesub'){
                $DocDigital->envio_total = 1;
            }else{
                $DocDigital->envio_total = 0;
            }

            $DocDigital->tipo_envio = Input::get('tipoenvio');
            if(Input::get('tipoenvio')==3 or Input::get('tipoenvio')==5){
                $DocDigital->persona_id = Auth::user()->id;    
            }else{
                $DocDigital->persona_id = $jefe[0]->id;                
            }

            $DocDigital->usuario_created_at = Auth::user()->id;
            $DocDigital->save();

            if($DocDigital->id){
                
                    $created=Input::get('fecha').' '.date ("h:i:s");     
                    $DocHistorial = new DocumentoFechaH;
                    $DocHistorial->documento_id = $DocDigital->id;
                    $DocHistorial->fecha_documento = $DocDigital->created_at;
                    $DocHistorial->comentario ='Inicio';
                    $DocHistorial->usuario_created_at = Auth::user()->id;
                    $DocHistorial->save();
                /*if(Input::get('tipoenvio')==3){
                    $DocDigitalArea = new DocumentoDigitalArea();
                    $DocDigitalArea->doc_digital_id = $DocDigital->id;
                    $DocDigitalArea->persona_id = $jefe[0]->id;
                    $DocDigitalArea->area_id =Auth::user()->area_id;
                    $DocDigitalArea->tipo = 1;
                    $DocDigitalArea->usuario_created_at = Auth::user()->id;
                    $DocDigitalArea->save();
                }else{*/
                	$areas_envio = json_decode(Input::get('areasselect'));
                	foreach ($areas_envio as $key => $value) {
                		$DocDigitalArea = new DocumentoDigitalArea();
                		$DocDigitalArea->doc_digital_id = $DocDigital->id;
                		$DocDigitalArea->persona_id = $value->persona_id;
                		$DocDigitalArea->area_id = $value->area_id;
                        $DocDigitalArea->tipo = $value->tipo;
                		$DocDigitalArea->usuario_created_at = Auth::user()->id;
                		$DocDigitalArea->save();
                	}
                //}
            }
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente','nombre'=>$DocDigital->titulo,'iddocdigital'=>$DocDigital->id));
        }
    }

    public function getVista($id,$tamano,$tipo)
    {

        $DocumentoDigital = DocumentoDigital::find($id);
        $sql= "SELECT d.posicion,d.posicion_fecha
                FROM documentos d
                INNER JOIN plantilla_doc pd ON d.id=pd.tipo_documento_id
                WHERE pd.id=".$DocumentoDigital->plantilla_doc_id;
        $oData = DB::select($sql);
        
        if ($DocumentoDigital) {
            /*get remitente data*/
            $persona = Persona::find($DocumentoDigital->persona_id);
            $area = Area::find($DocumentoDigital->area_id);
            $rol= Rol::find($persona->rol_id);
            $remitente = $persona->nombre." ".$persona->paterno." ".$persona->materno." - <span style='font-size:11px'>(".$rol->nombre.") ".$area->nombre."</span>";
            /*end get remitente data */

            /*get destinatario data*/
            $copias = '';
            $destinatarios = '';
            if($DocumentoDigital->envio_total ==1){
                $copias = '';
                $destinatarios = 'Todas las Gerencias y Sub Gerencias';
            }else{
                $copias.= '';
                $destinatarios.= '';
                $DocDigitalArea = DocumentoDigitalArea::where('doc_digital_id', '=', $id)->where('estado', '=', 1)->get();
                foreach($DocDigitalArea as $key => $value){
                    $persona2 = Persona::find($value->persona_id);
                    $area2 = Area::find($value->area_id);
                    $rol2= Rol::find($persona2->rol_id);
                    if($value->tipo ==1){
                        if($destinatarios!=""){
                            $destinatarios.="<br><span>&nbsp;&nbsp;&nbsp;<span style='padding-left: 9em;'>";
                        }
                        else{
                            $destinatarios.="<span>";
                        }
                        $destinatarios.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">('.$rol2->nombre.') '.$area2->nombre.'</span>';
                    }else{
                        if($copias!=""){
                            $copias.="<br><span>&nbsp;&nbsp;&nbsp;<span style='padding-left: 9em;'>";
                        }
                        else{
                            $copias.="<span>";
                        }
                        $copias.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">('.$rol2->nombre.') '.$area2->nombre.'</span>';
                    }        
                }
                //$destinatarios.= '</ul>';    
                //$copias.= '</ul>';          
            }

            /*end get destinatario data*/
            if($tamano==4){
                $size=150;}
            else if($tamano==5){
                 $size=120;
            }
            
            $png = QrCode::format('png')->size($size)->generate("http://proceso.munindependencia.pe/documentodig/vistaprevia/".$id);
            $png = base64_encode($png);
            $png= "<img src='data:image/png;base64," . $png . "'>";
            $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
            
            $fechabase=$DocumentoDigital->created_at;
            $fecha=explode(' ', $fechabase);
            $fechaa=explode('-', $fecha[0]);
            
            $cabecera=1;
            
            if($DocumentoDigital->tipo_envio==4){
                $cabecera=null;
            }
//            if($DocumentoDigital->tipo_envio==4 AND $DocumentoDigital->area_id==12){
//                $DocumentoDigital->area_id=1;
//            }
//            if($DocumentoDigital->tipo_envio==4 AND $DocumentoDigital->area_id==44){
//                $DocumentoDigital->area_id=1;
//            }
            if($tipo==0){
                $vistaprevia='Documento Vista Previa';}
            else if($tipo==1){
                 $vistaprevia='';
            }
            $documenttittle= $DocumentoDigital->titulo;
            if(strlen($documenttittle)>60){
                $dd=explode("-",$documenttittle);
                $documenttittle='';
                if( strlen( $dd[0] )<=40 ){
                    for ($i=0; $i < count($dd) ; $i++) { 
                        if( ($i+2)==count($dd) ){
                            $documenttittle.="<br><br>".$dd[$i]."-".$dd[$i+1];
                            $i++;
                        }
                        else{
                            $documenttittle.=$dd[$i]."-";
                        }
                    }
                }
                else{
                    for ($i=0; $i < count($dd) ; $i++) { 
                        if( ($i+3)==count($dd) ){
                            $documenttittle.="<br><br>".$dd[$i]."-".$dd[$i+1]."-".$dd[$i+2];
                            $i++;$i++;
                        }
                        else{
                            $documenttittle.=$dd[$i]."-";
                        }
                    }
                }
            }
            else{
                $documenttittle= $DocumentoDigital->titulo;
            }
            $params = [
                'tamano'=>$tamano,
                'posicion'=>$oData[0]->posicion,
                'posicion_fecha'=>$oData[0]->posicion_fecha,
                'tipo_envio'=>$DocumentoDigital->tipo_envio,
                'titulo' => $documenttittle,
                'vistaprevia'=>$vistaprevia,
                'area' => $DocumentoDigital->area_id,
                'asunto' => $DocumentoDigital->asunto,
                'conCabecera' => $cabecera,
                'contenido' => $DocumentoDigital->cuerpo,
                'fecha' => 'Independencia, '.$fechaa[2].' de '.$meses[$fechaa[1]*1].' del '.$fechaa[0],
                'remitente' => $remitente,
                'destinatario' => $destinatarios,
                'imagen'=>$png,
            ];  
            if($copias != '' && $copias != '<ul></ul>'){ 
                $params['copias'] = $copias;                
            }
            $params = $params;
            
            $view = \View::make('admin.mantenimiento.templates.plantilla1', $params);
            $html = $view->render();

            $pdf = App::make('dompdf');
            $pdf->loadHTML($html);
            $pdf->setPaper('a'.$tamano)->setOrientation('portrait');

            return $pdf->stream();
            //\PDFF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream();
        }

    }


    function dataEjemploPlantilla() {
        return [
            'titulo' => '(EJEMPLO) MEMORANDUM CIRCULAR N 016-2016-SG/MDC',
            'remitente' => 'Nombre de Encargado <br>Nombre de Gerencia y/o Subgerencia',
            'destinatario' => 'Nombre a quien va dirigido <br>Nombre de Gerencia y/o Subgerencia',
            'asunto' => 'Titulo, <i>Ejemplo:</i> Invitación a la Inaguración del Palacio Municipal',
            'fecha' => 'Lima,'.date('d').' de '.date('F').' del '.date('Y'),
        ];
    }


    public function postDocdigital()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

                $array=array();
                $array['where']='';$array['usuario']=Auth::user()->id;
                $array['limit']='';$array['order']='';
                $array['having']='HAVING ruta=0 AND rutadetallev=0';

                if(Input::has('idtipo') AND Input::get('idtipo')!=''){
                    if(Input::get('idtipo')==1){
                        $array['having']="HAVING ruta=".Input::get('idtipo')." OR rutadetallev=".Input::get('idtipo')."";                    
                    }else{
                         $array['having']="HAVING ruta=".Input::get('idtipo')." AND rutadetallev=".Input::get('idtipo').""; 
                    }
                }
                
             /*   if (Input::has('draw')) {
                    if (Input::has('order')) {
                        $inorder=Input::get('order');
                        $incolumns=Input::get('columns');
                        $array['order']=  ' ORDER BY '.
                                          $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                          $inorder[0]['dir'];
                    }

                    $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                    $aParametro["draw"]=Input::get('draw');
                }*/
                /************************************************************/

                if( Input::has('titulo') AND Input::get('titulo')!='' ){
                    $array['where'].=" AND dd.titulo LIKE '%".Input::get('titulo')."%' ";
                }

                if( Input::has('asunto') AND Input::get('asunto')!='' ){
                    $array['where'].=" AND dd.asunto LIKE '%".Input::get('asunto')."%' ";
                }

                if( Input::has('plantilla') AND Input::get('plantilla')!='' ){
                    $array['where'].=" AND pd.descripcion LIKE '%".Input::get('plantilla')."%' ";
                }
/*

                if( Input::has("area") ){
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
                }*/

                $array['order']=" ORDER BY ruta DESC,rutadetallev DESC ";

                $cant  = DocumentoDigital::getDocdigitalCount( $array );
                $aData = DocumentoDigital::getDocdigital( $array );

                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $aData;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);
        }
    }

	/**
	 * Display a listing of the resource.
	 * GET /documentodigital
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /documentodigital/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /documentodigital
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /documentodigital/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
