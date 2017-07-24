<?php

class Bandeja extends \Eloquent {
    protected $fillable = [];
    public $table = "rutas";

    public static function runLoad($r)
    {
        $sql=Bandeja::select('id','cargo','estado')
            ->where( 
                function($query) use ($r){
                    if( $r->has("cargo") ){
                        $cargo=trim($r->cargo);
                        if( $cargo !='' ){
                            $query->where('cargo','like','%'.$cargo.'%');
                        }
                    }
                    if( $r->has("estado") ){
                        $estado=trim($r->estado);
                        if( $estado !='' ){
                            $query->where('estado','like','%'.$estado.'%');
                        }
                    }
                }
            );
        $result = $sql->orderBy('cargo','asc')->paginate(10);
        return $result;
    }
}
