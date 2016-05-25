<?php 

namespace Cronograma\PlantillasWord;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Plantilla;
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
     * Actualizar plantilla
     * POST /plantilla/editar
     */
    public function postEditar()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');
            $file = Helpers::convertHtmlToWord($html , Input::get('nombre') );
            $newfile= public_path().'/templates/'.Input::get('nombre').'.docx';
            if ( copy($file, $newfile) ) {
                $plantilla = Plantilla::find(Input::get('id'));
                $plantilla->nombre = Input::get('nombre');
                $plantilla->path = '';
                $plantilla->cuerpo = $html;
                $plantilla->estado = Input::get('estado');
                $plantilla->usuario_updated_at = Auth::user()->id;
                $plantilla->save();
                return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
            } else{
                return Response::json(array('rst'=>2, 'msj'=>'Hubo problemas'));
            }

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
            $file = Helpers::convertHtmlToWord($html , Input::get('nombre') );
            $newfile= public_path().'/templates/'.Input::get('nombre').'.docx';
            if ( copy($file, $newfile) ) {
                $plantilla = new Plantilla;
                $plantilla->nombre = Input::get('nombre');
                $plantilla->path = $newfile;
                $plantilla->cuerpo = $html;
                $plantilla->estado = Input::get('estado');
                $plantilla->usuario_created_at = Auth::user()->id;
                $plantilla->save();
                return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
            
            } else{
                return Response::json(array('rst'=>2, 'msj'=>'Hubo problemas'));
            }
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
}