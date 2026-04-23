<?php
session_start();
include('scripts/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$conexion = mysqli_connect($server, $user, $password, $database);
mysqli_set_charset($conexion,"utf8");
if (!$conexion){
  die('Error de Conexión: ' . mysqli_connect_errno());
}

$iduser;
$accion;
$informacion = [];
$queryF;

//$mirar;//para hacer la consulta del archivo cuando se guarde
//$nombre_archivo_buscar//para hacer la consulta del archivo cuando se guarde


if(!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}else{
  $iduser=$_SESSION['id'];
}

if (isset($_POST['accion'])) {
  $accion = $_POST['accion']; //ruta de donde se cargara el documento
}else{
  $accion = 1;
}



switch ($accion) {

  case 1://para extraer y listar documentos

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
      //$arreglo["data"][] = array_map("utf8_encode",$data);
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;

  case 2://guardar documentos
  $id = $_POST['id_procesoinput'];
  $fisico = $_POST['fisico'];
  $digital = $_POST['digital'];
  $area_almacenamiento = $_POST['almacenamiento'];
  $proteccion = $_POST['proteccion'];
  $version = $_POST['version'];
  $recuperacion = $_POST['recuperacion'];
  $archivo_proceso = $_POST['archivo_proceso'];
  $archivo_central = $_POST['archivo_central'];
  $disposicion = $_POST['disposicion'];
  $ruta = $_POST['enlaceArchivo'];
  $target_path = "plugins/upload/master_list_of_formats/";
//  $target_path = "plugins/upload/prueba2/";
  $carpeta = $target_path.$id;


  if(trim($ruta) <> ''){
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0755, true);
    }
    $nombreArchivo = $_FILES['archivo']['name'];
    //  $nom = utf8_encode($nombreArchivo);
    $tipoArchivo = $_FILES['archivo']['type'];
    $target_path = $target_path .$id.'/'. basename($nombreArchivo);
    $ruta = $target_path;

    //mysql_set_charset('uft8');
    if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)){
      $queryC = "SELECT max(sr_no)+1 from file_uploads ";
      $resultado = mysqli_query($conexion, $queryC);
      $dato = mysqli_fetch_row($resultado);
      $idFile = '583efd86-9714-4c15-'.$dato[0].'-5e8b6bb444e6';

      //  $nombre_archivo_buscar = $nombreArchivo;//para hacer la consulta de mirar el archivo cuando se guarde

      $queryF = "INSERT INTO file_uploads(id,system_table_id, record, file_details, file_type, file_dir, user_id, file_status, result, publish, created,user_session_id,branchid,departmentid,created_by,modified_by,modified, fisico, digital, almacenamiento, proteccion, recuperacion, ap, ac, disposicion,version) VALUES ('$idFile','5297b2e7-3538-4360-97fc-2d8f0a000005','$id','$nombreArchivo','$tipoArchivo','$target_path','$iduser',1,'File uploaded',1,now(),'$iduser','543e9129-1508-46aa-a75e-1204174a8323','523a0abb-21e0-4b44-a219-6142c6c32681','$iduser','$iduser',now(),'$fisico','$digital','$area_almacenamiento','$proteccion','$recuperacion','$archivo_proceso','$archivo_central','$disposicion','$version')";
      $resultado = mysqli_query($conexion, $queryF);
      //mysqli_set_charset($conexion,"utf8");
      if (!$resultado){
        $informacion["respuesta"] = "ERROR";
      }
      else{
        $informacion["respuesta"] = "BIEN";
      }
      echo json_encode($informacion);
    }

  }
  break;

  case 3:
  $queryC = "SELECT * from file_uploads WHERE sr_no = (SELECT max(sr_no) maximo from file_uploads)";
  $resultado = mysqli_query($conexion, $queryC);
  $dato = mysqli_fetch_assoc($resultado);
  $idFile = $dato['file_dir'];
  echo $idFile;
  break;

  case 4://actualizar documentos
  $arreglo=array();
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $idprocesorecord=$_POST['id_procesoinput'];
    $almacenamiento = $_POST['almacenamiento'];
    $recuperacion = $_POST['recuperacion'];
    $proteccion = $_POST['proteccion'];
    $archivoproceso = $_POST['archivo_proceso'];
    $archivocentral = $_POST['archivo_central'];
    $disposicion = $_POST['disposicion'];
    $version = $_POST['version'];
    $fisico = $_POST['fisico'];
    $digital = $_POST['digital'];
    $ruta = $_POST['enlaceArchivo'];
    $rutavieja = $_POST['enlaceArchivoOld'];

    if (empty($rutavieja)) {
      $query = "UPDATE file_uploads set almacenamiento = '$almacenamiento',recuperacion='$recuperacion',proteccion='$proteccion',ac='$archivocentral',ap='$archivoproceso',disposicion='$disposicion',version='$version',fisico='$fisico',digital='$digital', modified=now() where id = '$id'";
      $resultado = mysqli_query($conexion,$query);

      if (!$resultado){
        $informacion["respuesta"] = "ERROR";
      }
      else{
        $informacion["respuesta"] = "BIEN";
      }
    }else{
      $borrar = unlink($rutavieja);
      $nombreArchivo = $_FILES['archivo']['name'];
      $tipoArchivo = $_FILES['archivo']['type'];



      $array = preg_split("/[\/]+/", $rutavieja);
    //  $array = spliti("/",$rutavieja);
      $tamañoarray = sizeof($array);
      $palabraParaReemplazar=$array[$tamañoarray-1];

      $nuevaruta = str_replace($palabraParaReemplazar,basename($nombreArchivo),$rutavieja);

        if(move_uploaded_file($_FILES['archivo']['tmp_name'], $nuevaruta)){


          $queryF = "UPDATE file_uploads set almacenamiento = '$almacenamiento',file_dir='$nuevaruta',file_details='$nombreArchivo',recuperacion='$recuperacion',proteccion='$proteccion',ac='$archivocentral',ap='$archivoproceso',disposicion='$disposicion',version='$version',fisico='$fisico',digital='$digital', modified=now() where id = '$id'";

          $resultado = mysqli_query($conexion, $queryF);
          //mysqli_set_charset($conexion,"utf8");
          if (!$resultado){
            $informacion["respuesta"] = "ERROR";
          }
          else{
            $informacion["respuesta"] = "BIEN";
          }
        }
    }
    echo json_encode($informacion);
  }
  break;

  case 5://para extraer y listar documentos

  $arreglo = array();
  $query ="SELECT file_uploads.file_dir,file_uploads.id,file_uploads.file_details,file_uploads.version,if (file_uploads.fisico='1', 'X', '') as fisico,if (file_uploads.digital='1', 'X', '') as digital,file_uploads.almacenamiento,file_uploads.proteccion,file_uploads.recuperacion,file_uploads.ap,file_uploads.ac,file_uploads.disposicion FROM file_uploads inner join master_list_of_formats on (file_uploads.record=master_list_of_formats.id) where file_uploads.system_table_id = '5297b2e7-3538-4360-97fc-2d8f0a000005' and master_list_of_formats.title = 'FORMATOS'";
  $resultado = mysqli_query($conexion,$query);
  if (!$resultado) {
    die("error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      //$arreglo["data"][] = array_map("utf8_encode",$data);
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;

  case 6://eliminar documentos
 $arreglo=array();
 if (isset($_POST['id'])) {
   $id = $_POST['id'];
   $ruta = $_POST['ruta'];
   $doc = $_POST['nombre'];
   $tabla = $_POST['idtabla'];

   $queryb = "SELECT COUNT(id) cantidad from file_uploads WHERE file_details ='$doc' and record='$tabla'";
   $resp = mysqli_query($conexion,$queryb);
   $res = mysqli_fetch_assoc($resp);

   if (!$resp) {
     var_dump("error en la consulta");
   }else{

     if($res['cantidad']>1){
       $query = "DELETE from file_uploads where id = '$id'";
       $resultado = mysqli_query($conexion,$query);
       if (!$resultado){
        $informacion["respuesta"] = "ERROR";
      }
      else{
        $informacion["respuesta"] = "BIEN";
      }
    }
    else{
     $borrar = unlink($ruta);
     $querym = "DELETE from file_uploads where id = '$id'";
     $result = mysqli_query($conexion,$querym);
     if (!$result){
      $informacion["respuesta"] = "ERROR";
    }
    else{
      $informacion["respuesta"] = "BIEN";
    }

  }
  echo json_encode($informacion);
}
}
break;


  case 7://para extraer y listar documentos
  $arreglo = array();
  $query ="SELECT file_uploads.id,file_uploads.file_details,file_uploads.version,if (file_uploads.fisico='1', 'X', '') as fisico,if (file_uploads.digital='1', 'X', '') as digital,file_uploads.file_dir FROM file_uploads inner join master_list_of_formats on (file_uploads.record=master_list_of_formats.id) where file_uploads.system_table_id = '5297b2e7-3538-4360-97fc-2d8f0a000005' and master_list_of_formats.title in ('CARACTERIZACION','DOCUMENTOS DE SOPORTE','INSTRUCTIVOS','MANUAL','PROCEDIMIENTOS')";
  $resultado = mysqli_query($conexion,$query);
  if (!$resultado) {
    die("error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      //$arreglo["data"][] = array_map("utf8_encode",$data);
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;

  case 8://para actualizar el numero de descargas de cada documento
  if (isset($_POST['id'])) {
    $id = $_POST["id"];
    $query = "UPDATE file_uploads SET descargas =1+descargas where id ='$id'";
    $resultado=mysqli_query($conexion,$query);
    if (!$resultado) {
      echo "error";
    }else{
      echo "success";
    }
  }else{
    echo "mal";
  }
  //mysqli_free_result($resultado);
  break;

  case 9://listar los 5 documentos mas descargados
  $arreglo = array();
  $query ="SELECT fu.id,fu.sr_no,fu.record,fu.file_details,fu.file_type,fu.file_dir,fu.version,fu.descargas FROM file_uploads fu inner join master_list_of_formats ml on (fu.record=ml.id) where ml.title = 'FORMATOS' ORDER BY descargas DESC LIMIT 5";
  $resultado = mysqli_query($conexion,$query);
  if (!$resultado) {
    var_dump("error");
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;

  case 10://para listar todos los documentos mas Descargados
  $arreglo = array();
  $query = "SELECT fu.id,fu.sr_no,fu.record,fu.file_details,fu.file_type,fu.file_dir,fu.version,fu.descargas FROM file_uploads fu inner join master_list_of_formats ml on (fu.record=ml.id) where ml.title = 'FORMATOS' ORDER BY descargas DESC";

  $resultado = mysqli_query($conexion,$query);
  if (!$resultado) {
    echo "error";
  }else{
    while ($data=mysqli_fetch_assoc($resultado)) {
      $arreglo["data"][] = $data;
    }
    echo json_encode($arreglo);
  }
  mysqli_free_result($resultado);
  break;
  
  case 11: //enviar documento por correo
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  $mail = new PHPMailer(true);
  $idDoc = $_POST["idDoc"];
  $queryC = "SELECT * from file_uploads WHERE id = '$idDoc'";
  $resultado = mysqli_query($conexion, $queryC);
  $dato = mysqli_fetch_assoc($resultado);
  $dirFile = $dato['file_dir'];
  $nomFile = $dato['file_details'];
  $enlaceDoc = "https://fupvirtual.edu.co/isocalidad/".$dirFile;
  
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
  $mail->Host = $hostmail; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
  $mail->Username = $usermail; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente.
  $mail->Password = $passmail; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
  $mail->SMTPSecure = "ssl";
  $mail->Port = $portmail; // Puerto de conexión al servidor de envio.
  $mail->setFrom($instmail, $nommail);
  $correo = $_POST["correo"];
  $extension = $_POST["extension"];
  $destinatario = $correo.$extension;
  $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos
  $mail->IsHTML(true); // El correo se envía como HTML
  $mail->CharSet = "UTF-8";
  $asunto = "DOCUMENTO ISOCALIDAD - ".$nomFile;
  $asunto = "=?UTF-8?B?" . base64_encode($asunto) . "=?=";
  //$mail->Subject = utf8_encode($asunto);
  $mail->Subject = mb_convert_encoding($asunto, 'UTF-8', 'ISO-8859-1');
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
              <td><b>Apreciad@ ".$destinatario."</b>
                <p>La Fundación Universitaria de Popayán y la Oficina de Calidad Institucional, aportando al medio ambiente y la política de cero papel, envía por éste medio el documento solicitado.<br></p>

                <p><b>DOCUMENTO: </b>".$nomFile." <br>
                <p>Para descargar el documento dale click al siguiente botón:</p>
                <a href=\"".$enlaceDoc."\" style=\"display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;\"> Descargar </a>
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
  // <p><b>REFERENCIA: ".$idDoc." </b></p>
  $exito = $mail->Send(); // Envía el correo.
  if($exito){
    $informacion["respuesta"] = "BIEN";
    $queryUpdate = "UPDATE file_uploads SET descargas =1+descargas where id ='$idDoc'";
    $resultadoUpdate = mysqli_query($conexion,$queryUpdate);
    echo json_encode($informacion);
      // code...
      break;
  } else {
     $informacion["respuesta"] = "ERROR";
     echo json_encode($informacion);
  }
  break;
  
  case 12://seleccionar los 5 documentos modificados o agragados recientemente
  $arreglo = array();
  $query = "SELECT file_details,file_dir FROM file_uploads WHERE file_details LIKE '%-FO-%' ORDER BY modified DESC LIMIT 5";
  $resultado = mysqli_query($conexion,$query);
  $cad = "";
  $cad.='<ul style="padding: initial;">
      <li>
          <div class="drop-title">Documentos actualizados</div>
      </li>';
      while ($data=mysqli_fetch_assoc($resultado)) {
        $cad.= '<li>
            <div class="message-center">
                <a href="https://fupvirtual.edu.co/isocalidad/'.$data["file_dir"].'" target="_blank">
                    <div class="mail-contnet" id="contenedor-noti">
                    '.$data["file_details"].'
                      </div>
                </a>
            </div>
        </li>';
      }
      $cad.='</ul>';
      echo $cad;
  break;

}
?>
