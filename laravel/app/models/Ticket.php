<?php

class Ticket extends Base
{
    public $table = "tickets";
    public static $where =['id', 'persona_id','area_id','descripcion','fecha_pendiente','fecha_atencion','fecha_solucion', 'estado_ticket'];
    public static $selec =['id', 'persona_id','area_id','descripcion','fecha_pendiente','fecha_atencion','fecha_solucion', 'estado_ticket'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(t.id) cant
                FROM tickets t
                WHERE t.estado=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT t.id,p1.id as persona_id, CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) solicitante,a.id as area_id,a.nombre area,t.descripcion,t.fecha_pendiente,t.fecha_atencion,t.fecha_solucion,t.estado_ticket
                FROM tickets t
                left join personas as p1 on p1.id = t.persona_id
                left join areas as a on a.id= t.area_id
                WHERE t.estado=1 ";

        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public function getTicket(){
        $ticket=DB::table('tickets')
                ->select('id','persona_id','area_id','descripcion','fecha_pendiente','fecha_atencion','fecha_solucion', 'estado_ticket')
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

    public static function getCambiarEstadoTicket( )
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
