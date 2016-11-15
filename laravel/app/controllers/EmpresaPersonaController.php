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
        ->leftjoin(
            DB::raw("(
                SELECT ep.cargo, ep.fecha_vigencia, ep.fecha_cese,ep.empresa_id,
                p.dni,
                CONCAT(p.paterno,' ',p.materno,', ', p.nombre ) AS representante
                FROM empresa_persona ep 
                JOIN personas p ON  ep.persona_id=p.id 
                AND ep.representante_legal=1
                ) rep
            "),
            'e.id', '=', 'rep.empresa_id'
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
            
            $query->join('empresa_persona as ep','e.id','=','ep.empresa_id');
            $query->select(
            'e.id','e.nombre_comercial','e.direccion_fiscal','e.telefono','rep.dni',
            'e.estado','e.fecha_vigencia', 'e.tipo_id' , 'e.ruc', 'e.razon_social',
            'ep.cargo as persona_cargo', 'ep.fecha_vigencia as persona_vigencia',
            'ep.fecha_cese as persona_cese', 'rep.dni',
            DB::raw(
                'IFNULL(rep.representante,"sin representante") as representante'
                )
            );
            $query->where('ep.persona_id','=',Auth::id());
        } else {
            $query->select(
            'e.id','e.nombre_comercial','e.direccion_fiscal','e.telefono','rep.dni',
            'e.estado','e.fecha_vigencia', 'e.tipo_id' , 'e.ruc', 'e.razon_social',
            DB::raw(
                'IFNULL(rep.representante,"sin representante") as representante'
                )
            );
        }

        $perPage = Input::has('per_page') ? (int) Input::get('per_page') : null;

        return Response::json($query->paginate($perPage));
    }
    /**
     * consultar las personas afiliadas por empresa
     */
    public function getAfiliados(){
        
        $query = DB::table('personas as p')
        ->join('empresa_persona as ep','p.id','=','ep.persona_id')
        ->select('p.id', 'p.dni', 'p.paterno', 'p.materno',
                'p.nombre', 'ep.fecha_vigencia', 'ep.fecha_cese',
                'ep.cargo', 'p.estado', 'ep.representante_legal');

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
                $q->where('paterno', 'like', $value)
                    ->orWhere('materno', 'like', $value)
                    ->orWhere('nombre', 'like', $value)
                    ->orWhere('cargo', 'like', $value);
            });
        }
        if (Input::has('empresa_id')) {
            $query->where('ep.empresa_id','=',Input::get('empresa_id'));
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
        /**
     * crear empresa
     *
     * @return Response
     */
    public function postAfiliar()
    {
        $rules = [
            'id'                     => 'required|Integer',
            'empresa_id'             => 'required|Integer',
            'imagen'                 => 'required',
            'imagen_dni'             => 'required',
            'cargo'                  => 'required|Alpha',
            'cese'                   => 'required|date_format:"Y-m-d H:i:s"',
            'vigencia'               => 'required|date_format:"Y-m-d H:i:s"',
            'representante_legal'    => 'required|Integer|Max:1',
        ];
        $validator = Validator::make(Input::all(),$rules);
        if ( $validator->fails() ) {
            return Response::json([
                'rst'=>false,
                'msj'=>$validator->messages()->all()[0],
            ]);
        }
        $id=Input::get('id');
        $uploadFolder = 'img/user/'.md5('u'.$id);
        if ( !is_dir($uploadFolder) ) {
            mkdir($uploadFolder);
        }
        $imagen=Input::get('imagen');
        $imagenDni=Input::get('imagen_dni');
        if (Input::has('imagen')) {
            $data = Input::get('imagen');
            if (isset( explode(';', $data)[1] )) {
                list($type, $data) = explode(';', $data);
                list(, $type) = explode('/', $type);
                if ($type=='jpeg') $type='jpg';
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $imagen = "u".Input::get('id') . "." . $type;
                $file = $uploadFolder . '/' . $imagen;
                file_put_contents($file , $data);
            } elseif (strpos($data, 'img/user/')!== false) {
                $imagen = explode('/', $data)[3];
            }
        }
        if (Input::has('imagen_dni')) {
            $data = Input::get('imagen_dni');
            if (isset( explode(';', $data)[1] )) {
                list($type, $data) = explode(';', $data);
                list(, $type) = explode('/', $type);
                if ($type=='jpeg') $type='jpg';
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $imagenDni = "dni".Input::get('dni') . "." . $type;
                $file = $uploadFolder . '/' . $imagenDni;
                file_put_contents($file , $data);
            } elseif (strpos($data, 'img/user/')!== false) {
                $imagenDni = explode('/', $data)[3];
            }
        }

        $persona = Persona::find($id);
        $persona->imagen =$imagen;
        $persona->imagen_dni =$imagenDni;
        $rst=$persona->save();
        $empresaId=Input::get('empresa_id');
        $msj='no se encontro empresa o usuario a afiliar';
        if ($rst && $empresaId>0) {
            //buscar si esta afiliado a dicha empresa
            $empresaPersona = DB::table('empresa_persona')
                                    ->where('persona_id', '=', $id)
                                    ->where('empresa_id', '=', $empresaId)
                                    ->first();
            if (is_null($empresaPersona)) {
                $empresa = Empresa::find(Input::get('empresa_id'));
                $persona->empresas()->save(
                    $empresa,
                    [
                        'cargo'=> Input::get('cargo'),
                        'representante_legal'=> Input::get('representante_legal'),
                        'fecha_vigencia'=> Input::get('vigencia'),
                        'fecha_cese'=> Input::get('cese'),
                    ]
                );
                $msj='se afilio persona correctamente';
            } else {
                DB::table('empresa_persona')
                    ->where('persona_id', '=', $id)
                    ->where('empresa_id', '=', $empresaId)
                    ->update(
                       [
                        'cargo'=> Input::get('cargo'),
                        'representante_legal'=> Input::get('representante_legal'),
                        'fecha_vigencia'=> Input::get('vigencia'),
                        'fecha_cese'=> Input::get('cese'),
                        ]
                    );
                $msj='se actualizo afiliacion';
            }
        }
        $reesponse=[
            'rst'=>$rst,
            'msj'=>$msj,
        ];
        return Response::json($reesponse);
    }
}