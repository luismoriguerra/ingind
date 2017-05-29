<?php

class PretramiteController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /pretramite
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function postListarpretramites(){
		$rst=Pretramite::getPreTramites();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function postListar(){ //listar clasificacion tramite area
		
		$rst=Pretramite::getAreasbyClaTramite();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function postGetbyid(){
		$rst=Pretramite::getPreTramiteById();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
	}

	public function postEmpresasbypersona(){
		$rst=Pretramite::getEmpresasUser();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function postClasificadorestramite(){
		$rst=Pretramite::getClasificadoresTramite();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function postRequisitosbyctramite(){
		$rst=Pretramite::getrequisitosbyClaTramite();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /pretramite/create
	 *
	 * @return Response
	 */
	public function postCreatepretramite(){
		if ( Request::ajax() ) {
			$array_data = json_decode(Input::get('info'));
			$pretramite = new Pretramite;

	        $pretramite['clasificador_tramite_id'] = $array_data->idclasitramite;

	        if($array_data->idempresa){
	        	$pretramite['empresa_id'] = $array_data->idempresa;        	
	        }

	        $pretramite['persona_id'] =  Auth::user()->id;
	        $pretramite['tipo_solicitante_id'] = $array_data->cbo_tiposolicitante;
	        $pretramite['tipo_documento_id'] = $array_data->cbo_tipodoc;
	        $pretramite['documento'] = $array_data->tipodoc;
	        $pretramite['nro_folios'] = $array_data->numfolio;
	        //$pretramite['area_id'] = $array_data->idarea;
	/*        $pretramite['fecha_pretramite'] = date();*/
	        $pretramite['usuario_created_at'] = Auth::user()->id;
	        $pretramite->save();

	        return Response::json(
	            array(
	            'rst'=>1,
	            'msj'=>'Registro realizado correctamente',
	            )
	        );
	 	}
	}

	public function postCreate()
	{
		$array_data = json_decode(Input::get('info'));
		$pretramite = new Pretramite;
        $codigo = Pretramite::Correlativo($array_data->cbo_tipodocumento);        //var_dump($codigo);exit();      
        $pretramite['clasificador_tramite_id'] = $array_data->idclasitramite;

        if($array_data->idempresa AND $array_data->cbo_tiposolicitante==2){
        	$pretramite['empresa_id'] = $array_data->idempresa;  
                $pretramite['persona_id'] = $array_data->persona_id;                 
        }else{
        	$pretramite['persona_id'] =  $array_data->persona_id;
        }
        $pretramite['correlativo'] = $codigo->correlativo;
        $pretramite['tipo_solicitante_id'] = $array_data->cbo_tiposolicitante;
        $pretramite['tipo_documento_id'] = $array_data->cbo_tipodoc;
        $pretramite['tipo_tramite_id'] = $array_data->cbo_tipodocumento;
        $pretramite['documento'] = $array_data->tipodoc;
        $pretramite['nro_folios'] = $array_data->numfolio;
        if($array_data->idarea){
        $pretramite['area_id'] = $array_data->idarea;}
/*        $pretramite['fecha_pretramite'] = date();*/
        $pretramite['usuario_created_at'] = Auth::user()->id;
        $pretramite->save();


        /*tramite*/
        if($pretramite->id){ // if registry was succesfully

        		$tramite = new Tramite;
		       	$tramite['pretramite_id'] = $pretramite->id;

		        if($pretramite->empresa_id AND $array_data->cbo_tiposolicitante==2 ){
		        	$tramite['empresa_id'] = $pretramite->empresa_id;  
                                $tramite['persona_id'] = $pretramite->persona_id; 
		        }else{
		        	$tramite['persona_id'] = $pretramite->persona_id;
		        }
                        if($pretramite->area_id){
                        $tramite['area_id'] = $pretramite->area_id;}
		        $tramite['clasificador_tramite_id'] = $pretramite->clasificador_tramite_id;
		        $tramite['tipo_solicitante_id'] = $pretramite->tipo_solicitante_id;
		        $tramite['tipo_documento_id'] = $pretramite->tipo_documento_id;
		        $tramite['documento'] = $pretramite->documento;
		        $tramite['nro_folios'] = $pretramite->nro_folios;
		        $tramite['observacion'] = '';
		        $tramite['imagen'] = '';
		        $tramite['fecha_tramite'] = date('Y-m-d H:i:s');
		        $tramite['usuario_created_at'] = Auth::user()->id;
		        $tramite->save();
                               
//		        	$codigo = str_pad($tramite->id, 7, "0", STR_PAD_LEFT).'-'.date('Y'); //cod
                        if($array_data->cbo_tipodocumento==1)   {
                            $codigo= 'DS-'.$codigo->correlativo.'-'.date('Y') ;
                        } 
                        if($array_data->cbo_tipodocumento==2)   {
                            $codigo= 'EX-'.$codigo->correlativo.'-'.date('Y');
                        }
//                        var_dump($codigo);exit();
		        	/*get ruta flujo*/
                  /*  $sql="SELECT flujo_id
                            FROM areas_internas
                            WHERE area_id='".$tramite->area_id."' 
                            AND estado=1";
                    $area_interna=DB::select($sql);*/
                    $clasificador = ClasificadorTramite::find($array_data->idclasitramite);      
                    $ruta_flujo = RutaFlujo::find($clasificador->ruta_flujo_id);
                    $ruta_flujo_id = $ruta_flujo->id;
		        	/* end get ruta flujo*/


		        	/*proceso*/
		        	$tablaRelacion=DB::table('tablas_relacion as tr')
                        ->join(
                            'rutas as r',
                            'tr.id','=','r.tabla_relacion_id'
                        )
	                    ->where('tr.id_union', '=', $codigo)
	                    ->where('r.ruta_flujo_id', '=', $ruta_flujo_id)
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
				        $tablaRelacion=new TablaRelacion;
				        $tablaRelacion['software_id']=1;
                                        $tablaRelacion['tramite_id']=$tramite->id;
				        $tablaRelacion['id_union']=$codigo;
				        
				        $tablaRelacion['fecha_tramite']= $tramite->fecha_tramite; //Input::get('fecha_tramite');
				        $tablaRelacion['tipo_persona']=$tramite->tipo_solicitante_id;

				       /* if( Input::has('paterno') AND Input::has('materno') AND Input::has('nombre') ){*/
				       	if($tramite->persona_id){
				            /*$tablaRelacion['paterno']=Input::get('paterno');
				            $tablaRelacion['materno']=Input::get('materno');
				            $tablaRelacion['nombre']=Input::get('nombre');*/
				            $persona = Persona::find($tramite->persona_id);
				        	$tablaRelacion['paterno']=$persona['paterno'];
				            $tablaRelacion['materno']=$persona['materno'];
				            $tablaRelacion['nombre']=$persona['nombre'];
				        }
				        elseif( Input::has('razon_social') AND Input::has('ruc') ){
				            $tablaRelacion['razon_social']=Input::get('razon_social');
				            $tablaRelacion['ruc']=Input::get('ruc');
				        }
				        elseif( Input::has('area_p_id') ){
				            $tablaRelacion['area_id']=Input::get('area_p_id');
				        }
				        elseif( Input::has('carta_id') ){ // Este caso solo es para asignar carta inicio
				            $tablaRelacion['area_id']=Auth::user()->area_id;
				        }
				        elseif( Input::has('razon_social') ){
				            $tablaRelacion['razon_social']=Input::get('razon_social');
				        }


				        if( Input::has('referente') AND trim(Input::get('referente'))!='' ){
				            $tablaRelacion['referente']=Input::get('referente');
				        }

				        if( Input::has('responsable') AND trim(Input::get('responsable'))!='' ){
				            $tablaRelacion['responsable']=Input::get('responsable');
				        }
				        $tablaRelacion['sumilla']=$tramite->observacion;

				        $tablaRelacion['persona_autoriza_id']='';
				        $tablaRelacion['persona_responsable_id']='';

				        $tablaRelacion['usuario_created_at']=Auth::user()->id;
				        $tablaRelacion->save();

				        $rutaFlujo=RutaFlujo::find($ruta_flujo_id);

				        $ruta= new Ruta;
				        $ruta['tabla_relacion_id']=$tablaRelacion->id;
				        $ruta['fecha_inicio']= $tramite->fecha_tramite;
				        $ruta['ruta_flujo_id']=$rutaFlujo->id;
				        $ruta['flujo_id']=$rutaFlujo->flujo_id;
				        $ruta['persona_id']=$rutaFlujo->persona_id;
				        $ruta['area_id']=$rutaFlujo->area_id;
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
				        $referido['ruta_detalle_verbo_id']=0;
				        $referido['referido']=$tablaRelacion->id_union;
				        $referido['fecha_hora_referido']=$tablaRelacion->created_at;
				        $referido['usuario_referido']=$tablaRelacion->usuario_created_at;
				        $referido['usuario_created_at']=Auth::user()->id;
				        $referido->save();
				        /**********************************************/

				        $qrutaDetalle=DB::table('rutas_flujo_detalle')
				            ->where('ruta_flujo_id', '=', $rutaFlujo->id)
				            ->where('estado', '=', '1')
				            ->orderBy('norden','ASC')
				            ->get();
				            $validaactivar=0;
	        
	        			$conteo=0;$array['fecha']=''; // inicializando valores para desglose
			            foreach($qrutaDetalle as $rd){
			                $rutaDetalle = new RutaDetalle;
			                $rutaDetalle['ruta_id']=$ruta->id;
			                $rutaDetalle['area_id']=$rd->area_id;
			                $rutaDetalle['tiempo_id']=$rd->tiempo_id;
			                $rutaDetalle['dtiempo']=$rd->dtiempo;
			                $rutaDetalle['norden']=$rd->norden;
			                $rutaDetalle['estado_ruta']=$rd->estado_ruta;
			                /*if($rd->norden==1 or ($rd->norden>1 and $validaactivar==0 and $rd->estado_ruta==2) ){
			                    $rutaDetalle['fecha_inicio']=Input::get('fecha_inicio');
			                }*/
			                 if($rd->norden==1 or ($rd->norden>1 and $validaactivar==0 and $rd->estado_ruta==2) ){
                                if($rd->norden==1 && $rd->area_id == 52){
                                    $rutaDetalle['dtiempo_final']=date("Y-m-d H:i:s");
                                    $rutaDetalle['tipo_respuesta_id']=2;
                                                $rutaDetalle['tipo_respuesta_detalle_id']=1;
                                    $rutaDetalle['observacion']="";
                                    $rutaDetalle['usuario_updated_at']=Auth::user()->id;
                                    $rutaDetalle['updated_at']=date("Y-m-d H:i:s");
                                }
                                $rutaDetalle['fecha_inicio']=date("Y-m-d H:i:s");
                            }
			                else{
			                    $validaactivar=1;
			                }
			                $rutaDetalle['usuario_created_at']= Auth::user()->id;
			                $rutaDetalle->save();
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


					        if( $rd->norden==1 AND Input::has('carta_id') ){
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
			                    $rutaDetalleVerbo['documento']='';
			                    $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
			                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
			                    $rutaDetalleVerbo->save();
		                	}

			                $qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
			                                ->where('ruta_flujo_detalle_id', '=', $rd->id)
			                                ->where('estado', '=', '1')
			                                ->orderBy('orden', 'ASC')
			                                ->get();

		                    if(count($qrutaDetalleVerbo)>0){
		                        /*foreach ($qrutaDetalleVerbo as $rdv) {
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
		                        }*/
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


                                                /*if($rd->norden==1){*/
                                                 if($rd->norden==1 && $rd->area_id == 52){
                                                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                                                    $rutaDetalleVerbo['updated_at']= date("Y-m-d H:i:s");
                                                    $rutaDetalleVerbo['finalizo']=1;
                                                }

                                                $rutaDetalleVerbo->save();
                                            }
		                    }
		                }
/*		                DB::commit();
		                return Response::json(
				            array(
				            'rst'=>1,
				            'msj'=>'Registro realizado correctamente',
				            )
			        	);*/
					}
		        /*end proceso*/	
				} //end if registry was succesfully
        /*end tramite*/
		
		return Response::json(
            array(
            'rst'=>1,
            'msj'=>'Registro realizado correctamente',
            )
        );
	}

	public function getVoucherpretramite()
	{

		/*get data*/
		$rst=Pretramite::getPreTramiteById();
		$data = $rst[0];
		/*end get data*/

		$html = "<html><meta charset=\"UTF-8\">";
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
		$html.="<h3>VOCHER PRE TRAMITE</h3>";
		$html.="
				<table>
					<tr>
						<th>FECHA: </th>
						<td>".$data->fregistro."</td>
					</tr>
					<tr>
						<th>COD PRE TRAMITE: </th>
						<td>".$data->pretramite."</td>
					</tr>";

		$html.="
					<tr>
						<th>DNI: </th>
						<td>".$data->dniU."</td>
					</tr>
					<tr>
						<th>APELLIDO PATERNO: </th>
						<td>".$data->apepusuario."</td>
					</tr>
					<tr>
						<th>APELLIDO MATERNO: </th>
						<td>".$data->apemusuario."</td>
					</tr>
					<tr>
						<th>NOMBRE USUARIO: </th>
						<td>".$data->nombusuario."</td>
					</tr>";
					
		if($data->empresa){
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
							<td>".$data->empresa."</td>
						</tr>
						<tr>
							<th>NOMBRE COMERCIAL: </th>
							<td>".$data->nomcomercial."</td>
						</tr>
						<tr>
							<th>DIRECCION FISCAL: </th>
							<td>".$data->edireccion."</td>
						</tr>
						<tr>
							<th>TELEFONO: </th>
							<td>".$data->etelf."</td>
						</tr>
						<tr>
							<th>REPRESENTANTE: </th>
							<td>".$data->reprelegal."</td>
						</tr>";
		}
				
		$html.="</table><hr>
		</body>
		</html>";

		return PDF::load($html, 'A4', 'landscape')->download('voucher-pretramite-'.$data->pretramite);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /pretramite
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /pretramite/{id}
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
	 * GET /pretramite/{id}/edit
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
	 * PUT /pretramite/{id}
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
	 * DELETE /pretramite/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
