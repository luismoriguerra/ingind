<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

<style>

html, body{
    font-size: 11px;
    line-height: 15px;
    font-family: arial, sans-serif;
}

table, tr , td, th {
    text-align: left !important;
    border-collapse: collapse;
    border: 1px solid #ccc;
    font-size: 11px;
    font-family: arial, sans-serif;
}
th, td {
    padding: 2px;
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
     left: 10px;position: absolute;
}
.logo img {
    height: 107px;
}
.nombre-municipio {
    position: absolute;
    top:  0px; 
    left: 190px;
    font-style: italic;
    font-size: 14px;
}
.nombre-vistaprevia {
    position: absolute;
    top:  60px; 
    left: 280px;
    font-style: italic;
    font-weight: bold;
    color: red;
    font-size: 14px;
    text-decoration: underline; 
}
.nombre-anio {
    font-style: italic;
    position: absolute;
    top:  50px; 
    left: 220px;
    font-size: 14px;
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
    font-size: 12px;
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
  top:  -30px; 
  left: 550px;
}

.body-rest{
    margin-left: 1.8cm;       
}

.row {
  padding: 2;
  margin: 0;
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
            <h4 class="nombre-vistaprevia">{{ $vistaprevia }}</h4>
           <div class="qr">{{ $imagen }}</div>
        </div>
        @if ($area!=1)
        <br>
        <div class="body-rest">
        <h2 class="nombre-documento">
        {{ $titulo }}
        </h2>
        </div>
        @endif
        <div class="body-rest">
        @if ($conCabecera)
            <div class="tabla-cabecera">
                <div class="row">
                    <b">DE&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 5em;padding-right: 2em;">:</b> {{ $remitente }}
                </div>
                <div class="row">
                    <b>A&nbsp;&nbsp;</b><b style="padding-left: 6em;padding-right: 2em;">:</b> {{ $destinatario }}
                </div>
                @if(isset($copias))
                <div class="row">
                    <b>CC&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 5em;padding-right: 2em;">:</b> {{ $copias }}
                </div>
                @endif
                <div class="row">
                    <b>ASUNTO</b><b style="padding-left: 3em;padding-right: 2em;">:</b> 
                    <span>
                        {{ $asunto }}
                    </span>
                </div>
                <div class="row">
                    <b>FECHA&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 3em;padding-right: 2em;">:</b> {{ $fecha }}

                </div>
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
