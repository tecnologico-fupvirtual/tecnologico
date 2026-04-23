
<?php

  session_start();

  if(!isset($_SESSION['id'])) {

    header('Location: index.php');

    exit();

  } 

  include 'scripts/utiles.php'; 
?>
<!DOCTYPE html>  

<html lang="en">

<head><meta charset="gb18030">



<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="">

<meta name="author" content="">

<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">

<title>Sistema De Gestión De Calidad</title>

<!-- Bootstrap Core CSS -->

<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<link href="plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">

<!-- Menu CSS -->

<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">

<!-- toast CSS -->

<link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">

<!-- animation CSS -->

<link href="css/animate.css" rel="stylesheet">

<!-- Custom CSS -->

<link href="css/style.css" rel="stylesheet">

<link rel="stylesheet" href="plugins/bower_components/dropify/dist/css/dropify.min.css">

<!-- color CSS -->

<link href="css/colors/blue.css" id="theme"  rel="stylesheet">

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

<div id="wrapper">

  <!-- Top Navigation -->

  <nav class="navbar navbar-default navbar-static-top m-b-0">

    <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>

      <div class="top-left-part"><a class="logo" href="index.html"><b><img src="plugins/images/eliteadmin-logo.png" alt="home" /></b><span class="hidden-xs"><img src="plugins/images/eliteadmin-text.png" alt="home" /></span></a></div>

      <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>

        <li>

          <form role="search" class="app-search hidden-xs">

            <input type="text" placeholder="Search..." class="form-control">

            <a href=""><i class="fa fa-search"></i></a>

          </form>

        </li>

      </ul>

      <ul class="nav navbar-top-links navbar-right pull-right">

        <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-envelope"></i>

          <div class="notify"><span class="heartbit"></span><span class="point"></span></div>

          </a>

          <ul class="dropdown-menu mailbox animated bounceInDown">

            <li>

              <div class="drop-title">You have 4 new messages</div>

            </li>

            <li>

              <div class="message-center"> <a href="#">

                <div class="user-img"> <img src="plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>

                <div class="mail-contnet">

                  <h5>Pavan kumar</h5>

                  <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>

                </a> <a href="#">

                <div class="user-img"> <img src="plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>

                <div class="mail-contnet">

                  <h5>Sonu Nigam</h5>

                  <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>

                </a> <a href="#">

                <div class="user-img"> <img src="plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>

                <div class="mail-contnet">

                  <h5>Arijit Sinh</h5>

                  <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>

                </a> <a href="#">

                <div class="user-img"> <img src="plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>

                <div class="mail-contnet">

                  <h5>Pavan kumar</h5>

                  <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>

                </a> </div>

            </li>

            <li> <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a></li>

          </ul>

          <!-- /.dropdown-messages -->

        </li>

        <!-- /.dropdown -->

        <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-note"></i>

          <div class="notify"><span class="heartbit"></span><span class="point"></span></div>

          </a>

          <ul class="dropdown-menu dropdown-tasks animated slideInUp">

            <li> <a href="#">

              <div>

                <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>

                <div class="progress progress-striped active">

                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>

                </div>

              </div>

              </a> </li>

            <li class="divider"></li>

            <li> <a href="#">

              <div>

                <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>

                <div class="progress progress-striped active">

                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>

                </div>

              </div>

              </a> </li>

            <li class="divider"></li>

            <li> <a href="#">

              <div>

                <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>

                <div class="progress progress-striped active">

                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>

                </div>

              </div>

              </a> </li>

            <li class="divider"></li>

            <li> <a href="#">

              <div>

                <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>

                <div class="progress progress-striped active">

                  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>

                </div>

              </div>

              </a> </li>

            <li class="divider"></li>

            <li> <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a> </li>

          </ul>

          <!-- /.dropdown-tasks -->

        </li>

        <!-- /.dropdown -->

        <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">Steave</b> </a>

          <ul class="dropdown-menu dropdown-user animated flipInY">

            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>

            <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>

            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>

            <li role="separator" class="divider"></li>

            <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>

            <li role="separator" class="divider"></li>

            <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>

          </ul>

          <!-- /.dropdown-user -->

        </li>

        <!-- .Megamenu -->

        <li class="mega-dropdown">

          <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Mega</span> <i class="icon-options-vertical"></i></a>

          <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">

            <li class="col-sm-3">

              <ul>

                <li class="dropdown-header">Forms Elements</li>

                <li><a href="form-basic.html">Basic Forms</a></li>

                            <li><a href="form-layout.html">Form Layout</a></li>

                <li><a href="form-advanced.html">Form Addons</a></li>

                <li><a href="form-material-elements.html">Form Material</a></li> <li><a href="form-float-input.html">Form Float Input</a></li>

                <li><a href="form-upload.html">File Upload</a></li>

                <li><a href="form-mask.html">Form Mask</a></li>

            <li><a href="form-img-cropper.html">Image Cropping</a></li>

                <li><a href="form-validation.html">Form Validation</a></li>

                

              </ul>

            </li>

            <li class="col-sm-3">

              <ul>

                <li class="dropdown-header">Advance Forms</li>

                <li><a href="form-dropzone.html">File Dropzone</a></li>

                <li><a href="form-pickers.html">Form-pickers</a></li>

<li><a href="icheck-control.html">Icheck Form Controls</a></li>

                            <li><a href="form-wizard.html">Form-wizards</a></li>

            <li><a href="form-typehead.html">Typehead</a></li>

                <li><a href="form-xeditable.html">X-editable</a></li>

            <li><a href="form-summernote.html">Summernote</a></li>

                <li><a href="form-bootstrap-wysihtml5.html">Bootstrap wysihtml5</a></li>

                <li><a href="form-tinymce-wysihtml5.html">Tinymce wysihtml5</a></li>



              </ul>

            </li>

            <li class="col-sm-3">

              <ul>

                <li class="dropdown-header">Table Example</li>

                <li><a href="basic-table.html">Basic Tables</a></li> <li><a href="table-layouts.html">Table Layouts</a></li>

                <li><a href="data-table.html">Data Table</a></li>

<li class="hidden"><a href="crud-table.html">Crud Table</a></li>

                <li><a href="bootstrap-tables.html">Bootstrap Tables</a></li>

                <li><a href="responsive-tables.html">Responsive Tables</a></li>

                <li><a href="editable-tables.html">Editable Tables</a></li>

                <li><a href="foo-tables.html">FooTables</a></li>

                <li><a href="jsgrid.html">JsGrid Tables</a></li>

              </ul>

            </li>

            <li class="col-sm-3">

              <ul>

                <li class="dropdown-header">Charts</li>

                <li> <a href="flot.html">Flot Charts</a> </li>

                <li><a href="morris-chart.html">Morris Chart</a></li>

                <li><a href="chart-js.html">Chart-js</a></li>

                <li><a href="peity-chart.html">Peity Charts</a></li>                                     <li><a href="knob-chart.html">Knob Charts</a></li>

                <li><a href="sparkline-chart.html">Sparkline charts</a></li>

                <li><a href="extra-charts.html">Extra Charts</a></li>

              </ul>

            </li>

            <li class="col-sm-12 m-t-40 demo-box">

               <div class="row">

                  <div class="col-sm-2"><div class="white-box text-center bg-purple"><a href="../eliteadmin-inverse/index.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 1</a></div></div>

                  <div class="col-sm-2"><div class="white-box text-center bg-success"><a href="../eliteadmin/index.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 2</a></div></div>

                  <div class="col-sm-2"><div class="white-box text-center bg-info"><a href="../eliteadmin-ecommerce/index.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 3</a></div></div>

                  <div class="col-sm-2"><div class="white-box text-center bg-inverse"><a href="../eliteadmin-horizontal-navbar/index3.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 4</a></div></div>

                  <div class="col-sm-2"><div class="white-box text-center bg-warning"><a href="../eliteadmin-iconbar/index4.html" target="_blank" class="text-white"><i class="linea-icon linea-basic fa-fw" data-icon="v"></i><br/>Demo 5</a></div></div>

                  <div class="col-sm-2"><div class="white-box text-center bg-danger"><a href="https://themeforest.net/item/elite-admin-responsive-web-app-kit-/16750820" target="_blank" class="text-white"><i class="linea-icon linea-ecommerce fa-fw" data-icon="d"></i><br/>Buy Now</a></div></div>

               </div>     

            </li>

          </ul>

        </li>

        <!-- /.Megamenu -->

        <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>

        <!-- /.dropdown -->

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

          </span> </div>

          <!-- /input-group -->

        </li>

        <li> <a href="escritorio.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu"> ESCRITORIO <span class="fa arrow"></span> </span></a>



        </li>

        <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span></a>

          <ul class="nav nav-second-level">

            <li> <a href="procesos.php">Procesos</a> </li>

            <li> <a href="cargos.php">Cargos</a> </li>

            <li> <a href="empleados.php">Empleados</a> </li>

            <li> <a href="usuarios.php">Usuarios</a> </li>

          </ul>

        </li>

        <li> <a href="mapadeprocesos.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span></a>          

        </li>

        <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADO DE MAESTROS<span class="fa arrow"></span></span></a>

          <ul class="nav nav-second-level">

            <li> <a href="listadomaestro.php?r=1">Listado maestro de registro</a> </li>

            <li> <a href="listadomaestro.php?r=0">Listado maestro de documentos</a> </li>

          </ul>

        </li>

        <li> <a href="mapadeprocesos.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">BUSCAR DOCUMENTOS<span class="fa arrow"></span></span></a>          

        </li>        

      </ul>

    </div>

  </div>

  <!-- Left navbar-header end -->

  <!-- Page Content -->

  <div id="page-wrapper">

    <div class="container-fluid">

      <div class="row bg-title">

        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">

          <h4 class="page-title">Editar PQRS</h4>

        </div>
        <!-- /.col-lg-12 -->

      </div>

      <!-- .row -->

      <form id="frmDatos" method="POST" enctype="multipart/form-data">

        <div class="modal-body">                

          <div class="form-group">

            <label for="message-text" class="control-label">PQRS:</label>

            <textarea class="form-control" style="height: 200px" id="descripcionpqr" name="descripcionpqr" readonly="readonly"></textarea>

          </div>      

          <div class="form-group">

            <label for="message-text" class="control-label">Respuesta a la PQRS:</label>

            <textarea class="form-control" style="height: 100px" id="accioninmediata" name="accioninmediata"></textarea>

          </div> 

          <div class="form-group">
      <label class="control-label">Archivo</label>
      <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="10M" name="archivo" id="archivo" />
    </div>

          <div class="form-group bt-switch" id="activo" name="activo">

            <label for="message-text" class="control-label">Cerrar PQRS:</label>

            <input type="checkbox" data-on-color="success" data-off-color="warning" data-on-text="Si" data-off-text="No" id="estado" name="estado" onchange="cambiar_estado();">

            <input type="hidden" id="valor" name="valor">

            <input type="hidden" id="id" name="id">

            <input type="hidden" id="accion" name="accion" value="3">

          </div>            

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>

          <button type="submit" id="guardar-registro" class="btn btn-danger waves-effect waves-light">Guardar</button>

        </div>

      </form>

      <!-- /.row -->

      <!-- .row -->

      

    

      
      <!-- /.row -->

      

      <!-- /.right-sidebar -->


    <!-- /.container-fluid -->

    <footer class="footer text-center"> 2018 &copy; UNIVIDA </footer>

  </div>

  <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->

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

<!--Counter js -->

<script src="plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>

<script src="plugins/bower_components/counterup/jquery.counterup.min.js"></script>

<!-- Custom Theme JavaScript -->

<script src="js/custom.min.js"></script>

<script src="js/dashboard1.js"></script>

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

<!-- Sparkline chart JavaScript -->

<script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>

<script src="plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>

<script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>

<script type="text/javascript">
  
</body>

</html>

