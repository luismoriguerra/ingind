<?php
class PlantillaDocumentoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /plantilladocumento.php
	 *
	 * @return Response
	 */

	public function postCargar()
    {
        if ( Request::ajax() ) {
            $plantillas_doc = PlantillaDocumento::getPlantillas();
            return Response::json(array('rst'=>1,'datos'=>$plantillas_doc));
        }
    }

    public function postCambiarestado()
    {
        if (Request::ajax() && Input::has('id') && Input::has('estado')) {
            $plantilla_doc = PlantillaDocumento::find(Input::get('id'));
            $plantilla_doc->estado = Input::get('estado');
            $plantilla_doc->save();
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro actualizado correctamente',
                )
            );
        }
    }

    public function postEditar()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');

            $plantilla = PlantillaDocumento::find(Input::get('id'));
            $plantilla->descripcion = Input::get('nombre');
            $plantilla->tipo_documento_id = Input::get('tipodoc');
            $plantilla->area_id = Input::get('area');
            $plantilla->cuerpo = $html;
/*            $plantilla->estado = Input::get('estado');*/
/*            $plantilla->cabecera = Input::get('cabecera');*/
            $plantilla->usuario_updated_at = Auth::user()->id;
            $plantilla->save();
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));

        }
    }

    /**
     * Actualizar plantilla
     * POST /plantilla/editar
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');

            $plantilla = new PlantillaDocumento;
            $plantilla->descripcion = Input::get('nombre');
            $plantilla->tipo_documento_id = Input::get('tipodoc');
            $plantilla->area_id = Input::get('area');
            $plantilla->cuerpo = $html;
            $plantilla->usuario_created_at = Auth::user()->id;
            $plantilla->save();
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));

        }
    }

    public function getVistaprevia($id)
    {

        $Plantilladoc = PlantillaDocumento::find( $id );

        if ($Plantilladoc) {

            $params = [
                'anio'=>date('Y'),
                'tamano'=>4,
                'posicion'=>0,
                'posicion_fecha'=>1,
                'tipo_envio'=>1,
                'nombre' => $Plantilladoc->nombre,
                'vistaprevia'=>'',
                'area' => $Plantilladoc->area_id,
                'conCabecera' => 1,
                'contenido' => $Plantilladoc->cuerpo,
                'titulo' =>  " N&ordm; 001-" . date('Y') . "-XX/XX"
            ];
            $params = $params + $this->dataEjemploPlantilla();

            $view = \View::make('admin.mantenimiento.templates.plantilla1', $params);
            $html = $view->render();

            $pdf = App::make('dompdf');
            $html = preg_replace('/>\s+</', '><', $html);
            $pdf->loadHTML($html);

            $pdf->setPaper('A4')->setOrientation('portrait');

            return $pdf->stream();


            //return \PDF::loadHTML($html, 'A4', 'portrait')->show();
        }

    }

    function dataEjemploPlantilla() {
        return [
            'titulo' => '(EJEMPLO) MEMORANDUM CIRCULAR N 016-2016-SG/MDC',
            'remitente' => 'Nombre de Encargado <br>Nombre de Gerencia y/o Subgerencia',
            'destinatario' => 'Nombre a quien va dirigido <br>Nombre de Gerencia y/o Subgerencia',
            'asunto' => 'Titulo, <i>Ejemplo:</i> Invitación a la Inaguración del Palacio Municipal',
            'fecha' => 'Lima,'.date('d').' de '.date('F').' del '.date('Y'),
            'imagen' => '',
            'copias'=> '',
        ];
    }

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /plantilladocumento.php/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /plantilladocumento.php
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /plantilladocumento.php/{id}
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
	 * GET /plantilladocumento.php/{id}/edit
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
	 * PUT /plantilladocumento.php/{id}
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
	 * DELETE /plantilladocumento.php/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
