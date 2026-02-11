<?php 
    require_once('functions/initialize2.php');
	$subject_set = find_all_subjects();
	$subject_set2 = find_all_fechas();
	$contfechas = mysqli_num_rows($subject_set2);
    
    if (!empty($_GET)) {
      error_reporting(0);
    	$res = $_GET['res'];
      $id = $_GET['id'];
      $nof = intval($_GET['nof']);

    	if ($res==1) {
    		//a lo mejor le tenga que poner == 0 en vez de preguntar si es null
    		if (mysqli_num_rows($subject_set) != 0 ) {
    			$dia = date('dM');
        		insert_dia($dia);
        		insert_asistencia_vacia($dia);
    		}else{
    			echo  "<script type=\"text/javascript\"> 
  
    			alert('Necesita haber por lo menos 1 alumno registrado para realizar esta accion'); 
    			</script>";
    		}
    	
    }
    }

    


    ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

  <div class="navbarleft">
  <a href="index.php"><font size="5" style="padding-left: 20px">Volver a grupos</font></a>
</div>
  <div class="grupos">
  <font size="20">GRUPO 2</font>
  </div>

<title>Lista</title>
</head>
<body>
<table border="1" width="100%" align="left" > 
 <tr> 
  <th bgcolor="#E9EAEA">NO.</th>
    <th bgcolor="#E9EAEA">NOMBRE DEL</th> 
    <th bgcolor="#E9EAEA">ASISTENCIA</th>
    
 </tr> 
 
  <tr>
  <th bgcolor="#E9EAEA">#</th>
  <th align="center" bgcolor="#E9EAEA">ALUMNO</th>
  <td><table  border="1" width="100%"> 
       <tr> 
       	<?php while($fila = mysqli_fetch_array($subject_set2)){ ?>
    	<td bgcolor="#E9EAEA" align="center"><font size="1"><b><?php echo $fila['dia']; ?></b></font></td>

    	<?php  } ?>
    	
          

       </tr> 
      
        </table></td>
        <?php $noa = 0; while($row = mysqli_fetch_array($subject_set)) { $noa = $noa +1;
        		$idalumno = $row['id'];
            $dias = json_decode($row['asistencia'], true);
            

         ?>

 		<tr>  
      <td align="center"><?php echo $noa ?></td>
      <?php if($idalumno==$id){ ?>
        <td><?php echo $row['nombre']; ?><a href="lista2.php"><img align="right" src="images/cancelar.png" width="20px" height="20px" /></a></td>
      <?php }else{ ?>
        <td><?php echo $row['nombre']; ?></td>
      <?php } ?>

      <td><table  border="1" width="100%"> 
      	<!--Aqui se va a poner el while para recorrer el arreglo y agregar rows para poner numero y nombre-->
      	
       <tr> 
       	 <?php $not = 0; for ($i=0; $i <$contfechas ; $i++) {   $not = $not +1;?>

          <!--empieza primer if--><?php if($idalumno == $id){ ?>

            <!--empieza segundo if--><?php if($not == $nof){?>

       	
       	<td align="center" height="50" width="50" bgcolor="red"><?php echo $dias[$i];  ?><form method="POST"  id="edit" action="<?php echo "lista2.php?res=3&id=" . $id ."&not=" . $not ?>"><input type="text" name="asist" size="1"><input type="submit"  value="Editar" id="edit" size="1"><font size="1"></font></form></td>

          <!--termina segundo if-->  <?php }else{  ?>

                <td align="center"><font size="1"><?php echo $dias[$i]; ?></font></td>

                <?php }  ?>

        <!--termina primer if--><?php }else{ ?>

                <td align="center"><font size="1"><?php echo $dias[$i]; ?></font></td>
        <?php } ?>
    	
    	<!--este es el del for--><?php } ?>
         
       	 </tr> 

       	 </table></td>
       	 <!--Aqui se pone una nueva fila y se cierra para agregar otro alumno <tr></tr>-->
       	<?php }?>
</table>

</body>
</html>