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
  background-image: url("http://proceso.munindependencia.pe/img/carnet/model2_nuevo2.jpg");
  border: 0px solid #000;
  height: 214px;
  width: 336px;    
}

.textos{
  font-family: "Comic Sans MS", cursive, sans-serif;
  font-size: 11px;
}


.areal{
  border: 0px solid blue;
}

.f1{
  border: 1px solid #000;
  height: 120px;
}

.ff1{
  border: 0px solid #000;
  height: 130px;
  margin: 1px auto;
  width: 90px;
  margin-top: 20px;
}
.f2{
  border: 0px solid #000;
  height: 90px;
}
.ff2{
  border: 0px solid #000;
  height: 65px;
  width: 65px;
  margin: 1px auto;
  margin-top: 85px;
}

.rotar1  
{ 
  /*
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
  */
  width: 440px;  
  position: absolute; 
  right: 0px;
  top: 90px;  
  left: 200px;
  font-size: 35px; 
  opacity: 0.14;
}

</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" rightmargin="0">

<?php if($reporte == 1) : ?>
 <div class="carnet" style="margin: 10px auto;">
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <!-- <div class="f1"> -->
           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo @$imagen_dni; ?>" style="border: 0px; height: 130px; width: 90px;"/></div>
         <!-- </div> -->
         <!--
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
         -->
       </td>
       <td class="textos" style="width: 45%;">
         <div class="areal" style="width: 100%; font-weight: bold; margin-top:48px; text-transform: capitalize;">{{ $nombres }}</div>              
         <div class="areal" style="width: 100%; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;">{{ $apellidos }}</div>
         <div class="areal" style="width: 100%; font-size: 8pt; margin-bottom: 2px;">DNI&nbsp;: {{ $dni }}</div>
         <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">{{ $rol }}</div>
         <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px; text-transform: uppercase; ">{{ $area }}</div>

          <?php if(($rol_id == 8 || $rol_id == 9) && $area_id != 10): ?>
            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $resolucion; ?></div>
          <?php else: 
                  if($area_id != 10): ?>
                  <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
          <?php   endif;
                endif; ?>

          <?php if($area_id == 10): ?>
            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">C&oacute;digo de Inspector: {{ $numero }}</div>
            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $resolucion; ?></div>
            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
          <?php else: ?>
            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">&nbsp;</div>
            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
          <?php endif; ?>
       </td>
       <td style="width: 25%;"> 
         <div class="ff2">{{ $imagen }}</div>
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
                        <!-- <div class="f1"> -->
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo $val['imagen_dni']; ?>" style="border: 0px; height: 130px; width: 90px;"/></div>
                        <!-- </div> -->
                        <!--
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>
                         -->
                       </td>
                       <td class="textos" style="width: 45%;">
                         <div class="areal" style="width: 100%; font-weight: bold; margin-top:48px; text-transform: capitalize;"><?php echo $val['nombre']; ?></div>
                         <div class="areal" style="width: 100%; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;"><?php echo $val['apellidos']; ?></div>
                         <div class="areal" style="width: 100%; font-size: 8pt; margin-bottom: 2px;">DNI&nbsp;: <?php echo $val['dni']; ?></div>
                         <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;"><?php echo $val['rol']; ?></div>
                         <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px; text-transform: uppercase; "><?php echo $val['area']; ?></div>
                           
                          <?php if(($val['rol_id'] == 8 || $val['rol_id'] == 9) && $val['area_id'] != 10): ?>
                            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>
                          <?php else: 
                                  if($val['area_id'] != 10): ?>
                                  <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
                          <?php   endif;
                                endif; ?>
                          <?php if($val['area_id'] == 10): ?>
                            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">C&oacute;digo de Inspector: {{ $val['cod_inspector'] }}</div>
                            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>
                            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
                          <?php else: ?>
                            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">&nbsp;</div>
                            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
                          <?php endif; ?>
                       </td>
                       <td style="width: 25%;"> 
                         <div class="ff2"><?php echo $val['imagen']; ?></div>
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
                        <!-- <div class="f1"> -->
                           <div class="ff1"><img src="http://proceso.munindependencia.pe/img/carnet/<?php echo $val['imagen_dni']; ?>" style="border: 0px; height: 130px; width: 90px;"/></div>
                        <!-- </div> -->
                        <!--
                         <div class="f2">
                           <div class="ff2"><?php echo $val['imagen']; ?></div>
                         </div>
                         -->
                       </td>
                       <td class="textos" style="width: 45%;">
                         <div class="areal" style="width: 100%; font-weight: bold; margin-top:48px; text-transform: capitalize;"><?php echo $val['nombre']; ?></div>
                         <div class="areal" style="width: 100%; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;"><?php echo $val['apellidos']; ?></div>
                         <div class="areal" style="width: 100%; font-size: 8pt; margin-bottom: 2px;">DNI&nbsp;: <?php echo $val['dni']; ?></div>
                         <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;"><?php echo $val['rol']; ?></div>
                         <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px; text-transform: uppercase; "><?php echo $val['area']; ?></div>
                           
                          <?php if(($val['rol_id'] == 8 || $val['rol_id'] == 9) && $val['area_id'] != 10): ?>
                            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>
                          <?php else: 
                                  if($val['area_id'] != 10): ?>
                                  <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
                          <?php   endif;
                                endif; ?>
                          <?php if($val['area_id'] == 10): ?>
                            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">C&oacute;digo de Inspector: {{ $val['cod_inspector'] }}</div>
                            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $val['resolucion']; ?></div>
                            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
                          <?php else: ?>
                            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">&nbsp;</div>
                            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
                          <?php endif; ?>
                       </td>
                       <td style="width: 25%;"> 
                         <div class="ff2"><?php echo $val['imagen']; ?></div>
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
<div class="carnet" style="margin: 10px auto;">
  <div class="rotar1"><?php if($vistaprevia!=''){echo '<img src="http://proceso.munindependencia.pe/img/carnet/logo_muni.png"/>';} ?></div> 
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <!-- <div class="f1"> -->
           <div class="ff1" style="margin-top: 10px;">
            <img src="http://proceso.munindependencia.pe/img/carnet/<?php echo @$imagen_dni; ?>" style="border: 0px; height: 130px; width: 90px;"/>                        
           </div>
           <div style="margin-top: 0px; margin-left: 6px;">
            <?php if($vistaprevia!=''){ ?> <?php echo '<label class="" style="'.$class_estado.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$text_estado.'&nbsp;&nbsp;&nbsp;</label>';   ?><?php } ?>
           </div>
         <!-- </div> -->
         <!--
         <div class="f2">
           <div class="ff2">{{ $imagen }}</div>
         </div>
         -->
       </td>
       <td class="textos" style="width: 45%;">        
         <div class="areal" style="width: 100%; font-weight: bold; margin-top:48px; text-transform: capitalize;">{{ $nombres }}</div>              
         <div class="areal" style="width: 100%; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;">{{ $apellidos }}</div>
         <div class="areal" style="width: 100%; font-size: 8pt; margin-bottom: 2px;">DNI&nbsp;: {{ $dni }}</div>
         <div class="areal" style="width: 90%; font-size: 9pt; margin-bottom: 3px;">{{ $rol }}</div>
         <div class="areal" style="width: 94%; font-size: 9pt; margin-bottom: 3px; text-transform: uppercase; ">{{ $area }}</div>
         <?php if(($rol_id == 8 || $rol_id == 9) && $area_id != 10): ?>
            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $resolucion; ?></div>
          <?php else: 
                  if($area_id != 10): ?>
                  <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
          <?php   endif;
                endif; ?>

          <?php if($area_id == 10): ?>
            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">C&oacute;digo de Inspector: {{ $numero }}</div>
            <div class="areal" style="width: 100%; font-size: 9pt;">Resoluci&oacute;n: <?php echo $resolucion; ?></div>
            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
          <?php else: ?>
            <div class="areal" style="width: 100%; font-size: 9pt; margin-bottom: 3px;">&nbsp;</div>
            <div class="areal" style="width: 100%; font-size: 9pt;">&nbsp;</div>
          <?php endif; ?>
       </td>
       <td style="width: 25%;"> 
         <div class="ff2">{{ $imagen }}</div>
       </td>
     </tr>
  </table>
 </div>
<?php endif; ?> 

</body>
</html>