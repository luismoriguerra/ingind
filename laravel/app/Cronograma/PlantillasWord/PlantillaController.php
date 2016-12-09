<?php

namespace Cronograma\PlantillasWord;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Plantilla;
use DocumentoWord;
use Helpers;

class PlantillaController extends \BaseController {

    /**
     * cargar plantillas
     * GET /plantilla/cargar
     */
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $plantillas = Plantilla::get(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$plantillas));
        }
    }

    /**
     * Listar plantilla
     * POST /plantilla/listar
     */
    public function postListar()
    {
        if ( Request::ajax() ) {

            $areas = Plantilla::getPlantillas();

            return Response::json(array('rst' => 1, 'datos' => $areas));
        }
    }

    /**
     * Obtener una plantilla
     * POST /plantilla/plantilla
     */
    public function postPlantilla()
    {
        if ( Request::ajax() ) {

            $id = Input::get('id');
            $area = Plantilla::where('id','=',$id)
                        ->where('estado','=','1')
                        ->get();

            $correlativo = DocumentoWord::where('plantillaId','=',$id)
                        ->where('estado','=','1')
                        ->count();
            $correlativo = str_pad($correlativo+1, 3, "0", STR_PAD_LEFT);

            return Response::json(array('rst' => 1, 'datos' => $area, 'correlativo' => $correlativo));
        }
    }

    /**
     * Actualizar plantilla
     * POST /plantilla/editar
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');

            $plantilla = Plantilla::find(Input::get('id'));
            $plantilla->nombre = Input::get('nombre');
            $plantilla->path = '';
            $plantilla->cuerpo = $html;
            $plantilla->estado = Input::get('estado');
            $plantilla->titulo = Input::get('titulo');
            $plantilla->cabecera = Input::get('cabecera');
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

            $plantilla = new Plantilla;
            $plantilla->nombre = Input::get('nombre');
            $plantilla->path = '';
            $plantilla->cuerpo = $html;
            $plantilla->estado = Input::get('estado');
            $plantilla->titulo = Input::get('titulo');
            $plantilla->cabecera = Input::get('cabecera');
            $plantilla->usuario_created_at = Auth::user()->id;
            $plantilla->save();
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));

        }
    }
    /**
     * Changed the specified resource from storage.
     * POST /plantilla/cambiarestado
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
                'contenido' => $plantilla->cuerpo,
                'titulo' => $plantilla->titulo . " N&ordm; 001-" . date('Y') . "-XX/XX"
            ];
            $params = $params + $this->dataEjemploPlantilla();

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
            'fecha' => 'Fecha, <i>Ejemplo:</i> Lima, 01 de diciembre del 2016',
        ];
    }

}

