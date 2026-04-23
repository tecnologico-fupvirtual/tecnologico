<?php
    if (isset($_GET['key']))
    {
        $key = $_GET['key'];
        include('scripts/config.php');
        $conexion = mysqli_connect($server, $user, $password, $database);
         mysqli_set_charset($conexion,"utf8");
          
        if (!$conexion){ 
            die('Error de Conexión: ' . mysqli_connect_errno());  
        } 
        $query = "SELECT corrective_preventive_actions.name, corrective_preventive_actions.sr_no, corrective_preventive_actions.created, employees.name, corrective_preventive_actions.closed_by, corrective_preventive_actions.lugar, corrective_preventive_actions.tipo, corrective_preventive_actions.observacion, corrective_preventive_actions.completion_remarks, corrective_preventive_actions.id, corrective_preventive_actions.archivo, corrective_preventive_actions.notificacion, corrective_preventive_actions.current_status FROM corrective_preventive_actions inner join employees on (corrective_preventive_actions.assigned_to = employees.id) where corrective_preventive_actions.llave = '$key'";
        $resultado = mysqli_query($conexion, $query);
        $registro = mysqli_fetch_row($resultado);
          
       
        if(($registro[11] == 0)&&($registro[12] == 1)){
          $ip = $_SERVER['REMOTE_ADDR'];
          mysqli_query($conexion, "UPDATE corrective_preventive_actions SET notificacion = 1, fecha_notificacion = now() where id = '$registro[9]'");
          mysqli_query($conexion, "INSERT INTO audit_pqr(pqr_id, pqr_sr_no, accion, estado, usuario, fecha, ip) VALUES ('$registro[9]', '$registro[1]', 'Vista por parte del usuario', 'Cerrada', '$registro[3]', now(), '$ip')");
        }
    }
    else
    {
        $activa=0;
    }
?>
<!DOCTYPE html>  
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
<title>PQR - Sistema de gestión de calidad</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="css/colors/blue.css" id="theme"  rel="stylesheet">
<!--alerts CSS -->
<link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="pqr-register">
  <div class="login-box login-sidebar">
    <div class="white-box">
      <form class="form-horizontal form-material" id="frmDatos" method="POST" enctype="multipart/form-data">
        <a href="javascript:void(0)" class="text-center db"><img src="plugins/images/eliteadmin-logo-darkfup.png" alt="Home" /><br/></a>   
        
        
    
      </form>
      <?php if ($registro[0]<>'') { ?>
      <h4 class="font-bold m-t-30">SOLICITUD <?php echo $registro[0]; ?></h4>
      <hr>
      <div class="row">
        <div class="col-md-6 col-xs-6 b-r"> <strong>Fecha de creación</strong> <br>
            <p class="text-muted"><?php echo $registro[2]; ?></p>
        </div>
        <div class="col-md-6 col-xs-6 b-r"> <strong>Estado actual</strong> <br>
            <p class="text-muted"><?php if ($registro[4] == -1) {echo 'ABIERTO';} else {echo 'CERRADO';}?></p>
        </div>
        <div class="col-md-6 col-xs-6 b-r"> <strong>Lugar</strong> <br>
            <p class="text-muted"><?php echo $registro[5]; ?></p>
        </div>
        <div class="col-md-6 col-xs-6"> <strong>Tipo</strong> <br>
            <p class="text-muted"><?php echo $registro[6]; ?></p>
        </div>
      </div>
      <hr>
      <p class="m-t-30"><strong>Descripción:</strong><?php echo ' '.$registro[7]; ?></p>
      <hr>
      <p class="m-t-30"><strong>Respuesta:</strong><?php echo ' '.$registro[8]; ?></p>
      <hr>
      <?php if(trim($registro[10]) <> ''){ ?>
            <center><a href="<?php echo $registro[10]; ?>" target="_blank">
                <img src="plugins/images/archivo.png" alt="Ver Documento" width="42" height="42" border="0">Ver Documento
                </a>
            </center>
      <?php }
      } else { ?>
        <div id="flashMessage" class="alert alert-danger  fade in message">PQR no disponible<button aria-hidden="true" data-dismiss="alert" class="close" type="button" onclick="ocultar()">x</button></div>
      <?php } ?>
      
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/custom.min.js"></script>
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!-- Sweet-Alert  -->

</body>
</html>
