<?php 
    require_once('functions/initialize2.php');
    

    if(!empty($_GET)){
      $res = $_GET['res'];
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
          
        }
      }else if($res==3){
          delete_tareas();

      }else if($res==4){
          delete_alumnos();

      }else if($res==5){
        //aqui vamos a validar de que no sea null y que solo sea numerico
        $newcal = $_POST['notarea'];
        if (valida_campo($newcal)) {
          $id = $_GET['id'];
        $not = $_GET['not'];
        editar_tarea($id,$not,$newcal);
        }
        
      }else if ($res==6) {
        $newcal = $_POST['noexamen'];
        if (valida_campo($newcal)) {
          $id = $_GET['id'];
        $noe = $_GET['noe'];
        editar_examen($id,$noe,$newcal);
        }
        
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
  <font size="20">GRUPO 2</font>
  </div>

  <title>Maestro</title>
</head>
<body>

      <!--botones-->

        <form action="grupo2.php?res=2"  method="post" enctype="multipart/form-data" margin='0' style="float: left">
      <dl>

        <dt><input type="image" id="image" src="images/addtarea.png" height="50" width="50" style="margin-left: 15px" />&nbsp;&nbsp;</br>Nueva tarea &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</dt>

         
      </dl>

    </form>
 
    <form action="borrar2.php?borrar=1" method="post" enctype="multipart/form-data" margin='0' style="float: left">
      <dl>

        <dt>&nbsp;&nbsp;<input type="image" src="images/deletetareas.png" height="50" width="50" style="margin-left: 30px" /></br>Borrar todas las tareas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</dt>
        
          
      </dl>

    </form>

  <form action="grupo2.php?res=1" method="post" enctype="multipart/form-data" margin='0' style="float: left">
      <dl>
      

        <dt>&nbsp;&nbsp;<input type="image" src="images/newstudent.png" height="50" width="250" style="margin-left: 25px" /></br>Nombre Completo <input type="text" name="nombre" value="" /></dt>
          
      </dl>
      
    </form>
  

<form action="borrar2.php?borrar=2" method="post" enctype="multipart/form-data" margin='0' style="float: left">
      <dl>
      

        <dt><input type="image" src="images/deletestudents.png" height="50" width="150" style="margin-left: 50px" /></br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Borrar Alumnos</dt>
          
      </dl>

      
    </form>

    <form action="lista2.php"  method="post" enctype="multipart/form-data" margin='0' style="float: right">
      <dl>

        <dt><input type="image" id="image" src="images/asistencia.png" height="50" width="50" style="margin-left: 15px" />&nbsp;&nbsp;</br>Lista de asistencia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</dt>

         
      </dl>

    </form>

    <!--botones-->
  </br>

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

           
         
        <?php $hw = mysqli_fetch_assoc($subject_set2); ?>


          <?php if ($conttareas != 0) {   ?>

          <?php for ($i=1; $i <= $conttareas ; $i++) {
            $tareas = "T" . $i;
           ?>

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
        <?php $noa = 0; while($row = mysqli_fetch_array($subject_set)) { $noa = $noa +1;
          $example = json_decode($row['tareas'], true);
          $example2 = json_decode($row['examenes'], true);
         ?>
         
         
      
       
      <tr>  
      <td align="center"><?php echo $noa ?></td>
      <td><?php $id = $row['id']; echo $row['nombre']; ?></td>   
      <!--<?php var_dump($row) ?>  -->
      <!--calificaciones de cada alumno-->
      <td><table  border="1" width="100%"> 
       <tr> 

        
         <!--IMPRIME EL NUMERO DE TAREAS DE CADA ALUMNO--> 
        <?php $not = 0; for ($i=0; $i <$conttareas ; $i++) {   $not = $not +1;?>
            <td align="center"><a href=<?php echo"maestroedit2.php?hw=" . $not . "&id=" . $id . "&res=0"?>><?php echo $example[$i] ?></a></td>
         <!-- Aqui termina el for de tareas --> <?php } ?>
          

          

       </tr> 
      
        </table></td>

        <td><table  border="1" width="100%" style="table-layout: auto;" > 
       <tr> 
        <!--IMPRIME EL NUMERO DE EXAMENES DE CADA ALUMNO-->
          <?php for ($i=1; $i <=3 ; $i++) { ?>
            
            <td align="center" width="25"><a href=<?php echo "maestroedit2.php?id=" . $id . "&ex=" . $i ?>> <?php echo $example2[$i-1] ?> </a> </td> 

          <?php } ?>
       </tr> 
       
        </table></td>
        <!--Poner rojo el campo si el promedio es menor que 60 y verde si es mayor o igual a 60-->
       <?php $promedio = promedio($id); if ($promedio<60) { ?>
         <td align="center" bgcolor="red"><?php echo $promedio; ?></td>
       <?php }else{ ?>
        <td align="center" bgcolor="gren"><?php echo $promedio; ?></td> 
      <?php } ?>
      </tr>

     

    <!--Aqui termina el while--><?php } ?>
    </tr>




</table>

  
  </br>

  





</body>
</html>

    

