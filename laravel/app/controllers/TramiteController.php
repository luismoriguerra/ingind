<?php

class TramiteController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /tramite
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function postListartramites(){
                $array=array();
                $array['where']='';
                
            if( Input::has("buscar") AND Input::get('buscar')!='' ){
                 $buscar=explode(" ",trim(Input::get('buscar')));
                    for($i=0; $i<count($buscar); $i++){
                       $array['where'].=" AND tr.id_union LIKE '%".$buscar[$i]."%' ";
                    }
            }
                
		$rst=Tramite::getAllTramites($array);
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function postGetbyid(){
		$rst=Tramite::getTramiteById();
          return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$rst
              )
          );
	}

	public function getVouchertramite()
	{

		/*get data*/
		$rst=Tramite::getTramiteById();
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
		$html.="<h3>VOCHER TRAMITE</h3>";
		$html.="
				<table>
					<tr>
						<th>FECHA: </th>
						<td>".$data->tipotramite."</td>
					</tr>
					<tr>
						<th>COD TRAMITE: </th>
						<td>".$data->tramiteid."</td>
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

		$html.="		<tr>
							<th>NOMBRE TRAMITE: </th>
							<td>".$data->tramite."</td>
						</tr>					
						<tr>
							<th>AREA: </th>
							<td>".$data->area."</td>
						</tr>";
				
		$html.="</table><hr>
		</body>
		</html>";

		return PDF::load($html, 'A4', 'landscape')->download('voucher-tramite-'.$data->tramiteid);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tramite/create
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$img = $_FILES['txt_file'];
		$data = $_POST;

		if($img && $data){ //img y data
			$name = md5($img['name']).'_'.$data['txt_pretramiteid'].'.jpeg';
			$root = public_path().'/img/tramite/'.$name;

			if(move_uploaded_file($img['tmp_name'], $root)){ //move
				$tramite = new Tramite;
		       	$tramite['pretramite_id'] = $data['txt_pretramiteid'];
		        $tramite['persona_id'] = $data['txt_personaid'];

		        if($data['txt_empresaid']){
		        	$tramite['empresa_id'] = $data['txt_empresaid'];      	
		        }

		        //$tramite['area_id'] = $data['txt_area'];
		        $tramite['clasificador_tramite_id'] = $data['txt_ctramite'];
		        $tramite['tipo_solicitante_id'] = $data['txt_tsolicitante'];
		        $tramite['tipo_documento_id'] = $data['txt_tdocumento'];
		        $tramite['documento'] =$data['txt_tdoc'];
		        $tramite['nro_folios'] = $data['txt_folio'];
		        $tramite['observacion'] = $data['txt_observaciones'];
		        $tramite['imagen'] = $name;
		        $tramite['fecha_tramite'] = date('Y-m-d H:i:s');
		        $tramite['usuario_created_at'] = Auth::user()->id;
		        $tramite->save();


		        /*start to create process*/
		        if($tramite->id){ // if registry was succesfully
		        	$codigo = str_pad($tramite->id, 7, "0", STR_PAD_LEFT).'-'.date('Y'); //cod

		        	/*get ruta flujo*/
                   /* $sql="SELECT flujo_id
                            FROM areas_internas
                            WHERE area_id='".$tramite->area_id."' 
                            AND estado=1";
                    $area_interna=DB::select($sql);*/
                    $clasificador = ClasificadorTramite::find($tramite->clasificador_tramite_id);
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

				        $tablaRelacion['id_union']=$codigo;
				        
				        $tablaRelacion['fecha_tramite']= $tramite->fecha_tramite; //Input::get('fecha_tramite');
				        $tablaRelacion['tipo_persona']=$tramite->tipo_solicitante_id;

				       /* if( Input::has('paterno') AND Input::has('materno') AND Input::has('nombre') ){*/
				       	if($data['txt_personaid']){
				            /*$tablaRelacion['paterno']=Input::get('paterno');
				            $tablaRelacion['materno']=Input::get('materno');
				            $tablaRelacion['nombre']=Input::get('nombre');*/
				            $persona = Persona::find($data['txt_personaid']);
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
				        $tablaRelacion['sumilla']=Input::get('sumilla');

				        $tablaRelacion['persona_autoriza_id']=Input::get('id_autoriza');
				        $tablaRelacion['persona_responsable_id']=Input::get('id_responsable');

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
			                 /*if($rd->norden==1 or $rd->norden==2 or ($rd->norden>1 and $validaactivar==0 and $rd->estado_ruta==2) ){*/
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
			                    $rutaDetalleVerbo['documento']=Input::get('codigo');
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

                                                if($rd->norden==1 && $rd->area_id == 52){
                                                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                                                    $rutaDetalleVerbo['updated_at']= date("Y-m-d H:i:s");
                                                    $rutaDetalleVerbo['finalizo']=1;
                                                }

                                                $rutaDetalleVerbo->save();
                                            }
		                    }
		                }
		                DB::commit();
		                return Response::json(
				            array(
				            'rst'=>1,
				            'msj'=>'Registro realizado correctamente',
				            )
			        	);
					}
		        /*end proceso*/
		        	


		        
		        /*end start to create process*/
				
					
				} //end if registry was succesfully
			}	//end move		
		} //end if img y data
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tramite
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /tramite/{id}
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
	 * GET /tramite/{id}/edit
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
	 * PUT /tramite/{id}
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
	 * DELETE /tramite/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
