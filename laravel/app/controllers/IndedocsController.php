<?php

class IndedocsController extends \BaseController {

        
    public function postListadocumentosindedocs()
    {
      
      $area=Auth::user()->area_id;
      //$area=1;
      $AreaIntera=AreaInterna::where('area_id','=',$area)->first();
      $retorno=array(
                  'rst'=>1
               );

      $url ='https://www.muniindependencia.gob.pe/repgmgm/index.php?opcion=documento&area='.$AreaIntera->area_id_indedocs;
      $curl_options = array(
                    //reemplazar url 
                    CURLOPT_URL => $url,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_FOLLOWLOCATION => TRUE,
                    CURLOPT_ENCODING => 'gzip,deflate',
            );
 
            $ch = curl_init();
            curl_setopt_array( $ch, $curl_options );
            $output = curl_exec( $ch );
            curl_close($ch);

      $r = json_decode(utf8_encode($output),true);
      
      $html="";
      
      
      $n=1;
      foreach ($r["documento"] as $rr) {
        $buscar=array(' - ');
        $reemplazar=array('-');
        $valor=str_replace($buscar, $reemplazar, $rr["Docu_cabecera"]);
        $html.="<tr>";
        $html.="<td>".$n."</td>";
        $html.="<td>".$valor."</td>";
        $html.='<td> <a class="btn btn-success" onClick="cargarNroDoc(\''.$valor.'\',\''.$rr["Documento_id"].'\')" data-toggle="modal" data-target="#indedocsModal">
                                                    <i class="fa fa-check fa-lg"></i>
                                                </a></td>';
        $html.="</tr>";
         $n++;
      }
      $retorno["data"]=$html;

      return Response::json( $retorno );
    }
	/**
	 * Display a listing of the resource.
	 * GET /prueba
	 *
	 * @return Response
	 */
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
