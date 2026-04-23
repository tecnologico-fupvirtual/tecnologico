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
          case 1: //cargar combo procesos
          $opt='';
          $query="SELECT id, name FROM departments WHERE publish='1' ORDER BY name ASC";
          $res=mysqli_query($conexion,$query);
          if (!$res) {
            die("Error");
          }else{
           while($datos=mysqli_fetch_assoc($res)){
             $opt.="<option value='".$datos['id']."'>".$datos['name']."</option>";
           }
          echo $opt;
          }
          break;

          case 2: //Registrar coordenada
          $proceso = $_POST['cbx_proceso'];
          $x = $_POST['dataX'];
          $y = $_POST['dataY'];
          $width = $_POST['dataWidth'];
          $ancho = $width+$x;
          $height = $_POST['dataHeight'];
          $alto = $height+$y;
          $coordenada = $x.", ".$y.", ".$ancho.", ".$alto;
          $query = "UPDATE departments SET map_coordinates = '$coordenada' WHERE id = '$proceso'";
          $resultado = mysqli_query($conexion, $query);
          if (!$resultado)
            $informacion['respuesta']='ERROR';
          else
            $informacion['respuesta']='BIEN';
            echo json_encode($informacion);
            break;

          case 3: // Guardar imagen
          $tmp = $_FILES['Image']['tmp_name'];
          $nombre = $_FILES['Image']['name'];
          $imagen = $_FILES['Image'];
          $hora = time();
          $direccion = __DIR__."/plugins/images/mapasProcesos/".$nombre.$hora;
          $ruta = "plugins/images/mapasProcesos/".$imagen['name'].$hora;
          $query = "SELECT route_img_processMap FROM companies WHERE id = '543e9129-ed48-4e86-b2b8-1204174a8323'";
          $resultadoRuta = mysqli_query($conexion, $query);
          $datoRuta = mysqli_fetch_array($resultadoRuta);
          if ($datoRuta[0] == $ruta) {
            $informacion['respuesta']='EXISTE';
            echo json_encode($informacion);
          } else {
            if ($imagen["type"] == "image/jpg" || $imagen["type"] == "image/png" || $imagen["type"] == "image/jpeg") {
              $query = "UPDATE companies SET route_img_processMap = '$ruta' WHERE id = '543e9129-ed48-4e86-b2b8-1204174a8323'";
              $resultado = mysqli_query($conexion, $query);
              $informacion['respuesta']='BIEN';
              if (!move_uploaded_file($tmp,$direccion)) {
                echo json_encode ("ERROR");
              }
              echo json_encode($informacion);
            } else {
              $informacion['respuesta']='ERROR';
              echo json_encode($informacion);
            }
          }
          break;

  }

  mysqli_close($conexion);
?>
