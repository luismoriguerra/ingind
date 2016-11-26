<?php

namespace Cronograma\DocumentosWord;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Plantilla;
use DocumentoWord;
use Helpers;

class DocumentoController extends \BaseController {

    /**
     * cargar documentos
     * GET /documentoword/cargar
     */
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $documentos = DocumentoWord::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$documentos));
        }
    }

    /**
     * Actualizar documento
     * POST /documentoword/editar
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $documento = DocumentoWord::find(Input::get('id'));
            $documento->titulo = Input::get('titulo');
            $documento->cabecera = Input::get('cabecera');
            $documento->remitente = '';
            $documento->destinatario = '';
            $documento->asunto = Input::get('asunto', '');
            // $documento->fecha = new \DateTime();
            $documento->cuerpo = Input::get('word', '');
            // $documento->correlativo = '';
            // $documento->plantillaId = '';
            // $documento->areaIdRemitente = '';
            // $documento->areaIdDestinatario = '';
            // $documento->personaIdRemitente = '';
            // $documento->personaIdDestinatario = '';
            $documento->usuario_updated_at = Auth::user()->id;
            $documento->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Actualizar documento
     * POST /documentoword/crear
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {

            $documento = new DocumentoWord;
            $documento->titulo = Input::get('titulo');
            $documento->cabecera = Input::get('cabecera');
            $documento->remitente = '';
            $documento->destinatario = '';
            $documento->asunto = Input::get('asunto', '');
            $documento->fecha = Input::get('fechaDocumento', new \DateTime());
            $documento->cuerpo = Input::get('word', '');
            $documento->correlativo = '';
            $documento->plantillaId = '';
            $documento->areaIdRemitente = '';
            $documento->areaIdDestinatario = '';
            $documento->personaIdRemitente = '';
            $documento->personaIdDestinatario = '';
            $documento->usuario_created_at = Auth::user()->id;
            $documento->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Changed the specified resource from storage.
     * POST /documentoword/cambiarestado
     *
     * @return Response
     */
    public function postCambiarestado()
    {
        if (Request::ajax() && Input::has('id') && Input::has('estado')) {
            $plantilla = Plantilla::find(Input::get('id'));
            $plantilla->estado = Input::get('estado');
            $plantilla->save();
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro actualizado correctamente',
                )
            );
        }
    }

    /**
     * POST /plantilla/previsualizar
     *
     * @return Response
     */
    public function getPrevisualizar($id)
    {

        $plantilla = Plantilla::find( $id );

        if ($plantilla) {

            $params = [
                'nombre' => $plantilla->nombre,
                'conCabecera' => $plantilla->cabecera,
                'contenido' => $plantilla->cuerpo
            ];
            $params = $params + $this->dataEjemploPlantilla();

            $view = \View::make('admin.mantenimiento.templates.plantilla1', $params);
            $html = $view->render();

            return \PDF::load($html, 'A4', 'portrait')->show();
        }

    }

    function dataEjemploPlantilla() {
        return [
            'nombreDocumento' => '(EJEMPLO) MEMORANDUM CIRCULAR N 016-2016-SG/MDC',
            'remitente' => 'Nombre de Encargado <br>Nombre de Gerencia y/o Subgerencia',
            'destinatario' => 'Nombre a quien va dirigido <br>Nombre de Gerencia y/o Subgerencia',
            'asunto' => 'Titulo, <i>Ejemplo:</i> Invitación a la Inaguración del Palacio Municipal',
            'fecha' => 'Fecha, <i>Ejemplo:</i> Lima, 01 de diciembre del 2016',
        ];
    }

}

