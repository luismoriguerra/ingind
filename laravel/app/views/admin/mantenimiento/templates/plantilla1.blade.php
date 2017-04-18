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
     left: -40px;position: absolute;
}
.logo img {
    height: 100px;
}
.nombre-municipio {
 position: absolute;
  top:  0px; 
  left: 120px;
  font-style: italic;
   font-size: 15px;
}
.nombre-anio {
    text-align: center;
    font-style: italic;
    font-size: 15px;
    padding: 0px;
    margin: 10px;
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
    font-size: 19px;
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
  top:  -15px; 
  left: 550px;
}

.body-rest{
    margin-left: 2cm;       
}
.ul-style {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
</style>

</head>
<body>

    <div>

        <div>
            <div class="logo">
                <img align="left" src="img/logo_muni.jpg">
            </div> 
            <h4 class="nombre-municipio">MUNICIPALIDAD DISTRITAL DE INDEPENDENCIA</h4>
            <!--            <h4 class="gerencia">Gerencia x</h4>--><br><br><br><br><br>
            <h4 class="nombre-anio">“Año del Buen Servicio al Ciudadano”</h4>
           <div class="qr">{{ $imagen }}</div>
        </div>
        @if ($area!=44)
        <h2 class="nombre-documento">{{ $titulo }}</h2>
        @endif
        <div class="body-rest">
        @if ($conCabecera)
            <div class="tabla-cabecera">
                <ul class="ul-style">
                    <li><b>DE:</b> {{ $remitente }}</li>
                </ul>
                <ul class="ul-style">
                    <li><b>A:</b> {{ $destinatario }}</li>
                </ul>
                @if(isset($copias))
                <ul class="ul-style">
                    <li><b>CC:</b> {{ $copias }}</li>
                </ul>
                @endif
                <ul class="ul-style">
                    <li><b>ASUNTO:</b> {{ $asunto }}</li>

                </ul>
                <ul class="ul-style">
                    <li><b>FECHA:</b> {{ $fecha }}</li>

                </ul>
            </div>

            <br><hr><br>
        @endif

            <div class='cuerpo-documento'>
                {{ $contenido }}
            </div>            
        </div>
    </div>

</body>
</html>
