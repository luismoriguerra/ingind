<?php

class AnexoController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function postAnexosbytramite(){
		$rst=Anexo::getAnexosbyTramite();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function postAnexobyid(){
		$rst=Anexo::getDetalleAnexobyId();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function index()
	{
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$img = $_FILES['txt_file'];
		$data = $_POST;

/*		var_dump($img);
		var_dump($data);
		exit();
*/
		if($img && $data){

			$anexofind=Anexo::find($data['txt_anexoid']);
			if($anexofind){ //editar
				$anexofind['nro_folios'] = $data['txt_folio'];
				 $anexofind['obeservacion'] = $data['txt_observ'];
                                 $anexofind['documento_id'] = $data['cbo_tipodoc'];
				/*if($anexofind->persona_id != Auth::user()->id){
					$anexofind['usuario_atendio'] = Auth::user()->id;
					$anexofind['fecha_recepcion'] = date('Y-m-d H:i:s');					
				}*/

				if($img['name']){
					$name = md5($img['name']).'_'.$data['txt_codtramite'].'.jpeg';
					$root = public_path().'/img/anexo/'.$name;
					if(move_uploaded_file($img['tmp_name'], $root)){
						$anexofind['imagen'] = $name;						
					}
				}

                $anexofind['usuario_updated_at']= Auth::user()->id;
                $anexofind->save(); 

                return Response::json(
			        array(
			            'rst'=>1,
			            'msj'=>'Registro actualizado correctamente',
			        )
			    );
			}else{ //guardar
                                DB::beginTransaction();
				$name = md5($img['name']).'_'.$data['txt_codtramite'].'.jpeg';
				$root = public_path().'/img/anexo/'.$name;

				if(move_uploaded_file($img['tmp_name'], $root)){
					$anexo = new Anexo;
			       	$anexo['tramite_id'] = $data['txt_codtramite'];
			        $anexo['persona_id'] = $data['txt_persona_id'];
			        $anexo['fecha_anexo'] = date('Y-m-d H:i:s');
                                $anexo['documento_id'] = $data['cbo_tipodoc'];
			        $anexo['nombre'] = $data['txt_nombtramite'];
			        $anexo['nro_folios'] = $data['txt_folio'];
                                $anexo['obeservacion'] = $data['txt_observ'];
			        $anexo['imagen'] = $name;
			        $anexo['usuario_created_at'] = Auth::user()->id;   
                                $codigo=Anexo::Correlativo();
                                $anexo['correlativo'] = $codigo->correlativo;
                                $anexo->save();	
                                $codigo='AN-'.$codigo->correlativo.'-'.date('Y');    
                                
                                

                                $tablarelacion = TablaRelacion::where('tramite_id','=',$data['txt_codtramite'])->first();
                                $ruta = Ruta::where('tabla_relacion_id','=',$tablarelacion->id)->first();
                                $rutadetalle = RutaDetalle::whereRaw('ruta_id ='.$ruta->id.
                                               ' AND ISNULL(dtiempo_final) AND condicion=0 AND estado=1 AND fecha_inicio IS NOT NULL ')->first();
                                

                         
        
        $codigounico="";
        $codigounico=$codigo;

        $id_documento='';
        if( Input::has('documento_id2') ){
            $id_documento=Input::get('documento_id2');
        }
        $ruta_id= Input::get('ruta_id2');
        $rutadetalle_id= Input::get('rutadetalle_id2');
        $tablarelacion_id= Input::get('tablarelacion_id2');

        $tablaRelacion=DB::table('tablas_relacion as tr')
                        ->join(
                            'rutas as r',
                            'tr.id','=','r.tabla_relacion_id'
                        )
                        ->where('tr.id_union', '=', $codigo)
                        ->where('r.ruta_flujo_id', '=', 3620)
                        ->where('tr.estado', '=', '1')
                        ->where('r.estado', '=', '1')
                        ->get();

        if(count($tablaRelacion)>0){
            DB::rollback();
            return  array(
                    'rst'=>2,
                    'msj'=>'El trámite ya fue registrado anteriormente'
                );
        }
        else{

        $fecha_inicio2= date('Y-m-d H:i:s');
        if( $fecha_inicio2=='0000-00-00 00:00:00' ){
            $fecha_inicio2=date('Y-m-d H:i:s');
        }
        $tablaRelacion=new TablaRelacion;
        $tablaRelacion['software_id']=1;

        $tablaRelacion['id_union']=$codigo;
        
        $tablaRelacion['fecha_tramite']= $fecha_inicio2; //Input::get('fecha_tramite');
        $tablaRelacion['tipo_persona']=Input::get('tipo_persona2');

        if( Input::has('paterno2') AND Input::has('materno2') AND Input::has('nombre2') ){
            $tablaRelacion['paterno']=Input::get('paterno2');
            $tablaRelacion['materno']=Input::get('materno2');
            $tablaRelacion['nombre']=Input::get('nombre2');
        }
        elseif( Input::has('razon_social2') AND Input::has('ruc2') ){
            $tablaRelacion['razon_social']=Input::get('razon_social2');
            $tablaRelacion['ruc']=Input::get('ruc2');
        }
        elseif( Input::has('area_p_id2') ){
            $tablaRelacion['area_id']=Input::get('area_p_id2');
        }
        elseif( Input::has('carta_id') ){ // Este caso solo es para asignar carta inicio
            $tablaRelacion['area_id']=Auth::user()->area_id;
        }
        elseif( Input::has('razon_social2') ){
            $tablaRelacion['razon_social']=Input::get('razon_social2');
        }

        if( Input::has('doc_digital_id2')){
            $tablaRelacion['doc_digital_id']=Input::get('doc_digital_id2');
        }


        if( Input::has('referente2') AND trim(Input::get('referente2'))!='' ){
            $tablaRelacion['referente']=Input::get('referente2');
        }

        if( Input::has('responsable') AND trim(Input::get('responsable'))!='' ){
            $tablaRelacion['responsable']=Input::get('responsable');
        }
        $tablaRelacion['sumilla']=Input::get('sumilla2');

        $tablaRelacion['persona_autoriza_id']=Input::get('id_autoriza');
        $tablaRelacion['persona_responsable_id']=Input::get('id_responsable');

        $tablaRelacion['usuario_created_at']=Auth::user()->id;
        $tablaRelacion->save();

        $rutaFlujo=RutaFlujo::find(3620);//3620

        $ruta= new Ruta;
        $ruta['tabla_relacion_id']=$tablaRelacion->id;
        $ruta['fecha_inicio']= $fecha_inicio2;
        $ruta['ruta_flujo_id']=$rutaFlujo->id;
        $ruta['flujo_id']=$rutaFlujo->flujo_id;
        $ruta['persona_id']=$rutaFlujo->persona_id;
        $ruta['area_id']=$rutaFlujo->area_id;

        if( Input::has('doc_digital_id2')){
            $ruta['doc_digital_id']=Input::get('doc_digital_id2');
        }
        $ruta['usuario_created_at']= Auth::user()->id;
        $ruta->save();
        /**************CARTA *************************************************/
        $carta=array();
        if( Input::has('carta_id') ){
            $carta= Carta::find(Input::get('carta_id'));
        }
        else{
            $carta= new Carta;
            $carta['flujo_id']=$ruta->flujo_id;
            $carta['correlativo']=0;
            $carta['nro_carta']=$codigo;
            $carta['objetivo']="";
            $carta['entregable']="";
            $carta['alcance']="MDI";
            $carta['flujo_id']=$ruta->flujo_id;

            if( trim(Auth::user()->area_id)!='' ){
                $carta['area_id']=Auth::user()->area_id;
            }
            else{
                $carta['area_id']=$ruta->area_id;
            }
        }
            $carta['union']=1;
            $carta['usuario_updated_at']=Auth::user()->id;
            $carta['ruta_id']=$ruta->id;
            $carta->save();
        /*********************************************************************/
        /************Agregado de referidos*************/
        $referido=new Referido;
        $referido['ruta_id']=$ruta->id;
        $referido['tabla_relacion_id']=$tablaRelacion->id;
        if($tablarelacion_id!=''){
            $referido['tabla_relacion_id']=$tablarelacion_id;
        }
        if( Input::has('doc_digital_id2')){
            $referido['doc_digital_id']=Input::get('doc_digital_id2');
        }
        $referido['tipo']=0;
        $referido['ruta_detalle_verbo_id']=0;
        $referido['referido']=$tablaRelacion->id_union;
        $referido['fecha_hora_referido']=$tablaRelacion->created_at;
        $referido['usuario_referido']=$tablaRelacion->usuario_created_at;
        $referido['usuario_created_at']=Auth::user()->id;
        $referido->save();
        /**********************************************/

        $qrutaDetalle=DB::table('rutas_flujo_detalle')
            ->where('ruta_flujo_id', '=', 3620)
            ->where('estado', '=', '1')
            ->orderBy('norden','ASC')
            ->get();
            $validaactivar=0;
        
        $conteo=0;$array['fecha']=''; // inicializando valores para desglose

        $tiempoG = 1;
        $areaG = array(52,$rutadetalle->area_id);
        $copiaG = 0 ;
        $tipoenvio=2;

            foreach ($areaG as $index => $val) {
  
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$val;
                $rutaDetalle['tiempo_id']=2;         
/*
                if (is_array($tiempo)){
                    $rutaDetalle['dtiempo']=$tiempo[$index];                    
                }else{*/
                    $rutaDetalle['dtiempo']=$tiempoG;
/*                }
*/
                $rutaDetalle['norden']=$index + 1;
                if($index==0){
                    $rutaDetalle['fecha_inicio']=$fecha_inicio2;
                }
                else{
                    $validaactivar=1;
                }

                if ($index < 2) {
                     $rutaDetalle['estado_ruta']=1;
                }elseif($index >= 2){
                     $rutaDetalle['estado_ruta']=2;
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();
/*            }

            foreach($qrutaDetalle as $rd){
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$rd->area_id;
                $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                $rutaDetalle['dtiempo']=$rd->dtiempo;
                $rutaDetalle['norden']=$rd->norden;
                if($rd->norden==1){
                    $rutaDetalle['fecha_inicio']=$fecha_inicio2;
                }
                else{
                    $validaactivar=1;
                }

                if ($rd->norden < 3) {
                     $rutaDetalle['estado_ruta']=1;
                }elseif($rd->norden >= 3){
                     $rutaDetalle['estado_ruta']=2;
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();*/
                /**************CARTA DESGLOSE*********************************/
                $cartaDesglose=array();
                if( Input::has('carta_id') ){
                    $carta_id=Input::get('carta_id');
                    $sql="  SELECT id
                            FROM carta_desglose
                            WHERE carta_id='$carta_id'
                            AND estado=1
                            ORDER BY id
                            LIMIT $conteo,1";
                    $cd=DB::select($sql);
                    $conteo++;
                    $cartaDesglose=CartaDesglose::find($cd[0]->id);
                }
                else{
                    $sql="  SELECT id
                            FROM personas
                            WHERE estado=1
                            AND rol_id IN (8,9,70)
                            AND area_id='".$rutaDetalle->area_id."'";
                    $person=DB::select($sql);
                        /***********MEDIR LOS TIEMPOS**************************/
                        $cantmin=0;
                        if( $rutaDetalle->tiempo_id==1 ){
                            $cantmin=60;
                        }
                        elseif( $rutaDetalle->tiempo_id==2 ){
                            $cantmin=1440;
                        }

                        if( $array['fecha']=='' ){
                            $array['fecha']= Input::get('fecha_inicio');
                        }
                        $array['tiempo']=($rutaDetalle->dtiempo*$cantmin);
                        $array['area']=$rutaDetalle->area_id;
                        $ff=Carta::CalcularFechaFin($array);
                        $fi=$array['fecha'];
                        $array['fecha']=$ff;

                    $cartaDesglose= new CartaDesglose;
                    $cartaDesglose['carta_id']=$carta->id;
                    $cartaDesglose['tipo_actividad_id']=19;
                    $cartaDesglose['actividad']="Actividad";
                        if( isset($person[0]->id) ){
                        $cartaDesglose['persona_id']=$person[0]->id;
                        }
                    $cartaDesglose['area_id']=$rutaDetalle->area_id;
                    $cartaDesglose['recursos']="";
                    $cartaDesglose['fecha_inicio']=$fi;
                    $cartaDesglose['fecha_fin']=$ff;
                    $cartaDesglose['hora_inicio']="08:00";
                    $cartaDesglose['hora_fin']="17:30";
                    $cartaDesglose['fecha_alerta']=$ff;
                }
                    $cartaDesglose['ruta_detalle_id']=$rutaDetalle->id;
                    $cartaDesglose->save();
                /*************************************************************/
                if( $index==0 AND Input::has('carta_id') ){
                    $rutaDetalleVerbo = new RutaDetalleVerbo;
                    $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                    $rutaDetalleVerbo['nombre']= '-';
                    $rutaDetalleVerbo['condicion']= '0';
                    $rol_id=1;
                        if( Input::has('rol_id') AND Input::get('rol_id')!='' ){
                            $rol_id=Input::get('rol_id');
                        }
                        elseif( isset(Auth::user()->rol_id) ){
                            $rol_id=Auth::user()->rol_id;
                        }
                    $rutaDetalleVerbo['rol_id']= $rol_id;
                    $rutaDetalleVerbo['verbo_id']= '1';
                    $rutaDetalleVerbo['documento_id']= '57';//Carta de inicio
                    $rutaDetalleVerbo['orden']= '0';
                    $rutaDetalleVerbo['finalizo']='1';
                    $rutaDetalleVerbo['documento']=Input::get('codigo');
                    $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                    $rutaDetalleVerbo->save();
                }



                /*$qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                ->where('estado', '=', '1')
                                ->orderBy('orden', 'ASC')
                                ->get();
                    if(count($qrutaDetalleVerbo)>0){
                        foreach ($qrutaDetalleVerbo as $rdv) {
                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $rdv->nombre;
                            $rutaDetalleVerbo['condicion']= $rdv->condicion;
                            $rutaDetalleVerbo['rol_id']= $rdv->rol_id;

                            $rutaDetalleVerbo['verbo_id']= $rdv->verbo_id;
                            $rutaDetalleVerbo['documento_id']= $rdv->documento_id;
                            $rutaDetalleVerbo['orden']= $rdv->orden;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();
                        }
                    }*/
                    $array_verbos = [];
                    if($index==0){
                        $array_verbos = [4];
                        /*foreach ($array_verbos as $key => $value) {
                            $verbo = Verbo::find($value);

                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $verbo->nombre;
                            $rutaDetalleVerbo['condicion']= 0;

                            if($value == 5){
                                $Area = Area::find($val);
                                if($Area->area_gestion == 1){
                                    $rutaDetalleVerbo['rol_id']= 8;     
                                }elseif($Area->area_gestion == 2){
                                    $rutaDetalleVerbo['rol_id']= 9;                                    
                                }
                            }else{
                                $rutaDetalleVerbo['rol_id']= 1;                                
                            }

                            $rutaDetalleVerbo['verbo_id']= $value;
                             $rutaDetalleVerbo['documento_id']= '';
                            $rutaDetalleVerbo['orden']= $key + 1;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();                           
                        }*/
                    }elseif( $tipoenvio==1 && $copiaG==0){ //con retorno
                        $array_verbos = [2,1,5,4];
         /*               foreach ($array_verbos as $key => $value) {
                            $verbo = Verbo::find($value);

                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $verbo->nombre;
                            $rutaDetalleVerbo['condicion']= 0;

                            if($value == 5){
                                $Area = Area::find($val);
                                if($Area->area_gestion == 1){
                                    $rutaDetalleVerbo['rol_id']= 8;     
                                }elseif($Area->area_gestion == 2){
                                    $rutaDetalleVerbo['rol_id']= 9;                                    
                                }
                            }else{
                                $rutaDetalleVerbo['rol_id']= 1;                                
                            }

                            $rutaDetalleVerbo['verbo_id']= $value;
                             $rutaDetalleVerbo['documento_id']= '';
                            $rutaDetalleVerbo['orden']= $key + 1;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();                           
                        }*/
                    }else if($tipoenvio==2  or $copiaG==1){ //sin retorno
                        $array_verbos = [2,14]; 
         /*               foreach ($array_verbos as $key => $value) {
                            $verbo = Verbo::find($value);

                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $verbo->nombre;
                            $rutaDetalleVerbo['condicion']= 0;
                            $rutaDetalleVerbo['rol_id']= 1;

                            $rutaDetalleVerbo['verbo_id']= $value;
                             $rutaDetalleVerbo['documento_id']= '';
                            $rutaDetalleVerbo['orden']= $key + 1;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();                           
                        }*/
                    }

                    foreach ($array_verbos as $key => $value) {
                        $verbo = Verbo::find($value);

                        $rutaDetalleVerbo = new RutaDetalleVerbo;
                        $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                        $rutaDetalleVerbo['nombre']= $verbo->nombre;
                        $rutaDetalleVerbo['condicion']= 0;

                        if($value == 5){
                            $Area = Area::find($val);
                            if($Area->area_gestion == 1){
                                $rutaDetalleVerbo['rol_id']= 8;     
                            }elseif($Area->area_gestion == 2){
                                $rutaDetalleVerbo['rol_id']= 9;                                    
                            }
                        }else{
                            $rutaDetalleVerbo['rol_id']= 1;                                
                        }

                        $rutaDetalleVerbo['verbo_id']= $value;
                         $rutaDetalleVerbo['documento_id']= '';
                        $rutaDetalleVerbo['orden']= $key + 1;
                        $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                        $rutaDetalleVerbo->save();                           
                    }
            }

            DB::commit();
            return  array(
                    'rst'=>1,
                    'msj'=>'Registro realizado con éxito'
            );
        }

			    }
			}

		}

	}

	public function postRecepcionar(){
		if ( Request::ajax() ) {
			$anexofind=Anexo::find(Input::get('codanexo'));
			if($anexofind){ //editar
				$anexofind['obeservacion'] =Input::get('observacion');
				$anexofind['usuario_atendio'] = Auth::user()->id;
				$anexofind['fecha_recepcion'] = date('Y-m-d H:i:s');
                $anexofind['usuario_updated_at']= Auth::user()->id;
                $anexofind->save(); 

                return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro recepcionado correctamente',
                )
            );    
			}
		}
	}

	public function getVoucheranexo()
	{

		/*get data*/
		$rst=Anexo::getDetalleAnexobyId();
		$data = $rst[0];
		/*end get data*/

		$html = "<html>";
		$html.= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		$html.="
				<body>
				<style>
				table, tr , td, th {
				text-align: left !important;
				border-collapse: collapse;
				border: 1px solid #ccc;
				width: 100%;
				font-size: .9em;
				font-family: arial, sans-serif;
				}
				Th, td {
				padding: 5px;
				}
				</style>";
		$html.="<h3>VOuCHER ANEXO</h3>";
		$html.="
				<table>
					<tr>
						<th>FECHA: </th>
						<td>".$data->fechaanexo."</td>
					</tr>
					<tr>
						<th>COD ANEXO: </th>
						<td>".$data->codanexo."</td>
					</tr>
					<tr>
						<th>COD TRAMITE: </th>
						<td>".$data->codtramite."</td>
					</tr>";

		$html.="
					<tr>
						<th>DNI: </th>
						<td>".$data->dnipersona."</td>
					</tr>
					<tr>
						<th>APELLIDO PATERNO: </th>
						<td>".$data->apepersona."</td>
					</tr>
					<tr>
						<th>APELLIDO MATERNO: </th>
						<td>".$data->apempersona."</td>
					</tr>
					<tr>
						<th>NOMBRE USUARIO: </th>
						<td>".$data->nombrepersona."</td>
					</tr>";
					
		if($data->ruc){
			$html.="
						<tr>
							<th>RUC: </th>
							<td>".$data->ruc."</td>
						</tr>
						<tr>
							<th>TIPO EMPRESA: </th>
							<td>".$data->tipoempresa."</td>
						</tr>
						<tr>
							<th>RAZON SOCIAL: </th>
							<td>".$data->razonsocial."</td>
						</tr>
						<tr>
							<th>NOMBRE COMERCIAL: </th>
							<td>".$data->nombcomercial."</td>
						</tr>
						<tr>
							<th>DIRECCION FISCAL: </th>
							<td>".$data->direcfiscal."</td>
						</tr>
						<tr>
							<th>TELEFONO: </th>
							<td>".$data->etelefono."</td>
						</tr>
						<tr>
							<th>REPRESENTANTE: </th>
							<td>".$data->representantelegal."</td>
						</tr>";
		}

		$html.="		<tr>
							<th>NOMBRE TRAMITE: </th>
							<td>".$data->nombretramite."</td>
						</tr>
						<tr>
							<th>FECHA TRAMITE: </th>
							<td>".$data->fechatramite."</td>
						</tr>
						<tr>
							<th>AREA: </th>
							<td>".$data->area."</td>
						</tr>";
				
		$html.="</table><hr>
		</body>
		</html>";

		return PDF::load($html, 'A4', 'landscape')->download('voucher-anexo-'.$data->codanexo);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postDestroy()
	{
		  if ( Request::ajax() ) {
            $Anexo = Anexo::find(Input::get('codanexo'));
            $Anexo->estado = 0;
            $Anexo->usuario_updated_at = Auth::user()->id;
            $Anexo->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro eliminado correctamente',
                )
            );    

        }
	}


}
