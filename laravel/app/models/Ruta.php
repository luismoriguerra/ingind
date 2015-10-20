<?php
class Ruta extends Eloquent
{
    public $table="rutas";

    /**
     * Areas relationship
     */
    public function crearRuta(){
        DB::beginTransaction();

        $tablaRelacion=DB::table('tablas_relacion as tr')
                        ->join(
                            'rutas as r',
                            'tr.id','=','r.tabla_relacion_id'
                        )
                        ->where('tr.id_union', '=', Input::get('codigo'))
                        ->where('r.ruta_flujo_id', '=', Input::get('ruta_flujo_id'))
                        ->where('tr.estado', '=', '1')
                        ->where('r.estado', '=', '1')
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

        if( Input::has('ci') ){
            $tablaRelacion['id_union']=Input::get('ci').Input::get('codigo');
        }
        else{
            $tablaRelacion['id_union']=Input::get('codigo');
        }
        $tablaRelacion['fecha_tramite']=Input::get('fecha_tramite');
        $tablaRelacion['tipo_persona']=Input::get('tipo_persona');
        if( Input::has('paterno_autoriza') AND Input::has('materno_autoriza') AND Input::has('nombre_autoriza') ){
            $tablaRelacion['paterno_autoriza']=Input::get('paterno_autoriza');
            $tablaRelacion['materno_autoriza']=Input::get('materno_autoriza');
            $tablaRelacion['nombre_autoriza']=Input::get('nombre_autoriza');
        }
        if( Input::has('paterno_responsable') AND Input::has('materno_responsable') AND Input::has('nombre_responsable') ){
            $tablaRelacion['paterno_responsable']=Input::get('paterno_responsable');
            $tablaRelacion['materno_responsable']=Input::get('materno_responsable');
            $tablaRelacion['nombre_responsable']=Input::get('nombre_responsable');
        }

        if( Input::has('paterno') AND Input::has('materno') AND Input::has('nombre') ){
            $tablaRelacion['paterno']=Input::get('paterno');
            $tablaRelacion['materno']=Input::get('materno');
            $tablaRelacion['nombre']=Input::get('nombre');
        }
        elseif( Input::has('razon_social') AND Input::has('ruc') ){
            $tablaRelacion['razon_social']=Input::get('razon_social');
            $tablaRelacion['ruc']=Input::get('ruc');
        }
        elseif( Input::has('area_p_id') ){
            $tablaRelacion['area_id']=Input::get('area_p_id');
        }
        elseif( Input::has('razon_social') ){
            $tablaRelacion['razon_social']=Input::get('razon_social');
        }

        if( Input::has('referente') AND trim(Input::get('referente'))!='' ){
            $tablaRelacion['referente']=Input::get('referente');
        }

        if( Input::has('responsable') AND trim(Input::get('responsable'))!='' ){
            $tablaRelacion['responsable']=Input::get('responsable');
        }
        $tablaRelacion['sumilla']=Input::get('sumilla');
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
            ->orderBy('norden','ASC')
            ->get();
            $validaactivar=0;
            foreach($qrutaDetalle as $rd){
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id']=$ruta->id;
                $rutaDetalle['area_id']=$rd->area_id;
                $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                $rutaDetalle['dtiempo']=$rd->dtiempo;
                $rutaDetalle['norden']=$rd->norden;
                $rutaDetalle['estado_ruta']=$rd->estado_ruta;
                if($rd->norden==1 or ($rd->norden>1 and $validaactivar==0 and $rd->estado_ruta==2) ){
                    $rutaDetalle['fecha_inicio']=Input::get('fecha_inicio');
                }
                else{
                    $validaactivar=1;
                }
                $rutaDetalle['usuario_created_at']= Auth::user()->id;
                $rutaDetalle->save();

                if( $rd->norden==1 AND Input::has('ci') ){
                    $rutaDetalleVerbo = new RutaDetalleVerbo;
                    $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                    $rutaDetalleVerbo['nombre']= '';
                    $rutaDetalleVerbo['condicion']= '0';
                    $rutaDetalleVerbo['rol_id']= Input::get('rol_id');
                    $rutaDetalleVerbo['verbo_id']= '1';
                    $rutaDetalleVerbo['orden']= '0';
                    $rutaDetalleVerbo['finalizo']='1';
                    $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                    $rutaDetalleVerbo->save();
                }

                $qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                ->where('estado', '=', '1')
                                ->orderBy('orden', 'ASC')
                                ->get();
                    if(count($qrutaDetalleVerbo)>0){
                        foreach ($qrutaDetalleVerbo as $rdv) {
                            $rutaDetalleVerbo = new RutaDetalleVerbo;
                            $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                            $rutaDetalleVerbo['nombre']= $rdv->nombre;
                            $rutaDetalleVerbo['condicion']= $rdv->condicion;
                            $rutaDetalleVerbo['rol_id']= $rdv->rol_id;
                            $rutaDetalleVerbo['verbo_id']= $rdv->verbo_id;
                            $rutaDetalleVerbo['documento_id']= $rdv->documento_id;
                            $rutaDetalleVerbo['orden']= $rdv->orden;
                            $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;
                            $rutaDetalleVerbo->save();
                        }
                    }
            }

            if( Input::has('referente') ){
                $rutaid=$ruta->id;
                $referente=trim( Input::get('referente') );
                $sql="  SELECT r.id, IFNULL(tr.referente,'') referente
                        FROM rutas r
                        INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1
                        WHERE r.estado=1
                        AND tr.id_union='".$referente."'
                        AND r.id < ".$rutaid."
                        ORDER BY r.id DESC
                        LIMIT 0,1
                        ";
                $padre= DB::select($sql);

                while( count($padre)>0 ){
                    $insert='INSERT INTO referentes (ruta_id,ruta_id_padre) 
                             VALUES ('.$ruta->id.','.$padre[0]->id.')';
                    $ins=DB::insert($insert);
                    if( trim($padre[0]->referente)!='' ){
                        $referente=$padre[0]->referente;
                        $rutaid=$padre[0]->id;
                        $sql="  SELECT r.id, IFNULL(tr.referente,'') referente
                                FROM rutas r
                                INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1
                                WHERE r.estado=1
                                AND tr.id_union='".$referente."'
                                AND r.id < ".$rutaid."
                                ORDER BY r.id DESC
                                LIMIT 0,1
                                ";
                        $padre= DB::select($sql);
                    }
                    else{
                        $padre=''; $padre=array();
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
