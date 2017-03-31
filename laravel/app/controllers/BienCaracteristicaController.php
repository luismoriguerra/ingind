<?php

class BienCaracteristicaController extends \BaseController {

	public function postCargar(){
		if ( Request::ajax() ) {
            $bien      = new BienCaracteristica;
            $listar = $bien->getCaracteristicabyBien();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
	}

	public function postCreatecaracteristica(){
		if ( Request::ajax() ) {
			$BienCa = new BienCaracteristica();
			$BienCa['bien_id'] = Input::get('idbien'); 
			$BienCa['descripcion'] = Input::get('nombre'); 
			$BienCa['observacion'] = Input::get('observ'); 
			$BienCa['valor'] = Input::get('valor'); 
			$BienCa['alerta'] = Input::get('alerta'); 
			
			if(Input::has('motivoalerta')){
				$BienCa['alerta_razon'] = Input::get('motivoalerta'); 
			}

			$BienCa['created_at'] = date('Y-m-d H:i:s');
			$BienCa['usuario_created_at'] = Auth::user()->id;
			$BienCa->save();

			return Response::json(
			    array(
			       'rst'=>1,
			       'msj'=>'Se registro con Exito',
			       'bien' => $BienCa->bien_id
			    )
		 	);
		}
	}

	/**
	 * Display a listing of the resource.
	 * GET /biencaracteristica
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /biencaracteristica/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /biencaracteristica
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /biencaracteristica/{id}
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
	 * GET /biencaracteristica/{id}/edit
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
	 * PUT /biencaracteristica/{id}
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
	 * DELETE /biencaracteristica/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}