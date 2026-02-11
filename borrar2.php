<?php 

require_once('functions/initialize2.php');

$borrar = $_GET['borrar'];



 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
   <meta charset="utf-8">
 </head>
 <body>

<?php if($borrar==1){ ?>
    <div align="center">
      <h1 align="center">¿Está seguro de borrar todas las tareas?</h1>
  <form action="grupo2.php?res=3" method="post">

    <input type="image" name="si" value ="si" id="si" src="images/si.jpg" width="50" align="left" style="margin-left: 500px"> 
   

  </form>
  &nbsp;&nbsp;&nbsp;

  <form action="grupo2.php" method="post">

    <input type="image" name="si" value ="si" id="si" src="images/no.png" width="50" align="right" style="margin-right: 500px">

  </form>
  </div>

<?php }else if($borrar==2){ ?>
  <div align="center">
<h1 align="center">¿Está seguro de borrar todos los alumnos?</h1>
  <form action="grupo2.php?res=4" method="post">

    <input type="image" name="si" value ="si" id="si" src="images/si.jpg" width="50" align="left" style="margin-left: 500px">
   

  </form>
  <form action="grupo2.php" method="post">

    <input type="image" name="si" value ="si" id="si" src="images/no.png" width="50" align="right" style="margin-right: 500px">

  </form>

</div>

<?php }else if($borrar==3){ ?>

 <div align="center">
<h1 align="center">¿Está seguro de borrar todas las fechas?</h1>
  <form action="lista2.php?res=2" method="post">

    <input type="image" name="si" value ="si" id="si" src="images/si.jpg" width="50" align="left" style="margin-left: 500px">
   

  </form>
  
  <form action="lista2.php" method="post">

    <input type="image" name="si" value ="si" id="si" src="images/no.png" width="50" align="right" style="margin-right: 500px">

  </form>

</div>



<?php } ?>

</div>
 
 </body>
 </html>