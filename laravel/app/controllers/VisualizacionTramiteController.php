<?php

class VisualizacionTramiteController extends BaseController
{
    /**
     * actualizar el estado de visualizacion de los trmites
     */
    public function postCambiarestado()
    {
        $estado = Input::get('estado');
        $rutaDetalleId = Input::get('ruta_detalle_id');
        $id = Input::get('id','');
        $personaId=Auth::user()->id;
        $objeto = new VisualizacionTramite();
        $objeto->ruta_detalle_id=$rutaDetalleId;
        $objeto->tipo_visualizacion_id=$estado;
        $objeto->estado=1;
        $objeto->usuario_created_at = $personaId;
        $objeto->usuario_updated_at = $personaId;
        $rst=$objeto->save();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst,
                'estado'=>$estado,
                'rutaDetalleId'=>$rutaDetalleId,
                'id'=>$id,
                'msj' => 'se actualizo con exito',
            )
        );
    }
     /**
     * mostrar listado de suusarios que vieron el tramite
     */
    public function postUsuarios()
    {

        $rutaDetalleId = Input::get('ruta_detalle_id');
        $rst = VisualizacionTramite::usuarios_visualizacion($rutaDetalleId);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst,
                'msj' => 'se actualizo con exito',
            )
        );
    }
}