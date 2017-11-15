<?php
class Flujo extends Base
{
    public $table = "flujos";
    public static $where =['id', 'nombre', 'estado', 'categoria_id',
                            'usuario_created_at'];
    public static $selec =['id', 'nombre', 'estado','categoria_id'];

    public function getFlujo(){
        if( Input::has('pasouno') ){
            $usuario=Auth::user()->id;
            $where="";
                if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                    $where=" AND f.tipo_flujo=2";
                }
                elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                    $where=" AND f.tipo_flujo=1";
                }
            $sql="  SELECT f.id, f.nombre, f.estado, a.nombre as area, 
                    f.area_id, f.area_id as evento, 
                    IF(f.tipo_flujo=1,'Trámite','Proceso de oficio') as tipo_flujo,
                    f.tipo_flujo as tipo_flujo_id,
                    GROUP_CONCAT(
                        CONCAT(rf.id,'|',rfd.id,'|',rfd.area_id,'|',rfd.norden)
                    ) validacion
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    WHERE  f.estado = 1  
                    AND rfd.area_id IN (
                        SELECT a.id
                        FROM area_cargo_persona acp
                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                        WHERE acp.estado=1
                        AND cp.persona_id= $usuario
                    )
                    $where
                    GROUP BY f.id 
                    ORDER BY f.id ASC";
        $flujo=DB::select($sql);
        }
        else{
        $flujo=DB::table('flujos AS f')
                ->join(
                    'areas AS a',
                    'a.id', '=', 'f.area_id'
                )
                ->leftJoin(
                    'categorias AS c',
                    'c.id', '=', 'f.categoria_id'
                )
                ->leftJoin(
                    'rutas_flujo AS rf',
                    'rf.flujo_id', '=', 'f.id'
                )
                ->leftJoin('rutas_flujo_detalle AS rfd', function($join)
                {
                    $join->on('rfd.ruta_flujo_id', '=', 'rf.id')
                         ->where('rfd.norden', '=', 1);
                })
                ->select('f.id','f.nombre','f.estado','a.nombre AS area','f.area_id','f.area_id AS evento',
                    DB::raw('IFNULL(c.nombre,"sin categoria") AS categoria'), DB::raw('IFNULL(f.categoria_id,"") AS categoria_id'),
                    DB::raw('IF(f.tipo_flujo=1,"Trámite","Proceso de oficio") as tipo_flujo,f.tipo_flujo as tipo_flujo_id')
                )
                ->where( 
                    function($query){
                        if ( Input::get('usuario') ) {
                            $query->whereRaw('a.id IN ('.
                                                'SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                             )'
                                            );
                                if( Input::get('usuario')==1 ){
                                    $query->where('f.estado','=','1');
                                }
                        }
                        elseif ( Input::get('soloruta') ) {
                            $query->where('f.estado', '=', '1')
                                ->where('rf.estado', '=', '1')
                                ->where('rfd.estado', '=', '1')
                                ->whereRaw('rf.id is not null')
                                ->whereRaw('rfd.area_id IN ('.
                                                'SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                             )'
                                            );
                        }
                        elseif ( Input::get('estado') ) {
                            $query->where('f.estado','=','1');
                        }

                        if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                            $query->where('f.tipo_flujo','=',2);
                        }
                        elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                            $query->where('f.tipo_flujo','=',1);
                        }

                        if( Input::has('faltantes') ){
                            $query->whereNull('rf.id');
                        }

                        if( Input::has('flujo_id') ){
                            $query->where('f.id','=',Input::get('flujo_id'));
                        }
                    }
                )
                ->groupBy('f.id')
                ->orderBy('f.nombre')
                ->get();
        }
                
        return $flujo;
    }
    
    public static function getFlujoMicroProceso($array){

            $sSql="  SELECT f.id, f.nombre, f.estado, a.nombre as area, 
                    f.area_id, f.area_id as evento, 
                    IF(f.tipo_flujo=1,'Trámite','Proceso de oficio') as tipo_flujo,
                    f.tipo_flujo as tipo_flujo_id,
                    GROUP_CONCAT(
                        CONCAT(rf.id,'|',rfd.id,'|',rfd.area_id,'|',rfd.norden)
                    ) validacion,
                    rf.id as ruta_flujo_id
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    WHERE  f.estado = 1";
            $sSql.= $array['where'];
            $sSql.= " GROUP BY f.id ";
            $sSql.= $array['order'];
            $sSql.= $array['limit'];
          
      return  $r=DB::select($sSql);
      
    }
    
    public static function getFlujoMicroProcesoCount($array){

            $sSql="  SELECT COUNT(f.id) cant
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    WHERE  f.estado = 1";
            $sSql.= $array['where'];
            $sSql.= " ORDER BY f.nombre ASC ";
            
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    public static function getFlujoProceso2($array){
        
            $usuario=Auth::user()->id;
           
            $sSql="  SELECT f.id, f.nombre, f.estado, a.nombre as area, 
                    f.area_id, f.area_id as evento, 
                    IF(f.tipo_flujo=1,'Trámite','Proceso de oficio') as tipo_flujo,
                    f.tipo_flujo as tipo_flujo_id,
                    GROUP_CONCAT(
                        CONCAT(rf.id,'|',rfd.id,'|',rfd.area_id,'|',rfd.norden)
                    ) validacion,
                    rf.id as ruta_flujo_id,
                    IF(fpd.id!='',1,0) as checked
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    LEFT JOIN ficha_proceso_detalle fpd ON fpd.ruta_flujo_id=rf.id AND fpd.estado=1 AND fpd.check=1 AND fpd.usuario_created_at=".$usuario."
                    WHERE  f.estado = 1  
                    AND rfd.area_id IN (
                        SELECT a.id
                        FROM area_cargo_persona acp
                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                        WHERE acp.estado=1
                        AND cp.persona_id= $usuario
                       )";
            $sSql.= $array['where'];
            $sSql.= " GROUP BY f.id ";
            $sSql.= $array['order'];
            $sSql.= $array['limit'];
          
      return  $r=DB::select($sSql);
      
    }
    
    public static function getFlujoProceso($array){
        
            $usuario=Auth::user()->id;
           
            $sSql="  SELECT f.id, f.nombre, f.estado, a.nombre as area, 
                    f.area_id, f.area_id as evento, 
                    IF(f.tipo_flujo=1,'Trámite','Proceso de oficio') as tipo_flujo,
                    f.tipo_flujo as tipo_flujo_id,
                    GROUP_CONCAT(
                        CONCAT(rf.id,'|',rfd.id,'|',rfd.area_id,'|',rfd.norden)
                    ) validacion,
                    rf.id as ruta_flujo_id
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    WHERE  f.estado = 1  
                    AND rfd.area_id IN (
                        SELECT a.id
                        FROM area_cargo_persona acp
                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                        WHERE acp.estado=1
                        AND cp.persona_id= $usuario
                       )";
            $sSql.= $array['where'];
            $sSql.= " GROUP BY f.id ";
            $sSql.= $array['order'];
            $sSql.= $array['limit'];
          
      return  $r=DB::select($sSql);
      
    }
    
    public static function getFlujoProcesoCount($array){

          $usuario=Auth::user()->id;
           
            $sSql="  SELECT COUNT(f.id) cant
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    WHERE  f.estado = 1  
                    AND rfd.area_id IN (
                        SELECT a.id
                        FROM area_cargo_persona acp
                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                        WHERE acp.estado=1
                        AND cp.persona_id= $usuario
                    )";
            $sSql.= $array['where'];
            $sSql.= " ORDER BY f.nombre ASC ";
            
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT COUNT(f.id) cant
                FROM flujos f
                INNER JOIN categorias c ON c.id=f.categoria_id
                INNER JOIN areas a ON a.id=f.area_id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT f.id,f.area_id,f.categoria_id,f.nombre,f.estado,
                c.nombre categoria,a.nombre area, f.tipo_flujo tipo_flujo_id,
                CASE f.tipo_flujo
                WHEN 1 THEN 'Trámite'
                WHEN 2 THEN 'Orden de Trabajo'
                END tipo_flujo
                FROM flujos f
                INNER JOIN categorias c ON c.id=f.categoria_id
                INNER JOIN areas a ON a.id=f.area_id
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

     public static function getProdporprocesoCount( $array )
    {
        $sSql=" SELECT  COUNT(f.id) as cant from flujos f 
                inner join rutas_flujo rf on rf.flujo_id =f.id and rf.estado in (1,2)
                inner join rutas_flujo_detalle rfd on rf.id=rfd.ruta_flujo_id and rfd.norden=1 and rfd.estado=1
                inner join areas a on rfd.area_id=a.id and a.estado=1 
                left join rutas r on r.flujo_id=f.id
                left join tablas_relacion tr on r.tabla_relacion_id=tr.id and tr.estado=1
                where f.estado=1 
                group by f.id  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getProdporproceso()
    {
        $sSql ="";
        $sSql.="select f.id norden,a.nombre area ,f.nombre proceso,
                (select SUM(rd.dtiempo) from rutas_flujo_detalle rd where rd.ruta_flujo_id=rf.id and rd.estado=1) as cant_diast,
                (select COUNT(r.id) from rutas r where r.flujo_id=f.id and r.estado=1) as cantProc,
                rd.norden nordendetalle,
                rd.dtiempo,a2.nombre areadetalle,
                (select COUNT(rdv.id) from rutas_flujo_detalle_verbo rdv where rdv.ruta_flujo_detalle_id=rd.id and rdv.estado=1) as cant_rdv";

        if(Input::has('area_id')){
             $sSql.=",(select ROUND(SUM(rd2.dtiempo)/cant_diast,2) from rutas_flujo_detalle rd2 where rd2.estado=1 and rd2.ruta_flujo_id=rf.id and rd2.area_id IN (".Input::get('area_id').")) as porc_ttotal";
        }else{
            $sSql.=",(select ROUND(SUM(rd2.dtiempo)/cant_diast,2) from rutas_flujo_detalle rd2 where rd2.estado=1  and rd2.ruta_flujo_id=rf.id) as porc_ttotal";
        }
        $sSql.=",(select ROUND(rd.dtiempo/cant_diast,2)) as porc_actividad,
                CONCAT_WS(' ',p.nombre,p.paterno,p.materno) userAct,rd.updated_at fechaActualizo 
                from flujos f ";

        if(Input::has('cargos') && Input::get('cargos')==1){
            $sSql.=" INNER JOIN rutas_flujo rf ON rf.flujo_id=f.id AND rf.estado=1 AND rf.area_id=".Auth::user()->area_id;
        }else{
            $sSql.=" INNER JOIN rutas_flujo rf ON rf.flujo_id=f.id AND rf.estado=1";
        }
        $sSql.=" INNER JOIN areas a ON rf.area_id=a.id AND a.estado=1";


        if((Input::has('area_id') && Input::get('cargos')==2) or (!Input::has('area_id') && Input::get('cargos')==2)){
             $sSql.=" INNER JOIN rutas_flujo_detalle rd ON rd.ruta_flujo_id=rf.id and rd.estado=1 AND rd.norden > 1 AND rd.area_id='".Auth::user()->area_id."'";
        }else if(Input::has('area_id') && Input::get('cargos')!=2){
              $sSql.=" INNER JOIN rutas_flujo_detalle rd ON rd.ruta_flujo_id=rf.id and rd.estado=1 AND rd.area_id IN (".Input::get('area_id').")";
        }else{
            $sSql.=" INNER JOIN rutas_flujo_detalle rd ON rd.ruta_flujo_id=rf.id and rd.estado=1";
        }

        $sSql.=" INNER JOIN areas a2 ON rd.area_id=a2.id AND a2.estado=1
        LEFT JOIN personas p ON p.id=rd.usuario_updated_at AND p.estado=1
        WHERE f.estado=1";

$sSql.=" ORDER BY proceso,rd.norden";

/*var_dump($sSql);
exit();*/
     /*   $sSql= "";
        $sSql.=" SELECT  f.id norden,f.nombre proceso ,a.nombre area, COUNT(r.id) cantidad from flujos f 
                inner join rutas_flujo rf on rf.flujo_id =f.id and rf.estado in (1,2)
                inner join rutas_flujo_detalle rfd on rf.id=rfd.ruta_flujo_id and rfd.norden=1 and rfd.estado=1
                inner join areas a on rfd.area_id=a.id and a.estado=1 
                left join rutas r on r.flujo_id=f.id
                left join tablas_relacion tr on r.tabla_relacion_id=tr.id and tr.estado=1
                where f.estado=1";

         if(Input::has('fecha')){
            list($fechaIni,$fechaFin) = explode(" - ", Input::get('fecha'));
            $sSql.=' AND date(r.created_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" ';
          }
          if(Input::has('area_id')){
            $sSql.=' AND rfd.area_id IN ('.Input::get('area_id').') ';
          }

          $sSql.=" group by f.id";*/
/*
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];*/

        $oData = DB::select($sSql);
        return $oData;
    }

}
