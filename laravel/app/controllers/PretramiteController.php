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