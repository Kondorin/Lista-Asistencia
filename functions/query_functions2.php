<?php

  require_once('database.php');

 
function find_all_subjects(){

	global $db;

	$sql = "SELECT * FROM calificacion2 ";
	$sql .= "ORDER BY nombre ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_all_fechas(){

  global $db;

  $sql = "SELECT * FROM fecha2";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function insert_dia($dia){
  global $db;

  $sql = "INSERT INTO fecha2 ";
  $sql .= "(dia) VALUES ('$dia')";

  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
   
    header('Location: ../maestro/lista2.php');
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }


}


function find_all_tareas(){

  global $db;

 $sql = "SELECT * FROM tareas2 ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function select_from_id($id){
	global $db;


	$sql = "SELECT * FROM calificacion2 ";
	$sql .= "WHERE id='" . $id . "'";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$subject = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $subject; //return an assoc. array

}


  function promedio($id){

          $datos = select_from_id($id);
          $examenes = json_decode($datos['examenes'], true); 
          $noexamenes = count($examenes);
          $suma = 0;
          $sumatareas = 0;
          $sumaexamenes = 0;

          if (!is_null(json_decode($datos['tareas'], true))) {

            $tareas = json_decode($datos['tareas'], true);
            $notareas = count($tareas);

          for($i=0; $i <count($tareas) ; $i++) {

            $suma = intval($tareas[$i]);
            $sumatareas = $sumatareas + $suma;
          }

          }else{
            $sumatareas = 0;
            $notareas = 0;
          }
          
          $notye = $notareas + $noexamenes;
          
          for ($j=0; $j <$noexamenes ; $j++) { 
            $suma = intval($examenes[$j]);
            $sumaexamenes = $sumaexamenes + $suma;
          }
          $suma = ($sumatareas + $sumaexamenes) / $notye;
          
          return $suma;

  }




function insert_alumno($nombre,$cont){
  //$nombre = $_POST['nombre'];
	global $db;
  $exam = array("EX1","EX2","EX3");
  if ($cont != 0) {
    insert_alumno2($nombre,$cont);
  }else{
    $examencoded = json_encode($exam);

 $sql = "INSERT INTO calificacion2 ";
  $sql .= "(nombre, tareas, examenes) ";
  $sql .= "VALUES (";
  $sql .= "'" . $nombre . "'," . "''," . "'$examencoded'";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
   
    header('Location: ../maestro/grupo2.php?');
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }

  }

 

}

function insert_alumno2($nombre,$cont){
  //$nombre = $_POST['nombre'];
  global $db;
 

 $array = array();
 $exam = array("EX1","EX2","EX3");
 $arrayexamencoded = json_encode($exam);

 for ($i=1; $i <$cont ; $i++) { 
   array_push($array, "T" . $i);
 }
 
 array_push($array, "T" . $cont);

 $arrayencoded = json_encode($array);

  $fechas = find_all_fechas();

 if (!is_null($fechas)) {
  $array = array();
  while($fecha = mysqli_fetch_assoc($fechas)){
    array_push($array, "X");
  }
    $arrayfechas = json_encode($array);

    $sql = "INSERT INTO calificacion2 ";
  $sql .= "(nombre, tareas, examenes, asistencia) ";
  $sql .= "VALUES (";
  $sql .= "'" . $nombre . "'," . "'$arrayencoded'," . "'$arrayexamencoded'," . "'$arrayfechas'";
  $sql .= ")";
    

 }else{

 $sql = "INSERT INTO calificacion2 ";
  $sql .= "(nombre, tareas, examenes) ";
  $sql .= "VALUES (";
  $sql .= "'" . $nombre . "'," . "'$arrayencoded'," . "'$arrayexamencoded'";
  $sql .= ")";

 }



  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
   
    header('Location: ../maestro/grupo2.php?');
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }

  

 

}

function insert_tarea(){
  
  global $db;
  $subject_tareas1 = find_all_tareas();
  $conttareas = mysqli_num_rows($subject_tareas1) + 1;

  $sql = "INSERT INTO tareas2 ";
  $sql .= "(tarea) ";
  $sql .= "VALUES (";
  $sql .= "'" . "T" . $conttareas . "'";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
    
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }

}

function insert_tareas_vacias($cont,$noalumnos){
  
  global $db;
  $alumnos = find_all_subjects();
          $datos = mysqli_fetch_assoc($alumnos);

 //$example = array("", "", 3);
  $array = array("T" . 1);

//Encode $example array into a JSON string.
$arrayencoded = json_encode($array);


  for ($i=1; $i <=$noalumnos ; $i++) { 
  $id = $datos['id'];

  $sql = "UPDATE calificacion2 SET tareas =" . "'$arrayencoded' where id=" . $id;
  $result = mysqli_query($db, $sql);
   $datos = mysqli_fetch_assoc($alumnos);

  }
}

function insert_asistencia_vacia($dia){
  
  global $db;
           $alumnos = find_all_subjects(); 
          $subject_dias = find_all_fechas();
          $contador = mysqli_num_rows($subject_dias); 
          $contador2 = mysqli_num_rows($subject_dias) + 1;
          var_dump($contador);
//QUE NO SE PUEDA INSERTAR FECHA NUEVA SI NO HAY POR LO MENOS 1 ALUMNO REGISTRADO
          while($datos = mysqli_fetch_array($alumnos)){ 
              if (is_null($datos['asistencia'])) {
                $array = array("X");
              }else{
                 $example = json_decode($datos['asistencia'], true);
                 $array = array();

                 for($i=1; $i<$contador2-1; $i++){

                  array_push($array, $example[$i-1]);

                  }
                  array_push($array, "X");

              }

//Encode $example array into a JSON string.
$arrayencoded = json_encode($array);


  $id = $datos['id'];

  $sql = "UPDATE calificacion2 SET asistencia =" . "'$arrayencoded' where id=" . $id;
  $result = mysqli_query($db, $sql);
   //$datos = mysqli_fetch_assoc($alumnos);
}



if ($result) {
 // return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}


}


function agregar_tarea_vacia($cont,$noalumnos){
  
  global $db;

          $alumnos = find_all_subjects();
          $subject_tareas1 = find_all_tareas();
          $conttareas = mysqli_num_rows($subject_tareas1) + 1;
          $contador = mysqli_num_rows($subject_tareas1);

           while($datos = mysqli_fetch_array($alumnos)) {

            $example = json_decode($datos['tareas'], true);
              $array = array();
         
              for($i=1; $i<$conttareas-1; $i++){
                  array_push($array, $example[$i-1]);

              }

              array_push($array, "T" . $contador);

         $arrayencoded = json_encode($array);

 
  $id = $datos['id'];

  
  $sql = "UPDATE calificacion2 SET tareas =" . "'$arrayencoded'" . "where id=" . $id;
  $result = mysqli_query($db, $sql);

 }
//for UPDATE statements, $result is true/false

if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}


}

function editar_tarea($id,$not, $newcal){
  
  global $db;
 

         $datos = select_from_id($id);
          $example = json_decode($datos['tareas'], true);
          $example[$not-1] = $newcal;
          $array = json_encode($example);

  $sql = "UPDATE calificacion2 SET tareas =" . "'$array'" . "where id=" . $id;
  $result = mysqli_query($db, $sql);


if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}


}

function editar_examen($id,$noe, $newcal){
  
  global $db;

         $datos = select_from_id($id);
          $example = json_decode($datos['examenes'], true);
          $example[$noe-1] = $newcal;
          $array = json_encode($example);

  $sql = "UPDATE calificacion2 SET examenes =" . "'$array'" . "where id=" . $id;
  $result = mysqli_query($db, $sql);


if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }

}

function editar_asistencia($id,$not, $newasist){
  
  global $db;

         $datos = select_from_id($id);
          $example = json_decode($datos['asistencia'], true);
          $example[$not-1] = $newasist;
          $array = json_encode($example);

  $sql = "UPDATE calificacion2 SET asistencia =" . "'$array'" . "where id=" . $id;
  $result = mysqli_query($db, $sql);


if ($result) {
   header('Location: ../maestro/lista2.php');
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }

}


function delete_tareas(){
global $db;

$sql = "truncate table tareas2";


  $result = mysqli_query($db, $sql);

  //for DELETE statements, $result is true/false

  if ($result) {
      delete_tareas2();
    }else{
      //DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;

    } 

}

function delete_tareas2(){
global $db;

$sql = "UPDATE calificacion2 SET tareas = null";


  $result = mysqli_query($db, $sql);

  //for DELETE statements, $result is true/false

  if ($result) {
      header('Location: ../maestro/grupo2.php');
    }else{
      //DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;

    } 

}

function delete_alumnos(){
global $db;

$sql = "truncate table calificacion2";


  $result = mysqli_query($db, $sql);

  //for DELETE statements, $result is true/false

  if ($result) {
      header('Location: ../maestro/grupo2.php');
    }else{
      //DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;

    } 

}

function reiniciar_fechas(){
  global $db;

  $sql = "truncate table fecha2";

  $result = mysqli_query($db, $sql);

   if ($result) {
      header('Location: ../maestro/lista2.php');
    }else{
      //DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;

    } 

}

?>