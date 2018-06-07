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
  font-size: 13px;
}

.cab{
  border: 0px solid blue;
  width: 256px;
  padding: 8px 2px;
  text-align: center;
  height: 16px;
  font-weight: bold;
  margin-top: 10px;
}

.areal{
  border: 0px solid blue;
  float:left;
  font-weight: bold;
}

.f1{
  border: 0px solid #000;
  height: 20px;  
}
.f2{
  border: 0px solid #000;
  height: 100px;
}
.ff2{
  border: 0px solid #000;
  height: 100px;
  width: 100px;
  margin: 2px auto;
}
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" rightmargin="0">

<?php if($reporte == 1) : ?> 
<div class="carnet" style="margin: 10px auto;">
  <table border="0" style="width: 100%;">
      <tr>
       <td style="width: 30%;border: 0px solid blue;">
         <div class="f1">
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
             <td class="areal" style="width: 28%;">N° RE.&nbsp;:<td>              
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
                             <td class="areal" style="width: 28%;">N° RE.&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo '32938293'; ?><td>
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
                             <td class="areal" style="width: 28%;">N° RE.&nbsp;:<td>              
                             <td style="width: 72%;"><?php echo '32938293'; ?><td>
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

</body>
</html>
