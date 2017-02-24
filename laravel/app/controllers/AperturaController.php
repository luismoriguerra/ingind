<?php

class AperturaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	public function postGetapertura(){
		if ( Request::ajax() ) {
            $a      = new Apertura;
            $listar = Array();
            $listar = $a->getAperturas();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
	}

	public function postCreateapertura(){
		if ( Request::ajax() ) {
			$Aperturas = DB::table('inventario_apertura')->where('estado',1)->get();
			foreach ($Aperturas as $key => $value) {
				$update = Apertura::find($value->id);
				$update['estado'] = 0;
				$update->save();
			}
			$apertura = new Apertura();
			$apertura['fecha_inicio']=Input::get('fechainicio');
			$apertura['fecha_fin']=Input::get('fechafinal');
			$apertura['observacion']=Input::get('observacion');
			$apertura->save();

			return Response::json(
	            array(
	            'rst'=>1,
	            'msj'=>'Registro realizado correctamente',
	            )
	        );
		}
	}

	public function postEditapertura(){
		if ( Request::ajax() ) {
			$apertura = Apertura::find(Input::get('idapertura'));
			$apertura['fecha_inicio']=Input::get('fechainicioA');
			$apertura['fecha_fin']=Input::get('fechafinalA');
			$apertura['observacion']=Input::get('observacionA');
			$apertura->save();

			return Response::json(
	            array(
	            'rst'=>1,
	            'msj'=>'Registro Actualizado correctamente',
	            )
	        );
		}
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
	public function destroy($id)
	{
		//
	}


}
