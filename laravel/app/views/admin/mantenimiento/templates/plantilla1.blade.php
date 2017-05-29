<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

<style>
.rotar1  
    {  
      -webkit-transform: rotate(-25deg);  
      -moz-transform: rotate(-25deg);  
      -ms-transform: rotate(-25deg);  
      -o-transform: rotate(-25deg);  
      transform: rotate(-25deg);  
       
      -webkit-transform-origin: 50% 50%;  
      -moz-transform-origin: 50% 50%;  
      -ms-transform-origin: 50% 50%;  
      -o-transform-origin: 50% 50%;  
      transform-origin: 50% 50%;  
       
      font-size: 50px;  
      width: 600px;  
      position: absolute; 
      right: -70px;
      top: 230px;  
      font-size: 40px; 
      opacity: 0.12;
    } 
html, body{
    font-size: 11px;
    line-height: 15px;
    font-family: arial, sans-serif;
}

 tr , td, th {
/*    text-align: left !important;
    border-collapse: collapse;
    border: 1px #ccc; */
    font-size: 11px;
/*    font-family: arial, sans-serif;*/
    
}
table{
    font-size: 11px;
    width: 100% !important;
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
     left: 70px;position: absolute;top: -17px;
}
.logo img {
    height: 117px;
    width: 100px;
}
.nombre-municipio {
    position: absolute;
    top:  0px; 
    left: 208px;
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
    left: 240px;
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

.nombre-documento-left {
    text-align: left;
    font-size: 19px;
    text-decoration: underline; 
}

.nombre-documento-right {
    text-align: right;
    font-size: 19px;
    text-decoration: underline; 
}

.fecha-documento-left {
    text-align: left;
    font-size: 12px;

}

.fecha-documento-right {
    text-align: right;
    font-size: 12px;

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
  top: -21px; 
  left: 580px;
}

.body-rest{
    margin-left: 1.8cm;       
}

.row {
  padding: 2;
  margin: 0;
}
@page {
    margin-bottom: 60px;
    margin-top: 150px;
}
header { 
    position: fixed;
    left: 0px;
    top: -100px;
    right: 0px;
    height: 130px;
}
footer {
    position: fixed;
    left: 0px;
    bottom: -20px;
    right: 0px;
    height: 2px;
    border-bottom: 2px solid #ddd;
}
footer .page:after {
    content: counter(page);
}
footer p {
    text-align: right;
}
footer .izq {
    text-align: left;
}

.c1{
    width: 18% !important
}

.c2{
    width: 82% !important;text-align: left !important
}

</style>

</head>

<footer class="body-rest">
    <table>
      <tr>
        <td>
            <p class="izq">
              
            </p>
        </td>
        <td>
          <p class="page">
            Página
          </p>
        </td>
      </tr>
    </table>
</footer>
<?php if ($tamano==4) {   ?> 
<header>
    <div class="logo">
        <img align="left" src="img/logo_muni.png">
    </div> 
    <h4 class="nombre-municipio">MUNICIPALIDAD DISTRITAL DE INDEPENDENCIA</h4>
    <!--            <h4 class="gerencia">Gerencia x</h4>-->
    <h4 class="nombre-anio">“Año del Buen Servicio al Ciudadano”</h4>
    <h4 class="nombre-vistaprevia">{{ $vistaprevia }}</h4>
   <div class="qr">{{ $imagen }}</div>
    <div class="rotar1"><?php if($vistaprevia!=''){echo "Documento No Válido";} ?></div> 
</header>
<?php } else if($tamano==5){?>
<style type="text/css">
.qr {
  position: absolute;
  top: -21px; 
  left: 370px;
}
.logo {
     left: 10px;position: absolute;top: -17px;
}
.logo img {
    height: 117px;
    width: 80px;
}
.nombre-municipio {
    position: absolute;
    top:  0px; 
    left: 100px;
    font-style: italic;
    font-size: 11.3px;
}
.nombre-vistaprevia {
    position: absolute;
    top:  60px; 
    left: 180px;
    font-style: italic;
    font-weight: bold;
    color: red;
    font-size: 12px;
    text-decoration: underline; 
}
.nombre-anio {
    font-style: italic;
    position: absolute;
    top:  50px; 
    left: 120px;
    font-size: 12px;
    padding: 0px;
    margin: 10px;
}
.body-rest{
    margin-left: 1cm;       
}
.nombre-documento {
    text-align: center;
    font-size: 15px;
    text-decoration: underline; 
}
.nombre-documento-left {
    text-align: left;
    font-size: 15px;
    text-decoration: underline; 
}
.nombre-documento-right {
    text-align: right;
    font-size: 15px;
    text-decoration: underline; 
}
.nombre-documento-right {
    text-align: right;
    font-size: 15px;
    text-decoration: underline; 
}
.fecha-documento-left {
    text-align: left;
    font-size: 14px;
}
.fecha-documento-right {
    text-align: right;
    font-size: 14px;
}
</style>
<header>
    <div class="logo">
        <img align="left" src="img/logo_muni.png">
    </div> 
    <h4 class="nombre-municipio">MUNICIPALIDAD DISTRITAL DE INDEPENDENCIA</h4>
    <!--            <h4 class="gerencia">Gerencia x</h4>--><br><br><br><br><br>
    <h4 class="nombre-anio">“Año del Buen Servicio al Ciudadano”</h4>
    <h4 class="nombre-vistaprevia">{{ $vistaprevia }}</h4>
   <div class="qr">{{ $imagen }}</div>
   <div class="rotar1"><?php if($vistaprevia!=''){echo "Documento No Válido";} ?></div> 
</header>
<?php } ?>
<body>
<?php if ($tamano==4) {   ?> 
    <div>
        @if ($area!=1)
        <div class="body-rest">
            <?php if ($posicion_fecha==2 and ($tipo_envio==4 or $tipo_envio==7))  { ?>  
            <h4 class="fecha-documento-right">
           {{ $fecha }}
            </h4>
            <?php }else if($posicion_fecha==1 and ($tipo_envio==4 or $tipo_envio==7)) {?>
            <h4 class="fecha-documento-left">
            {{ $fecha }}
            </h4>
            <?php }   ?>
            <?php if ($tipo_envio!=7) {?>
           <?php if ($posicion==0) {   ?> 
            <h2 class="nombre-documento">
            {{ $titulo }}
            </h2>
           <?php } else if($posicion==2) { ?> 
            <h2 class="nombre-documento-right">
            {{ $titulo }}
            </h2>
            <?php } else if($posicion==1){ ?>
            <br>
            <h2 class="nombre-documento-left">
            {{ $titulo }}
            </h2>
            <?php }  }  ?>
            
            <?php if ($posicion_fecha==4 and ($tipo_envio==4 or $tipo_envio==7))  { ?>  
            <h4 class="fecha-documento-right">
           {{ $fecha }}
            </h4>
            <?php }else if($posicion_fecha==3 and ($tipo_envio==4 or $tipo_envio==7)) {?>
            <h4 class="fecha-documento-left">
            {{ $fecha }}
            </h4>
            <?php }   ?>
        </div>
        @endif
        <div class="body-rest">
        @if ($conCabecera)
            <div class="tabla-cabecera">
               <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                            <b>DE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                       </td>
                       <td class="c2">
                            {{ $remitente }}
                       </td>
                   </tr>
               </table>
                <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                            <b>A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 4em;">:</b>
                       </td>
                       <td class="c2">
                            {{ $destinatario }}
                       </td>
                   </tr>
               </table>
               {{--  <div class="row">
                    <b>A&nbsp;&nbsp;</b><b style="padding-left: 6em;padding-right: 2em;">:</b> {{ $destinatario }}
                </div> --}}
                @if(isset($copias))
                {{-- <div class="row">
                    <b>CC&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 5em;padding-right: 2em;">:</b> {{ $copias }}
                </div> --}}
                <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                            <b>CC&nbsp;</b><b style="padding-left: 5em;">:</b>
                       </td>
                       <td class="c2">
                            {{ $copias }}
                       </td>
                   </tr>
               </table>                
                @endif
                <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                             <b>ASUNTO&nbsp;&nbsp;</b><b style="padding-left: 2em;"">:</b> 
                       </td>
                       <td class="c2">
                            {{ $asunto }}
                       </td>
                   </tr>
               </table>
                <div class="row">
                    <b>&nbsp;&nbsp;FECHA&nbsp;</b><b style="padding-left: 3em;padding-right: 3em;">:</b> {{ $fecha }}
                </div>
            </div>

            <br><hr>
        @endif

            <div class='cuerpo-documento'>
                {{ $contenido }}
            </div>            
        </div>
    </div>
<?php } else if($tamano==5){?>
 <div>
        @if ($area!=1)
        <div class="body-rest">
            <?php if ($posicion_fecha==2 and $tipo_envio==4)  { ?>  
            <h4 class="fecha-documento-right">
           {{ $fecha }}
            </h4>
            <?php }else if($posicion_fecha==1 and $tipo_envio==4) {?>
            <h4 class="fecha-documento-left">
            {{ $fecha }}
            </h4>
            <?php }   ?>
             <?php if ($tipo_envio!=7) {?>
           <?php if ($posicion==0) {   ?> 
            <h2 class="nombre-documento">
            {{ $titulo }}
            </h2>
           <?php } else if($posicion==2) { ?> 
            <h2 class="nombre-documento-right">
            {{ $titulo }}
            </h2>
            <?php } else if($posicion==1){ ?>
            <h2 class="nombre-documento-left">
            {{ $titulo }}
            </h2>
             <?php } }   ?>
            
            <?php if ($posicion_fecha==4 and $tipo_envio==4)  { ?>  
            <h4 class="fecha-documento-right">
           {{ $fecha }}
            </h4>
            <?php }else if($posicion_fecha==3 and $tipo_envio==4) {?>
            <h4 class="fecha-documento-left">
            {{ $fecha }}
            </h4>
            <?php }   ?>
        </div>
        @endif
        <div class="body-rest">
        @if ($conCabecera)
            <div class="tabla-cabecera">
               <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                            <b>DE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>
                       </td>
                       <td class="c2">
                            {{ $remitente }}
                       </td>
                   </tr>
               </table>
                <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                            <b>A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>
                       </td>
                       <td class="c2">
                            {{ $destinatario }}
                       </td>
                   </tr>
               </table>
               {{--  <div class="row">
                    <b>A&nbsp;&nbsp;</b><b style="padding-left: 6em;padding-right: 2em;">:</b> {{ $destinatario }}
                </div> --}}
                @if(isset($copias))
                {{-- <div class="row">
                    <b>CC&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 5em;padding-right: 2em;">:</b> {{ $copias }}
                </div> --}}
                <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                            <b>CC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>
                       </td>
                       <td class="c2">
                            {{ $copias }}
                       </td>
                   </tr>
               </table>                
                @endif
                <table style="width: 100% !important">
                   <tr>
                       <td class="c1">
                             <b>ASUNTO&nbsp;&nbsp;&nbsp;&nbsp;:</b>
                       </td>
                       <td class="c2">
                            {{ $asunto }}
                       </td>
                   </tr>
               </table>
                <div class="row">
                    <b>&nbsp;&nbsp;FECHA&nbsp;&nbsp;&nbsp;</b><b style="padding-left: 1em;padding-right: 1em;">:</b> {{ $fecha }}
                </div>
            </div>

            <br><hr><br>
        @endif

            <div class='cuerpo-documento'>
                {{ $contenido }}
            </div>            
        </div>
    </div>
<?php } ?>
</body>
</html>
