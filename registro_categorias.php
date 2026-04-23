<?php
  session_start();
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
      $query = "SELECT master_list_of_formats.id,master_list_of_formats.title,departments.name AS proceso,departments.id AS id_proceso, master_list_of_formats.publish, master_list_of_formats.publish AS estado from master_list_of_formats inner join departments on (master_list_of_formats.departmentid = departments.id) where master_list_of_formats.soft_delete = 0 order by master_list_of_formats.sr_no desc";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado) {
        die("Error");
      }else{
        while ($data=mysqli_fetch_assoc($resultado)) {
          switch ($data['estado']) {
            case 1:
              $data['estado']='<i class="icon-check"></i>';
              break;

            case 0:
              $data['estado']='<i class="icon-close"></i>';
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
      $query = "SELECT master_list_of_formats.id,master_list_of_formats.title,departments.name AS proceso,departments.id AS id_proceso, master_list_of_formats.publish, master_list_of_formats.publish AS estado from master_list_of_formats inner join departments on (master_list_of_formats.departmentid = departments.id) where master_list_of_formats.soft_delete = 0 and master_list_of_formats.publish = 1 order by master_list_of_formats.sr_no desc";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado) {
        die("Error");
      }else{
        while ($data=mysqli_fetch_assoc($resultado)) {
          switch ($data['estado']) {
            case 1:
              $data['estado']='<i class="icon-check"></i>';
              break;

            case 0:
              $data['estado']='<i class="icon-close"></i>';
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
      $proceso = $_POST['proceso'];
      $valor = $_POST['valor'];
      $query = "UPDATE master_list_of_formats SET master_list_of_formats.title = '$nombre', master_list_of_formats.departmentid = '$proceso', master_list_of_formats.publish = '$valor' where master_list_of_formats.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        //$informacion["respuesta"] = $query;
        $informacion["respuesta"] = "ERROR";
      else
        //$informacion["respuesta"] = $query;
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 4: //Eliminar
      $id = $_POST['id'];
      $query = "DELETE from master_list_of_formats where master_list_of_formats.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 5: //Registrar
      $nombre = $_POST['nombre'];
      $proceso = $_POST['proceso'];
      $query = "SELECT master_list_of_formats.id FROM master_list_of_formats where master_list_of_formats.title = '$nombre' and master_list_of_formats.departmentid = '$proceso'";
      $resultado = mysqli_query($conexion, $query);
      $existe = mysqli_num_rows($resultado);
      if($existe > 0){
        $informacion["respuesta"] = "EXISTE";
        echo json_encode($informacion);
      }else{
        $query = "SELECT max(sr_no)+1 FROM master_list_of_formats";
        $resultado = mysqli_query($conexion, $query);
        $dato = mysqli_fetch_array($resultado);
        $id= '523aad7c-e838-4472-a2e4-63e4c6c32'.$dato[0];
        $query = "INSERT INTO master_list_of_formats (id,sr_no,title,departmentid,publish, document_number, issue_number, revision_date, prepared_by, approved_by, branchid, created_by, created, modified_by, modified) values ('$id','$dato[0]','$nombre','$proceso',0, 1, 1, now(), '', '', '523a0abb-21e0-4b44-a219-6142c6c32691', '', now(), '', now())";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado)
          //$informacion["respuesta"] = $query;
          $informacion["respuesta"] = "ERROR";
        else
          $informacion["respuesta"] = "BIEN";
        echo json_encode($informacion);
      }
      break;
    case 6: //Listar solo los no publicados
      $arreglo = array();
      $query = "SELECT master_list_of_formats.id,master_list_of_formats.title,departments.name AS proceso,departments.id AS id_proceso, master_list_of_formats.publish, master_list_of_formats.publish AS estado from master_list_of_formats inner join departments on (master_list_of_formats.departmentid = departments.id) where master_list_of_formats.soft_delete = 0 and master_list_of_formats.publish = 0 order by master_list_of_formats.sr_no desc";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado) {
        die("Error");
      }else{
        while ($data=mysqli_fetch_assoc($resultado)) {
          switch ($data['estado']) {
            case 1:
              $data['estado']='<i class="icon-check"></i>';
              break;

            case 0:
              $data['estado']='<i class="icon-close"></i>';
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
      $query = "SELECT master_list_of_formats.id,master_list_of_formats.title,departments.name AS proceso,departments.id AS id_proceso, master_list_of_formats.publish, master_list_of_formats.publish AS estado from master_list_of_formats inner join departments on (master_list_of_formats.departmentid = departments.id) where master_list_of_formats.soft_delete = 1 order by master_list_of_formats.sr_no desc";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado) {
        die("Error");
      }else{
        while ($data=mysqli_fetch_assoc($resultado)) {
          switch ($data['estado']) {
            case 1:
              $data['estado']='<i class="icon-check"></i>';
              break;

            case 0:
              $data['estado']='<i class="icon-close"></i>';
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
        $tabla = "employees";
        //$tabla = "iso_employees";
        $condicion = "";
      }
      $query = "SELECT count(*) from $tabla $condicion";
      $resultado = mysqli_query($conexion, $query);
      $dato = mysqli_fetch_array($resultado);
      echo $dato[0];
      mysqli_free_result($resultado);
      break;
    case 9: //Cargar combo
      if(isset($_POST['tabla'])){
        $tabla = $_POST['tabla'];
        $condicion = $_POST['condicion'];
        $seleccionado = $_POST['seleccionado'];
      }
      else{
        $tabla = "departments";
        //$tabla = "iso_departments";
        $condicion = "ORDER BY departments.name";
      }
      $cad = '';
      $query = "SELECT departments.id, departments.name from $tabla $condicion "; // ERROR
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado) {
        die("Error");
      }else{
        while ($data=mysqli_fetch_assoc($resultado)) {
          if ($data['id'] == $seleccionado)
            $cad.='<option value="'.$data['id']. '" selected>'.$data['name']."</option>";
          else
            $cad.='<option value="'.$data['id']. '">'.$data['name']."</option>";
        }
        echo $cad;
      }
      mysqli_free_result($resultado);
      break;
  }


  mysqli_close($conexion);
?>
