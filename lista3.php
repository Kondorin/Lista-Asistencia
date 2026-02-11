<?php 
    require_once('functions/initialize3.php');
	$subject_set = find_all_subjects();
	$subject_set2 = find_all_fechas();
	$contfechas = mysqli_num_rows($subject_set2);
    
    if (!empty($_GET)) {
    	//if (!empty($_GET['res'])) {
    	//	$res=0;
    	//}
    	$res = $_GET['res'];

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
    	
    		}else if($res==2){
    			reiniciar_fechas();
    		}else if($res==3){
    			$newasist = $_POST['asist'];
    			if (valida_campo2($newasist)) {
         			$id = $_GET['id'];
    				$not = $_GET['not'];
        			editar_asistencia($id,$not,$newasist);
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
  <font size="20">GRUPO 3</font>
  </div>

<title>Lista</title>
</head>
<body>
<!--botones-->

      <form action="lista3.php?res=1"  method="post" enctype="multipart/form-data" style="float: left">
      <dl>
        <dt><input type="image" value="Agregar" src="images/newday.png" height="50" width="50" style="margin-left: 30px" /></br>Agregar nuevo dia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </dt>

          
      </dl>
    </form>

    <form action="borrar3.php?borrar=3"  method="post" enctype="multipart/form-data" style="float: left">
      <dl>
        <dt><input type="image" value="Borrar" src="images/deletedays.png" height="50" width="50" style="margin-left: 45px" /></br>Borrar todas las fechas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </dt>   
      </dl>
   
    </form>

    <form action="grupo3.php"  method="post" enctype="multipart/form-data" style="float: right">
      <dl>
        <dt><input type="image" value="calificaciones" src="images/calificaciones.png" height="50" width="50" style="margin-left: 20px" /></br>Calificaciones </dt>  
      </dl>

    </form>


<!-- fin de botones -->

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
        		$dias = json_decode($row['asistencia'], true);
        		
           		

         ?>

 		<tr>  
      <td align="center" height="50"><?php echo $noa ?></td>
      <td><?php $id = $row['id']; echo $row['nombre']; ?></td>


      <td><table  border="1" width="100%"> 
      	<!--Aqui se va a poner el while para recorrer el arreglo y agregar rows para poner numero y nombre-->
      	
       <tr> 
       	 <?php $nof = 0; for ($i=0; $i <$contfechas ; $i++) {   $nof = $nof +1;?>
       	
       	<td align="center" height="50"><a href=<?php echo"listaedit3.php?res=0" . "&nof=" . $nof . "&id=" . $id ?>><b><font size="4"><?php echo $dias[$i]; ?></div></font></b></a></td>
    	
    	<?php } ?>
         
       	 </tr> 

       	 </table></td>
       	 <!--Aqui se pone una nueva fila y se cierra para agregar otro alumno <tr></tr>-->
       	<?php }?>
</table>


  
  </br>
 
</body>
</html>