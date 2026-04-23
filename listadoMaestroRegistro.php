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
  
  <link href="plugins/bower_components/icheck/skins/all.css" rel="stylesheet">


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



<script src="http://www.w3schools.com/lib/w3data.js"></script>

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

       <div class="top-left-part"><a class="logo" href="https://fup.edu.co" target="_blank">&emsp;<b><img src="plugins/images/eliteadmin-logo.png" alt="home" /></b></a></div>

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
            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" id="resultado" name="resultado">
            </div>
        </li>
        <!-- fin notificaciones-->
          
        </li>

        

        <!-- /.dropdown -->

        <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['nombre']; ?></b> </a>

          <ul class="dropdown-menu dropdown-user animated flipInY">
              <li><a href="configuracionCuenta"><i class="ti-settings"></i> Configuración de Perfil</a></li>
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

            </span> </div>

            <!-- /input-group -->

          </li>

          <li> <a href="escritorio" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu"> ESCRITORIO <span class="fa arrow"></span> </span></a>



          </li>

          <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span></a>

            <ul class="nav nav-second-level">

              <li> <a href="procesos">Procesos</a> </li>
              
              <li> <a href="categorias">Categorías</a> </li>

              <li> <a href="cargos">Cargos</a> </li>

              <li> <a href="empleados">Empleados</a> </li>

              <li> <a href="usuarios">Usuarios</a> </li>

            </ul>

          </li>

          <li> <a href="mapadeprocesos.php" class="waves-effect "><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span></a>          

          </li>

          <li> <a href="#" class="waves-effect active" ><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADO DE MAESTROS<span class="fa arrow"></span></span></a>

            <ul class="nav nav-second-level">

              <li> <a href="listadoMaestroRegistro">Listado maestro de registro</a> </li>
              <li> <a href="listadoMaestroDocumentos">Listado maestro de documentos</a> </li>
              <li> <a href="documentosDescargados">Informe documentos descargados</a> </li>

            </ul>
            
            <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">CONFIGURACIÓN<span class="fa arrow"></span></span></a>

          <ul class="nav nav-second-level">

            <li> <a href="form-img-cropper.php">Mapa de procesos</a> </li>

          </ul>

        </li>

          </li>

          <li> <a href="buscarDocumentos" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">BUSCAR DOCUMENTOS<span class="fa arrow"></span></span></a>          

          </li> 
          
          <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">SOLICITUDES SGC <span class="fa arrow"></span></span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="https://forms.office.com/r/Dy28fet3Xv" target="_blank">Solicitud de cambio al SGC - FUP</a> </li>
                                <li> <a href="https://forms.office.com/r/QRb71zfT90" target="_blank">Reporte No-Conformidad</a> </li>
                                <li> <a href="https://forms.office.com/r/Bev2TbAwkj" target="_blank">Reporte salida No-Conforme</a> </li>
                            </ul>
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

            <h4 class="page-title">LISTADO MAESTRO DE REGISTRO</h4>

          </div>



        </div>



        <!-- /row -->

        <div class="row">

          

          <div class="col-sm-12">

            <div class="white-box">
                
              
              
              <h3 class="box-title m-b-0">Exportar datos</h3>

              <div class="table-responsive">
             

              <table id='datatable' class='display nowrap' cellspacing='0' width='100%'>

                <thead>

                  <tr>

                    <th>Nombre</th>

                    <th>Versión</th>
                    
                    <th>Físico</th>
                    
                    <th>Digital</th>
                    
                    <th>Almacenamiento</th>
                    
                    <th>Protección</th>
                    
                    <th>Recuperación</th>
                    
                    <th>AP</th>
                    
                    <th>AC</th>
                    
                    <th>Disposición</th>

                    <th>Ver</th>

                  </tr>

                </thead>

              </table>

              </div>

            </div>

          </div>

        </div>

        <!-- /.row -->



        <!-- /row -->

        

        

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





  <!-- Custom Theme JavaScript -->

  <script src="js/custom.min.js"></script>

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



  <script>  

    

    $(document).on("ready", function(){

      listar(5);

    });





    var listar = function(accion){

      var table = $('#datatable').DataTable({

        destroy:true,

        dom: 'Blfrtip',

        buttons: [

        'csv', 'pdf', 'print'

        ],

        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "ajax":{

          "method":"POST",

          "url":"registro_documentos.php",

          "data": {"accion":accion}

        },

        "columns":[

        {"data":"file_details"},

        {"data":"version"},
        
        {"data":"fisico"},
        
        {"data":"digital"},
        
        {"data":"almacenamiento"},
        
        {"data":"proteccion"},
        
        {"data":"recuperacion"},
        
        {"data":"ap"},
        
        {"data":"ac"},
        
        {"data":"disposicion"},

        {"defaultContent":"<button type='button' class='ver btn btn-info btn-circle' data-toggle='modal' data-target='#msg' data-toggle='tooltip' data-placement='top' data-original-title='Ver'><i class='fa fa-file-text-o'></i> </button>"}],

        "language": {

          "url": "plugins/bower_components/datatables/spanish.json"

        }

      });

      

      obtener_data_ver("#datatable tbody",table);

     

    } 




    

    var obtener_data_ver = function(tbody,table){

      $(tbody).on("click","button.ver",function(){

        var data = table.row($(this).parents("tr")).data();
        
        window.open(data.file_dir,"_blank");  

      });

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

  

  <!-- bt-switch -->

  

</body>

</html>

