<?php


include('scripts/config.php');

$conexion = mysqli_connect($server, $user, $password, $database);
mysqli_set_charset($conexion,"utf8");
if (!$conexion){
  die('Error de Conexión: ' . mysqli_connect_errno());
}
$informacion = [];
if(isset($_POST['accion']))
$accion=$_POST['accion'];
else
$accion=1;

switch($accion){
  case 1: //Listar todo
  $arreglo = array();
  $query = "SELECT departments.id,departments.name,departments.clauses, departments.publish, departments.publish AS estado from departments where departments.soft_delete = 0 order by departments.sr_no desc";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado) {
    die("Error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      switch ($data['publish']) {
        case 1:
        $data['publish']='<i class="icon-check"></i>';
        break;

        case 0:
        $data['publish']='<i class="icon-close"></i>';
        break;
      }
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;
  case 2: //Listar solo los publicados
  $arreglo = array();
  $query = "SELECT departments.id,departments.name,departments.clauses, departments.publish, departments.publish AS estado from departments where departments.soft_delete = 0 and departments.publish = 1 order by departments.sr_no desc";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado) {
    die("Error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      switch ($data['publish']) {
        case 1:
        $data['publish']='<i class="icon-check"></i>';
        break;

        case 0:
        $data['publish']='<i class="icon-close"></i>';
        break;
      }
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;
  case 3: //Actualizar
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $clausulas = $_POST['clausulas'];
  $valor = $_POST['valor'];
  $query = "UPDATE departments SET departments.name = '$nombre', departments.clauses = '$clausulas', departments.publish = '$valor' where departments.id = '$id'";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado)
  $informacion["respuesta"] = "ERROR";
  else
  $informacion["respuesta"] = "BIEN";
  echo json_encode($informacion);
  break;
  case 4: //Eliminar
  $id = $_POST['id'];
  $query = "DELETE from departments where departments.id = '$id'";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado)
  $informacion["respuesta"] = "ERROR";
  else
  $informacion["respuesta"] = "BIEN";
  echo json_encode($informacion);
  break;
  case 5: //Registrar
  $nombre = $_POST['nombre'];
  $clausulas = $_POST['clausulas'];
  $subproceso = $_POST['subproceso'];
  $query = "SELECT departments.id FROM departments where departments.name = '$nombre'";
  $resultado = mysqli_query($conexion, $query);
  $existe = mysqli_num_rows($resultado);
  if($existe > 0){
    $informacion["respuesta"] = "EXISTE";
    echo json_encode($informacion);
  }else{
    $query = "SELECT max(sr_no)+1 FROM departments";
    $resultado = mysqli_query($conexion, $query);
    $dato = mysqli_fetch_array($resultado);
    $id= '523a0abb-21e0-4b44-a219-6142c6c326'.$dato[0];
    $query = "INSERT INTO departments (id,name,clauses,publish, branchid, departmentid,created_by, created, modified_by, modified, ver_todo, alias) values ('$id','$nombre','$clausulas',0, '', '', '', now(), '', now(), 1, '', '$subproceso')";
    $resultado = mysqli_query($conexion, $query);
    if (!$resultado)
    $informacion["respuesta"] = "ERROR";
    else
    $informacion["respuesta"] = "BIEN";
    echo json_encode($informacion);
  }
  break;
  case 6: //Listar solo los no publicados
  $arreglo = array();
  $query = "SELECT departments.id,departments.name,departments.clauses, departments.publish, departments.publish AS estado from departments where departments.soft_delete = 0 and departments.publish = 0 order by departments.sr_no desc";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado) {
    die("Error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      switch ($data['publish']) {
        case 1:
        $data['publish']='<i class="icon-check"></i>';
        break;

        case 0:
        $data['publish']='<i class="icon-close"></i>';
        break;
      }
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;
  case 7: //Listar solo los eliminados
  $arreglo = array();
  $query = "SELECT departments.id,departments.name,departments.clauses, departments.publish, departments.publish AS estado from departments where departments.soft_delete = 1 order by departments.sr_no desc";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado) {
    die("Error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      switch ($data['publish']) {
        case 1:
        $data['publish']='<i class="icon-check"></i>';
        break;

        case 0:
        $data['publish']='<i class="icon-close"></i>';
        break;
      }
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;
  case 8: //Cantidad total
    if(isset($_POST['tabla'])){
      $tabla = $_POST['tabla'];
      $condicion = $_POST['condicion'];
    }
    else{
      $tabla = "departments";
      $condicion = "";
    }
    $query = "SELECT count(*) from $tabla $condicion ";
    $resultado = mysqli_query($conexion, $query);
    $dato = mysqli_fetch_array($resultado);
    echo $dato[0];
    mysqli_free_result($resultado);
    break;
  /*
  case 8: //Cantidad total
  if(isset($_POST['tabla'])){
  $tabla = $_POST['tabla'];
  $condicion = $_POST['condicion'];
}
else{
$tabla = "departments";
$condicion = "";
}*/
case 9://para proceso
if(isset($_POST['alias'])){
  $alias = $POST['alias'];
}
$arreglo = array();
$query = "SELECT master_list_of_formats.id,master_list_of_formats.sr_no,master_list_of_formats.title AS name,departments.alias FROM master_list_of_formats INNER JOIN departments on(master_list_of_formats.departmentid = departments.id) WHERE departments.alias=aseguramientoCalidad";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
  die("Error");
}else{
  while ($data=mysqli_fetch_assoc($resultado)) {
    $arreglo2["data"][] = $data;
  }
  echo json_encode($arreglo2);

}
case 10://para mostrar nombres en las tablas
$tabla;
if (isset($_POST['idtabla'])) {
  $tabla=$_POST['idtabla'];
}
$arreglo = array();
//$query = "SELECT master_list_of_formats.id,master_list_of_formats.sr_no,master_list_of_formats.title AS name,departments.alias FROM master_list_of_formats INNER JOIN departments on(master_list_of_formats.departmentid = departments.id) WHERE departments.alias='$tabla'";

$query= "SELECT master_list_of_formats.id,master_list_of_formats.sr_no,master_list_of_formats.title AS name,departments.alias,(SELECT count(*) FROM file_uploads where system_table_id = '5297b2e7-3538-4360-97fc-2d8f0a000005' and record = master_list_of_formats.id) as cantidad FROM master_list_of_formats INNER JOIN departments on(master_list_of_formats.departmentid = departments.id) WHERE departments.alias='$tabla'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
  die("Error");
}else{
  while ($data=mysqli_fetch_assoc($resultado)) {
    $arreglo["data"][] = $data;
  }
  echo json_encode($arreglo);
}
mysqli_free_result($resultado);
break;



case 11://para extraer documentos

if (isset($_POST['idtabla'])) {
  $documento = $_POST['idtabla'];
}
$arreglo = array();
$query ="SELECT * FROM file_uploads where system_table_id = '5297b2e7-3538-4360-97fc-2d8f0a000005' and record = '$documento'";
$resultado = mysqli_query($conexion,$query);
if (!$resultado) {
  die("error");
}else{
  while ($data=mysqli_fetch_assoc($resultado)) {
    $arreglo["data"][] = $data;
  }
  echo json_encode($arreglo);
}
mysqli_free_result($resultado);
break;
case 12://para borrar documentos
$id = $_POST['id'];
$accion = $_POST['accion'];
$query = "DELETE from file_uploads where id = '$id'";
$resultado = mysqli_query($conexion, $query);
if (!$resultado){
  die("error");
  echo "no fue borrado";
}else{
  echo $id." ".$accion;
}
//mysqli_free_result($resultado);
break;

case 13://para extraer documentos
$cad = '';
if (isset($_POST['archivo'])) {
  $documento = $_POST['archivo'];
}
$arreglo = array();
$query ="SELECT * FROM file_uploads where system_table_id = '5297b2e7-3538-4360-97fc-2d8f0a000005' and record = '$documento'";
$resultado = mysqli_query($conexion,$query);
if (!$resultado) {
  die("error");
}else{
  while ($data=mysqli_fetch_assoc($resultado)) {
    $control = '';
    if($_POST['administrador']==1){
      //<td><button onclick="mostrardatoseditar()" class="btn btn-info waves-effect waves-lighta href="">Editar</a></button></td> > boton para poder editar
      $control = "<td><button onclick=\"deshabilitar('".$data["id"]."')\" class=\"deshabilitar btn btn-danger btn waves-effect\" data-dismiss=\"modal\">Eliminar</button></td>";
    }
    $cad.='<tr><td><input id="a" style="border:none;background:white" size="80" type="text" name="" value="'.$data["file_details"].'" disabled></td>'.$control.'</tr>';
  }
  echo $cad;
}
mysqli_free_result($resultado);
break;




$query = "SELECT count(*) from $tabla $condicion ";
$resultado = mysqli_query($conexion, $query);
$dato = mysqli_fetch_array($resultado);
echo $dato[0];
mysqli_free_result($resultado);
break;
}


mysqli_close($conexion);
?>
