<?php
  session_start();
  include('scripts/config.php');

  $conexion = mysqli_connect($server, $user, $password, $database);
  mysqli_set_charset($conexion,"utf8");
  if (!$conexion){
    die('Error de Conexi��n: ' . mysqli_connect_errno());
  }
  $informacion = [];
  if(isset($_POST['accion']))
    $accion=$_POST['accion'];
  else
    $accion=1;

  switch($accion){
    case 1: //Listar todo
      $arreglo = array();
      $query = "SELECT designations.id,designations.name, designations.publish, designations.publish AS estado from designations where designations.soft_delete = 0 order by designations.sr_no desc";
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
      $query = "SELECT designations.id,designations.name,designations.publish, designations.publish AS estado from designations where designations.soft_delete = 0 and designations.publish = 1 order by designations.sr_no desc";
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
      $valor = $_POST['valor'];
      $query = "UPDATE designations SET designations.name = '$nombre', designations.publish = '$valor' where designations.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 4: //Eliminar
      $id = $_POST['id'];
      $query = "DELETE from designations where designations.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 5: //Registrar
      $nombre = $_POST['nombre'];
      $query = "SELECT designations.id FROM designations where designations.name = '$nombre'";
      $resultado = mysqli_query($conexion, $query);
      $existe = mysqli_num_rows($resultado);
      if($existe > 0){
        $informacion["respuesta"] = "EXISTE";
        echo json_encode($informacion);
      }else{
        $query = "SELECT max(sr_no)+1 FROM designations";
        $resultado = mysqli_query($conexion, $query);
        $dato = mysqli_fetch_array($resultado);
        $id = '5297a9cc-8418-4605-a61f-26b20a000'.$dato[0];
        $branch = '0941b9a8-2990-11e3-a528-d919ee611857';
        $department = '522e3da7-8e48-4be2-ab9d-8545c6c3268c';
        $created_by = '54e5d056-199b-11e3-9f46-c709d410d2ec';
        $modified_by = '54e5d056-199b-11e3-9f46-c709d410d2ec';
        $query = "INSERT INTO designations (id,name,publish,branchid,departmentid,created_by,created,modified_by,modified) values ('$id','$nombre',0,'$branch','$department','$created_by',now(),'$modified_by',now())";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado)
          //$informacion["respuesta"] = $query;
          $informacion["respuesta"] = "ERROR";
        else
          //$informacion["respuesta"] = $query;
          $informacion["respuesta"] = "BIEN";
        echo json_encode($informacion);
      }
      break;
    case 6: //Listar solo los no publicados
      $arreglo = array();
      $query = "SELECT designations.id,designations.name, designations.publish, designations.publish AS estado from designations where designations.soft_delete = 0 and designations.publish = 0 order by designations.sr_no desc";
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
      $query = "SELECT designations.id,designations.name, designations.publish, designations.publish AS estado from designations where designations.soft_delete = 1 order by designations.sr_no desc";
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
        $tabla = "designations";
        $condicion = "";
      }
      $query = "SELECT count(*) from $tabla $condicion ";
      $resultado = mysqli_query($conexion, $query);
      $dato = mysqli_fetch_array($resultado);
      echo $dato[0];
      mysqli_free_result($resultado);
      break;
  }


  mysqli_close($conexion);
?>
