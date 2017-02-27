<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style>

html, body{
    font-size: 35px;
}

table, td, th {
    text-align: left !important;
    border-collapse: collapse;
    border: 1px solid #ccc;
    width: 100%;
    font-size: 25px;
    font-family: arial, sans-serif;
    line-height: 8px;
}

tr{
    line-height: 10px;
}


th, td {
    padding: 0px;
    line-height: 8px;
}
hr {
    width: 100%;
    height: 0;
    color: #b2b2b2;
    background-color: #b2b2b2;
    line-height: 8px;
}
.text-negrita {
    font-weight: bold;
}

.logo {
     left: -40px;position: absolute;
     text-align: center;
     line-height: 1.5px;
}
.logo img {
    height: 100px;
}

.nombmuni{
    text-align: center;
       line-height: 1.5px;
}

.nombre-municipio {
 position: absolute;
    top: 0px
  left: 120px;
  font-style: italic;
   font-size: 25px;
      line-height: 1.5px;
}
.nombre-anio {
    text-align: center;
    font-style: italic;
    font-size: 25px;
    padding: 0px;
    margin: 10px;
       line-height: 1.5px;
}
.gerencia {
     position: absolute;
    top:  25px; 
    left: 150px;
    font-style: italic;
    font-size: 15px;
}
.nombre-documento {
    text-align: center;
    font-size: 40px;
    text-decoration: underline;
}
.cuerpo-documento {
    font-size: 35px;
        line-height: 18px;
}
.tabla-cabecera {
    border: none;
       line-height: 10px;
        font-size: 33px;
}
.tabla-cabecera td {
    vertical-align: top;
    border: none;
    padding: 5px;
     line-height: 18px;
      font-size: 33px;
}
.qr {
  position: absolute;
  text-align: right;
/*  top:  -15px; 
  left: 550px;*/
}
</style>

</head>
<body>

    <div>

        <div>
            <div class="logo">
                <img align="left" src="img/logo_muni.jpg">
            </div> 
            <div class="nombmuni">
                <h4 class="nombre-municipio">MUNICIPALIDAD DISTRITAL DE INDEPENDECIA</h4>                
            </div>
            <!--            <h4 class="gerencia">Gerencia x</h4>--><br><br><br><br><br>
            <h4 class="nombre-anio">“Año del Buen Servicio al Ciudadano”</h4>
           <div class="qr">{{ $imagen }}</div>
        </div>

        <h3 class="nombre-documento">{{ $titulo }}</h3>

        @if ($conCabecera)
        <table class="tabla-cabecera">
            <tr>
                <td width='25%' class='text-negrita'>DE</td>
                <td width='5px' class='text-negrita'>:</td>
                <td width='75%'>{{ $remitente }}</td>
            </tr>
            <tr>
                <td width='25%' class='text-negrita'>A</td>
                <td width='5px' class='text-negrita'>:</td>
                <td width='75%'>{{ $destinatario }}</td>
            </tr>
             <tr>
                <td width='25%' class='text-negrita'>CC</td>
                <td width='5px' class='text-negrita'>:</td>
                <td width='75%'>{{ $copias }}</td>
            </tr>
            <tr>
                <td width='25%' class='text-negrita'>ASUNTO</td>
                <td width='5px' class='text-negrita'>:</td>
                <td width='75%'>{{ $asunto }}</td>
            </tr>
            <tr>
                <td width='25%' class='text-negrita'>FECHA</td>
                <td width='5px' class='text-negrita'>:</td>
                <td width='75%'>{{ $fecha }}</td>
            </tr>
        </table>

        <br><hr><br>
        @endif

        <div class='cuerpo-documento'>
            {{ $contenido }}
        </div>
    </div>

</body>
</html>
