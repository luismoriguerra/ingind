<?php
class Ruta extends Eloquent
{
    public $table="rutas";

    /**
     * Areas relationship
     */
    public function crearRuta(){
        DB::beginTransaction();
        $rutaFlujo=RutaFlujo::find(Input::get('ruta_flujo_id'));

        $ruta= new Ruta;
        $ruta['tabla_relacion_id']=Input::get('tabla_relacion_id');
        $ruta['fecha_inicio']= Input::get('fecha_inicio');
        $ruta['ruta_flujo_id']=$rutaFlujo->id;
        $ruta['flujo_id']=$rutaFlujo->flujo_id;
        $ruta['persona_id']=$rutaFlujo->persona_id;
        $ruta['area_id']=$rutaFlujo->area_id;
        $ruta['usuario_created_at']= Auth::user()->id;
        $ruta->save();

        $qrutaDetalle=DB::table('rutas_flujo_detalle')
            ->where('ruta_flujo_id', '=', $rutaFlujo->id)
            ->where('estado', '=', '1')
            ->get();

            foreach($qrutaDetalle as $rd){
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$rd->area_id;
                $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                $rutaDetalle['dtiempo']=$rd->dtiempo;
                $rutaDetalle['norden']=$rd->norden;
                if($rd->norden==1){
                    $rutaDetalle['fecha_inicio']=Input::get('fecha_inicio');
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();

                $qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                ->where('estado', '=', '1')
                                ->get();
                    if(count($qrutaDetalleVerbo)>0){
                        foreach ($qrutaDetalleVerbo as $rdv) {
                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $rdv->nombre;
                            $rutaDetalleVerbo['condicion']= $rdv->condicion;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();
                        }
                    }
            }

        DB::commit();

        return  array(
                    'rst'=>1,
                    'msj'=>'Registro realizado con éxito'
                );
    }

}
?>
