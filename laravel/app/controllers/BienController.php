<?php

class BienController extends \BaseController {

	public function postCargar(){
		if ( Request::ajax() ) {
            $bien      = new Bien;
            $listar = $bien->getbienes();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
	}

	public function postCreatebien(){
		if ( Request::ajax() ) {
			$Bien = new Bien();
			$Bien['bienes_categoria_id'] = Input::get('categoria'); 
			$Bien['area_id'] = Auth::user()->area_id;
			$Bien['nro_interno'] = Input::get('nroInterno'); 
			$Bien['descripcion'] = Input::get('nombre'); 
			$Bien['marca'] = Input::get('marca'); 
			$Bien['modelo'] = Input::get('modelo'); 
			$Bien['serie'] = Input::get('serie'); 
			$Bien['ubicacion'] = Input::get('ubicacion'); 
			$Bien['fecha_adquisicion'] = Input::get('fechaadquisicion'); 
			$Bien['created_at'] = date('Y-m-d H:i:s');
			$Bien['usuario_created_at'] = Auth::user()->id;
			$Bien->save();

			return Response::json(
			    array(
			       'rst'=>1,
			       'msj'=>'Se registro con Exito',
			    )
		 	);
		}
	}

	public function postEditar(){
		if ( Request::ajax() ) {
			$Bien = Bien::find(Input::get('id'));
			$Bien['bienes_categoria_id'] = Input::get('categoria'); 
			$Bien['area_id'] = Auth::user()->area_id;
			$Bien['nro_interno'] = Input::get('nroInterno'); 
			$Bien['descripcion'] = Input::get('nombre'); 
			$Bien['marca'] = Input::get('marca'); 
			$Bien['modelo'] = Input::get('modelo'); 
			$Bien['serie'] = Input::get('serie'); 
			$Bien['ubicacion'] = Input::get('ubicacion'); 
			$Bien['fecha_adquisicion'] = Input::get('fechaadquisicion'); 
			$Bien['updated_at'] = date('Y-m-d H:i:s');
			$Bien['usuario_updated_at'] = Auth::user()->id;
			$Bien->save();

			return Response::json(
			    array(
			       'rst'=>1,
			       'msj'=>'Se actualizo con Exito',
			    )
		 	);
		}
	}

	public function postCambiarestado()
    {

        if ( Request::ajax() ) {
            $Id = Input::get('id');
            $Bien = Bien::find($Id);
            $Bien->usuario_updated_at = Auth::user()->id;
            $Bien->estado = Input::get('estado');
            $Bien->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }


	/**
	 * Display a listing of the resource.
	 * GET /bien
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /bien/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /bien
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /bien/{id}
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
	 * GET /bien/{id}/edit
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
	 * PUT /bien/{id}
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
	 * DELETE /bien/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}