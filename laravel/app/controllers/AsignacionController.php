<?php

class AsignacionController extends \BaseController
{
    public function postResponsable()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $cdid=Input::get('carta_deglose_id');
            $personaId=Input::get('persona_id');
            
            DB::beginTransaction();
            $asignacion=new Asignacion;
            $asignacion['tipo']=1;
            $asignacion['idtipo']=$cdid;
            
            $cartaDesglose=CartaDesglose::find($cdid);
            $asignacion['persona_id_i']=$cartaDesglose->persona_id;
            $asignacion['persona_id_f']=$personaId;
            $cartaDesglose['persona_id']=$personaId;
            $cartaDesglose['cambios']=$cartaDesglose->cambios*1+1;
            $cartaDesglose['usuario_created_at']=Auth::user()->id;
            $cartaDesglose->save();

            $asignacion['usuario_created_at']=Auth::user()->id;
            $asignacion->save();
            DB::commit();
            
            $rpta['rst']=1;
            $rpta['msj']="Responsable Actualizado";
            return Response::json($rpta);
        }
    }

    public function postPersona()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $rdvid=Input::get('ruta_detalle_verbo_id');
            $personaId=Input::get('persona_id');

            DB::beginTransaction();
            $asignacion=new Asignacion;
            $asignacion['tipo']=2;
            $asignacion['idtipo']=$rdvid;

            $rutaDetalleVerbo=RutaDetalleVerbo::find($rdvid);
            $asignacion['persona_id_i']=trim($rutaDetalleVerbo->usuario_updated_at);
            $asignacion['persona_id_f']=$personaId;
            $rutaDetalleVerbo['usuario_updated_at']=$personaId;
            $rutaDetalleVerbo->save();

            $asignacion['usuario_created_at']=Auth::user()->id;
            $asignacion->save();
            DB::commit();

            $rpta['rst']=1;
            $rpta['msj']="Persona Actualizada";
            return Response::json($rpta);
        }
    }

}
