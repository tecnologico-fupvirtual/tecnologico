<?php

   session_start();
  if(!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
  }
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
      $query = "SELECT users.id,users.administrador as admin,users.name,employees.name AS empleado,employees.id AS id_empleado, users.username, users.publish, users.publish AS estado,users.is_view_all,users.is_view_all AS view_all from users inner join employees on (users.employee_id = employees.id) where users.soft_delete = 0 order by users.sr_no desc";
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
          switch ($data['view_all']) {
            case 1:
              $data['view_all']='<i class="icon-check"></i>';
              break;
            case 0:
              $data['view_all']='<i class="icon-close"></i>';
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
      $query = "SELECT users.id,users.administrador as admin,users.name,employees.name AS empleado, employees.id AS id_empleado,users.username, users.publish, users.publish AS estado,users.is_view_all,users.is_view_all AS view_all from users inner join employees on (users.employee_id = employees.id) where users.soft_delete = 0 and users.publish = 1 order by users.sr_no desc";
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
          switch ($data['view_all']) {
            case 1:
              $data['view_all']='<i class="icon-check"></i>';
              break;
            case 0:
              $data['view_all']='<i class="icon-close"></i>';
              break;
          }

          $arreglo["data"][] = $data;
        }
        echo json_encode($arreglo);
      }
      mysqli_free_result($resultado);
      break;
    case 3: //Actualizar

      $empleado = $_POST['empleado'];
      $valor = $_POST['valor'];
      //$password = $_POST['contrasena'];
      $valorAdmin = $_POST['valorAdmin'];
      $queryEmpl = "SELECT employees.office_email FROM employees WHERE employees.id = '$empleado'";
      $resultadoEmpl = mysqli_query($conexion, $queryEmpl);
      $datoEmpl = mysqli_fetch_array($resultadoEmpl);
      //echo $dato[0];
      mysqli_free_result($resultadoEmpl);
      //nombre, correo, contrase�0�9a, activo, administrador.
      $query = "UPDATE users SET users.name = '$datoEmpl[0]', users.username = '$datoEmpl[0]', users.publish = '$valor', users.is_view_all = '$valorAdmin' WHERE users.employee_id = '$empleado'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        //$informacion["respuesta"] = $query;
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
        //$informacion["respuesta"] = $query;
      echo json_encode($informacion);
      break;
    case 4: //Eliminar
      $id = $_POST['id'];
      $query = "DELETE from users where users.id = '$id'";
      $resultado = mysqli_query($conexion, $query);
      if (!$resultado)
        //$informacion["respuesta"] = $query;
        $informacion["respuesta"] = "ERROR";
      else
        //$informacion["respuesta"] = $query;
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
    case 5: //Registrar
      $empleado = $_POST['empleado'];
      $query = "SELECT users.id FROM users where users.employee_id = '$empleado'";
      $resultado = mysqli_query($conexion, $query);
      $existe = mysqli_num_rows($resultado);
      if($existe > 0){
        $informacion["respuesta"] = "EXISTE";
        echo json_encode($informacion);
      }else{
        $queryEmpl = "SELECT employees.office_email,designations.name FROM employees inner join designations on(designations.id=employees.designation_id) where employees.id = '$empleado'";
        $resultadoEmpl = mysqli_query($conexion, $queryEmpl);
        $datoEmpl = mysqli_fetch_array($resultadoEmpl);
        //echo $dato[0];
        mysqli_free_result($resultadoEmpl);
        $query = "SELECT max(sr_no)+1 FROM users";
        $resultado = mysqli_query($conexion, $query);
        $dato = mysqli_fetch_array($resultado);
        $password = md5($_POST['contrasena']);
        $branch_id = '543e9129-1508-46aa-a75e-1204174a8323';
        $branchid = '543e9129-1508-46aa-a75e-1204174a8323';
        $created_by = '543e98b9-f4c0-4fc2-a6df-1204174a8323';
        $modified_by = '557aef01-82c8-4d04-aaaa-16f40e234168';
        $id = '582b351b-ffcc-4a51-aa03-09ecc0a80'.$dato[0];
        $query = "INSERT INTO users (id,name,employee_id,username,department_id,publish,password,branch_id,branchid,departmentid,created_by,created,modified_by,modified,administrador) values ('$id','$datoEmpl[0]','$empleado','$datoEmpl[0]','$datoEmpl[1]',0,'$password','$branch_id','$branchid','$datoEmpl[1]','$created_by',now(),'$modified_by',now(),0)";
        echo $query;
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
      $query = "SELECT users.id,users.administrador as admin,users.name,employees.name AS empleado, employees.id AS id_empleado, users.username, users.publish, users.publish AS estado,users.is_view_all,users.is_view_all AS view_all from users inner join employees on (users.employee_id = employees.id) where users.soft_delete = 0 and users.publish = 0 order by users.sr_no desc";
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
          switch ($data['view_all']) {
            case 1:
              $data['view_all']='<i class="icon-check"></i>';
              break;
            case 0:
              $data['view_all']='<i class="icon-close"></i>';
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
      $query = "SELECT users.id,users.administrador as admin,users.name,employees.name AS empleado, employees.id AS id_empleado, users.username, users.publish, users.publish AS estado from users inner join employees on (users.employee_id = employees.id) where users.soft_delete = 1 order by users.sr_no desc";
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
          switch ($data['admin']) {
            case 1:
              $data['admin']='<i class="icon-check"></i>';
              break;
            case 0:
              $data['admin']='<i class="icon-close"></i>';
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
        $tabla = "users";
        $condicion = "";
      }
      $query = "SELECT count(*) from $tabla $condicion ";
      $resultado = mysqli_query($conexion, $query);
      $dato = mysqli_fetch_array($resultado);
      echo $dato[0];
      mysqli_free_result($resultado);
      break;

      case 9: //Cargar combo empleados
        if(isset($_POST['tabla'])){
          $tabla = $_POST['tabla'];
          $condicion = $_POST['condicion'];
          $seleccionado = $_POST['seleccionado'];
        }
        else{
          $tabla = "employees";
          $condicion = "";
        }
        $cad = '';
        $query = "SELECT employees.id, employees.name from $tabla $condicion order by employees.name asc";
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
        case 10: //Cambiar contrase�0�9a
          $empleado = $_POST['empleado'];
          $edit_password = $_POST['edit_password'];
          $query = "UPDATE users SET users.password = md5('$edit_password') WHERE users.employee_id = '$empleado'";
          $resultado = mysqli_query($conexion, $query);
          if (!$resultado)
            //$informacion["respuesta"] = $query;
            $informacion["respuesta"] = "ERROR";
          else
            $informacion["respuesta"] = "BIEN";
            //$informacion["respuesta"] = $query;
          echo json_encode($informacion);
          break;

          case 11: //cambiar contrase�0�9a
            $newpass1 = $_POST['nueva-contrasenia1'];
            $newpass2 = $_POST['nueva-contrasenia2'];
            $oldpass = $_POST['antigua-contrasenia'];
            $usuario = $_SESSION['username'];

            if($newpass1==$newpass2){
                $query = "SELECT password from users where username = '$usuario'";
                $resultado = mysqli_query($conexion, $query);
                $dato = mysqli_fetch_array($resultado);
                //$informacion['respuesta']= $dato[0];
                if(md5($oldpass)==$dato[0]){
                    $query1 = "UPDATE users set password=md5('$newpass1') where username='$usuario'";
                    $resultado1 = mysqli_query($conexion,$query1);

                    if (!$resultado1) {
                      $informacion['respuesta']="ERROR";
                    }else{
                      $informacion['respuesta']="BIEN";
                    }

                } else {
                    $informacion['respuesta']="ERROR2";
                }
            } else {
                $informacion['respuesta']="ERROR1";
            }
            echo json_encode($informacion);
          break;

          case 12: //actualizar foto de perfil
            $usuarioId = $_SESSION['id'];
            $uploadDir = 'plugins/images/users/profiles';

            if (!isset($_FILES['foto_perfil']) || $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_OK) {
              $informacion['respuesta'] = "ERROR4";
              echo json_encode($informacion);
              break;
            }

            if (!file_exists($uploadDir)) {
              mkdir($uploadDir, 0755, true);
            }

            if ($_FILES['foto_perfil']['size'] > 2097152) {
              $informacion['respuesta'] = "ERROR5";
              echo json_encode($informacion);
              break;
            }

            $imageInfo = @getimagesize($_FILES['foto_perfil']['tmp_name']);
            $allowedTypes = array(
              IMAGETYPE_JPEG => 'jpg',
              IMAGETYPE_PNG => 'png',
              IMAGETYPE_GIF => 'gif',
              IMAGETYPE_WEBP => 'webp'
            );

            if ($imageInfo === false || !isset($allowedTypes[$imageInfo[2]])) {
              $informacion['respuesta'] = "ERROR3";
              echo json_encode($informacion);
              break;
            }

            foreach (glob($uploadDir . '/' . $usuarioId . '.*') as $oldAvatar) {
              if (is_file($oldAvatar)) {
                unlink($oldAvatar);
              }
            }

            $avatarPath = $uploadDir . '/' . $usuarioId . '.' . $allowedTypes[$imageInfo[2]];

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $avatarPath)) {
              $informacion['respuesta'] = "BIEN";
              $informacion['avatar'] = $avatarPath;
            } else {
              $informacion['respuesta'] = "ERROR";
            }

            echo json_encode($informacion);
          break;

  }


  mysqli_close($conexion);
?>
