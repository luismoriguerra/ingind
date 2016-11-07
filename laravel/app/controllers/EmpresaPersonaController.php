<?php

class EmpresaPersonaController extends BaseController
{
    public function getIndex(){

        $query = DB::table('empresa as e')
        ->join('empresa_persona as ep','e.id','=','ep.empresa_id')
        ->join('personas as p','ep.persona_id','=','p.id')
        ->select( 'e.tipo_id' , 'e.ruc', 'e.razon_social' , 
    DB::RAW("CONCAT(p.paterno,' ',p.materno,', ', p.nombre ) AS representante")
            ,'e.cargo' , 'ep.fecha_vigencia' ,'ep.fecha_cese'
        );

        if (Input::has('sort')) {
            list($sortCol, $sortDir) = explode('|', Input::get('sort'));
            $query->orderBy($sortCol, $sortDir);
        } else {
            $query->orderBy('e.id', 'asc');
        }

        if (Input::has('filter')) {
            $filter=Input::get('filter');
            $query->where(function($q) use($filter) {
                $value = "%{$filter}%";
                $q->where('razon_social', 'like', $value)
                    ->orWhere('nombre_comercial', 'like', $value)
                    ->orWhere('direccion_fiscal', 'like', $value)
                    ->orWhere('ruc', 'like', $value);
            });
        }
        if (Input::has('usuario_actual')) {
            $query->where('e.representante_legal','=',Auth::id());
        }

        $perPage = Input::has('per_page') ? (int) Input::get('per_page') : null;

        return Response::json($query->paginate($perPage));
    }
}