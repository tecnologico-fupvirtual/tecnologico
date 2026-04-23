<?php
session_start();
if(!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}
$tab;
if (!isset($_GET['id'])) {
  $tab=0;
  header('Location: escritorio.php');
}else{
  $tab = $_GET['id'];
}
include 'scripts/utiles.php';
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
  <!-- Bootstrap Core CSS -->
  <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
  <!-- Menu CSS -->
  <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
  <!-- animation CSS -->
  <link href="css/animate.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
  <!-- color CSS -->
  <link href="css/colors/blue.css" id="theme"  rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- toast CSS -->
  <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
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
    <script>
        var cambiarPaginaDocumentos=function(tbody,table){
            $(tbody).on("click","button.cambiar",function(){
                var data = table.row($(this).parents("tr")).data();
                var id_proceso = data['id'];
                console.log(data);
                location.href='documentos.php?id_proceso='+id_proceso;
            });
        }
        $(document).on("ready", function(){
            listar();
        });
        var listar = function(){
            var table = $("#datatable1").DataTable({
                destroy:true,
                dom: '',
                buttons: [
                    'csv', 'pdf', 'print'
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax":{
                    "method":"POST",
                    "url":"registro_procesos.php",
                    "data": {"accion":10,"idtabla": $("#tabtomado").val()}

                },
                "columns":[
                    {"data":"name"},
                    {"defaultContent":"<button type='button' class='cambiar btn btn-success btn-circle' data-toggle='modal'  data-toggle='tooltip' data-placement='top' ><i class='fa fa-edit'></i></button>"},
                    {"data":"cantidad"}
                ]
            });
            cambiarPaginaDocumentos("#datatable1 tbody",table);
        }
        // Funcion para mostrar los documentos modificados
        var doc_mod_recientes = function(){
            $.ajax({
                method:"POST",
                url:"registro_documentos.php",
                data:{"accion":12},
                success: function(info){
                    $("#resultado").html("");
                    $("#resultado").html(info);
                }
            });
        }
    </script>
    
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="js/toastr.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
    <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> 
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="ti-menu"></i>
                </a>
                <div class="top-left-part">
                    <a class="logo" href="https://fup.edu.co" target="_blank">&emsp;<b><img src="plugins/images/eliteadmin-logo.png" alt="home" /></b></a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- notificaciones de documentos modificados recientemente -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="doc_mod_recientes()">
                            <i class="icon-book-open"> </i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" id="resultado" name="resultado"></div>
                    </li>
                    <!-- fin notificaciones-->
                    <li class="dropdown"> 
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                            <img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['nombre']; ?></b> 
                        </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="#"><i class="ti-user"></i> Mi perfil</a></li>
                            <li><a href="configuracionCuenta"><i class="ti-settings"></i> Configuración de cuenta</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="scripts/admin.php?action=2"><i class="fa fa-power-off"></i> Cerrar sesion</a></li>
                        </ul>
                    </li>
                    <!-- /.dropdown -->
                    <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> 
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li> 
                        <a href="escritorio.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> 
                            <span class="hide-menu"> ESCRITORIO <span class="fa arrow"></span> </span>
                        </a>
                        <?php if($_SESSION['administrador']==1){ ?>
                    </li>
                    <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="procesos">Procesos</a> </li>
                            <li> <a href="categorias">Categorias</a> </li>
                            <li> <a href="cargos">Cargos</a> </li>
                            <li> <a href="empleados">Empleados</a> </li>
                            <li> <a href="usuarios">Usuarios</a> </li>
                        </ul>
                    </li>
                        <?php } ?>
                    <li> <a href="mapadeprocesos" class="waves-effect active"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span></a>
                    </li>
                    <?php if($_SESSION['administrador']==1){ ?>
                        <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADOS MAESTROS<span class="fa arrow"></span></span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="listadoMaestroRegistro">Listado maestro de registro</a> </li>
                                <li> <a href="listadoMaestroDocumentos">Listado maestro de documentos</a> </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li> <a href="buscarDocumentos" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">BUSCAR DOCUMENTOS<span class="fa arrow"></span></span></a>
                    </li>
                    <?php if($_SESSION['administrador']==1){ ?>
                        <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">SOLICITUDES SGC <span class="fa arrow"></span></span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="https://forms.office.com/r/Dy28fet3Xv" target="_blank">Solicitud de cambio al SGC - FUP</a> </li>
                                <li> <a href="https://forms.office.com/r/QRb71zfT90" target="_blank">Reporte No-Conformidad</a> </li>
                                <li> <a href="https://forms.office.com/r/Bev2TbAwkj" target="_blank">Reporte salida No-Conforme</a> </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!--listado de los procesos-->
        <!-- inicio pestaña -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body" id="tabs">
                        <ul class="nav nav-pills m-b-30 ">
                            <?php if($tab=='docencia'){  ?>
                                <li class="active"> <a href="#navpills-1" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('docencia');">Docencia</a> </li>
                                <li > <a href="#navpills-11" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('registroAcademico');">Registro Académico</a> </li>
                                <li > <a href="#navpills-12" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionCurricular');">Gestion Curricular</a> </li>
                                <!--<li > <a href="#navpills-13" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionEducacionVirtual');">Gestion de la Educación Virtual</a> </li> -->
								<li > <a href="#navpills-14" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('posgrados');">Posgrados</a> </li>
								<li > <a href="#navpills-15" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('consultorioJuridico');">Consultorio Jurídico</a> </li>
								<li > <a href="#navpills-16" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('centroConciliacion');">Centro Conciliación</a> </li>
                            <?php } if($tab=='investigacion'){ ?>
                                <li class="active"> <a href="#navpills-2" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('investigacion');">Investigación Desarrollo e Innovación</a> </li>
                                <!--<li > <a href="#navpills-21" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionInvestigacion');">Gestión de Investigación</a></li>
                                <li > <a href="#navpills-22" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionProyectosInvestigacion');">Gestion de Proyectos de Investigación</a> </li>-->
                            <?php } if($tab=='extensionProyeccion'){ ?>
                                <li class="active"> <a href="#navpills-3" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('extensionProyeccion');">Extensión y Proyección Social</a> </li>
                                <li > <a href="#navpills-31" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('emprendimiento');">Emprendimiento</a></li>
                                <li > <a href="#navpills-32" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionEgresados');">Gestion de Egresados</a> </li>
                                <li > <a href="#navpills-33" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('educacionContinuada');">Educación Continuada</a> </li>
                                <li > <a href="#navpills-34" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionProyectosExtension');">Gestion de Proyectos de Extensión</a> </li>
                                <li > <a href="#navpills-35" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('escuelaFormacion');">Escuela de Formación para el TDH</a> </li>                                
                            <?php } if($tab=='direccionamientoEstrategico'){ ?>
                                <li class="active"> <a href="#navpills-4" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('direccionamientoEstrategico');">Direccionamiento Estrategico Desarrollo e Innovación</a> </li>
                                <li > <a href="#navpills-41" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('planeacionInstitucional');">Planeación Institucional</a></li>
                                <li > <a href="#navpills-42" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionSistemasInformacion');">Gestion de Sistemas de Información</a> </li>
                                <li > <a href="#navpills-43" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionProyectosInstitucionales');">Gestion de Proyectos Institucionales</a> </li>
                                <li > <a href="#navpills-44" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionCalidad');">Gestión de Calidad</a> </li>
                            <?php } if($tab=='aseguramientoCalidad'){ ?>
                                <li class="active"> <a href="#navpills-5" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('aseguramientoCalidad');">Aseguramiento de la Calidad</a> </li>
                                <li > <a href="#navpills-51" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('autoevaluacionInstitucional');">Autoevaluación Institucional</a></li>
                                <li > <a href="#navpills-52" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('registroCalificado');">Registro Calificado</a> </li>
                                <!--<li > <a href="#navpills-53" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('calidadInstitucional');">Gestion de Calidad</a> </li>-->
                            <?php } if($tab=='visibilidadNacionalInternacional'){ ?>
                                <li class="active"> <a href="#navpills-6" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('visibilidadNacionalInternacional');">Visibilidad Nacional e Internacional</a> </li>
                                <li > <a href="#navpills-61" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('ORI');">Relaciones Interinstitucionales ORI</a></li>
                                <li > <a href="#navpills-62" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('mercadeo');">Mercadeo - Admisiones</a> </li>
                                <li > <a href="#navpills-63" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('comunicacionInstitucional');">Comunicaciones Institucional</a> </li>
                            <?php } if($tab=='bienestarUniversitario'){ ?>
                                <li class="active"> <a href="#navpills-7" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('bienestarUniversitario');">Bienestar Institucional</a> </li>
                            <?php } if($tab=='gestionHumana'){ ?>
                                <li class="active"> <a href="#navpills-8" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionHumana');">Gestión Humana</a> </li>
                                <li > <a href="#navpills-81" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('talentoHumano');">Gestión del Talento Humano</a></li>
                                <li > <a href="#navpills-82" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionSeguridadSaludTrabajo');">Gestión de Seguridad y Salud en el Trabajo</a> </li>
                            <?php } if($tab=='gestionAdministrativaFinanciera'){ ?>
                                <li class="active"> <a href="#navpills-9" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionAdministrativaFinanciera');">Gestión Administrativa y Financiera</a> </li>
                                <li > <a href="#navpills-91" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('financiera');">Gestión Financiera</a></li>
                                <li > <a href="#navpills-92" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('bienesServicios');">Gestión Administrativa</a> </li>
                                <li > <a href="#navpills-93" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionContable');">Gestión Contable y Tesorería</a> </li>
                            <?php } if($tab=='gestionLegalDocumental'){ ?>
                                <li class="active"> <a href="#navpills-100" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionLegalDocumental');">Gestión Legal y Documental</a> </li>
                                <li > <a href="#navpills-101" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionLegal');">Gestión Legal</a></li>
                                <li > <a href="#navpills-102" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionDocumental');">Gestión Documental</a> </li>  
                            <?php } if($tab=='gestionRecursos'){ ?>
                                <li class="active"> <a href="#navpills-111" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('gestionRecursos');">Gestión de Recursos</a> </li>
                                <li > <a href="#navpills-112" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('recursosEducativos');">Recursos Educativos</a></li>
                                <li > <a href="#navpills-113" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('recursosTecnologicos');">Recursos Tecnológicos</a> </li>
                                <li > <a href="#navpills-114" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('recursosFisicos');">Recursos Físicos</a> </li>
                            <?php } ?>
                        </ul>
                        <!-- /inicio tabla row -->
                        <?php if($tab=='docencia'){ ?>
                        <div class="table-responsive">
                            <table id='datatable1'>
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documentos</th>
                                        <th>Cantidad Documentos</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /FIN tabla row -->
        <?php } if($tab=='registroAcademico'){ ?>
            <div id="navpills-11" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!-- /FIN tabla row -->
        <?php } if($tab=='gestionCurricular'){ ?>
            <div id="navpills-12" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- <?php } if($tab=='gestionEducacionVirtual'){ ?>
            <div id="navpills-13" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
		 <!-- /FIN tabla row -->
        <?php } if($tab=='posgrados'){ ?>
            <div id="navpills-14" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		 <!-- /FIN tabla row -->
        <?php } if($tab=='consultorioJuridico'){ ?>
            <div id="navpills-15" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		 <!-- /FIN tabla row -->
        <?php } if($tab=='centroConciliacion'){ ?>
            <div id="navpills-16" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='investigacion'){ ?>
            <div id="navpills-2" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!-- /FIN tabla row -->
        <?php } if($tab=='gestionInvestigacion'){ ?>
            <div id="navpills-21" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
         <?php } if($tab=='gestionProyectosInvestigacion'){ ?>
            <div id="navpills-22" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='extensionProyeccion'){ ?>
            <div id="navpills-3" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='emprendimiento'){ ?>
            <div id="navpills-31" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionEgresados'){ ?>
            <div id="navpills-32" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='educacionContinuada'){ ?>
            <div id="navpills-33" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionProyectosExtension'){ ?>
            <div id="navpills-34" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='escuelaFormacion'){ ?>
            <div id="navpills-35" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='direccionamientoEstrategico'){ ?>
            <div id="navpills-4" class="tab-pane active">
                <div class="row">      
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='planeacionInstitucional'){ ?>
            <div id="navpills-41" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionSistemasInformacion'){ ?>
            <div id="navpills-42" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionProyectosInstitucionales'){ ?>
            <div id="navpills-43" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='aseguramientoCalidad'){ ?>
            <div id="navpills-5" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /FIN tabla row -->
        <?php } if($tab=='autoevaluacionInstitucional'){ ?>
            <div id="navpills-51" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='registroCalificado'){ ?>
            <div id="navpills-52" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='calidadInstitucional'){ ?>
            <div id="navpills-53" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='visibilidadNacionalInternacional'){ ?>
            <div id="navpills-6" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='ORI'){ ?>
            <div id="navpills-61" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='mercadeo'){ ?>
            <div id="navpills-62" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='comunicacionInstitucional'){ ?>
            <div id="navpills-63" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='bienestarUniversitario'){ ?>
            <div id="navpills-7" class="tab-pane active">
                <div class="row">    
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='gestionHumana'){ ?>
            <div id="navpills-8" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='talentoHumano'){ ?>
            <div id="navpills-81" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionSeguridadSaludTrabajo'){ ?>
            <div id="navpills-82" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='gestionAdministrativaFinanciera'){ ?>
            <div id="navpills-9" class="tab-pane active">
                <div class="row">    
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='financiera'){ ?>
            <div id="navpills-91" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='bienesServicios'){ ?>
            <div id="navpills-92" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionContable'){ ?>
            <div id="navpills-93" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <!-- /inicio tabla row -->
        <?php } if($tab=='gestionLegalDocumental'){ ?>
            <div id="navpills-10" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionLegal'){ ?>
            <div id="navpills-101" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='gestionDocumental'){ ?>
            <div id="navpills-102" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->       
        <!-- /inicio tabla row -->
        <?php } if($tab=='gestionRecursos'){ ?>
            <div id="navpills-111" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!-- /FIN tabla row -->
        <?php } if($tab=='recursosEducativos'){ ?>
            <div id="navpills-112" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='recursosTecnologicos'){ ?>
            <div id="navpills-113" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->
        <?php } if($tab=='recursosFisicos'){ ?>
            <div id="navpills-114" class="tab-pane active">
                <div class="row">
                    <div class="table-responsive">
                        <table id='datatable1'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Documentos</th>
                                    <th>Cantidad Documentos</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FIN tabla row -->  
  <?php } ?>
  
  
  
  
  <input id="tabtomado" hidden readonly type="text" name="" value="<?=$tab?>">
            <!-- fin pestaña -->
            <!-- /#wrapper -->
            <!-- jQuery -->
            <script type="text/javascript">
                function cambiarPestania(alias){
                    document.getElementById("tabtomado").value = alias;
                    listar();
                }
            </script>
            <!-- .right-sidebar -->
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
            <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2023 &copy; UNIVIDA </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    
</body>
</html>
