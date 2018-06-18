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
  background-image: url("http://proceso.munindependencia.pe/img/carnet/model2_n.jpeg");
  border: 0px solid #000;
  height: 216px;
  width: 336px;    
}

.textos{
  font-family: "Comic Sans MS", cursive, sans-serif;
  font-size: 11pt;
}


.areal{
  border: 0px solid blue;
}

.f1{
  border: 0px solid #000;
  height: 94px;
}

.ff1{
  border: 0px solid #000;
  height: 94px;
  margin: 1px auto;
  margin-top: 8px;
  width: 80px;
  margin-left: 5px;
}
.f2{
  border: 0px solid #000;
  height: 90px;
}
.ff2{
  border: 0px solid #000;
  height: 80px;
  width: 80px;
  margin: 1px auto;
  margin-top: 14px;
  margin-left: 5px;
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
 <div class="carnet" style="10px auto;">
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo @$imagen_dni; ?>" style="border: 0px; height: 94px; width: 79px;"/></div>
         </div>
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
       </td>
       <td class="textos" style="width: 70%;">
         <div class="areal" style="font-weight: bold; margin-top:22px; text-transform: capitalize;">{{ $nombres }}</div>              
         <div class="areal" style="font-weight: bold;text-transform: capitalize; margin-bottom: 4px;">{{ $apellidos }}</div>
         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;">{{ $area }}</div>
         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 6px;">DNI&nbsp;: {{ $dni }}</div>
         <?php if($area_id == 10): ?>
          <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;">C&oacute;digo de Inspector: {{ $numero }}</div>
          <div class="areal" style="width: 80%; font-size: 10pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>
         <?php endif; ?>
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
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo $val['imagen_dni']; ?>" style="border: 0px; height: 94px; width: 79px;"/></div>
                         </div>
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>         
                       </td>
                       <td class="textos" style="width: 70%;">
                         <div class="areal" style="font-weight: bold; margin-top:22px; text-transform: capitalize;"><?php echo $val['nombre']; ?></div>
                         <div class="areal" style="font-weight: bold;text-transform: capitalize; margin-bottom: 4px;"><?php echo $val['apellidos']; ?></div>
                         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;"><?php echo $val['area']; ?></div>
                         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 6px;">DNI&nbsp;: <?php echo $val['dni']; ?></div>
                           <?php if($val['area_id'] == 10): ?>
                           <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;">C&oacute;digo de Inspector: <?php echo $val['cod_inspector']; ?></div>
                           <div class="areal" style="width: 80%; font-size: 10pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>                           
                         <?php endif; ?>
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
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo $val['imagen_dni']; ?>" style="border: 0px; height: 94px; width: 79px;"/></div>
                         </div>
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>         
                       </td>
                       <td class="textos" style="width: 70%;">
                         <div class="areal" style="font-weight: bold; margin-top:22px; text-transform: capitalize;"><?php echo $val['nombre']; ?></div>
                         <div class="areal" style="font-weight: bold;text-transform: capitalize; margin-bottom: 4px;"><?php echo $val['apellidos']; ?></div>
                         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;"><?php echo $val['area']; ?></div>
                         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 6px;">DNI&nbsp;: <?php echo $val['dni']; ?></div>
                           <?php if($val['area_id'] == 10): ?>
                           <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;">C&oacute;digo de Inspector: <?php echo $val['cod_inspector']; ?></div>
                           <div class="areal" style="width: 80%; font-size: 10pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>                           
                         <?php endif; ?>
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
<div class="carnet" style="10px auto;">
  <div class="rotar1"><?php if($vistaprevia!=''){echo "Validación - Identificación";} ?></div> 
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo @$imagen_dni; ?>" style="border: 0px; height: 94px; width: 79px;"/></div>
         </div>
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
       </td>
       <td class="textos" style="width: 70%;">        
         <div class="areal" style="font-weight: bold; margin-top:18px; text-transform: capitalize;">{{ $nombres }}</div>              
         <div class="areal" style="font-weight: bold;text-transform: capitalize; margin-bottom: 4px;">{{ $apellidos }}</div>
         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;">{{ $area }}</div>
         <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 6px;">DNI&nbsp;: {{ $dni }}</div>
         <?php if($area_id == 10): ?>
          <div class="areal" style="width: 80%; font-size: 10pt; margin-bottom: 4px;">C&oacute;digo de Inspector: {{ $numero }}</div>
          <div class="areal" style="width: 80%; font-size: 10pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>
         <?php endif; ?>
         <?php if($vistaprevia!=''){ ?>
           <div class="areal" style="width: 80%; font-size: 10pt;"><?php echo '<label class="" style="'.$class_estado.'">'.$text_estado.'</label>';   ?></div>
         <?php } ?>        
       </td>
     </tr>
  </table>
 </div>
<?php endif; ?> 

</body>
</html>
