<?php

class Ticket extends Base
{
    public $table = "tickets";
    public static $where =['id', 'persona_id','area_id','descripcion','fecha_pendiente','fecha_atencion','fecha_solucion','solucion','estado_tipo_problema', 'estado_ticket'];
    public static $selec =['id', 'persona_id','area_id','descripcion','fecha_pendiente','fecha_atencion','fecha_solucion','solucion','estado_tipo_problema', 'estado_ticket'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(t.id) cant
                FROM tickets t
                left join personas as p1 on p1.id = t.persona_id
                left join personas as p2 on p2.id = t.responsable_atencion_id
                left join personas as p3 on p3.id = t.responsable_solucion_id
                left join areas as a on a.id= t.area_id
                WHERE t.estado=1 and (t.estado_ticket=1 or t.estado_ticket=2)";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    

    public static function getCargarHistoricoCount( $array )
    {
        $sSql=" SELECT  COUNT(t.id) cant
                FROM tickets t
                left join personas as p1 on p1.id = t.persona_id
                left join personas as p2 on p2.id = t.responsable_atencion_id
                left join personas as p3 on p3.id = t.responsable_solucion_id
                left join areas as a on a.id= t.area_id
                WHERE t.estado=1 and t.estado_ticket=3";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    

    public static function getCargar( $array )
    {
        $sSql=" SELECT t.id,
            p1.id as persona_id, 
            CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) solicitante,
            a.id as area_id,
            a.nombre area,
            t.descripcion,
            t.fecha_pendiente,
            t.fecha_atencion,
            t.responsable_atencion_id,
            CONCAT_WS(' ',p2.paterno,p2.materno,p2.nombre) responsable_atencion,
            t.fecha_solucion,
            t.responsable_solucion_id,
            t.solucion,
            t.estado_tipo_problema,
            CONCAT_WS(' ',p3.paterno,p3.materno,p3.nombre) responsable_solucion,
            t.estado_ticket,
                                CASE t.estado_tipo_problema
                                WHEN '1' THEN 'Error de Usuario'
                                WHEN '2' THEN 'Incidencia del Sistema'
                                WHEN '3' THEN 'Consultas'
                                WHEN '4' THEN 'Peticiones'
                                WHEN '5' THEN 'Problema de Equipo'
                                END estado_tipo_problema

                FROM tickets t
                left join personas as p1 on p1.id = t.persona_id
                left join personas as p2 on p2.id = t.responsable_atencion_id
                left join personas as p3 on p3.id = t.responsable_solucion_id
                left join areas as a on a.id= t.area_id
                WHERE t.estado=1 and (t.estado_ticket=1 or t.estado_ticket=2)";

        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public static function getCargarHistorico( $array )
    {
        $sSql=" SELECT t.id,
            p1.id as persona_id, 
            CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) solicitante,
            a.id as area_id,
            a.nombre area,
            t.descripcion,
            t.fecha_pendiente,
            t.fecha_atencion,
            t.responsable_atencion_id,
            CONCAT_WS(' ',p2.paterno,p2.materno,p2.nombre) responsable_atencion,
            t.fecha_solucion,
            t.responsable_solucion_id,
            t.solucion,
            t.estado_tipo_problema,
            CONCAT_WS(' ',p3.paterno,p3.materno,p3.nombre) responsable_solucion,
            t.estado_ticket,
                                CASE t.estado_tipo_problema
                                WHEN '1' THEN 'Error de Usuario'
                                WHEN '2' THEN 'Insidencia del Sistema'
                                WHEN '3' THEN 'Consultas'
                                WHEN '4' THEN 'Peticiones'
                                WHEN '5' THEN 'Problema de Equipo'
                                END estado_tipo_problema

                FROM tickets t
                left join personas as p1 on p1.id = t.persona_id
                left join personas as p2 on p2.id = t.responsable_atencion_id
                left join personas as p3 on p3.id = t.responsable_solucion_id
                left join areas as a on a.id= t.area_id
                WHERE t.estado=1 and t.estado_ticket=3 ";

        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }



    public function getTicket(){
        $ticket=DB::table('tickets')
                ->select('id','persona_id','area_id','descripcion','fecha_pendiente','fecha_atencion','responsable_atencion_id','fecha_solucion','responsable_solucion_id','solucion','estado_tipo_problema', 'estado_ticket')
                ->where( 
                    function($query){
                        if ( Input::get('estado_ticket') ) {
                            $query->where('estado_ticket','=','1');
                        }
                       

                    }
                )
                ->orderBy('persona_id')
                ->get();
                
        return $ticket;
    }

    public static function getCambiarEstadoTicket( ) //ELIMINAR
    {   
        $sSql="UPDATE tickets set "
                ."  estado='0',
                    usuario_updated_at='".Auth::user()->id."', 
                    updated_at= now() 
                    WHERE id=".Input::get('id');
        $oData = DB::update($sSql);
        return $oData;
    }
}
