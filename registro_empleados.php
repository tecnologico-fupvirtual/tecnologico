<?php
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
      $query = "SELECT employees.id,employees.name,designations.name AS cargo,designations.id AS id_cargo, employees.office_email, employees.publish, employees.publish AS estado from employees inner join designations on (employees.designation_id = designations.id) where employees.soft_delete = 0 order by employees.sr_no desc";
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
      $query = "SELECT employees.id,employees.name,designations.name AS cargo, designations.id AS id_cargo,employees.office_email, employees.publish, employees.publish AS estado from employees inner join designations on (employees.designation_id = designations.id) where employees.soft_delete = 0 and employees.publish = 1 order by employees.sr_no desc";
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
      $email = $_POST['email'];
      $cargo = $_POST['cargo'];
      $valor = $_POST['valor'];
      $query = "UPDATE employees SET employees.name = '$nombre', employees.office_email = '$email', employees.designation_id = '$cargo', employees.publish = '$valor' where employees.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 4: //Eliminar
      $id = $_POST['id'];
      $query = "DELETE from employees where employees.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 5: //Registrar
      $nombre = $_POST['nombre'];
      $email = $_POST['email'];
      $cargo = $_POST['cargo'];
      $query = "SELECT employees.id FROM employees where employees.office_email = '$email'";
      $resultado = mysqli_query($conexion, $query);
      $existe = mysqli_num_rows($resultado);
      if($existe > 0){
        $informacion["respuesta"] = "EXISTE";
        echo json_encode($informacion);
      }else{
        
        $query = "SELECT max(sr_no)+1 FROM employees";
        $resultado = mysqli_query($conexion, $query);
        $dato = mysqli_fetch_array($resultado);
        $id = '5845ea0c-d6ec-46c2-a34b-02486bb'.$dato[0];
        $branch_id = '543e9129-1508-46aa-a75e-1204174a8323';
        $departmentid = '523a0abb-21e0-4b44-a219-6142c6c32681';
        $created_by = '557aef01-82c8-4d04-aaaa-16f40e234159';
        $query = "INSERT INTO employees (id,name,employee_number,office_email,designation_id,publish,branch_id,branchid,departmentid,created_by,created) values ('$id','$nombre','$dato[0]','$email','$cargo',0,'$branch_id','$branch_id','$departmentid','$created_by',now())";
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
      $query = "SELECT employees.id,employees.name,designations.name AS cargo, designations.id AS id_cargo, employees.office_email, employees.publish, employees.publish AS estado from employees inner join designations on (employees.designation_id = designations.id) where employees.soft_delete = 0 and employees.publish = 0 order by employees.sr_no desc";
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
      $query = "SELECT employees.id,employees.name,designations.name AS cargo, designations.id AS id_cargo, employees.office_email, employees.publish, employees.publish AS estado from employees inner join designations on (employees.designation_id = designations.id) where employees.soft_delete = 1 order by employees.sr_no desc";
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
        $tabla = "employees";
        $condicion = "";
      }
      $query = "SELECT count(*) from $tabla $condicion ";
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
        $tabla = "designations";
        $condicion = "";
      }
      $cad = '';
      $query = "SELECT designations.id, designations.name from $tabla $condicion order by name asc ";
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
