<?php

class Bandeja extends \Eloquent {
    protected $fillable = [];
    public $table = "rutas";

    public static function runLoad($r)
    {
        $sql=DB::table('rutas AS r')
            ->join('rutas_detalle AS rd',function($join){
                $join->on('r.id','=','rd.ruta_id')
                ->where('rd.estado','=',1)
                ->where('rd.condicion','=',0);
            })
            ->join('tablas_relacion AS tr',function($join){
                $join->on('r.tabla_relacion_id','=','tr.id')
                ->where('tr.estado','=',1);
            })
            ->join('tiempos AS t',
                't.id','=','rd.tiempo_id'
            )
            ->join('flujos AS f',
                'f.id','=','r.flujo_id'
            )
            ->leftJoin(DB::raw('
                (SELECT re2.ruta_id,re2.referido,re2.norden 
                FROM referidos re2 
                INNER JOIN rutas ru2 ON ru2.id=re2.ruta_id AND ru2.estado=1 
                INNER JOIN rutas_detalle rd2 ON rd2.id=re2.ruta_detalle_id AND rd2.condicion=0 AND rd2.estado=1 
                ) AS re'),function($join){
                $join->on('re.ruta_id','=','r.id')
                ->where('re.norden','=','(rd.norden-1)');
            })
            ->select('r.id', 'rd.fecha_inicio', 'rd.norden', 'tr.id_union', 'rd.id AS ruta_detalle_id'
            ,DB::raw('CONCAT(t.apocope,": ",rd.dtiempo) AS tiempo'), 'rd.ruta_id AS ruta_id'
            ,'re.referido AS id_union_ant'
            , DB::raw('rand() AS visto'), 'f.nombre AS proceso'
            ,DB::raw(
            'IF( tr.tipo_persona=1 or tr.tipo_persona=6, CONCAT(tr.paterno," ",tr.materno,", ",tr.nombre),
                IF(tr.tipo_persona=2, CONCAT(tr.razon_social," | RUC:",tr.ruc), 
                    IF(tr.tipo_persona=3, (SELECT nombre FROM areas WHERE id=tr.area_id), 
                        IF(tr.tipo_persona=4 or tr.tipo_persona=5, tr.razon_social,
                        "")
                    )
                ) 
            ) AS persona')
            ,DB::raw(
            'IF( CalcularFechaFinal( rd.fecha_inicio, (rd.dtiempo*t.totalminutos), rd.area_id )>=CURRENT_TIMESTAMP(),
                "Dentro del Tiempo",
                "Fuera del Tiempo"
            ) AS tiempo_final')
            )
            ->where( 
                function($query) use ($r){
                    if( Input::has('id_union') AND $r['id_union']!='' ){
                        $id_union=explode(" ",trim($r['id_union']));
                        for($i=0; $i<count($id_union); $i++){
                            if( trim($id_union[$i]) !='' ){
                                $query->where('tr.id_union','LIKE','%'.trim($id_union[$i]).'%');
                            }
                        }
                    }

                    if( Input::has('id_ant') AND $r['id_ant']!='' ){
                        $id_ant=explode(" ",trim($r['id_ant']));
                        for($i=0; $i<count($id_ant); $i++){
                            if( trim($id_union[$i]) !='' ){
                                $query->where('re.referido','LIKE','%'.trim($id_ant[$i]).'%');
                            }
                        }
                    }

                    if( Input::has('solicitante') AND $r['solicitante']!='' ){
                        $solicitante=explode(" ",trim($r['solicitante']));
                        $dsol=array();$dsol[0]=array();$dsol[1]=array();$dsol[2]=array();
                        $wsol=" ( ";
                        for($i=0; $i<count($solicitante); $i++){
                        array_push($dsol[0]," CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre) like '%".$solicitante[$i]."%' ");
                        array_push($dsol[1]," CONCAT(tr.razon_social,' | RUC:',tr.ruc) like '%".$solicitante[$i]."%' ");
                        array_push($dsol[2]," tr.area_id IN (SELECT nombre FROM areas WHERE nombre like '%".$solicitante[$i]."%') ");
                        }
                        $wsol.=" (".implode(" AND ",$dsol[0]).") ";
                        $wsol.=" OR (".implode(" AND ",$dsol[1]).") ";
                        $wsol.=" OR (".implode(" AND ",$dsol[2]).") ";
                        $wsol.=" )";
                        $query->whereRaw($wsol);
                    }

                    if( Input::has('proceso') AND $r['proceso']!='' ){
                        $proceso=trim($r['proceso']);
                        $query->where('f.nombre','LIKE','%'.trim($proceso).'%');
                    }

                    if( Input::has('tiempo_final') AND $r['tiempo_final']!='' ){
                    $estadofinal=">=CURRENT_TIMESTAMP()";
                        if( $r['tiempo_final']=='0' ){
                        $estadofinal="<CURRENT_TIMESTAMP()";
                        }
                        $wtiempo="  CalcularFechaFinal(
                                    rd.fecha_inicio, 
                                    (rd.dtiempo*t.totalminutos),
                                    rd.area_id 
                                    )$estadofinal ";
                        $query->whereRaw($wtiempo);
                    }

                    if(Input::has('fecha_inicio_b') AND $r['fecha_inicio_b']!=''){
                        $fecha_inicio=explode(" - ",$r['fecha_inicio_b']);
                        $wfecini=" DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
                        $query->whereRaw($wfecini);
                    }

                    if(Input::has('fechaRange') AND $r['fechaRange']!=''){
                        $fecha_inicio=explode(" - ",$r['fechaRange']);
                        $wfecran=" DATE(rd.fecha_inicio) BETWEEN '".$fecha_inicio[0]."' AND '".$fecha_inicio[1]."' ";
                        $query->whereRaw($wfecran);
                    }
                }
            )
            ->where('r.estado','=','1')
            ->where('rd.fecha_inicio','<=','CURRENT_TIMESTAMP')
            ->whereNull('rd.dtiempo_final')
            ->whereRaw('rd.area_id in (
                            SELECT DISTINCT(a.id) 
                            FROM area_cargo_persona acp                            
                            INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1                            
                            INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1                            
                            WHERE acp.estado=1                            
                            AND cp.persona_id= '.Auth::user()->id.'
                        )');
        $result = $sql->paginate(10);
        return $result;
    }
}
