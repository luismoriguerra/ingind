<?php

class TipotramiteController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /tipotramite
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function postListar(){
		$a      = new TipoTramite;
        $listar = Array();
        $listar = $a->getAllTiposTramites();
        
        var_dump($listar);
        exit();
        
         return Response::json(
              array(
                  'rst'=>1,
                  'datos'=>$listar
              )
         );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tipotramite/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tipotramite
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /tipotramite/{id}
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
	 * GET /tipotramite/{id}/edit
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
	 * PUT /tipotramite/{id}
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
	 * DELETE /tipotramite/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}