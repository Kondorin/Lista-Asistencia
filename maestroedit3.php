<?php 
    require_once('functions/initialize3.php');
    

    if(!empty($_GET)){
      error_reporting(0);
      $res = $_GET['res'];
      $id = $_GET['id'];
      $hw = intval($_GET['hw']);
      $ex = intval($_GET['ex']);


      $subject_tareas1 = find_all_tareas();
            $conttareas = mysqli_num_rows($subject_tareas1);
      if ($res==1) {
         $nombre = $_POST['nombre'];
        if (!validate_campo($nombre)) {
          insert_alumno($nombre,$conttareas); 
        }else{
        echo  "<script type=\"text/javascript\"> 
  
        alert('Necesita registrar un nombre'); 
        </script>";
        }
      }else if($res==2){

        $subject_set = find_all_subjects();
       $result = mysqli_num_rows($subject_set);

        insert_tarea();
        if ($result != 0) {
         $alumnos = find_all_subjects();
         $noalumnos = mysqli_num_rows($alumnos);
          $datos = mysqli_fetch_assoc($alumnos);
          
          $id = $datos['id'];
          if ($datos['tareas'] == "") {
            
            insert_tareas_vacias($conttareas,$noalumnos);
          }else{
            $tareas = $datos['tareas'];
            agregar_tarea_vacia($conttareas,$noalumnos);
          }
          
          //si es diferente de 0 voy a agregar el array a la tabla de calificaciones en la columna tareas 
          //con la cantidad de tareas que hay en la tabla tareas pero con atributos vacios
        }
      }else if($res==3){
        delete_tareas();
      }else if($res==4){
        delete_alumnos();
      }
     

    }



?>

<?php
  
  $subject_set = find_all_subjects();
  $subject_set2 = find_all_subjects();
  $subject_tareas1 = find_all_tareas();
  $conttareas = mysqli_num_rows($subject_tareas1);

  $result = mysqli_num_rows($subject_set);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/estilo.css">

  <div class="navbarleft">
  <a href="index.php"><font size="5" style="padding-left: 20px">Volver a grupos</font></a>
</div>
  <div class="grupos">
  <font size="20">GRUPO 3</font>
  </div>
  <title>Maestro</title>
</head>
<body>

      <table border="1" width="100%" align="left" > 
 <tr> 
  <th bgcolor="#E9EAEA">NO.</th>
    <th>NOMBRE DEL</th> 
    <th>TAREAS</th>
  <th>EXAMENES</th>
  <th>PROMEDIO</th>

     
 </tr> 
 
  <tr>
  <th>#</th>
  <th align="center">ALUMNO</th>
  <td><table  border="1" width="100%"> 
       <tr> 


          <?php if ($conttareas != 0) {   ?>

          <?php for ($i=1; $i <= $conttareas ; $i++) {
            $tareas = "T" . $i;
           ?>
            <!--<th align="center"><a href="http://www.google.com"><?php echo $hw[1]; ?></a></th> -->
            <th align="center"><a href="http://www.google.com"><?php echo $tareas?></a></th>


         <?php } ?>

       <?php }else{  ?>
        <th align="center"><a href="http://www.google.com">.</a></th>
      <?php } ?>
        
          

       </tr> 
      
        </table></td>

        <td><table  border="1" width="100%"> 
       <tr> 
            <th align="center">EX1</th> 
            <th align="center">EX2</th> 
            <th align="center">EX3</th>
       </tr> 
       
        </table></td>
        <td bgcolor="#E9EAEA"><table bgcolor="#E9EAEA"  width="100%"> 
       <tr> 
            <th align="center">GENERAL</th> 
            
       </tr> 
       
        </table></td>


         <!--IMPRIME CADA ALUMNO QUE SE ENCUENTRA EN LA BASE DE DATOS EN LA TABLA DE LA PAGINA WEB-->
        <?php $noa = 0; while($row = mysqli_fetch_array($subject_set)) { $noa = $noa +1; $idalumno = $row['id'];
          $example = json_decode($row['tareas'], true);
          $example2 = json_decode($row['examenes'], true);

         ?>
         
         
      
       
      <tr>  
      <td align="center"><?php echo $noa ?></td>
      <?php if($idalumno==$id){ ?>

      <td><?php echo $row['nombre'] ?><a href="grupo3.php"><img align="right" src="images/cancelar.png" width="20px" height="20px" /></a></td>
      <?php  }else{ ?>
        <td><?php  echo $row['nombre'] ?></td>

      <?php } ?>

      <!--calificaciones de cada alumno-->
      <td><table  border="1" width="100%"> 
       <tr> 

        
         <!--IMPRIME EL NUMERO DE TAREAS DE CADA ALUMNO--> 
        <?php $not = 0; for ($i=0; $i <$conttareas ; $i++) {   $not = $not +1;?>
           <?php if($idalumno==$id){  ?>

           <?php if ($not== $hw){  ?>

              <!-- si en algun momento me da error es que estoy mandando $id, no el $idalumno-->
             <td align="center" bgcolor="red"><?php echo "T" . $not ?><form method="POST"  id="edit" action="<?php echo "grupo3.php?res=5&id=" . $id ."&not=" . $not ?>" > <input type="text" name="notarea" size="1"><input type="submit"  value="Editar" id="edit" ></form></td>

           <?php }else{  ?>

            <td align="center"><?php echo $example[$i] ?></td>
           
           <?php } ?>

           <!--aqui termina el primer if $noa--><?php }else{ ?>
            <td align="center"><?php echo $example[$i] ?></td>
           <?php }?>


          <!-- Aqui termina el for de tareas --><?php } ?>

          
          

       </tr> 
      
        </table></td>

        <td><table  border="1" width="100%" style="table-layout: auto;"> 
       <tr> 
          <?php $noe = 0; for ($i=0; $i <3 ; $i++) { $noe = $noe + 1;?>
            <?php if($idalumno == $id){ ?>
            <?php if($noe==$ex){ ?>

            <td align="center" bgcolor="red" width="25"><?php echo $example2[$i] ?><form method="POST"  id="edit" action="<?php echo "grupo3.php?res=6&id=" . $id ."&noe=" . $noe ?>" > <input type="text" name="noexamen" size="1"><input type="submit"  value="Editar" id="edit" ></form> </a> </td> 

          <?php }else{ ?>
            <td align="center"> <?php echo $example2[$i] ?> </a> </td> 
          <?php }?>

          <?php }else{ ?>
            <td align="center"><?php echo $example2[$i] ?></a> </td> 
          <?php }?>

          <?php } ?>
       </tr> 
       
        </table></td>

         <!--Poner rojo el campo si el promedio es menor que 60 y verde si es mayor o igual a 60-->
        <?php $promedio = promedio($idalumno); if ($promedio<60) { ?>
         <td align="center" bgcolor="red"><?php echo $promedio; ?></td>
       <?php }else{ ?>
        <td align="center" bgcolor="gren"><?php echo $promedio; ?></td> 
      <?php } ?>
      </tr>
      

     

    <?php } ?>
    </tr>




</table>

</body>
</html>

    

