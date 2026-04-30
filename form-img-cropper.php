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



  include 'scripts/utiles.php';
  include 'scripts/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="big5">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
<title>isoCalidad</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Cropper CSS -->
<link href="plugins/bower_components/cropper/cropper.min.css" rel="stylesheet">
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
<link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
<!-- <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="js/toastr.js"></script> -->
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
          <h4 class="page-title">COORDENADAS MAPA DE PROCESOS</h4>
        </div>
      </div>

      <!-- .row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box">
            <div class="row">
              <!-- .Your image -->
              <div class="col-md-9 p-20">
                <div class="img-container">
                  <?php
                  $query = "SELECT route_img_processMap FROM companies WHERE id = '543e9129-ed48-4e86-b2b8-1204174a8323'";
                  $resultadoRuta = mysqli_query($conexion, $query);
                  $datoRuta = mysqli_fetch_array($resultadoRuta);
                  echo '<img id="image" src="'.$datoRuta[0].'" class="img-responsive" alt="Picture"></div>';
                   ?>
              </div>
              <!-- /.Your image -->

              <!-- .Croping image -->
              <div class="col-md-3 p-20">
                <div class="docs-preview clearfix">
                  <div class="img-preview preview-lg"></div>
                </div>

                    <center><form id="guardar-imagen" action="" enctype="multipart/form-data">
                      <label class="btn btn-info btn-circle">
                      <input type="file" class="sr-only"name="Image" accept="image/*">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Examinar"> <span class="fa fa-upload"></span> </span> </label>
                      <label class="btn btn-success btn-circle">
                      <input type="submit" class="sr-only">
                      <span class="docs-tooltip" data-toggle="tooltip" title="Guardar"> <span class="fa fa-floppy-o"></span> </span></label>
                      <div><input type="hidden" name="accion" value="3"></div>
                    </form></center>

                        <form id="frmDatos" method="POST">
                          <div class="modal-body">
                            <div class="form-group">
                              <div class="input-group input-group-sm">
                              <label class="input-group-addon" id=mensaje_proceso name=mensaje_proceso class="control-label">Proceso:</label>
                              <div class="combo">
                                <select id="cbx_proceso" name="cbx_proceso" style= width:100%>
                                </select>
                              </div>
                              </div>
                            </div>
                            <div class="form-group">
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataX">X</label>
                              <input type="text" class="form-control" id="dataX" name="dataX" placeholder="x">
                              <span class="input-group-addon">px</span> </div>
                            </div>
                            <div class="form-group">
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataY">Y</label>
                              <input type="text" class="form-control" id="dataY" name="dataY" placeholder="y">
                              <span class="input-group-addon">px</span> </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group input-group-sm">
                                <label class="input-group-addon" for="dataWidth">Ancho</label>
                                <input type="text" class="form-control" id="dataWidth" name="dataWidth" placeholder="Ancho">
                                <span class="input-group-addon">px</span> </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group input-group-sm">
                                <label class="input-group-addon" for="dataHeight">Alto</label>
                                <input type="text" class="form-control" id="dataHeight" name="dataHeight" placeholder="Alto">
                                <span class="input-group-addon">px</span> </div>
                          </div>
                          <div>
                            <input type="hidden" name="accion" value="2">
                          </div>
                          <div class="modal-footer">
                            <center><button type="submit" id="guardar-coordenada" class="btn btn-danger waves-effect waves-light">Guardar Coordenada</button></center>
                          </div>
                        </form>
                      </div>
                </div>
              </div>
              <!-- /.Croping of image -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12">

            <div class="row">
              <div class="col-md-9 docs-buttons">
                <!-- .btn groups -->

                <!-- Show the cropped image in modal -->
                <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                      </div>
                      <div class="modal-body"></div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a> </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.btn groups -->

            <!-- /.btn groups -->
            </div>

        </div>
      </div>
      <!-- /.row -->
      <!-- .right-sidebar -->
      <div class="right-sidebar">
        <div class="slimscrollright">
          <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
          <div class="r-panel-body">
            <ul>
              <li><b>Layout Options</b></li>
              <li>
                <div class="checkbox checkbox-info">
                  <input id="checkbox1" type="checkbox" class="fxhdr">
                  <label for="checkbox1"> Fix Header </label>
                </div>
              </li>
            </ul>
            <ul id="themecolors" class="m-t-20">
              <li><b>With Light sidebar</b></li>
              <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
              <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
              <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
              <li><a href="javascript:void(0)" theme="blue" class="blue-theme working">4</a></li>
              <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
              <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
              <li><b>With Dark sidebar</b></li>
              <br/>
              <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
              <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
              <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>
              <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
              <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
              <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
            </ul>
            <ul class="m-t-20 chatonline">
              <li><b>Chat option</b></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a></li>
              <!-- <li><a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg" alt="user-img"  class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/ritesh.jpg" alt="user-img"  class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/john.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a></li>
              <li><a href="javascript:void(0)"><img src="plugins/images/users/pawandeep.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a></li> -->
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
<!-- Image cropper JavaScript -->
<script src="plugins/bower_components/cropper/cropper.min.js"></script>
<script src="plugins/bower_components/cropper/cropper-init.js"></script>
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

<script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="js/toastr.js"></script>

<script>
$(document).on("ready", function(){
met();
imagen();
guardarCoordenada();
});

var met = function(){
  $.ajax({
    method:"POST",
    url:"registro_coordinates.php",
    data:{"accion":1},
    success: function(datos)
    {
      $('.combo select').html(datos);
    }
  });
}

var guardarCoordenada = function(){
  $("#frmDatos").on("submit",function(e){
  e.preventDefault();
    var frm = $(this).serialize();
    $.ajax({
      method:"POST",
      url:"registro_coordinates.php",
      data:frm
    }).done(function(info){
      var json_info = JSON.parse(info);
       mostrar_mensaje(json_info);
    });
  });
}

var imagen = function(){
  $("#guardar-imagen").on("submit",function(e){
    e.preventDefault();
    // alert("prueba alerta");
    var frm = new FormData($("#guardar-imagen")[0]);
    // console.log(frm);
    $.ajax({
      method:"POST",
      url:"registro_coordinates.php",
      data:frm,
      contentType: false, // no envia informacion por encabezado
      processData: false // no convierte los datos en cadena de texto
    }).done(function(info){
      // alert(info);
      var json_info = JSON.parse(info);
      mostrar_mensaje(json_info);
      if (json_info.respuesta == 'BIEN'){
        setTimeout(function(){location.reload();},3600);
      }
    });
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

var mostrar_mensaje = function(informacion){
   // console.log(informacion.respuesta);
  if(informacion.respuesta == 'BIEN'){
    $.toast({
      heading: 'QMS Calidad',
      text: 'Los cambios se realizaron satisfactoriamente.',
      position: 'top-right',
      loaderBg:'#ff6849',
      icon: 'success',
      hideAfter: 3500,
      stack: 6
    });
  }else if(informacion.respuesta == 'ERROR'){
    $.toast({
      heading: 'QMS Calidad',
      text: 'No se realizaron cambios.',
      position: 'top-right',
      loaderBg:'#ff6849',
      icon: 'error',
      hideAfter: 3500
    });
  }else if(informacion.respuesta == 'EXISTE'){
    $.toast({
      heading: 'QMS Calidad',
      text: 'El registro ya existe en el sistema.',
      position: 'top-right',
      loaderBg:'#ff6849',
      icon: 'warning',
      hideAfter: 3500,
      stack: 6
    });
  }
}

</script>
</body>
</html>
