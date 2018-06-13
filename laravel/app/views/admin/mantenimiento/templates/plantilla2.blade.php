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
  height: 225px;
  width: 340px;
  font-family: arial;
  font-size: 8.5pt;
}

.cab{
  border: 0px solid blue;
  width: 256px;
  padding: 3px 2px;
  text-align: center;
  height: 16px;
  font-size: 9.5pt;
  font-weight: bold;
  margin-top: 0px;
  padding-left: -60px;
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
  height: 90px;
  margin: 1px auto;
  margin-top: 10px;
  margin-left: 15px;
}
.f2{
  border: 0px solid #000;
  height: 90px;
}
.ff2{
  border: 0px solid #000;
  height: 100px;
  width: 100px;
  margin: 1px auto;
  margin-top: 10px;
}

.malogo  
{       
  -webkit-transform-origin: 50% 50%;  
  -moz-transform-origin: 50% 50%;  
  -ms-transform-origin: 50% 50%;  
  -o-transform-origin: 50% 50%;  
  transform-origin: 50% 50%; 
 
  opacity: 0.12;
  position: fixed;
  margin: 10px auto;
  left:140px  
 } 

.rotar1  
{  
  -webkit-transform: rotate(-35deg);  
  -moz-transform: rotate(-35deg);  
  -ms-transform: rotate(-35deg);  
  -o-transform: rotate(-35deg);  
  transform: rotate(-35deg);  
   
  -webkit-transform-origin: 50% 50%;  
  -moz-transform-origin: 50% 50%;  
  -ms-transform-origin: 50% 50%;  
  -o-transform-origin: 50% 50%;  
  transform-origin: 50% 50%;  
  
  width: 440px;  
  position: absolute; 
  right: 0px;
  top: 90px;  
  left: 150px;
  font-size: 35px; 
  opacity: 0.12;
}

.bgimage
{
  border: 0px solid #000;
  background-image: url("http://proceso.munindependencia.pe/img/carnet.png");
  /*opacity: 0.12;*/
  background-repeat: repeat-y;
  height: 190px;
  width: 100%;
  background-repeat: no-repeat;
  background-position: center;
}

</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" rightmargin="0">

<?php if($reporte == 1) : ?>
<div class="carnet" style="margin: 10px auto;">
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo @$imagen_dni; ?>" style="border: 0px; height: 90px; width: 72px;"/></div>
         </div>
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
       </td>
       <td style="width: 70%;">

         <div class="cab">
             MUNICIPALIDAD DE INDEPENDENCIA
         </div>
         <div class="bgimage"> 
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

           <?php if($area_id == 10): ?>
           <tr>
             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
             <td style="width: 72%;">{{ $resolucion }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
             <td style="width: 72%;">{{ $numero }}<td>
           </tr>
         <?php endif; ?>
        </table>
        </div>

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
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo $val['imagen_dni']; ?>" style="border: 0px; height: 90px; width: 72px;"/></div>
                         </div>
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>         
                       </td>
                       <td style="width: 70%;">
                         <div class="cab">
                             MUNICIPALIDAD DE INDEPENDENCIA
                         </div>
                         <div class="bgimage">
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
                           <?php if($val['area_id'] == 10): ?>
                           <tr>
                             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['resolucion']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['cod_inspector']; ?><td>
                           </tr>
                         <?php endif; ?>
                        </table>
                        </div>              
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
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo $val['imagen_dni']; ?>" style="border: 0px; height: 90px; width: 72px;"/></div>
                         </div>
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>         
                       </td>
                       <td style="width: 70%;">
                         <div class="cab">
                             MUNICIPALIDAD DE INDEPENDENCIA
                         </div>
                         <div class="bgimage">
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
                           <?php if($val['area_id'] == 10): ?>
                           <tr>
                             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['resolucion']; ?><td>
                           </tr>
                           <tr>
                             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo $val['cod_inspector']; ?><td>
                           </tr>
                         <?php endif; ?>
                        </table>
                        </div>
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


<?php if($reporte == 3) : 
        if($estado == 'Activo') {
          $class_estado = 'padding: 8px 8px; font-size: 12px; background-color: #5cb85c; border-color: #5cb85c; color: #fff;';
          $text_estado = 'ACTIVO';
        } else {
          $class_estado = 'padding: 8px 8px; font-size: 12px; background-color: #f56954; border-color: #f4543c; color: #fff;';
          $text_estado = 'INACTIVO';
        }
?> 
<div class="carnet" style="height: 240px; margin: 10px auto;">
  <div class="rotar1"><?php if($vistaprevia!=''){echo "Validación - Identificación";} ?></div> 
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo @$imagen_dni; ?>" style="border: 0px; height: 90px; width: 72px;"/></div>
         </div>
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
       </td>
       <td style="width: 70%;">
         <div class="cab">
             MUNICIPALIDAD DE INDEPENDENCIA
         </div>
         <div class="bgimage">
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
           <?php if($area_id == 10): ?>
           <tr>
             <td class="areal" style="width: 28%;">N° RE&nbsp;:<td>              
             <td style="width: 72%;">{{ $resolucion }}<td>
           </tr>
           <tr>
             <td class="areal" style="width: 28%;">INSP.&nbsp;:<td>              
             <td style="width: 72%;">{{ $numero }}<td>
           </tr>
         <?php endif; ?>
           <?php if($vistaprevia!=''){ ?>
           <tr>
             <td class="areal" style="width: 28%;">Estado&nbsp;:<td>              
             <td style="width: 72%;"><?php echo '<label class="" style="'.$class_estado.'">'.$text_estado.'</label>';   ?><td>
           </tr>
           <?php } ?>
        </table>
        </div>
       </td>
     </tr>
  </table>
 </div>
<?php endif; ?> 

</body>
</html>
