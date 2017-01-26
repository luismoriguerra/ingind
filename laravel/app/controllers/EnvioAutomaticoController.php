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
      
         $Ssql="SELECT c.id,c.area_id,1 as titulo,c.titulo as descripcion,a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,p.id persona_id,1 as tipo,
                p.email,p.email_mdi,c.fecha_aviso,c.programacion_aviso,c.fecha_inicio,c.fecha_fin
                FROM contratacion c
                INNER JOIN areas a on c.area_id=a.id
                INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) 
                LEFT JOIN alertas_contratacion ac ON ac.general_id=c.id AND ac.tipo_id=1 AND ac.ultimo_registro=1
                WHERE c.estado=1 
                AND 
                (c.fecha_aviso=curdate() OR
                ADDDATE(ac.fecha_alerta,INTERVAL c.programacion_aviso day)=curdate()
                ) AND  ISNULL(c.fecha_conformidad)

                UNION

                SELECT cr.id,c.area_id,c.titulo,cr.texto,a.nombre as area,CONCAT(p.paterno,' ',p.materno,' ',p.nombre) as persona,p.id persona_id,2 as tipo,
                p.email,p.email_mdi,cr.fecha_aviso,cr.programacion_aviso,cr.fecha_inicio,cr.fecha_fin
                FROM contra_reque cr
                INNER JOIN contratacion c on cr.contratacion_id=c.id
                INNER JOIN areas a on c.area_id=a.id
                INNER JOIN personas p on p.area_id=a.id and rol_id in (9,8) 
                LEFT JOIN alertas_contratacion ac ON ac.general_id=cr.id AND ac.tipo_id=2 AND ac.ultimo_registro=1
                WHERE  cr.estado=1 AND 
                (cr.fecha_aviso=curdate() OR
                ADDDATE(ac.fecha_alerta,INTERVAL cr.programacion_aviso day)=curdate()
                ) AND  ISNULL(cr.fecha_conformidad)";
      
      $contratacion= DB::select($Ssql);
      
           $sql='select area_id,id,email, email_mdi
            from personas
            where area_id in (29)
            and rol_id in (9,8)
            and estado=1
            order by area_id;';
            $e= DB::select($sql);
       
      foreach ($contratacion as $value) {
  
        $html.="<tr>";
        $html.="<td>".$n."</td>";
        $html.="<td>".$value->descripcion."</td>";
        $html.="<td>".$value->area."</td>";
        $html.="<td>".$value->persona."</td>";
        $html.="<td>".$value->email."</td>";
        $html.="<td>".$value->email_mdi."</td>";
        $html.="</tr>";
        if ($value->tipo==1){
            $contratacion='Contratación: '.$value->descripcion;
            $descripcion='Contratación con el titulo; '.$value->descripcion; 'mencionado arriba.';
            $fechafin=$value->fecha_fin;
        }
        if ($value->tipo==2){
            $contratacion='Detalle de Contratación: '.$value->descripcion;
            $descripcion='Detalle de Contratación: '.$value->descripcion;
            $fechafin=$value->fecha_fin.', correspondiente a la Contratación: '.$value->titulo;
        }
        
        $plantilla=Plantilla::where('tipo','=','5')->first();
        $buscar=array('persona:','dia:','mes:','año:','contratacion:','descripcion:','fechainicio:','fechafinal:');
        $reemplazar=array($value->persona,date('d'),$meses[date('n')],date("Y"),$contratacion,$descripcion,$value->fecha_inicio,$fechafin);
        $parametros=array(
          'cuerpo'=>str_replace($buscar,$reemplazar,$plantilla->cuerpo)
        );
        
        $email=$value->email;
        $email_copia = [$e[0]->email, $e[0]->email_mdi];
        
        $email='rcapchab@gmail.com';
        $email_copia='consultas.gmgm@gmail.com';
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