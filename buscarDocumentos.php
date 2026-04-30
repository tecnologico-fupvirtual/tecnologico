<?php

session_start();

if(!isset($_SESSION['id'])) {

  header('Location: index.php');

  exit();

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
<?php include 'header.php'; ?>
<!-- Left navbar-header end -->

    <!-- Page Content -->

    <div id="page-wrapper">

      <div class="container-fluid">

        <div class="row bg-title">

          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">

            <h4 class="page-title">DOCUMENTOS</h4>

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

                    <th>Documento</th>

                    <th>Versión</th>

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

  <div class="row">
    <!-- /.modal -->
    <!--  FORMULARIO PARA ENVIAR DOCUMENTO POR CORREO-->
    <form id="frmEnviarDoc" action="" method="POST">
      <div id="msgEnviarDoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Enviar documento</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                <label for="recipient-name" class="control-label">Enviar a:</label>
                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo sin extensión" required>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label for="message-text" class="control-label">Extensión:</label>
                  <div class="combo">
                  <select class="form-control select2" id="extension" name="extension">
                      <option value="@fup.edu.co">@fup.edu.co</option>
                      <option value="@docente.fup.edu.co">@docente.fup.edu.co</option>
                      <option value="@unividafup.edu.co">@unividafup.edu.co</option>
                      <option value="@gmail.com">@gmail.com</option>
                  </select>
                  </div>
                </div>
              </div>
              </div>
              <!-- <input type="hidden" id="id" name="id"> -->
              <input type="hidden" id="accion" name="accion" value="11">
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="enviarDocumento" class="btn btn-info waves-effect waves-light" data-dismiss="modal">Enviar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

<script src="loading/jquery.blockUI.js"></script>
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
          {"defaultContent":"<button type='button' class='ver btn btn-info btn-circle' data-toggle='modal' data-target='#msg' data-toggle='tooltip' data-placement='top' data-original-title='ver'><i class='fa fa-file-text-o'></i> </button>&nbsp;&nbsp;<button type='button' class='enviar btn btn-warning btn-circle' data-toggle='modal' data-target='#msgEnviarDoc' data-toggle='tooltip' data-placement='top' data-original-title='Enviar'><i class='fa fa-envelope-o'></i> </button>"}],
        "language": {
          "url": "plugins/bower_components/datatables/spanish.json"
        }
      });
      obtener_data_ver("#datatable tbody",table);
      enviarDocumento("#datatable tbody",table);
    }

    var obtener_data_ver = function(tbody,table){
      $(tbody).on("click","button.ver",function(){
        var data = table.row($(this).parents("tr")).data();
        var id = data.id;
        $.ajax({
          method:"POST",
          url:"registro_documentos",
          data:{"accion":8,"id":id}
        }).done(function(respuesta){
          window.open(data.file_dir,"_blank");
        });
      });
    }

    var enviarDocumento = function(tbody,table){
      $(tbody).on("click","button.enviar",function(){
        var data = table.row($(this).parents("tr")).data();
        var idDoc = data.id;
        $("#enviarDocumento").on("click",function(){
          inicioLoading();
          var correo = $("#correo").val();
          var extension = $("#extension").val();
          $.ajax({
            method:"POST",
            url:"registro_documentos.php",
            data:{"accion":11,"idDoc":idDoc,"correo":correo,"extension":extension},
            success: function(info){
              finalizarLoading();
              var json_info = JSON.parse(info);
              mostrar_mensaje(json_info);
              setTimeout(()=>{location.reload()},3500);
              }
            });
          });
        });
      }

    // mensaje loading
    var inicioLoading = ()=>{
      $.blockUI({ message: '<h3>Espere un momento...</h3><div class="spinner-grow" role="status"></div><div class="spinner-grow text-success" role="status"></div><div class="spinner-grow text-warning" role="status"></div><div class="spinner-grow text-info" role="status"></div><div class="spinner-grow text-dark" role="status"></div>' });
    }

    var finalizarLoading = ()=>{
      $.unblockUI();
    }
    // fin

      var mostrar_mensaje = function(informacion){
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