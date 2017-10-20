<?php

class AuditoriaAcceso extends \Eloquent {

    public $table = "auditoria_acceso";
    
    public  static function getAuditoria(){
        
        $ruta=explode('.',URL::previous());
        if(Request::path()!='admin.inicio' and (Auth::user()->rol_id==8 or Auth::user()->rol_id==9)){
            $opcion= Opcion::where('ruta','like','%'.$ruta[2])->first();
            
            $auditoria=new AuditoriaAcceso;
            $auditoria->persona_id=Auth::user()->id;
            $auditoria->rol_id=Auth::user()->rol_id;
            $auditoria->opcion_id=@$opcion->id;
            $auditoria->tipo=2;
            $auditoria->usuario_created_at=Auth::user()->id;
            $auditoria->ruta=$ruta[4];
            $auditoria->save();
        }
    }
}