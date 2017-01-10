<?php

class EnvioAutomaticoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /prueba
	 *
	 * @return Response
	 */
             public function postContratacionesalertas()
    { 
      $array=array();
      $array['usuario']=Auth::user()->id;
      
      $retorno=array(
                  'rst'=>1
               );

      $html="";
      $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
      
      $n=1;
      
         $Ssql="SELECT c.id,c.area_id,c.titulo,a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,p.id persona_id,1 as tipo,
                p.email,p.email_mdi,c.fecha_aviso,c.programacion_aviso
                FROM contratacion c
                INNER JOIN areas a on c.area_id=a.id
                INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) 
                LEFT JOIN alertas_contratacion ac ON ac.general_id=c.id AND ac.tipo_id=1 AND ac.ultimo_registro=1
                WHERE c.estado=1 
                AND 
                (c.fecha_aviso=curdate() OR
                ADDDATE(ac.fecha_alerta,INTERVAL c.programacion_aviso day)=curdate()
                )

                UNION

                SELECT cr.id,c.area_id,cr.texto,a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,p.id persona_id,2 as tipo,
                p.email,p.email_mdi,cr.fecha_aviso,cr.programacion_aviso
                FROM contra_reque cr
                INNER JOIN contratacion c on cr.contratacion_id=c.id
                INNER JOIN areas a on c.area_id=a.id
                INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) 
                LEFT JOIN alertas_contratacion ac ON ac.general_id=cr.id AND ac.tipo_id=2 AND ac.ultimo_registro=1
                WHERE  cr.estado=1 AND 
                (cr.fecha_aviso=curdate() OR
                ADDDATE(ac.fecha_alerta,INTERVAL cr.programacion_aviso day)=curdate()
                )";
      
      $contratacion= DB::select($Ssql);

       
      foreach ($contratacion as $value) {
  
        $html.="<tr>";
        $html.="<td>".$n."</td>";
        $html.="<td>".$value->titulo."</td>";
        $html.="<td>".$value->area."</td>";
        $html.="<td>".$value->persona."</td>";
        $html.="<td>".$value->email."</td>";
        $html.="<td>".$value->email_mdi."</td>";
        $html.="</tr>";
        
        $plantilla=Plantilla::where('tipo','=','5')->first();
        $buscar=array('persona:','dia:','mes:','año:','titulo:','contratacion:');
        $reemplazar=array($value->persona,date('d'),$meses[date('n')],date("Y"),$value->titulo,$value->titulo);
        $parametros=array(
          'cuerpo'=>str_replace($buscar,$reemplazar,$plantilla->cuerpo)
        );
        
//        $Ssql='SELECT COUNT(aasc.id) as count
//                     FROM alertas_seguridad_ciudadana aasc
//                     WHERE aasc.idpersona='.$rr["idpersona"].' AND aasc.nro_inasistencias='.$rr["faltas"];
//                    $r= DB::select($Ssql);
//                     $r[0]->count==0 
        $email=$value->email;
        $email_copia='consultfas.gmgm@gmail.com';
        if( $email!=''  ){
          
            DB::beginTransaction();   
            $update='update alertas_contratacion set ultimo_registro=0
                     where general_id='.$value->id.' and tipo_id='.$value->tipo;
                     DB::update($update); 
        
            $insert='INSERT INTO alertas_contratacion (persona_id,area_id,tipo_id,general_id,fecha_alerta) 
                     VALUES ('.$value->persona_id.','.$value->area_id.','.$value->tipo.','.$value->id.',"'.date("Y-m-d").'")';
                     DB::insert($insert); 
                                    
        try{
            Mail::send('notreirel', $parametros , 
                function($message) use ($email,$email_copia){
                    $message
                    ->to($email)
                    ->cc($email_copia)
                    ->subject('.::Notificación::.');
                }
            );
       }
        catch(Exception $e){
            //echo $qem[$k]->email."<br>";
             DB::rollback();
        }
        DB::commit();
        }
        $n++;
      }
      $retorno["data"]=$html;

      return Response::json( $retorno );
    }
    
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /prueba/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /prueba
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /prueba/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /prueba/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /prueba/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /prueba/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}