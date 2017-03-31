<?php

class CaracteristicaEventoController extends \BaseController {

	public function postCargar(){
		if ( Request::ajax() ) {
            $bien      = new CaracteristicaEvento;
            $listar = $bien->getEventosByCaracteristica();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
	}

	public function postComfirmarevento(){
		 if ( Request::ajax() ) {
            $estado = Input::get('estado');
            $id = Input::get('id');
            $EventCaracteristica = CaracteristicaEvento::find($id);
            $EventCaracteristica->confirmacion = Input::get('estado');
            $EventCaracteristica->usuario_updated_at = Auth::user()->id;
            $EventCaracteristica->updated_at =  date('Y-m-d H:i:s');
            $EventCaracteristica->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                'id' => $EventCaracteristica->bien_caracteristica_id,
                )
            );    

        }
	}

	public function postCreatevento(){
		if ( Request::ajax() ) {
			$Evento = new CaracteristicaEvento();
			$Evento['bien_caracteristica_id'] = Input::get('idcaracteristica'); 
			$Evento['descripcion'] = Input::get('observ'); 
			$Evento['evento_categoria_id'] = Input::get('categoriaevent'); 
			
			if(Auth::user()->rol_id == 8 Or Auth::user()->rol_id == 9){
				$Evento['confirmacion'] = 1; 
			}

			$Evento['created_at'] = date('Y-m-d H:i:s');
			$Evento['usuario_created_at'] = Auth::user()->id;
			$Evento->save();

			return Response::json(
			    array(
			       'rst'=>1,
			       'msj'=>'Se registro con Exito',
			       'id' => $Evento->bien_caracteristica_id
			    )
		 	);
		}
	}

	/**
	 * Display a listing of the resource.
	 * GET /caracteristicaevento
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /caracteristicaevento/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /caracteristicaevento
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /caracteristicaevento/{id}
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
	 * GET /caracteristicaevento/{id}/edit
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
	 * PUT /caracteristicaevento/{id}
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
	 * DELETE /caracteristicaevento/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}