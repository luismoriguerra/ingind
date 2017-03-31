<?php

class BienCategoriaController extends \BaseController {

	public function postCreatecategoria(){
		if ( Request::ajax() ) {

			$BienCategoria = new BienCategoria();
			$BienCategoria['nombre'] = Input::get('nombre'); 
			$BienCategoria['observacion'] = Input::get('observ'); 
			$BienCategoria['estado'] = Input::get('estado'); 
			$BienCategoria['created_at'] = date('Y-m-d H:i:s');
			$BienCategoria['usuario_created_at'] = Auth::user()->id;
			$BienCategoria->save();

			return Response::json(
			    array(
			       'rst'=>1,
			       'msj'=>'Se registro con Exito',
			    )
		 	);
		}
	}

	public function postCargar(){
		if ( Request::ajax() ) {
            $categoria      = new BienCategoria;
            $listar = $categoria->getCategoriasBien();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
	}


	public function postCambiarestado()
    {

        if ( Request::ajax() ) {
            $estado = Input::get('estado');
            $id = Input::get('id');
            $bienCategoria = BienCategoria::find($id);
            $bienCategoria->usuario_updated_at = Auth::user()->id;
            $bienCategoria->estado = Input::get('estado');
            $bienCategoria->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

    public function postEditar()
    {

        if ( Request::ajax() ) {
            $bienCategoria = BienCategoria::find(Input::get('id'));
            $bienCategoria->nombre = Input::get('nombre');
            $bienCategoria->observacion =Input::get('observ');
            $bienCategoria->usuario_updated_at = Auth::user()->id;
            $bienCategoria->estado = Input::get('estado');
            $bienCategoria->save();

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
	 * GET /biencategoria
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /biencategoria/create
	 *
	 * @return Response
	 */

	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /biencategoria
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /biencategoria/{id}
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
	 * GET /biencategoria/{id}/edit
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
	 * PUT /biencategoria/{id}
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
	 * DELETE /biencategoria/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}