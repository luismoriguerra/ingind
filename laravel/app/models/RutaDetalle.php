<?php
class RutaDetalle extends Eloquent
{
    public $table="rutas_detalle";

    public function getRutadetalle()
    {
        $area_id="";
        $flujo_id="";
        $ruta_detalle_id="";
        $adicional="";

        if ( Input::get('tramite') ) {
            $tramite=Input::get('tramite');

            $adicional=
            'WHERE tr.id_union like "'.$tramite.'%"
            AND rd.area_id IN (
                    SELECT a.id
                    FROM area_cargo_persona acp
                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                    WHERE acp.estado=1
                    AND cp.persona_id='.Auth::user()->id.'
                    )
            AND rd.condicion=0
            AND rd.estado=1
            GROUP BY rd.id
            HAVING ( IFNULL(rd.dtiempo_final,"")="" )
            ORDER BY fi,rd.created_at';
        }

        if ( Input::get('ruta_detalle_id') ) {
            $ruta_detalle_id= Input::get('ruta_detalle_id');
            $adicional='WHERE rd.id="'.$ruta_detalle_id.'"';
        }

        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');
        $query =
            'SELECT rd.id, rd.dtiempo_final, r.flujo_id,
            CONCAT(t.nombre," : ",rd.dtiempo) tiempo,
            rd.observacion,r.ruta_flujo_id,
            a.nombre AS area,f.nombre AS flujo,
            s.nombre AS software,tr.id_union AS id_doc,tr.id id_tr,
            rd.norden, IFNULL(rd.fecha_inicio,"") AS fecha_inicio,
            if(tr.tipo_persona=1
                ,CONCAT("P. Natural: ",tr.paterno," ",tr.materno,", ",tr.nombre)
                ,if(tr.tipo_persona=2
                    ,CONCAT("P. Juridica: ",tr.razon_social," => RUC:",tr.ruc) 
                    ,a.nombre
                )
            ) solicitante,tr.fecha_tramite,tr.sumilla,
            IFNULL(GROUP_CONCAT(
                CONCAT(
                    rdv.id,
                     "=>",
                    rdv.nombre,
                     "=>",
                    IF(rdv.finalizo=0,"Pendiente","Finalizó"),
                    "=>",
                    IF(rdv.condicion=0,"NO",CONCAT("+",rdv.condicion) ),
                    "=>",
                    IFNULL(rdv.documento,""),
                    "=>",
                    IFNULL(rdv.observacion,""),
                    "=>",
                    IFNULL(ro.nombre,""),
                    "=>",
                    IFNULL(ve.nombre,""),
                    "=>",
                    IFNULL(do.nombre,""),
                    "=>",
                    rdv.orden,
                    "=>",
                    IFNULL(concat(p.paterno," ",p.materno,", ",p.nombre),""),
                    "=>",
                    IFNULL(rdv.updated_at,"")
                )
            SEPARATOR "|"),"") AS verbo,
            IFNULL(GROUP_CONCAT(
                CONCAT(
                    "<b>",
                    rdv.orden,
                    "</b>",
                     ".- ",
                    ro.nombre,
                     " tiene que ",
                    ve.nombre,
                     " ",
                    IFNULL(do.nombre,""),
                     " (",
                    rdv.nombre,
                     ")=>",
                    IF(rdv.finalizo=0,"<font color=#EC2121>Pendiente</font>",CONCAT("<font color=#22D72F>Finalizó(",p.paterno," ",p.materno,", ",p.nombre,")</font>") )
                )
            ORDER BY rdv.orden ASC
            SEPARATOR "|"),"") AS verbo2,IFNULL(rd.fecha_inicio,"9999") fi,
            IFNULL(
                DATE_ADD(
                rd.fecha_inicio, 
                INTERVAL (rd.dtiempo*t.totalminutos) MINUTE
                )
            ,"<font color=#E50D1C>Tranquilo! el paso anterior aún no ha acabado</font>") AS fecha_max, now() AS hoy
            ,IFNULL( max( IF(rdv.finalizo=1,rdv.condicion,NULL) ) ,"0") maximo
            FROM rutas_detalle rd
            INNER JOIN rutas r ON (r.id=rd.ruta_id AND r.estado=1)
            LEFT JOIN rutas_detalle_verbo rdv ON (rd.id=rdv.ruta_detalle_id AND rdv.estado=1)
            LEFT JOIN personas p ON p.id=rdv.usuario_updated_at
            LEFT JOIN roles ro ON ro.id=rdv.rol_id
            LEFT JOIN verbos ve ON ve.id=rdv.verbo_id
            LEFT JOIN documentos do ON do.id=rdv.documento_id
            INNER JOIN areas a ON a.id=rd.area_id
            INNER JOIN flujos f ON f.id=r.flujo_id
            INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id
            INNER JOIN softwares s ON s.id=tr.software_id
            INNER JOIN tiempos t ON t.id=rd.tiempo_id '.$adicional;
        $rd = DB::select($query);
        //echo $query;
        if ( Input::get('ruta_detalle_id') ) {
            return $rd[0];
        }
        else{
            return $rd;
        }
    }

    public function getTramite()
    {
        $array['tramite']='';
        if( Input::has('tramite') AND Input::get('tramite')!='' ){
        $tramite=explode(" ",trim(Input::get('tramite')));
            for($i=0; $i<count($tramite); $i++){
              $array['tramite'].=" AND tr.id_union LIKE '%".$tramite[$i]."%' ";
            }
        }
        $sql="  SELECT r.ruta_flujo_id,r.id,tr.id as tramite_id,tr.id_union,tr.fecha_tramite,
                IFNULL(ts.nombre,'') as solicitante,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) des_solicitante,tr.sumilla
                from rutas r
                inner join tablas_relacion tr ON r.tabla_relacion_id=tr.id and tr.estado=1
                LEFT join tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE r.estado=1
                ".$array['tramite'];
        $rd = DB::select($sql);
        
        return $rd;
    }

    public function getRutadetallev()
    {
        $area_id="";
        $flujo_id="";
        $ruta_detalle_id="";
        $adicional="";

        if ( Input::get('tramite') ) {
            $tramite= Input::get('tramite');

            $adicional=
            'WHERE tr.id_union like "'.$tramite.'%"
            AND rd.area_id IN (
                    SELECT a.id
                    FROM area_cargo_persona acp
                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                    WHERE acp.estado=1
                    AND cp.persona_id='.Auth::user()->id.'
                    )
            AND rd.condicion=0
            AND rd.alerta=1 
            AND rd.estado=1
            AND rd.alerta_tipo>0 
            GROUP BY rd.id
            HAVING ( IFNULL(rd.dtiempo_final,"")!="" )
            ORDER BY fi,rd.created_at';
        }

        if ( Input::get('ruta_detalle_id') ) {
            $ruta_detalle_id= Input::get('ruta_detalle_id');
            $adicional='WHERE rd.id="'.$ruta_detalle_id.'"';
        }

        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');
        $query =
            'SELECT rd.id, rd.dtiempo_final, r.flujo_id,
            CONCAT(t.nombre," : ",rd.dtiempo) tiempo,
            rd.observacion,r.ruta_flujo_id,r.id AS ruta_id,
            a.nombre AS area,f.nombre AS flujo,
            s.nombre AS software,tr.id_union AS id_doc,
            rd.norden, IFNULL(rd.fecha_inicio,"") AS fecha_inicio,
            IFNULL(rd.dtiempo_final,"") AS fecha_final,
            IFNULL(GROUP_CONCAT(
                CONCAT(
                    rdv.id,
                     "=>",
                    rdv.nombre,
                     "=>",
                    IF(rdv.finalizo=0,"Pendiente","Finalizó"),
                    "=>",
                    IF(rdv.condicion=1,"+1",
                        IF(rdv.condicion=2,"+2","NO")
                    )
                )
            SEPARATOR "|"),"") AS verbo,
            IFNULL(GROUP_CONCAT(
                CONCAT(
                    rdv.nombre,
                     "=>",
                    IF(rdv.finalizo=0,"<font color=#EC2121>Pendiente</font>","<font color=#22D72F>Finalizó</font>")
                )
            SEPARATOR "|"),"") AS verbo2,IFNULL(rd.dtiempo_final,"9999") fi,
            IFNULL(
                DATE_ADD(
                rd.fecha_inicio, 
                INTERVAL (rd.dtiempo*t.totalminutos) MINUTE
                )
            ,"<font color=#E50D1C>Tranquilo! el paso anterior aún no ha acabado</font>" )AS fecha_max, now() AS hoy,
            IF(rd.alerta_tipo=1,"NO CUMPLE TIEMPO",
                IF(rd.alerta_tipo=2,"NO CUMPLE TIEMPO ALERTA",
                    IF(rd.alerta_tipo=3,"ALERTA ACTIVADA","")
                )
            ) alerta_tipo,CONCAT(rd.alerta,"-",rd.alerta_tipo) codalerta
            FROM rutas_detalle rd
            INNER JOIN rutas r ON (r.id=rd.ruta_id AND r.estado=1)
            LEFT JOIN rutas_detalle_verbo rdv ON (rd.id=rdv.ruta_detalle_id AND rdv.estado=1)
            INNER JOIN areas a ON a.id=rd.area_id
            INNER JOIN flujos f ON f.id=r.flujo_id
            INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id
            INNER JOIN softwares s ON s.id=tr.software_id
            INNER JOIN tiempos t ON t.id=rd.tiempo_id '.$adicional;
        $rd = DB::select($query);

        if ( Input::get('ruta_detalle_id') ) {
            return $rd[0];
        }
        else{
            return $rd;
        }
    }

    public function getListaareas()
    {
        $query='SELECT a.id,a.nombre,a.estado
                FROM area_cargo_persona acp
                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                WHERE acp.estado=1
                AND cp.persona_id='.Auth::user()->id.
                ' ORDER BY a.nombre';
        $area=DB::select($query);
                
        return $area;
    }
}
?>
