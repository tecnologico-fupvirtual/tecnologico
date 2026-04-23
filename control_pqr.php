<?php
  
  include('scripts/config.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  $conexion = mysqli_connect($server, $user, $password, $database);
  mysqli_set_charset($conexion,"utf8");
  
  // Tamaño máximo del archivo en bytes (4 MB)
    $maxFileSize = 4 * 1024 * 1024; // 4 MB

    // Extensiones de archivo permitidas
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];

    // Tipos MIME permitidos
    $allowedMimeTypes = [
        'image/jpeg', 
        'image/png', 
        'application/pdf', 
        'application/msword', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel', 
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
  
  if (!$conexion){ 
    die('Error de Conexión: ' . mysqli_connect_errno());  
  } 
  $informacion = [];
  if(isset($_POST['accion'])) 
    $accion=$_POST['accion'];
  else
    $accion=1;
  
  switch($accion){
    case 1: 
      $captcha = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfU2wkTAAAAAGEJgivOqE4OQntRx27cBOYO8z2U&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']),TRUE);
        //echo $_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
      if($captcha['success']=== TRUE)
      {
        $fileUrl = '';
        $nombre = $_POST['nombre'];
        $tipoIde = $_POST['tipoIde'];
        $numeroIde = $_POST['cedula'];
        $nombre2 = $_POST['nombre']." - Tipo de Identificación: ".$_POST['tipoIde']." - Nro. Identificación: ".$_POST['cedula'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $vinculacion = $_POST['vinculacion'].' '.$_POST['programa'];
        $lugar = $_POST['lugar'].' '.$_POST['otro'];
        $tipo = $_POST['tipo'];
        $query = "SELECT max(sr_no)+1 FROM corrective_preventive_actions";
        $resultado = mysqli_query($conexion, $query);
        $dato = mysqli_fetch_array($resultado);
        $contador=$dato[0];
        $id='55a529a1-dca0-4645-9982-pqr'.$contador;
        $idCapa='55aea5d1-48a0-4b16-8ebd-pqr'.$contador;
        $llave = password_hash($contador.$correo, PASSWORD_BCRYPT);
        $titulo=$contador;
        $datos='Tipo: '.$_POST['tipo'].' - Lugar: '.$_POST['lugar'].' - Solicitante: '.$_POST['nombre'].' - Correo: '.$_POST['correo'].' - Dirección de correspondencia: '.$_POST['direccion'].' - Telefono contacto: '.$_POST['telefono'].' - Vinculacion: '.$_POST['vinculacion'].' '.$_POST['programa'];
        $sugerencia=$_POST['pqr'];
        $datosCapa=$datos.' - Descripcion: '.$sugerencia;
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
          if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
              // Verificar el tamaño del archivo
              if ($_FILES['archivo']['size'] > $maxFileSize) {
                  echo "ERROR_SIZE";
              }
  
              // Obtener la extensión del archivo
              $fileExtension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
              $fileExtension = strtolower($fileExtension);
  
              // Verificar la extensión del archivo
              if (!in_array($fileExtension, $allowedExtensions)) {
                  echo "ERROR_EXTENSION";
              }
  
              // Verificar el tipo MIME del archivo
              $fileMimeType = mime_content_type($_FILES['archivo']['tmp_name']);
              if (!in_array($fileMimeType, $allowedMimeTypes)) {
                  echo "ERROR_MIME";
              }
  
              // Configuración de la carpeta destino
              $uploadDir = 'plugins/upload/pqrs/'.$id.'/';
              if (!file_exists($uploadDir)) {
                  mkdir($uploadDir, 0755, true);
              }
              // Nombre original del archivo
              $fileName = basename($_FILES['archivo']['name']);
              // Ruta completa del archivo destino
              $uploadFile = $uploadDir . $fileName;
  
              // Mover el archivo subido a la carpeta destino
              if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadFile)) {
                  // URL del archivo para almacenar en la base de datos
                  $fileUrl = $uploadFile; // Ajusta esto según la URL base de tu servidor
              } else {
                  // Devolver respuesta de error en la subida de archivo
                  echo "ERROR_UPLOAD";
              }
          } else {
              // Devolver respuesta de error si hubo un problema con el archivo
              echo "ERROR_FILE";
          }
        }
        
        $query1 = "SELECT 
        employees.id, employees.branchid, employees.departmentid, 
        employees.system_table_id, employees.master_list_of_format_id, 
        employees.company_id, users.id
        FROM
        employees
        inner join users on (employees.id = users.employee_id)
        where employees.employee_number = '9999'";
        $resultado1 = mysqli_query($conexion, $query1);
        $registro = mysqli_fetch_array($resultado1);
        $idEmpleado = $registro[0];
        $idBranch = $registro[1];
        $idDepartment = $registro[2];
        $tablaSistema = $registro[3];
        $masterListFormat = $registro[4];
        $compania = $registro[5];

        $dias = 10;
        $fecha_actual = date("Y-m-d");
        $datestart= strtotime($fecha_actual);
        $diasemana = date('N',$datestart);
        $totaldias = $diasemana+$dias;
        $findesemana = intval( $totaldias/5) *2 ; 
        $diasabado = $totaldias % 5 ; 
        if ($diasabado==6) $findesemana++;
        if ($diasabado==0) $findesemana=$findesemana-2;
       
        $total = (($dias+$findesemana) * 86400)+$datestart ; 
        $fechafinal = date('Y-m-d', $total);

        $query2 = "SELECT 
        employees.id, employees.branchid, employees.departmentid, 
        employees.system_table_id, employees.master_list_of_format_id, 
        employees.company_id, users.id
        FROM
        employees
        inner join users on (employees.id = users.employee_id)
        where employees.employee_number = 'FUN001'";
        $resultado2 = mysqli_query($conexion, $query2);
        $registroAdmin = mysqli_fetch_array($resultado2);
        $idUsuarioAdmin = $registroAdmin[0];
        $query3 = "INSERT INTO suggestion_forms(id, sr_no, employee_id, status, title, activity, suggestion, remark, publish, record_status, soft_delete, branchid, departmentid, created_by, created, modified_by, approved_by, prepared_by, modified, system_table_id, master_list_of_format_id, company_id) VALUES ('$id', '$contador', '$idEmpleado', 0, '$titulo', '$datos', '$sugerencia', ' ', 0, 0, 0, '$idBranch', '$idDepartment', '$idEmpleado', now(), '$idEmpleado', -1, '$idEmpleado', now(), '$tablaSistema', '$masterListFormat', '$compania')";
        $resultado3 = mysqli_query($conexion, $query3);
        $query4 = "INSERT INTO corrective_preventive_actions(id, sr_no, name, number, capa_type, suggestion_form_id, assigned_to, initial_remarks, completed_by, root_cause_analysis_required, closed_by, current_status, priority, branchid, departmentid, created_by, created, modified_by, approved_by, prepared_by, modified, publish, record_status, soft_delete, system_table_id, master_list_of_format_id, company_id, correo, solicitante, lugar, tipo, observacion,capa_category_id,raised_by,target_date,notificacion,llave,archivoSolicitud) VALUES ('$id', '$contador', '$titulo', '$contador', '0', '$id', '$idUsuarioAdmin', '$datosCapa', -1, 0, -1, 0, 0, '$idBranch', '$idDepartment', '$idEmpleado', now(), '$idEmpleado',  '$idUsuarioAdmin', '$idEmpleado', now(), 1, 0, 0, '$tablaSistema', '0', '$compania', '$correo', '$nombre2', '$lugar', '$tipo', '$sugerencia','','','$fechafinal',0,'$llave','$fileUrl')";
        $resultado4 = mysqli_query($conexion, $query4);
        $query5 = "INSERT INTO audit_pqr(pqr_id, pqr_sr_no, accion, estado, usuario, fecha, ip) VALUES ('$id', '$contador', 'Nueva PQR', 'Abierta', 'calidad@fup.edu.co', now(), '$ip')";
        $resultado5 = mysqli_query($conexion, $query5);
        if (!$resultado4){
          echo $query4;
        }
        else{ 
          

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

          $mail = new PHPMailer(true);

          $mail->isSMTP();                                   // Set mailer to use SMTP
          $mail->Host = $hostmail;               // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $usermail;        // SMTP username
          $mail->Password = $passmail;   // SMTP password
          $mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $portmail;                 // TCP port to connect to

          //$mail->From = $instmail;
          //$mail->FromName = $nommail;
          $mail->setFrom($remmail, $nommail);
          $mail->addAddress($correo, $nombre);                // Add a recipient
          $mail->addAddress($instmail, 'Calidad');            // Add a recipient
          $mail->isHTML(true);                                  // Set email format to HTML

          $mail->CharSet = "UTF-8";
          $asunto = "Nueva PQR - ".$titulo;
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
                  <td><b>Apreciad@ ".$nombre."</b>
                    <p>Para el departamento de calidad y la Fundación Universitaria de Popayán en general, tu opinión es muy importante.</p>
                    <p><b>REFERENCIA: ".$titulo." </b></p>
                    <p></p>
                    <p>Los valores enviados son:</p>
                    <p><b>Nombre: </b>".$nombre." <br>
                    <p><b>Identificación: </b>".$tipoIde.': '.$numeroIde." <br>
                    <b>Correo electrónico: </b>".$correo."<br>
                    <b>Dirección de correspondencia: </b>".$direccion."<br>
                    <b>Teléfono | Celular: </b>".$telefono." <br>
                    <b>Vinculación: </b>".$vinculacion." <br>
                    <b>Lugar donde se originó: </b>".$lugar."<br> 
                    <b>".$tipo.": </b>".$sugerencia."</p>
                    <p>Para conocer el estado de su PQR lo invitamos a seguir el siguiente enlace:</p>
                    <a href=\"https://fupvirtual.edu.co/isocalidad/consultar?key=".$llave."\" style=\"display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;\"> Ver estado de PQR </a>
                    <p>Estamos trabajando para darte una pronta respuesta. </p>
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
          echo "BIEN";
        }
      } else {
        echo "ERROR";
      }
    break;   
    case 2: 
      $referencia=$_POST['referencia'];
      header("https://fupvirtual.edu.co/isocalidad/pqr/".urlencode($referencia).".html");
    break;
  } 
  mysqli_close($conexion);
?>