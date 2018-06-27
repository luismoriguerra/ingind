<?php
class ReporteProceso extends Eloquent
{
    public $table="rutas_flujo";

    public static function getReporteProceso($areas,$fechaIni,$fechaFin)
    {

    	$dateIni = explode("/", $fechaIni);
    	$dateEnd = explode("/", $fechaFin);

		$pivots = "";
		$lefts = "";
    	if($fechaIni == $fechaFin){

    		$filterMonth = " = '$fechaIni'";

    	}
    		$pv=0;
    		$limit = 100;

    			$m = (int)$dateIni[1];
    			$y = (int)$dateIni[0];


    		while($y < intval($dateEnd[0]) || $m <= intval($dateEnd[1])){


    			$auxMonth = str_pad($m, 2, "0", STR_PAD_LEFT);
	    		$pivots .= ",count(RFD$pv.id) as {$y}_{$m}\r\n";
				$lefts .= "LEFT JOIN rutas_flujo_detalle as RFD$pv ON DATE_FORMAT(RFD$pv.created_at,'%Y-%m') = '$y-$auxMonth' AND RFD$pv.id = RFD.id\r\n";
				
				$pv++;
    			$m++;

    			if($m == 13){
    				$m = 1;
    				$y++;
    			}
				

    		}

    		$filterMonth = "BETWEEN '$fechaIni' AND '$fechaFin'";
    	



		$x = "
			SELECT  
			RFD.area_id as a,
			A.nombre as nombre
			,count(RFD.id) as Total
			$pivots
			FROM procesos.rutas_flujo as RF 
			INNER JOIN procesos.rutas_flujo_detalle as RFD ON RF.id = RFD.ruta_flujo_id AND RFD.estado = 1
			INNER JOIN areas as A ON RFD.area_id = A.id
			$lefts
			WHERE RFD.area_id IN($areas) AND DATE_FORMAT(RF.created_at,'%Y/%m') $filterMonth
			AND RFD.norden = 1 AND RF.estado = 1
			GROUP BY A.id;
		";

		//echo $x;
		return DB::select($x);
   	}
public static function getReporteTramites($areas,$fechaIni,$fechaFin)
    {

    	$dateIni = explode("/", $fechaIni);
    	$dateEnd = explode("/", $fechaFin);

		$pivots = "";
		$lefts = "";
    	if($fechaIni == $fechaFin){

    		$filterMonth = " = '$fechaIni'";

    	}


    		$pv=0;
    		$limit = 100;

    			$m = (int)$dateIni[1];
    			$y = (int)$dateIni[0];


    		while($y < intval($dateEnd[0]) || $m <= intval($dateEnd[1])){


    			$auxMonth = str_pad($m, 2, "0", STR_PAD_LEFT);

				$pivots .= ",
				    CONCAT(
				    	CAST(COUNT(RD$pv.id) as CHAR(8))
				    	, '=' ,
				        CAST(COUNT(IF(RD$pv.norden = '01'AND RD$pv.`dtiempo_final` IS NULL,1,NULL))AS CHAR (8)),
				        '/',
				        CAST(COUNT(IF(RD$pv.norden != '01' AND RD$pv.`dtiempo_final` IS NULL,1,NULL)) AS CHAR (8))

				        ,'|',

				        CAST(COUNT(IF(RD$pv.norden = '01' AND RD$pv.`dtiempo_final`,1,NULL))AS CHAR (8)),
				        '/',
				        CAST(COUNT(IF(RD$pv.norden != '01' AND RD$pv.`dtiempo_final`,1,NULL))AS CHAR (8))
				    ) AS {$y}_{$m}

				    \r\n";



                $lefts .= "LEFT JOIN procesos.rutas_detalle AS RD$pv ON rd.id=RD$pv.id  AND RD$pv.`fecha_inicio` IS NOT NULL AND DATE_FORMAT(RD$pv.`fecha_inicio`,'%Y-%m') = '$y-$auxMonth'\r\n";

				
				$pv++;
    			$m++;

    			if($m == 13){
    				$m = 1;
    				$y++;
    			}
				

    		}

    		$filterMonth = "BETWEEN '$fechaIni' AND '$fechaFin'";
    	


		$x = "




    SELECT 
    A.id as a,
        A.nombre
        $pivots 
    FROM
        procesos.rutas AS R
        Inner join procesos.rutas_detalle rd on rd.ruta_id=R.id AND rd.condicion = 0 AND rd.estado=1
        INNER JOIN procesos.areas AS A ON A.id = rd.area_id
        $lefts

    WHERE
        A.id IN ($areas)
        AND R.`estado` = 1
        AND R.`fecha_inicio` IS NOT NULL
        AND DATE_FORMAT(R.`fecha_inicio`,'%Y/%m') $filterMonth
    GROUP BY A.id
    		";
//echo $x;

		return DB::select($x);
   	}

}

