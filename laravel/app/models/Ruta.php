<?php
class Ruta extends Eloquent
{
    public $table="rutas";

    /**
     * Areas relationship
     */
    public function crearRuta(){
        DB::beginTransaction();

        $tablaRelacion=DB::table('tablas_relacion')
                        ->where('id_union', '=', Input::get('codigo'))
                        ->get();

        if(count($tablaRelacion)>0){
            DB::rollback();
            return  array(
                    'rst'=>2,
                    'msj'=>'El trámite ya fue registrado anteriormente'
                );
        }
        else{

        $tablaRelacion=new TablaRelacion;
        $tablaRelacion['software_id']=1;
        $tablaRelacion['id_union']=Input::get('codigo');
        $tablaRelacion['fecha_tramite']=Input::get('fecha_tramite');
        $tablaRelacion['tipo_persona']=Input::get('tipo_persona');
        if(Input::get('tipo_persona')==1){
            $tablaRelacion['paterno']=Input::get('paterno');
            $tablaRelacion['materno']=Input::get('materno');
            $tablaRelacion['nombre']=Input::get('nombre');
        }
        else{
            $tablaRelacion['razon_social']=Input::get('razon_social');
            $tablaRelacion['ruc']=Input::get('ruc');
        }
        $tablaRelacion['usuario_created_at']=Auth::user()->id;
        $tablaRelacion->save();



        $rutaFlujo=RutaFlujo::find(Input::get('ruta_flujo_id'));

        $ruta= new Ruta;
        $ruta['tabla_relacion_id']=$tablaRelacion->id;
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

}
?>
