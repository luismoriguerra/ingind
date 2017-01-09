<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style>

html, body{
    font-size: 13px;
    line-height: 18px;
}

table, tr , td, th {
    text-align: left !important;
    border-collapse: collapse;
    border: 1px solid #ccc;
    width: 100%;
    font-size: 13px;
    font-family: arial, sans-serif;
}
th, td {
    padding: 5px;
}
hr {
    width: 100%;
    height: 0;
    color: #b2b2b2;
    background-color: #b2b2b2;
}
.text-negrita {
    font-weight: bold;
}

.logo {
    text-align: center;
}
.logo img {
    height: 100px;
}
.nombre-municipio {
    text-align: center;
    font-size: 15px;
    padding: 0px;
    margin: 10px;
}
.nombre-anio {
    text-align: center;
    font-style: italic;
    font-size: 15px;
    padding: 0px;
    margin: 10px;
}
.nombre-documento {
    text-align: center;
    font-size: 17px;
    text-decoration: underline;
}
.cuerpo-documento {
    font-size: 15px;
}
.tabla-cabecera {
    border: none;
}
.tabla-cabecera td {
    vertical-align: top;
    border: none;
    padding: 5px;
}
.qr {
  position: absolute;
  top:  8px; 
  left: 550px;
}
</style>

</head>
<body>

    <div>

        <div>
            <div class="logo">
                <img src="img/logo_muni.jpg">
            </div> <div class="qr">{{ $imagen }}</div>
            <h3 class="nombre-municipio">MUNICIPALIDAD DISTRITAL DE INDEPENDECIA</h3>
            <h4 class="nombre-anio">“Año de la consolidación del Mar de Grau”</h4>
           
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
