<?php

class Carta extends Base
{
    public $table = "cartas";

    public static function CargarDetalle (){
        $sql="  SELECT c.id,c.nro_carta,c.objetivo,c.entregable,c.alcance,
                GROUP_CONCAT( 
                    DISTINCT(
                        CONCAT(
                            cr.descripcion,'|',
                            cr.cantidad,'|',
                            cr.total
                        ) 
                    )
                    SEPARATOR '*' 
                ) recursos,
                GROUP_CONCAT( 
                    DISTINCT(
                        CONCAT(
                            cm.metrico,'|',
                            cm.actual,'|',
                            cm.objetivo,'|',
                            cm.comentario
                        ) 
                    )
                    SEPARATOR '*' 
                ) metricos,
                GROUP_CONCAT( 
                    DISTINCT(
                        CONCAT(
                            cd.actividad,'|',
                            cd.responsable,'|',
                            cd.area,'|',
                            cd.recursos,'|',
                            cd.fecha_inicio,'|',
                            cd.fecha_fin,'|',
                            cd.hora_inicio,'|',
                            cd.hora_fin
                        ) 
                    )
                    SEPARATOR '*' 
                ) desgloses
                FROM cartas c
                LEFT JOIN carta_recurso cr ON c.id=cr.carta_id AND cr.estado=1
                LEFT JOIN carta_metrico cm ON c.id=cm.carta_id AND cm.estado=1
                LEFT JOIN carta_desglose cd ON c.id=cd.carta_id AND cd.estado=1
                WHERE c.id = '".Input::get('carta_id')."'
                GROUP BY c.id";

        $r=DB::select($sql);

        return $r;
    }

    public static function CrearActualizar (){
        DB::beginTransaction(); // Iniciando transacción
        $carta=array();
        if( Input::has('carta_id') ){
            $carta=Carta::find(Input::get('carta_id'));
            $carta['usuario_updated_at']=Auth::user()->id;

            DB::table('carta_recurso')
                ->where('carta_id', '=', Input::get('carta_id'))
                ->update(array(
                    "estado"=>0,
                    "updated_at"=>date("Y-m-d H:i:s"),
                    "usuario_updated_at"=>Auth::user()->id
                )
            );

            DB::table('carta_metrico')
                ->where('carta_id', '=', Input::get('carta_id'))
                ->update(array(
                    "estado"=>0,
                    "updated_at"=>date("Y-m-d H:i:s"),
                    "usuario_updated_at"=>Auth::user()->id
                )
            );

            DB::table('carta_desglose')
                ->where('carta_id', '=', Input::get('carta_id'))
                ->update(array(
                    "estado"=>0,
                    "updated_at"=>date("Y-m-d H:i:s"),
                    "usuario_updated_at"=>Auth::user()->id
                )
            );
        }
        else{
            $carta=new Carta;
            $carta['usuario_created_at']=Auth::user()->id;
        }

        $carta['nro_carta']=Input::get('nro_carta');
        $carta['objetivo']=Input::get('objetivo');
        $carta['entregable']=Input::get('entregable');
        $carta['alcance']=Input::get('alcance');

        $carta->save();

        $recursos=array();
        if( Input::has('rec_des') ){
            $recursos[]=Input::get('rec_des');
            $recursos[]=Input::get('rec_can');
            $recursos[]=Input::get('rec_tot');

            for( $i=0; $i<count($recursos[0]); $i++ ){
                $cartaRecurso=new CartaRecurso;
                $cartaRecurso['usuario_created_at']=Auth::user()->id;

                $cartaRecurso['carta_id']=$carta->id;
                $cartaRecurso['descripcion']=$recursos[0][$i];
                $cartaRecurso['cantidad']=$recursos[1][$i];
                $cartaRecurso['total']=$recursos[2][$i];

                $cartaRecurso->save();
            }
        }

        $metricos=array();
        if( Input::has('met_met') ){
            $metricos[]=Input::get('met_met');
            $metricos[]=Input::get('met_act');
            $metricos[]=Input::get('met_obj');
            $metricos[]=Input::get('met_com');

            for( $i=0; $i<count($metricos[0]); $i++ ){
                $cartaMetrico=new CartaMetrico;
                $cartaMetrico['usuario_created_at']=Auth::user()->id;

                $cartaMetrico['carta_id']=$carta->id;
                $cartaMetrico['metrico']=$metricos[0][$i];
                $cartaMetrico['actual']=$metricos[1][$i];
                $cartaMetrico['objetivo']=$metricos[2][$i];
                $cartaMetrico['comentario']=$metricos[3][$i];

                $cartaMetrico->save();
            }
        }

        $desgloses=array();
        if( Input::has('des_act') ){
            $desgloses[]=Input::get('des_act');
            $desgloses[]=Input::get('des_res');
            $desgloses[]=Input::get('des_are');
            $desgloses[]=Input::get('des_rec');
            $desgloses[]=Input::get('des_fin');
            $desgloses[]=Input::get('des_ffi');
            $desgloses[]=Input::get('des_hin');
            $desgloses[]=Input::get('des_hfi');

            for( $i=0; $i<count($desgloses[0]); $i++ ){
                $cartaDesglose=new CartaDesglose;
                $cartaDesglose['usuario_created_at']=Auth::user()->id;

                $cartaDesglose['carta_id']=$carta->id;
                $cartaDesglose['actividad']=$desgloses[0][$i];
                $cartaDesglose['responsable']=$desgloses[1][$i];
                $cartaDesglose['area']=$desgloses[2][$i];
                $cartaDesglose['recursos']=$desgloses[3][$i];
                $cartaDesglose['fecha_inicio']=$desgloses[4][$i];
                $cartaDesglose['fecha_fin']=$desgloses[5][$i];
                $cartaDesglose['hora_inicio']=$desgloses[6][$i];
                $cartaDesglose['hora_fin']=$desgloses[7][$i];

                $cartaDesglose->save();
            }
        }
        //DB::rollback();
        DB::commit();

        return  array(
                    'rst'=>1,
                    'msj'=>'Registro realizado correctamente',
                );
    }

    public static function Cargar (){
        $r=DB::table('cartas')
                ->select('id','nro_carta','objetivo','entregable')
                ->where( 
                    function($query){
                        /*if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }*/
                    }
                )
                ->orderBy('nro_carta')
                ->get();
                
        return $r;
    }
}
