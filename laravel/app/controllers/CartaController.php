<?php

class CartaController extends \BaseController
{
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function postCorrelativo()
    {
        if ( Request::ajax() ) {
            $r = Carta::Correlativo();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postCargardetalle()
    {
        if ( Request::ajax() ) {
            $r = Carta::CargarDetalle();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postGuardar()
    {
        if ( Request::ajax() ) {
            $r=Carta::CrearActualizar();
            return Response::json(
                $r
            );
        }
    }

    public function postCargar()
    {
        if ( Request::ajax() ) {
            $r = Carta::Cargar();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }


    public function getCartainiciopdf()
    {
        $r = Carta::CargarDetalle();
        $response = $r[0];

        $recursos = explode('*', $response->recursos );
		$count = 0;
		$tr_recursos= "";
        foreach($recursos as $recurso) {
			$count++;
			if (!empty($recurso)){
				$row = explode("|", $recurso);

				$tr_recursos .= "<tr><td>$count</td>" ;
				$count = 0;
				foreach($row as $value){
					$count++;
					if ($count < 4)
					$tr_recursos .= "<td>$value</td>";
				}
				$tr_recursos .= "</tr>";

			}
        }

		// metricos
		$data = explode('*', $response->metricos );
		$count = 0;
		$tr_metricos= "";
		foreach($data as $r) {
			$count++;
			if (!empty($r)){
				$row = explode("|", $r);
				//$tr_metricos .= "<tr><td>$count</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";

				$tr_metricos .= "<tr><td>$count</td>" ;
				$count = 0;
				foreach($row as $value){
					$count++;
					if ($count < 5)
						$tr_metricos .= "<td>$value</td>";
				}
				//$tr_recursos .= "<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>";
				$tr_metricos .= "</tr>";

			}
		}


		// desglose
		$data = explode('*', $response->desgloses );
		$count = 0;
		$tr_desgloses= "";
		foreach($data as $r) {
			$count++;
			if (!empty($r)) {
				$row = explode("|", $r);
				//$tr_desgloses .= "<tr><td>$count</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td></tr>";
				$tr_desgloses .= "<tr><td>$count</td>" ;
				$count=0;
				foreach($row as $value){
					$count++;
					if ($count < 9)
					$tr_desgloses .= "<td>$value</td>";
				}
				//$tr_recursos .= "<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>";
				$tr_desgloses .= "</tr>";
			}
		}


		$html = "<html><meta charset=\"UTF-8\">
<body>
<style>
table, tr , td, th {
text-align: left !important;
border-collapse: collapse;
border: 1px solid #ccc;
width: 100%;
font-size: .9em;
font-family: arial, sans-serif;
}
Th, td {
padding: 5px;
}
</style>
<h3>CARTA DE INICIO</h3>
<table>
	<tr>
		<th>CARTA: </th>
		<td>".$response->nro_carta."</td>
	</tr>
	<tr>
		<th>OBJETIVOS DEL PROYECTO: </th>
		<td>".$response->objetivo."</td>
	</tr>
	<tr>
		<th>ENTREGABLES DEL PROYECTO: </th>
		<td>".$response->entregable."</td>
	</tr>
	<tr>
		<th>ALCANCE DEL PROYECTO: </th>
		<td>".$response->alcance."</td>
	</tr>
</table>
<hr>

<table>
	<tr><th colspan=\"4\">RECURSOS (NO HUMANOS):</th></tr>
	<tr>
		<th>Nro</th>
		<th>Tipo recurso</th>
		<th>Descripción</th>
		<th>Cantidad</th>
	</tr>
	$tr_recursos
</table>

<hr>
<table>
	<tr><th colspan=\"5\">METRICOS:</th></tr>
	<tr>
		<th>Nro</th>
		<th>Metrico</th>
		<th>Actual</th>
		<th>Objetivo</th>
		<th>Comentario</th>
	</tr>
	$tr_metricos
</table>

<hr>
<table>
	<tr><th colspan=\"9\">Desglose de Carta de Inicio N°:</th></tr>
	<tr>
		<th>Nro</th>
		<th>Tipo de actividad</th>
		<th>Actividad</th>
		<th>Responsable - Area</th>
		<th>Recursos</th>
		<th>Fecha Inicio</th>
		<th>Fecha Fin</th>
		<th>Hora Inicio</th>
		<th>Hora Fin</th>
	</tr>
	 $tr_desgloses
</table>

</body>
</html>";


        return PDF::load($html, 'A4', 'landscape')->download('carta-inicio-'.$response->nro_carta);
    }



	public function getInformecartainiciopdf()
	{
		$r = Carta::CargarDetalle();
		$response = $r[0];

		$recursos = explode('*', $response->recursos );
		$count = 0;
		$tr_recursos= "";
		foreach($recursos as $recurso) {
			$count++;
			if (!empty($recurso)) {
				$row = explode("|", $recurso);
//				$tr_recursos .= "<tr><td>$count</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
				$tr_recursos .= "<tr><td>$count</td>" ;
				foreach($row as $value){
					$tr_recursos .= "<td>$value</td>";
				}
				$tr_recursos .= "</tr>";
			}
		}

		// metricos
		$data = explode('*', $response->metricos );
		$count = 0;
		$tr_metricos= "";
		foreach($data as $r) {
			$count++;
			if (!empty($r)) {
				$row = explode("|", $r);
//				$tr_metricos .= "<tr><td>$count</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
				$tr_metricos .= "<tr><td>$count</td>" ;

				foreach($row as $value){
					$tr_metricos .= "<td>$value</td>";
				}
				//$tr_recursos .= "<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>";
				$tr_metricos .= "</tr>";
			}
		}


		// desglose
		$data = explode('*', $response->desgloses );
		$count = 0;
		$tr_desgloses= "";
		foreach($data as $r) {
			$count++;
			if (!empty($r)){
				$row = explode("|", $r);
//				$tr_desgloses .= "<tr><td>$count</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td><td>$row[8]</td><td>$row[9]</td></tr>";
				$tr_desgloses .= "<tr><td>$count</td>" ;

				foreach($row as $value){
					$tr_desgloses .= "<td>$value</td>";
				}
				//$tr_recursos .= "<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>";
				$tr_desgloses .= "</tr>";
			}
		}


		$html = "<html><meta charset=\"UTF-8\">
<body>
<style>
table, tr , td, th {
text-align: left !important;
border-collapse: collapse;
border: 1px solid #ccc;
width: 100%;
font-size: .9em;
font-family: arial, sans-serif;
}
Th, td {
padding: 5px;
}
</style>
<h3>INFORME CARTA DE INICIO</h3>
<table>
	<tr>
		<th>CARTA: </th>
		<td>".$response->nro_carta."</td>
		<th>EVALUACION DE RESULTADO: </th>

	</tr>
	<tr>
		<th>OBJETIVOS DEL PROYECTO: </th>
		<td>".$response->objetivo."</td>
		<td>".$response->informe_objetivo."</td>
	</tr>
	<tr>
		<th>ENTREGABLES DEL PROYECTO: </th>
		<td>".$response->entregable."</td>
		<td>".$response->informe_entregable."</td>
	</tr>
	<tr>
		<th>ALCANCE DEL PROYECTO: </th>
		<td>".$response->alcance."</td>
		<td>".$response->informe_alcance."</td>
	</tr>
</table>
<hr>

<table>
	<tr><th colspan=\"5\">RECURSOS (NO HUMANOS):</th></tr>
	<tr>
		<th>Nro</th>
		<th>Tipo recurso</th>
		<th>Descripción</th>
		<th>Cantidad</th>
		<th>Cuanto sobró</th>
	</tr>
	$tr_recursos
</table>

<hr>
<table>
	<tr><th colspan=\"6\">METRICOS:</th></tr>
	<tr>
		<th>Nro</th>
		<th>Metrico</th>
		<th>Actual</th>
		<th>Objetivo</th>
		<th>Comentario</th>
		<th>Cuanto se alcanzó</th>
	</tr>
	$tr_metricos
</table>

<hr>
<table>
	<tr><th colspan=\"11\">Desglose de Carta de Inicio N°:</th></tr>
	<tr>
		<th>Nro</th>
		<th>Tipo de actividad</th>
		<th>Actividad</th>
		<th>Responsable - Area</th>
		<th>Recursos</th>
		<th>Fecha Inicio</th>
		<th>Fecha Fin</th>
		<th>Hora Inicio</th>
		<th>Hora Fin</th>
		<th>Responsable</th>
		<th>Recurso</th>

	</tr>
	 $tr_desgloses
</table>

</body>
</html>";


		return PDF::load($html, 'A4', 'landscape')->download('informe-carta-inicio-'.$response->nro_carta);
	}

}
