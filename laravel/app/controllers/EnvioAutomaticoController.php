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
        
//        $email='rcapchab@gmail.com';
//        $email_copia='consultas.gmgm@gmail.com';
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
    
                 public function postNotidocplataformaalertas()
    { 
      $array=array();
      $array['usuario']=Auth::user()->id;
      $array['limit']='';$array['order']='';
      $array['id_union']='';$array['id_ant']='';
      $array['referido']=' LEFT ';
      $array['solicitante']='';$array['areas']='';
      $array['proceso']='';$array['tiempo_final']='';
      
      $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
      
      $n=1;
      
      $rst=Reporte::Docplataformaalertaenvio();
       
    foreach ($rst as $key => $value) {
        
        $alerta=explode("|",$value->alerta);
        $texto="";
        $tipo=0;
        $tipo_plat=0;
        
        DB::beginTransaction();

        if($alerta[1]==''){
          $tipo=1;
          $tipo_plat=6;
          $texto=".::Notificación::.";
        }
        elseif($alerta[1]!='' AND $alerta[1]==1){
          $tipo=$alerta[1]+1;
          $tipo_plat=7;
          $texto=".::Reiterativo::.";
        }
        elseif($alerta[1]!='' AND $alerta[1]==2){
          $tipo=$alerta[1]+1;
          $texto=".::Relevo::.";
          $tipo_plat=8;
        }
        elseif($alerta[1]!='' AND $alerta[1]==3){
          $tipo=1;
          $texto=".::Notificación::.";
          $tipo_plat=6;
        }

        $retorno['texto'][]=$texto;
        $retorno['tipo'][]=$tipo;

        if( trim($alerta[0])=='' OR $alerta[0]!=DATE("Y-m-d") ){
          $retorno['retorno']=$alerta[0];
            $plantilla=Plantilla::where('tipo','=',$tipo_plat)->first();
            $buscar=array('persona:','dia:','mes:','año:','tramite:','area:');
            $reemplazar=array($value->persona,date('d'),$meses[date('n')],date("Y"),$value->plataforma,$value->area);
            $parametros=array(
              'cuerpo'=>str_replace($buscar,$reemplazar,$plantilla->cuerpo)
            );
            
            $value->email_mdi='jorgeshevchenk1988@gmail.com';
            $value->email='rcapchab@gmail.com';
            $value->email_seguimiento='jorgeshevchenk@gmail.com,jorgesalced0@gmail.com';

            $email=array();
            if(trim($value->email_mdi)!=''){
              array_push($email, $value->email_mdi);
            }
            if(trim($value->email)!=''){
              array_push($email, $value->email);
            }
            $emailseguimiento=explode(",",$value->email_seguimiento);
            try{
                if(count($email)>0){

                    Mail::queue('notreirel', $parametros , 
                        function($message) use( $email,$emailseguimiento,$texto ) {
                            $message
                            ->to($email)
                            ->cc($emailseguimiento)
                            ->subject($texto);
                        }
                    );                    
                  $alerta=new Alerta;
                  $alerta['ruta_id']=$value->ruta_id;
                  $alerta['ruta_detalle_id']=$value->ruta_detalle_id;
                  $alerta['persona_id']=$value->persona_id;
                  $alerta['tipo']=$tipo;
                  $alerta['fecha']=DATE("Y-m-d");
                  $alerta['clasificador']=2;
                  $alerta->save();
                  $retorno['persona_id'][]=$value->persona_id;
                  
                }
                else{
                  /*$FaltaEmail=new FaltaEmail;
                  $FaltaEmail['persona_id']=$value->persona_id;
                  $FaltaEmail['ruta_detalle_id']=$value->ruta_detalle_id;
                  $FaltaEmail->save();*/
                }
            }
            catch(Exception $e){
              DB::rollback();
              $retorno['id_union'][]=$value->plataforma;
                //echo $qem[$k]->email."<br>";
            }
            DB::commit();
        }
      }
      
            return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );      
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