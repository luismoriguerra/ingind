<?php

class EmpresaPersonaController extends BaseController
{
    /**
     * mostrar listado de empresas a las que he sido afiliado,
     * el campo representante sera la persona que tiene representante_legal=1
     * el cargo se muestra de la tabla empresa_persona
     */
    public function getIndex(){


        $query = DB::table('empresas as e')
        ->join('empresa_persona as ep','e.id','=','ep.empresa_id')
        ->join('personas as p','ep.persona_id','=','p.id')
        ->leftjoin(
            DB::raw("(
                SELECT ep.cargo, ep.fecha_vigencia, ep.fecha_cese,ep.empresa_id,
                CONCAT(p.paterno,' ',p.materno,', ', p.nombre ) AS representante
                FROM empresa_persona ep 
                JOIN personas p ON  ep.persona_id=p.id 
                AND ep.representante_legal=1
                ) rep
            "),
            'e.id', '=', 'rep.empresa_id'
        )
        ->select( 'ep.id','e.tipo_id' , 'e.ruc', 'e.razon_social' ,'ep.cargo',
            'ep.fecha_vigencia' ,'ep.fecha_cese',
            DB::raw(
                'IFNULL(rep.representante,"sin representante") as representante'
            )
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
            $query->where('ep.persona_id','=',Auth::id());
        }

        $perPage = Input::has('per_page') ? (int) Input::get('per_page') : null;

        return Response::json($query->paginate($perPage));
    }
    /**
     * consultar empresa por ruc
     */
    public function getPorruc($ruc){
        return Empresa::where('ruc',$ruc)->first();
    }
}