
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
<?php include 'header.php'; ?>
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

