<?php
  session_start();
  if(!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
  }
  include('scripts/config.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
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
  //echo $_POST['accion'];
  switch($accion){
    case 1: //Listar todo
      $id = $_SESSION['empleado'];
      $arreglo = array();
      $query = "SELECT id,sr_no,solicitante,correo,created,target_date,initial_remarks,completion_remarks,current_status AS estado, assigned_to AS asignado,archivo,llave, archivoSolicitud FROM corrective_preventive_actions WHERE assigned_to = '$id' and current_status = 0 order by target_date asc";
      $resultado = mysqli_query($conexion, $query);
      //mysqli_set_charset($conexion,"utf8");
      //error_log($query);
      if (!$resultado) {
        die("Error");
      }else{
        while ($data=mysqli_fetch_assoc($resultado)) {
          //$arreglo["data"][] = array_map("utf8_encode", $data);
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
      $codigo = $_POST['codigo'];
      $accioninmediata = $_POST['accioninmediata'];
      $descripcionpqr = $_POST['descripcionpqr'];
      $llave = $_POST['llave'];
      $valor = $_POST['valor'];
      $idUser = $_SESSION['id'];
      $idBranch = $_SESSION['branch'];
      $idDepartment = $_SESSION['department'];
      $target_path = "plugins/upload/55a58e04-8b34-4bd5-8685-11fc0e234971/corrective_preventive_actions/";
      $ruta = $_POST['enlaceArchivo'];
      $carpeta = $target_path.$id;
      $fechacierre = $_POST['fechacierre'];
      $responsable = $_POST['cargo'];
      $numero = $_POST['numero'];
      $solicitante = $_POST['solicitante'];
      $correoSolicitante = $_POST['correoSolicitante'];
      $queryE = "SELECT id, name, office_email from employees where id = '$responsable'";
      $resultadoE = mysqli_query($conexion, $queryE);
      $empleado = mysqli_fetch_array($resultadoE);
      $estado = 'Abierta';
      $ip = $_SERVER['REMOTE_ADDR'];

      if(trim($ruta) <> ''){
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0755, true);
        }
        $nombreArchivo = $_FILES['archivo']['name'];
        $tipoArchivo = '';
        if(trim(basename($nombreArchivo))<>''){
            $target_path = $target_path .$id.'/'. basename($nombreArchivo);
            $ruta = $target_path;
        }
        if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)){
          $queryC = "SELECT max(sr_no)+1 from file_uploads ";
          $resultado = mysqli_query($conexion, $queryC);
          $dato = mysqli_fetch_row($resultado);
          $idFile = '583efd86-9714-4c15-'.$dato[0].'-5e8b6bb444e6';
          $queryF = "INSERT INTO file_uploads(id,system_table_id, record, file_details, file_type, file_dir, user_id, file_status, result, publish, created,user_session_id,branchid,departmentid,created_by,modified_by,modified) VALUES ('$idFile','5297b2e7-8aa0-4c76-ad42-2d8f0a000005','$id','$nombreArchivo','$tipoArchivo','$target_path','$idUser',1,'File uploaded',1,now(),'$idUser','543e9129-1508-46aa-a75e-1204174a8323','523a0abb-21e0-4b44-a219-6142c6c32681','$idUser','$idUser',now())";
          mysqli_query($conexion, $queryF);
        }
      }
      if($valor==0){
        $query = "UPDATE corrective_preventive_actions SET completion_remarks = '$accioninmediata',target_date = '$fechacierre', current_status = 0, assigned_to='$responsable',archivo='$ruta' where id = '$id'";
        if($_SESSION['empleado']<>$responsable){
        //   require 'PHPMailer/src/Exception.php';
        //   require 'PHPMailer/src/PHPMailer.php';
        //   require 'PHPMailer/src/SMTP.php';

        //   $mail = new PHPMailer(true);
        //   $mail->isSMTP();                                      // Set mailer to use SMTP
        //   $mail->Host = $hostmail;               // Specify main and backup SMTP servers
        //   $mail->SMTPAuth = true;                               // Enable SMTP authentication
        //   $mail->Username = $usermail;        // SMTP username
        //   $mail->Password = $passmail;   // SMTP password
        //   $mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
        //   $mail->Port = $portmail;                 // TCP port to connect to

        //   $mail->setFrom($remmail, $nommail);
        //   $mail->addAddress($empleado[2], $empleado[1]);                // Add a recipient
        //   $mail->addAddress($instmail, 'Calidad');            // Add a recipient
        //   $mail->isHTML(true);                                  // Set email format to HTML

        //   $mail->CharSet = "UTF-8";
        //   $asunto = "Asignación de PQR - ".$numero;
        //   $asunto = "=?UTF-8?B?" . base64_encode($asunto) . "=?=";
        //   $mail->Subject = utf8_encode($asunto);
        //   $mail->Body = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
        //     <head>
        //     <meta name=\"viewport\" content=\"width=device-width\" />
        //     <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
        //     <title>Eliteadmin Responsive web app kit</title>
        //     </head>
        //     <body style=\"margin:0px; background: #f8f8f8; \">
        //     <div width=\"100%\" style=\"background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;\">
        //       <div style=\"max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px\">
        //         <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%; margin-bottom: 20px\">
        //           <tbody>
        //             <tr>
        //               <td style=\"vertical-align: top; padding-bottom:30px;\" align=\"center\"><a href=\"http://fup.edu.co\" target=\"_blank\"><img src=\"https://fupvirtual.edu.co/isocalidad/plugins/images/logoFUP.png\" alt=\"Fundación Universitaria de Popayán\" style=\"border:none\"><br/>
        //                 </a> </td>
        //             </tr>
        //           </tbody>
        //         </table>
        //         <div style=\"padding: 40px; background: #fff;\">
        //           <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">
        //             <tbody>
        //               <tr>
        //                 <td><b>Apreciad@ ".$empleado[1]."</b>
        //                   <p>Para el departamento de calidad y la Fundación Universitaria de Popayán en general, tu gestión es muy importante.<br>
        //                     Se te ha asignado la siguiente PQR.</p>
        //                   <p><b>REFERENCIA: ".$numero." </b></p>
        //                   <p><b>PQR: </b>".$descripcionpqr." <br>
        //                   <p>Te invitamos a realizar el proceso correspondiente desde el sistema de gestión de calidad ingresando al siguiente enlace:</p>
        //                   <a href=\"https://fupvirtual.edu.co/isocalidad\" style=\"display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;\"> Ingresar </a>
        //                   <!--<a href=\"https://fupvirtual.edu.co/isocalidad\" > Ingresar </a>-->
        //                   <p>Estamos trabajando para mejorar. </p>
        //                   <b>- Gracias</b> </td>
        //               </tr>
        //             </tbody>
        //           </table>
        //         </div>
        //         <div style=\"text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px\">
        //           <p> Powered by UNIVIDA <br>
        //             </p>
        //         </div>
        //       </div>
        //     </div>
        //     </body>
        //     </html>";
        //   if (!$mail->send()) {
        //       echo "Message could not be sent.";
        //       echo "Mailer Error: " . $mail->ErrorInfo;
        //   }
        }
      }else{
          $estado = 'Cerrada';
          $query = "UPDATE corrective_preventive_actions SET completion_remarks = '$accioninmediata',target_date = '$fechacierre', current_status = 1, closed_by = '$idUser',closed_on_date = now(),archivo='$ruta' where id = '$id'";


          $enlacePqr = "https://fupvirtual.edu.co/isocalidad/consultar?key=".$llave;
          require 'PHPMailer/src/Exception.php';
          require 'PHPMailer/src/PHPMailer.php';
          require 'PHPMailer/src/SMTP.php';

          $mail = new PHPMailer(true);
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = $hostmail;               // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $usermail;        // SMTP username
          $mail->Password = $passmail;   // SMTP password
          $mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $portmail;                 // TCP port to connect to

          $mail->setFrom($remmail, $nommail);
          $mail->addAddress($correoSolicitante, $solicitante);                // Add a recipient
          $mail->addAddress($instmail, 'Calidad');            // Add a recipient
          $mail->isHTML(true);                                  // Set email format to HTML

          $mail->CharSet = "UTF-8";
          $asunto = "PQR Cerrada - ".$numero;
          $asunto = "=?UTF-8?B?" . base64_encode($asunto) . "=?=";
          $mail->Subject = utf8_encode($asunto);
          $mail->Body = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
            <head>
            <meta name=\"viewport\" content=\"width=device-width\" />
            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
            <title>Eliteadmin Responsive web app kit</title>
            </head>
            <body style=\"margin:0px; background: #f8f8f8; \">
            <div width=\"100%\" style=\"background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;\">
              <div style=\"max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px\">
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%; margin-bottom: 20px\">
                  <tbody>
                    <tr>
                      <td style=\"vertical-align: top; padding-bottom:30px;\" align=\"center\"><a href=\"http://fup.edu.co\" target=\"_blank\"><img src=\"https://fupvirtual.edu.co/isocalidad/plugins/images/logoFUP.png\" alt=\"Fundación Universitaria de Popayán\" style=\"border:none\"><br/>
                        </a> </td>
                    </tr>
                  </tbody>
                </table>
                <div style=\"padding: 40px; background: #fff;\">
                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">
                    <tbody>
                      <tr>
                        <td><b>Apreciad@ ".$solicitante."</b>
                          <p>Para el departamento de calidad y la Fundación Universitaria de Popayán en general, tu opinión es muy importante.<br>
                            Se te ha dado respuesta a la PQR generada.</p>
                          <p><b>REFERENCIA: ".$numero." </b></p>
                          <p><b>PQR: </b>".$descripcionpqr." <br>
                          <p>Para conocer la respuesta de su PQR lo invitamos a seguir el siguiente enlace:</p>
                          <a href=\"".$enlacePqr."\" style=\"display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;\"> Ingresar </a>
                          <p>Estamos trabajando para mejorar. </p>
                          <b>- Gracias</b> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div style=\"text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px\">
                  <p> Powered by UNIVIDA <br>
                    </p>
                </div>
              </div>
            </div>
            </body>
            </html>";

          if (!$mail->send()) {
              echo "Message could not be sent.";
              echo "Mailer Error: " . $mail->ErrorInfo;
          }


      }
      $resultado = mysqli_query($conexion, $query);
      $query5 = "INSERT INTO audit_pqr(pqr_id, pqr_sr_no, accion, estado, usuario, fecha, ip) VALUES ('$id', '$numero', '$accioninmediata', '$estado', '$empleado[2]', now(), '$ip')";
      $resultado5 = mysqli_query($conexion, $query5);

      //mysqli_set_charset($conexion,"utf8");
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
    case 5:

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
    case 9://listar todos los pqr
      # code...
       $id = $_SESSION['id'];
        $arreglo = array();
        $query = "SELECT corrective_preventive_actions.id,corrective_preventive_actions.sr_no,employees.name AS empleado,solicitante,corrective_preventive_actions.assigned_to,correo,corrective_preventive_actions.created,target_date,initial_remarks,completion_remarks,current_status AS estado,closed_on_date,corrective_preventive_actions.fecha_notificacion,archivo, assigned_to AS asignado, llave, archivoSolicitud FROM corrective_preventive_actions inner join employees on (employees.id = corrective_preventive_actions.assigned_to) where corrective_preventive_actions.publish = 1 order by target_date asc";
        $resultado = mysqli_query($conexion, $query);
        //mysqli_set_charset($conexion,"utf8");
        if (!$resultado) {
          die("Error");
        }else{
          while ($data=mysqli_fetch_assoc($resultado)) {
            //$arreglo["data"][] = array_map("utf8_encode", $data);
            $arreglo["data"][] = $data;
          }
          echo json_encode($arreglo);
        }
        mysqli_free_result($resultado);
      break;
      case 10://listar todos los pqr cerrados
      # code...
       $id = $_SESSION['id'];
        $arreglo = array();
        $query = "SELECT corrective_preventive_actions.id,corrective_preventive_actions.sr_no,employees.name AS empleado,solicitante,corrective_preventive_actions.assigned_to,correo,corrective_preventive_actions.created,target_date,initial_remarks,completion_remarks,current_status AS estado,closed_on_date,corrective_preventive_actions.fecha_notificacion,archivo, assigned_to AS asignado, llave, archivoSolicitud FROM corrective_preventive_actions inner join employees on (employees.id = corrective_preventive_actions.assigned_to) where current_status=1 and  corrective_preventive_actions.publish = 1 order by target_date asc";
        $resultado = mysqli_query($conexion, $query);
        //mysqli_set_charset($conexion,"utf8");
        if (!$resultado) {
          die("Error");
        }else{
          while ($data=mysqli_fetch_assoc($resultado)) {
            //$arreglo["data"][] = array_map("utf8_encode", $data);
            $arreglo["data"][] = $data;
          }
          echo json_encode($arreglo);
        }
        mysqli_free_result($resultado);
      break;
      case 11://listar todos los pqr abiertos
      # code...
       $id = $_SESSION['id'];
        $arreglo = array();
        $query = "SELECT corrective_preventive_actions.id,corrective_preventive_actions.sr_no,employees.name AS empleado,solicitante,corrective_preventive_actions.assigned_to AS asignado,correo,corrective_preventive_actions.created,target_date,initial_remarks,completion_remarks,current_status AS estado,closed_on_date,corrective_preventive_actions.fecha_notificacion,archivo, assigned_to AS asignado, llave, archivoSolicitud FROM corrective_preventive_actions inner join employees on (employees.id = corrective_preventive_actions.assigned_to) where current_status=0 and  corrective_preventive_actions.publish = 1 order by target_date asc";
        $resultado = mysqli_query($conexion, $query);
        //mysqli_set_charset($conexion,"utf8");
        if (!$resultado) {
          die("Error");
        }else{
          while ($data=mysqli_fetch_assoc($resultado)) {
            //$arreglo["data"][] = array_map("utf8_encode", $data);
            $arreglo["data"][] = $data;
          }
          echo json_encode($arreglo);
        }
        mysqli_free_result($resultado);
      break;
      case 12:
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
      case 13://Actualizar respuesta escritorio
      $id = $_POST['id'];
      $accioninmediata = $_POST['accioninmediata'];
      $valor = $_POST['valor'];
      $idUser = $_SESSION['id'];
      $idBranch = $_SESSION['branch'];
      $idDepartment = $_SESSION['department'];
      $target_path = "plugins/upload/55a58e04-8b34-4bd5-8685-11fc0e234971/corrective_preventive_actions/";
      $carpeta = $target_path.$id;
      $fechacierre = $_POST['fechacierre'];
      $responsable = $_POST['cargo'];
      if (!file_exists($carpeta)) {
          mkdir($carpeta, 0755, true);
      }
      $nombreArchivo = $_FILES['archivo']['name'];
      $tipoArchivo = '';
      $target_path = $target_path .$id.'/'. basename($nombreArchivo);
      if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)){
        $queryC = "SELECT max(sr_no)+1 from file_uploads ";
        $resultado = mysqli_query($conexion, $queryC);
        $dato = mysqli_fetch_row($resultado);
        $idFile = '583efd86-9714-4c15-'.$dato[0].'-5e8b6bb444e6';
        $queryF = "INSERT INTO file_uploads(id,system_table_id, record, file_details, file_type, file_dir, user_id, file_status, result, publish, created,user_session_id,branchid,departmentid,created_by,modified_by,modified) VALUES ('$idFile','5297b2e7-8aa0-4c76-ad42-2d8f0a000005','$id','$nombreArchivo','$tipoArchivo','$target_path','$idUser',1,'File uploaded',1,now(),'$idUser','543e9129-1508-46aa-a75e-1204174a8323','523a0abb-21e0-4b44-a219-6142c6c32681','$idUser','$idUser',now())";
        mysqli_query($conexion, $queryF);
      }
      if($valor==0){
        $query = "UPDATE corrective_preventive_actions SET proposed_immidiate_action = '$accioninmediata',target_date = '$fechacierre',assigned_to='$responsable' where id = '$id'";
         $informacion["respuesta"] = $query;
      }else{
        $query = "UPDATE corrective_preventive_actions SET proposed_immidiate_action = '$accioninmediata',target_date = '$fechacierre', current_status = 1, closed_by = '$idUser',closed_on_date = now() where id = '$id'";


          require 'PHPMailer/src/Exception.php';
          require 'PHPMailer/src/PHPMailer.php';
          require 'PHPMailer/src/SMTP.php';

          $mail = new PHPMailer(true);
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = $hostmail;               // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $usermail;        // SMTP username
          $mail->Password = $passmail;   // SMTP password
          $mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $portmail;                 // TCP port to connect to

          $mail->setFrom($remmail, $nommail);
          $mail->addAddress('mauricio.realpe@unividafup.edu.co', 'Mao');                // Add a recipient
          $mail->addAddress($instmail, 'Calidad');            // Add a recipient
          $mail->isHTML(true);                                  // Set email format to HTML

          $mail->CharSet = "UTF-8";
          $asunto = "PQR Cerrada";
          $asunto = "=?UTF-8?B?" . base64_encode($asunto) . "=?=";
          $mail->Subject = utf8_encode($asunto);
          $mail->Body = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
      <head>
      <meta name=\"viewport\" content=\"width=device-width\" />
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
      <title>Eliteadmin Responsive web app kit</title>
      </head>
      <body style=\"margin:0px; background: #f8f8f8; \">
      <div width=\"100%\" style=\"background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;\">
        <div style=\"max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px\">
          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%; margin-bottom: 20px\">
            <tbody>
              <tr>
                <td style=\"vertical-align: top; padding-bottom:30px;\" align=\"center\"><a href=\"http://eliteadmin.themedesigner.in\" target=\"_blank\"><img src=\"../plugins/images/eliteadmin-logo-dark.png\" alt=\"Eliteadmin Responsive web app kit\" style=\"border:none\"><br/>
                  <img src=\"../plugins/images/eliteadmin-text-dark.png\" alt=\"Eliteadmin Responsive web app kit\" style=\"border:none\"></a> </td>
              </tr>
            </tbody>
          </table>
          <div style=\"padding: 40px; background: #fff;\">
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">
              <tbody>
                <tr>
                  <td><b>Dear Sir/Madam/Customer,</b>
                    <p>This is to inform you that, Your account with Elite Admin has been created successfully. Log it for more details.</p>
                    <a href=\"javascript: void(0);\" style=\"display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;\"> Call to action button </a>
                    <p>This email template can be used for Create Account, Change Password, Login Information and other informational things.</p>
                    <b>- Thanks (Elite team)</b> </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div style=\"text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px\">
            <p> Powered by UNIVIDA <br>
              <a href=\"javascript: void(0);\" style=\"color: #b2b2b5; text-decoration: underline;\">Unsubscribe</a> </p>
          </div>
        </div>
      </div>
      </body>
      </html>";

          if (!$mail->send()) {
              echo "Message could not be sent.";
              echo "Mailer Error: " . $mail->ErrorInfo;
          }
      }
      $resultado = mysqli_query($conexion, $query);

      //mysqli_set_charset($conexion,"utf8");
      if (!$resultado)
        $informacion["respuesta"] = "ERROR";
      else
        $informacion["respuesta"] = "BIEN";
      echo json_encode($informacion);
      break;
      case 14: //Listar historico PQR
          $id = $_POST['pqr'];
          $arreglo = array();
          $query = "SELECT id,accion,estado,usuario,fecha,ip FROM audit_pqr WHERE pqr_sr_no = '$id'";
          $resultado = mysqli_query($conexion, $query);
          //mysqli_set_charset($conexion,"utf8");
          if (!$resultado) {
            die("Error");
          }else{
            while ($data=mysqli_fetch_assoc($resultado)) {
              //$arreglo["data"][] = array_map("utf8_encode", $data);
              $arreglo["data"][] = $data;
            }
            echo json_encode($arreglo);
          }
          mysqli_free_result($resultado);
      break;

  }

  mysqli_close($conexion);
?>