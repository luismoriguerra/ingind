<?php

class DocumentoDigitalController extends \BaseController {

	public function postCargar()
    {
        if ( Request::ajax() ) {
            $documento_digital = DocumentoDigital::getDocumentosDigitales();
            return Response::json(array('rst'=>1,'datos'=>$documento_digital));
        }
    }

    public function postCorrelativo()
    {
        if ( Request::ajax() ) {
            $r = DocumentoDigital::Correlativo();
            return Response::json(array('rst'=>1,'datos'=>$r));
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

            $DocDigital = DocumentoDigital::find(Input::get('iddocdigital'));
            $DocDigital->titulo = Input::get('titulofinal');
            $DocDigital->asunto = Input::get('asunto');
            $DocDigital->cuerpo = $html;
            $DocDigital->plantilla_doc_id = Input::get('plantilla');
            $DocDigital->area_id = Input::get('area_plantilla');
            $DocDigital->persona_id = Auth::user()->id;
            $DocDigital->usuario_created_at = Auth::user()->id;
            $DocDigital->save();

            if($DocDigital->id){
                $affectedRows = DocumentoDigitalArea::where('doc_digital_id', '=', $DocDigital->id)->get();
                foreach ($affectedRows as $docd) {
                    $dd = DocumentoDigitalArea::find($docd->id);
                    $dd->estado = 0;
                    $dd->usuario_updated_at = Auth::user()->id;
                    $dd->save();
                }

                $areas_envio = json_decode(Input::get('areasselect'));
                foreach ($areas_envio as $key => $value) {
                    $DocDigitalArea = new DocumentoDigitalArea();
                    $DocDigitalArea->doc_digital_id = $DocDigital->id;
                    $DocDigitalArea->persona_id = $value->persona_id;
                    $DocDigitalArea->area_id = $value->area_id;
                    $DocDigitalArea->usuario_created_at = Auth::user()->id;
                    $DocDigitalArea->save();
                }                    
            }

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

            $DocDigital = new DocumentoDigital;
            $DocDigital->titulo = Input::get('titulofinal');
            $DocDigital->asunto = Input::get('asunto');
            $DocDigital->cuerpo = $html;
            $DocDigital->plantilla_doc_id = Input::get('plantilla');
            $DocDigital->area_id = Input::get('area_plantilla');
            $DocDigital->tipo_envio = Input::get('tipoenvio');
            $DocDigital->persona_id = Auth::user()->id;;
            $DocDigital->usuario_created_at = Auth::user()->id;
            $DocDigital->save();

            if($DocDigital->id){
            	$areas_envio = json_decode(Input::get('areasselect'));
            	foreach ($areas_envio as $key => $value) {
            		$DocDigitalArea = new DocumentoDigitalArea();
            		$DocDigitalArea->doc_digital_id = $DocDigital->id;
            		$DocDigitalArea->persona_id = $value->persona_id;
            		$DocDigitalArea->area_id = $value->area_id;
                    $DocDigitalArea->tipo = $value->tipo;
            		$DocDigitalArea->usuario_created_at = Auth::user()->id;
            		$DocDigitalArea->save();
            	}
            }
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    public function getVistaprevia($id)
    {

        $DocumentoDigital = DocumentoDigital::find($id);

        if ($DocumentoDigital) {
        	/*get remitente data*/
        	$persona = Persona::find($DocumentoDigital->persona_id);
        	$area = Area::find($DocumentoDigital->area_id);
        	$remitente = $persona->nombre." ".$persona->paterno." ".$persona->materno." (".$area->nombre.")";
        	/*end get remitente data */

        	/*get destinatario data*/
            $copias = '';
            $copias.= '<ul>';
        	$destinatarios = '';
        	$destinatarios.= '<ul>';
        	$DocDigitalArea = DocumentoDigitalArea::where('doc_digital_id', '=', $id)->where('estado', '=', 1)->get();
        	foreach($DocDigitalArea as $key => $value){
        		$persona2 = Persona::find($value->persona_id);
        		$area2 = Area::find($value->area_id);
                if($value->tipo ==1){
        		  $destinatarios.= '<li>'.$persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' ('.$area2->nombre.')</li>';                    
                }else{
                    $copias.= '<li>'.$persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' ('.$area2->nombre.')</li>';
                }        
        	}
            $destinatarios.= '</ul>';    
        	$copias.= '</ul>';        	
        	/*end get destinatario data*/

            $params = [
                'titulo' => $DocumentoDigital->titulo,
                'asunto' => $DocumentoDigital->asunto,
                'conCabecera' => 1,
                'contenido' => $DocumentoDigital->cuerpo,
                'fecha' => 'Lima,'.date('d').' de '.date('F').' del '.date('Y'),
                'remitente' => $remitente,
                'destinatario' => $destinatarios,
                'copias' => $copias,
            ];
            $params = $params;

            $view = \View::make('admin.mantenimiento.templates.plantilla1', $params);
            $html = $view->render();

            return \PDF::load($html, 'A4', 'portrait')->show();
        }

    }

    function dataEjemploPlantilla() {
        return [
            'titulo' => '(EJEMPLO) MEMORANDUM CIRCULAR N 016-2016-SG/MDC',
            'remitente' => 'Nombre de Encargado <br>Nombre de Gerencia y/o Subgerencia',
            'destinatario' => 'Nombre a quien va dirigido <br>Nombre de Gerencia y/o Subgerencia',
            'asunto' => 'Titulo, <i>Ejemplo:</i> Invitación a la Inaguración del Palacio Municipal',
            'fecha' => 'Lima,'.date('d').' de '.date('F').' del '.date('Y'),
        ];
    }

	/**
	 * Display a listing of the resource.
	 * GET /documentodigital
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /documentodigital/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /documentodigital
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /documentodigital/{id}
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
	 * GET /documentodigital/{id}/edit
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
	 * PUT /documentodigital/{id}
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
	 * DELETE /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}