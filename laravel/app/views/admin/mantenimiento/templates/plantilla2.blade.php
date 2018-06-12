<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

<style>
body {
  margin:0;
  padding:0
}

.carnet{
  border: 2px solid #000;
  height: 210px;
  width: 400px;
  font-family: arial;
  font-size: 12px;
}

.cab{
  border: 0px solid blue;
  width: 256px;
  padding: 8px 2px;
  text-align: center;
  height: 16px;
  font-weight: bold;
  margin-top: 0px;
}

.areal{
  border: 0px solid blue;
  float:left;
  font-weight: bold;
}

.f1{
  border: 0px solid #000;
  height: 90px;
}
.ff1{
  border: 0px solid #000;
  height: 80px;
  width: 60px;
  margin: 1px auto;
  margin-top: 5px;
}
.f2{
  border: 0px solid #000;
  height: 100px;
}
.ff2{
  border: 0px solid #000;
  height: 100px;
  width: 100px;
  margin: 1px auto;
}

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
      width: 500px;  
      position: absolute; 
      right: 0px;
      top: 70px;  
      left: 150px;
      font-size: 40px; 
      opacity: 0.12;
    } 
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" rightmargin="0">

<?php if($reporte == 1) : ?> 
<div class="carnet" style="margin: 10px auto;">
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/logo_muni.png" style="border: 0px; width: 60px;"/></div>
         </div>
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
       </td>
       <td style="width: 70%;">
         <div class="cab">
             MUNICIPALIDAD DE INDEPENDENCIA
         </div>
         <table border="0" style="width: 100%;" cellpadding="4">
           <tr class="info">
             <td class="areal" style="width: 28%;">Nombres&nbsp;:<td>              
             <td style="width: 72%;">{{ $nombres }}<td>
           </tr>
           <tr class="info">
             <td class="areal" style="width: 28%;">Apellidos&nbsp;:<td>              
             <td style="width: 72%;">{{ $apellidos }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">Area&nbsp;:<td>              
             <td style="width: 72%;">{{ $area }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">DNI&nbsp;:<td>              
             <td style="width: 72%;">{{ $dni }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
             <td style="width: 72%;">{{ $resolucion }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
             <td style="width: 72%;">{{ $numero }}<td>
           </tr>
        </table>
        
       </td>
     </tr>
  </table>
 </div>
<?php endif; ?> 

<?php if ($reporte == 2) : ?>      
<?php   $c = 1;
        foreach ($oData as $key => $val) :?>
        <?php if($c == 1) { ?>
          <table border="0" style="width: 100%;">
        <?php } ?>
        <?php if($c % 2 == 1) { ?>
            <tr>
        <?php } ?> 
              <?php if($c % 2 == 1) { ?>
              <td style="">
                <div class="carnet" style="">
                  <table border="0" style="width: 100%;">
                      <tr>
                       <td style="width: 30%;border: 0px solid blue;">
                         <div class="f1">
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/logo_muni.png" style="border: 0px; width: 60px;"/></div>
                         </div>
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>         
                       </td>
                       <td style="width: 70%;">
                         <div class="cab">
                             MUNICIPALIDAD DE INDEPENDENCIA
                         </div>
                         <table border="0" style="width: 100%;" cellpadding="4">
                           <tr class="info">
                             <td class="areal" style="width: 28%;">Nombres&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['nombre']; ?><td>
                           </tr>
                           <tr class="info">
                             <td class="areal" style="width: 28%;">Apellidos&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['apellidos']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">Area&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['area']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">DNI&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['dni']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['resolucion']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['cod_inspector']; ?><td>
                           </tr>
                        </table>              
                       </td>
                     </tr>
                  </table>
                 </div>
              </td>
              <?php } else { ?>
              <td style="">          
                <div class="carnet" style="">
                  <table border="0" style="width: 100%;">
                      <tr>
                       <td style="width: 30%;border: 0px solid blue;">
                         <div class="f1">
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/logo_muni.png" style="border: 0px; width: 60px;"/></div>
                         </div>
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>         
                       </td>
                       <td style="width: 70%;">
                         <div class="cab">
                             MUNICIPALIDAD DE INDEPENDENCIA
                         </div>
                         <table border="0" style="width: 100%;" cellpadding="4">
                           <tr class="info">
                             <td class="areal" style="width: 28%;">Nombres&nbsp;:<td>              
                             <td style="width: 72%; font-size:10px;"><?php echo $val['nombre']; ?><td>
                           </tr>
                           <tr class="info">
                             <td class="areal" style="width: 28%;">Apellidos&nbsp;:<td>              
                             <td style="width: 72%; font-size:10px;"><?php echo $val['apellidos']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">Area&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['area']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">DNI&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['dni']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['resolucion']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['cod_inspector']; ?><td>
                           </tr>
                        </table>              
                       </td>
                     </tr>
                  </table>
                 </div>
              </td>
              <?php } ?>

        <?php if($c % 2 == 0) { ?>
            </tr>
        <?php } 

          if($c % 6 == 0) :?> 
          </table>
          <div style="page-break-after: always"><span style="display:none">&nbsp;</span></div>
          <table border="0" style="width: 100%;">
<?php     endif;
          $c++;
        endforeach; ?> 
<?php endif; ?> 


<?php if($reporte == 3) : ?> 
<div class="carnet" style="height: 235px; margin: 10px auto;">
  <div class="rotar1"><?php if($vistaprevia!=''){echo "Documento No Válido";} ?></div> 
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/logo_muni.png" style="border: 0px; width: 60px;"/></div>
         </div>
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
       </td>
       <td style="width: 70%;">
         <div class="cab">
             MUNICIPALIDAD DE INDEPENDENCIA
         </div>
         <table border="0" style="width: 100%;" cellpadding="4">
           <tr class="info">
             <td class="areal" style="width: 28%;">Nombres&nbsp;:<td>              
             <td style="width: 72%;">{{ $nombres }}<td>
           </tr>
           <tr class="info">
             <td class="areal" style="width: 28%;">Apellidos&nbsp;:<td>              
             <td style="width: 72%;">{{ $apellidos }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">Area&nbsp;:<td>              
             <td style="width: 72%;">{{ $area }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">DNI&nbsp;:<td>              
             <td style="width: 72%;">{{ $dni }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
             <td style="width: 72%;">{{ $resolucion }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
             <td style="width: 72%;">{{ $numero }}<td>
           </tr>
           <?php if($vistaprevia!=''){ ?>
           <tr>
             <td class="areal" style="width: 28%;">Estado&nbsp;:<td>              
             <td style="width: 72%;">{{ $estado }}<td>
           </tr>
           <?php } ?>
        </table>
        
       </td>
     </tr>
  </table>
 </div>
<?php endif; ?> 

</body>
</html>
