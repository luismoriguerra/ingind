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
				$name = md5($img['name']).'_'.$data['txt_codtramite'].'.jpeg';
				$root = public_path().'/img/anexo/'.$name;

				if(move_uploaded_file($img['tmp_name'], $root)){
					$anexo = new Anexo;
			       	$anexo['tramite_id'] = $data['txt_codtramite'];
			        $anexo['persona_id'] = Auth::user()->id;
			        $anexo['fecha_anexo'] = date('Y-m-d H:i:s');
			        $anexo['nombre'] = $data['txt_nombtramite'];
			        $anexo['nro_folios'] = $data['txt_folio'];
			        $anexo['imagen'] = $name;
			        $anexo['usuario_created_at'] = Auth::user()->id;
			        $anexo->save();

			        return Response::json(
			            array(
			            'rst'=>1,
			            'msj'=>'Registro realizado correctamente',
			            )
			        );
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
						<th>Nº COMPROBANTE: </th>
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
