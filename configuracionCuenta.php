<?php
session_start();
if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}

include 'scripts/utiles.php';
include 'scripts/config.php';

$conexion = mysqli_connect($server, $user, $password, $database);
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
  die('Error de Conexión: ' . mysqli_connect_errno());
}

$usuarioId = $_SESSION['id'];
$queryPerfil = "SELECT users.id, users.name, users.username, users.publish, users.is_view_all, users.employee_id, employees.name AS empleado, employees.office_email, designations.name AS cargo FROM users LEFT JOIN employees ON (users.employee_id = employees.id) LEFT JOIN designations ON (employees.designation_id = designations.id) WHERE users.id = '$usuarioId' LIMIT 1";
$resultadoPerfil = mysqli_query($conexion, $queryPerfil);
$perfil = mysqli_fetch_assoc($resultadoPerfil);
mysqli_free_result($resultadoPerfil);
mysqli_close($conexion);

$avatarUrl = 'plugins/images/users/varun.jpg';
foreach (glob('plugins/images/users/profiles/' . $usuarioId . '.*') as $avatarFile) {
  if (is_file($avatarFile)) {
    $avatarUrl = $avatarFile . '?v=' . filemtime($avatarFile);
    break;
  }
}

$nombrePerfil = isset($perfil['empleado']) && trim($perfil['empleado']) !== '' ? $perfil['empleado'] : $_SESSION['nombre'];
$correoPerfil = isset($perfil['office_email']) ? $perfil['office_email'] : 'No registrado';
$cargoPerfil = isset($perfil['cargo']) && trim($perfil['cargo']) !== '' ? $perfil['cargo'] : 'Sin cargo asignado';
$rolPerfil = !empty($_SESSION['super']) ? 'Administrador' : 'Usuario';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
  <title>isoCalidad</title>
  <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
  <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
  <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/colors/blue.css" id="theme" rel="stylesheet">
  <style>
    .profile-shell {
      background: linear-gradient(135deg, #f5f9ff 0%, #edf6ff 100%);
      border-radius: 18px;
      padding: 28px;
      box-shadow: 0 12px 30px rgba(44, 62, 80, 0.08);
    }

    .profile-card {
      background: linear-gradient(160deg, #0a5ea8 0%, #1486cc 100%);
      color: #fff;
      border-radius: 20px;
      padding: 28px;
      text-align: center;
      box-shadow: 0 16px 34px rgba(20, 134, 204, 0.25);
    }

    .profile-avatar-lg {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid rgba(255, 255, 255, 0.9);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      margin-bottom: 18px;
    }

    .profile-chip {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.16);
      margin-top: 12px;
      font-size: 12px;
      letter-spacing: 0.4px;
      text-transform: uppercase;
    }

    .profile-panel {
      background: #fff;
      border-radius: 18px;
      padding: 24px;
      margin-bottom: 24px;
      box-shadow: 0 10px 24px rgba(19, 44, 74, 0.08);
    }

    .profile-panel h4 {
      margin-top: 0;
      margin-bottom: 18px;
      color: #0a5ea8;
      font-weight: 600;
    }

    .profile-label {
      color: #7e8a97;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.7px;
      margin-bottom: 4px;
    }

    .profile-value {
      color: #22313f;
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 18px;
      word-break: break-word;
    }

    .btn-profile {
      border-radius: 10px;
      padding: 12px 18px;
      font-weight: 600;
    }

    .avatar-help {
      color: rgba(255, 255, 255, 0.84);
      font-size: 12px;
      margin-top: 10px;
    }

    .profile-input {
      height: 48px;
      border-radius: 10px;
      border: 1px solid #d8e2ec;
      box-shadow: none;
    }
  </style>
</head>
<body>
  <div class="preloader">
    <div class="cssload-speeding-wheel"></div>
  </div>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top m-b-0">
      <div class="navbar-header">
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg" href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
        <div class="top-left-part"><a class="logo" href="https://fup.edu.co" target="_blank">&emsp;<b><img src="plugins/images/eliteadmin-logo.png" alt="home" /></b></a></div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">
          <li class="dropdown">
            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
              <img src="<?php echo $avatarUrl; ?>" alt="user-img" width="36" class="img-circle">
              <b class="hidden-xs"><?php echo $_SESSION['nombre']; ?></b>
            </a>
            <ul class="dropdown-menu dropdown-user animated flipInY">
              <li><a href="configuracionCuenta"><i class="ti-settings"></i> Configuración de Perfil</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="scripts/admin.php?action=2"><i class="fa fa-power-off"></i> Cerrar sesion</a></li>
            </ul>
          </li>
          <li class="right-side-toggle"><a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
        </ul>
      </div>
    </nav>

    <div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
          <li class="sidebar-search hidden-sm hidden-md hidden-lg">
            <div class="input-group custom-search-form">
              <input type="text" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </li>
          <li><a href="escritorio" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu"> ESCRITORIO <span class="fa arrow"></span></span></a></li>
          <?php if ($_SESSION['administrador'] == 1) { ?>
          <li><a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span></a>
            <ul class="nav nav-second-level">
              <li><a href="procesos">Procesos</a></li>
              <li><a href="categorias">Categorias</a></li>
              <li><a href="cargos">Cargos</a></li>
              <li><a href="empleados">Empleados</a></li>
              <li><a href="usuarios">Usuarios</a></li>
            </ul>
          </li>
          <?php } ?>
          <li><a href="mapadeprocesos" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span></a></li>
          <?php if ($_SESSION['administrador'] == 1) { ?>
          <li><a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADO DE MAESTROS<span class="fa arrow"></span></span></a>
            <ul class="nav nav-second-level">
              <li><a href="listadoMaestroRegistro">Listado maestro de registro</a></li>
              <li><a href="listadoMaestroDocumentos">Listado maestro de documentos</a></li>
              <li><a href="documentosDescargados">Informe documentos descargados</a></li>
            </ul>
          </li>
          <li><a href="#" class="waves-effect active"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">CONFIGURACIÓN<span class="fa arrow"></span></span></a>
            <ul class="nav nav-second-level">
              <li><a href="form-img-cropper.php">Mapa de procesos</a></li>
              <li><a href="configuracionCuenta">Configuración de perfil</a></li>
            </ul>
          </li>
          <?php } ?>

          <li><a href="buscarDocumentos" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">BUSCAR DOCUMENTOS<span class="fa arrow"></span></span></a></li>
          <li><a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">SOLICITUDES SGC <span class="fa arrow"></span></span></a>
            <ul class="nav nav-second-level">
              <li><a href="https://forms.office.com/r/Dy28fet3Xv" target="_blank">Solicitud de cambio al SGC - FUP</a></li>
              <li><a href="https://forms.office.com/r/QRb71zfT90" target="_blank">Reporte No-Conformidad</a></li>
              <li><a href="https://forms.office.com/r/Bev2TbAwkj" target="_blank">Reporte salida No-Conforme</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

    <div id="page-wrapper">
      <div class="container-fluid">
        <div class="row bg-title">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4 class="page-title">CONFIGURACIÓN DE PERFIL</h4>
          </div>
        </div>

        <div class="profile-shell">
          <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-12">
              <div class="profile-card">
                <img src="<?php echo $avatarUrl; ?>" id="avatar-principal" alt="Avatar" class="profile-avatar-lg">
                <h3><?php echo htmlspecialchars($nombrePerfil); ?></h3>
                <p><?php echo htmlspecialchars($cargoPerfil); ?></p>
                <span class="profile-chip"><?php echo $rolPerfil; ?></span>
                <p class="avatar-help">Suba una imagen JPG, PNG, GIF o WEBP de hasta 2 MB para personalizar su perfil.</p>
                <form id="frmAvatar" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="accion" value="12">
                  <div class="form-group m-t-20">
                    <input type="file" class="form-control" name="foto_perfil" id="foto_perfil" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                  </div>
                  <button type="submit" class="btn btn-warning btn-profile btn-block">Actualizar foto de perfil</button>
                </form>
              </div>
            </div>

            <div class="col-lg-8 col-md-7 col-sm-12">
              <div class="profile-panel">
                <h4>Información de la cuenta</h4>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="profile-label">Nombre</div>
                    <div class="profile-value"><?php echo htmlspecialchars($nombrePerfil); ?></div>
                  </div>
                  <div class="col-sm-6">
                    <div class="profile-label">Usuario</div>
                    <div class="profile-value"><?php echo htmlspecialchars($perfil['username']); ?></div>
                  </div>
                  <div class="col-sm-6">
                    <div class="profile-label">Correo institucional</div>
                    <div class="profile-value"><?php echo htmlspecialchars($correoPerfil); ?></div>
                  </div>
                  <div class="col-sm-6">
                    <div class="profile-label">Cargo</div>
                    <div class="profile-value"><?php echo htmlspecialchars($cargoPerfil); ?></div>
                  </div>
                  <div class="col-sm-6">
                    <div class="profile-label">Rol en la plataforma</div>
                    <div class="profile-value"><?php echo $rolPerfil; ?></div>
                  </div>
                  <div class="col-sm-6">
                    <div class="profile-label">Estado</div>
                    <div class="profile-value"><?php echo !empty($perfil['publish']) ? 'Activo' : 'Inactivo'; ?></div>
                  </div>
                </div>
              </div>

              <div class="profile-panel">
                <h4>Seguridad</h4>
                <form id="frmPassword" method="POST">
                  <input type="hidden" id="accion" name="accion" value="11">
                  <div class="form-group">
                    <label class="control-label">Ingrese su antigua contraseña</label>
                    <input type="password" class="form-control profile-input" id="antigua-contrasenia" name="antigua-contrasenia" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Ingrese su nueva contraseña</label>
                    <input type="password" class="form-control profile-input" id="nueva-contrasenia1" name="nueva-contrasenia1" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Verifique su nueva contraseña</label>
                    <input type="password" class="form-control profile-input" id="nueva-contrasenia2" name="nueva-contrasenia2" required>
                  </div>
                  <div class="text-right">
                    <button type="button" class="btn btn-default btn-profile" onclick="limpiarCajasPassword();">Limpiar</button>
                    <button type="submit" class="btn btn-info btn-profile">Actualizar contraseña</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="right-sidebar">
        <div class="slimscrollright">
          <div class="rpanel-title"> Estilos <span><i class="ti-close right-side-toggle"></i></span> </div>
          <div class="r-panel-body">
            <ul id="themecolors" class="m-t-20">
              <li><b>Menú superior claro</b></li>
              <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
              <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
              <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
              <li><a href="javascript:void(0)" theme="blue" class="blue-theme working">4</a></li>
              <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
              <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
              <li><b>Menú superior oscuro</b></li>
              <br/>
              <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
              <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
              <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>
              <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
              <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
              <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
            </ul>
          </div>
        </div>
      </div>

      <footer class="footer text-center">2018 &copy; UNIVIDA</footer>
    </div>
  </div>

  <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
  <script src="js/jquery.slimscroll.js"></script>
  <script src="js/waves.js"></script>
  <script src="js/custom.min.js"></script>
  <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
  <script src="js/toastr.js"></script>
  <script src="plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js"></script>
  <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

  <script>
    $(document).on("ready", function() {
      guardarPassword();
      guardarAvatar();
    });

    var guardarPassword = function() {
      $("#frmPassword").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
          method: "POST",
          url: "registro_usuarios.php",
          data: $(this).serialize()
        }).done(function(info) {
          var json_info = JSON.parse(info);
          mostrarMensaje(json_info);
          if (json_info.respuesta === 'BIEN') {
            limpiarCajasPassword();
          }
        });
      });
    };

    var guardarAvatar = function() {
      $("#frmAvatar").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
          method: "POST",
          url: "registro_usuarios.php",
          data: formData,
          contentType: false,
          processData: false
        }).done(function(info) {
          var json_info = JSON.parse(info);
          mostrarMensaje(json_info);
          if (json_info.respuesta === 'BIEN') {
            window.setTimeout(function() {
              window.location.reload();
            }, 800);
          }
        });
      });
    };

    var mostrarMensaje = function(informacion) {
      if (informacion.respuesta == 'BIEN') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'Los cambios se realizaron satisfactoriamente.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'success',
          hideAfter: 3500,
          stack: 6
        });
      } else if (informacion.respuesta == 'ERROR') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'No se realizaron cambios.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'error',
          hideAfter: 3500
        });
      } else if (informacion.respuesta == 'ERROR1') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'La nueva contraseña y su verificación no coinciden.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'error',
          hideAfter: 3500
        });
      } else if (informacion.respuesta == 'ERROR2') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'La contraseña actual no es correcta.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'error',
          hideAfter: 3500
        });
      } else if (informacion.respuesta == 'ERROR3') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'El archivo debe ser una imagen JPG, PNG, GIF o WEBP.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'error',
          hideAfter: 3500
        });
      } else if (informacion.respuesta == 'ERROR4') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'Seleccione una imagen antes de continuar.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'warning',
          hideAfter: 3500
        });
      } else if (informacion.respuesta == 'ERROR5') {
        $.toast({
          heading: 'QMS Calidad',
          text: 'La imagen supera el límite de 2 MB.',
          position: 'top-right',
          loaderBg:'#ff6849',
          icon: 'error',
          hideAfter: 3500
        });
      }
    };

    var limpiarCajasPassword = function() {
      $("#antigua-contrasenia").val("").focus();
      $("#nueva-contrasenia1").val("");
      $("#nueva-contrasenia2").val("");
    };
  </script>
</body>
</html>
