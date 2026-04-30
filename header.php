<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
  }

  $currentPage = basename($_SERVER['PHP_SELF'], '.php');
  $isAdmin = isset($_SESSION['administrador']) && $_SESSION['administrador'] == 1;
  $avatarUrl = 'plugins/images/users/varun.jpg';

  if (isset($_SESSION['id'])) {
    foreach (glob('plugins/images/users/profiles/' . $_SESSION['id'] . '.*') as $avatarFile) {
      if (is_file($avatarFile)) {
        $avatarUrl = $avatarFile . '?v=' . filemtime($avatarFile);
        break;
      }
    }
  }

  if (!function_exists('menu_active')) {
    function menu_active($pages)
    {
      global $currentPage;
      return in_array($currentPage, $pages) ? ' active' : '';
    }
  }
?>

<!-- Preloader -->
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="if (typeof doc_mod_recientes === 'function') doc_mod_recientes();">
            <i class="icon-book-open"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" id="resultado" name="resultado"></div>
        </li>

        <li class="dropdown">
          <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
            <img src="<?php echo htmlspecialchars($avatarUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="user-img" width="36" class="img-circle">
            <b class="hidden-xs"><?php echo htmlspecialchars($_SESSION['nombre'], ENT_QUOTES, 'UTF-8'); ?></b>
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
              <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span>
          </div>
        </li>

        <li>
          <a href="escritorio" class="waves-effect<?php echo menu_active(array('escritorio')); ?>">
            <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">ESCRITORIO<span class="fa arrow"></span></span>
          </a>
        </li>

        <?php if ($isAdmin) { ?>
          <li>
            <a href="#" class="waves-effect<?php echo menu_active(array('procesos', 'categorias', 'cargos', 'empleados', 'usuarios')); ?>">
              <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
              <li><a href="procesos">Procesos</a></li>
              <li><a href="categorias">Categorías</a></li>
              <li><a href="cargos">Cargos</a></li>
              <li><a href="empleados">Empleados</a></li>
              <li><a href="usuarios">Usuarios</a></li>
            </ul>
          </li>
        <?php } ?>

        <li>
          <a href="mapadeprocesos" class="waves-effect<?php echo menu_active(array('mapadeprocesos', 'proceso', 'proceso2')); ?>">
            <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span>
          </a>
        </li>

        <?php if ($isAdmin) { ?>
          <li>
            <a href="#" class="waves-effect<?php echo menu_active(array('listadoMaestroRegistro', 'listadoMaestroDocumentos', 'documentosDescargados')); ?>">
              <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADO DE MAESTROS<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
              <li><a href="listadoMaestroRegistro">Listado maestro de registro</a></li>
              <li><a href="listadoMaestroDocumentos">Listado maestro de documentos</a></li>
              <li><a href="documentosDescargados">Informe documentos descargados</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="waves-effect<?php echo menu_active(array('form-img-cropper', 'configuracionCuenta')); ?>">
              <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">CONFIGURACIÓN<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level">
              <li><a href="form-img-cropper.php">Mapa de procesos</a></li>
              <?php if ($currentPage == 'escritorio') { ?>
                <li><a href="#" data-toggle="modal" data-target="#dashboard-banner-modal">Banner de escritorio</a></li>
              <?php } else { ?>
                <li><a href="escritorio?banner=1">Banner de escritorio</a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>

        <li>
          <a href="buscarDocumentos" class="waves-effect<?php echo menu_active(array('buscarDocumentos', 'documentos')); ?>">
            <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">BUSCAR DOCUMENTOS<span class="fa arrow"></span></span>
          </a>
        </li>

        <li>
          <a href="actas" class="waves-effect<?php echo menu_active(array('actas', 'acta_imprimir')); ?>">
            <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">ACTAS Y COMPROMISOS<span class="fa arrow"></span></span>
          </a>
        </li>

        <li>
          <a href="#" class="waves-effect">
            <i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">SOLICITUDES SGC<span class="fa arrow"></span></span>
          </a>
          <ul class="nav nav-second-level">
            <li><a href="https://forms.office.com/r/Dy28fet3Xv" target="_blank">Solicitud de cambio al SGC - FUP</a></li>
            <li><a href="https://forms.office.com/r/QRb71zfT90" target="_blank">Reporte No-Conformidad</a></li>
            <li><a href="https://forms.office.com/r/Bev2TbAwkj" target="_blank">Reporte salida No-Conforme</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
