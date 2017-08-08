<?php

class Ticket extends Base
{
    public $table = "tickets";
    public static $where =['id', 'persona_id','area_id','descripcion','fecha_inicio','fecha_atendido','fecha_fin_atencion', 'estado'];
    public static $selec =['id', 'persona_id','area_id','descripcion','fecha_inicio','fecha_atendido','fecha_fin_atencion', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(t.id) cant
                FROM tickets t
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT t.id, t.persona_id,t.area_id,t.descripcion,t.estado
                  FROM tickets t
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }


    public function getTicket(){
        $ticket=DB::table('tickets')
                ->select('id','persona_id','area_id','descripcion','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('persona_id')
                ->get();
                
        return $ticket;
    }
}
