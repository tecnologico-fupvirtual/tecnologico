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
    die('Error de Conexión: ' . mysqli_connect_errno());
  }

  include 'scripts/utiles.php';
  include 'scripts/config.php';

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



    <script src="http://www.w3schools.com/lib/w3data.js"></script>

  </head>

  <body>
<?php include 'header.php'; ?>
<!-- Left navbar-header end -->

  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
      </div>

      <!-- /row -->
      <div class="row">
         <?php
         $query = "SELECT route_img_processMap FROM companies WHERE id = '543e9129-ed48-4e86-b2b8-1204174a8323'";
         $resultadoRuta = mysqli_query($conexion, $query);
         $datoRuta = mysqli_fetch_array($resultadoRuta);
         echo '<center><img src="'.$datoRuta[0].'" usemap="#Map"></center>';
          ?>

        <map name="Map">
              <?php
              $query = "SELECT map_coordinates, alias FROM departments";
              $resultado = mysqli_query($conexion, $query);
              // print_r(var_dump($resultado));
              while($row = mysqli_fetch_array($resultado)){
                echo '<area shape="rect" coords="'.$row[0].'" href="proceso?id='.$row[1].'">';
              }
               ?>
              <!--FUP-->
              <area shape="rect" coords="141, 3, 264, 72" href="http://www.fup.edu.co" target="_blank">

        </map>

      </div>

      <!-- /.row -->





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

    <?php include 'footer.php'; ?>

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



  <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

</body>

</html>
