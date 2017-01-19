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
	public function postCreate()
	{
		$array_data = json_decode(Input::get('info'));
		$pretramite = new Pretramite;
       	$pretramite['persona_id'] =  Auth::user()->id;
        $pretramite['clasificador_tramite_id'] = $array_data->idclasitramite;

        if($array_data->idempresa){
        	$pretramite['empresa_id'] = $array_data->idempresa;        	
        }

        $pretramite['tipo_solicitante_id'] = $array_data->cbo_tiposolicitante;
        $pretramite['tipo_documento_id'] = $array_data->cbo_tipodoc;
        $pretramite['documento'] = $array_data->tipodoc;
        $pretramite['nro_folios'] = $array_data->numfolio;
        $pretramite['area_id'] = $array_data->idarea;
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