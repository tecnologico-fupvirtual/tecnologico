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

</head>

<body>
<?php include 'header.php'; ?>
<!-- Left navbar-header end -->

      <!--listado de los procesos-->



      <!-- inicio pestaña -->

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body" id="tabs">
              <ul class="nav nav-pills m-b-30 ">

                <?php if($tab=='planeacionInstitucional'){ ?>
                  <li class="active"> <a href="#navpills-1" data-toggle="tab" aria-expanded="false">Planeación Institucional</a> </li>
                <?php } 
if($tab=='visibilidadNacionalInternacional'){ ?>
                  <li class="active"> <a href="#navpills-26" data-toggle="tab" aria-expanded="false">Visibilidad Nacional e Internacional</a> </li>
                <?php }
if($tab=='aseguramientoCalidad'){ ?>
                  <li class="active"> <a href="#navpills-2" data-toggle="tab" aria-expanded="false">Aseguramiento Calidad</a> </li>
                <?php } if($tab=='direccionamientoEstrategico'){ ?>
                  <li class="active"> <a href="#navpills-3" data-toggle="tab" aria-expanded="false">Direccionamiento Estratégico</a> </li>
                <?php } if($tab=='calidadInstitucional'){  ?>
                  <li class="active"> <a href="#navpills-4" data-toggle="tab" aria-expanded="false">Calidad Institucional</a> </li>
                <?php } if($tab=='admisionesRegistro'){  ?>
                  <li class="active"> <a href="#navpills-5" data-toggle="tab" aria-expanded="false">Admisiones y Registro</a> </li>
                <?php } if($tab=='recursosEducativos'){  ?>
                  <li class="active"> <a href="#navpills-6" data-toggle="tab" aria-expanded="false">Recursos Educativos</a> </li>
                <?php } if($tab=='bienestarUniversitario'){  ?>
                  <li class="active"> <a href="#navpills-7" data-toggle="tab" aria-expanded="false">Bienestar Universitario</a> </li>
                <?php } if($tab=='bienesServicios'){  ?>
                  <li class="active"> <a href="#navpills-8" data-toggle="tab" aria-expanded="false">Bienes y Servicios</a> </li>
                <?php } if($tab=='comunicacionInstitucional'){  ?>
                  <li class="active"> <a href="#navpills-9" data-toggle="tab" aria-expanded="false">Comunicación Institucional</a> </li>
                <?php } if($tab=='recursosTecnologicos'){  ?>
                  <li class="active"> <a href="#navpills-10" data-toggle="tab" aria-expanded="false">Recursos Tecnológicos</a> </li>
                <?php } if($tab=='laboratorioMetrologia'){  ?>
                  <li class="active"> <a href="#navpills-11" data-toggle="tab" aria-expanded="false">Laboratorio Metrologia</a> </li>
                <?php } if($tab=='talentoHumano'){  ?>
                  <li class="active"> <a href="#navpills-12" data-toggle="tab" aria-expanded="false">Talento Humano</a> </li>
                  <li > <a href="#navpills-24" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('sistemaSeguridadSaludTrabajo');">Sistema de seguridad y salud en el trabajo</a> </li>
                <?php } if($tab=='financiera'){  ?>
                  <li class="active"> <a href="#navpills-13" data-toggle="tab" aria-expanded="false">Financiera</a> </li>
                <?php } if($tab=='mercadeo'){  ?>
                  <li class="active"> <a href="#navpills-14" data-toggle="tab" aria-expanded="false">Mercadeo</a> </li>
                <?php } if($tab=='docencia'){  ?>
                  <li class="active"> <a href="#navpills-15" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('docencia');">Docencia</a> </li>
                  <li > <a href="#navpills-16" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('posgrados');">Posgrados</a></li>
                  <li > <a href="#navpills-23" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('ori');">ORI</a> </li>
                  <li > <a href="#navpills-18" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('UNIVIDA');">UNIVIDA</a> </li>
                  <li> <a href="#navpills-19" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('centroConciliacion');">Centro Conciliación</a> </li>
                  <li > <a href="#navpills-20" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('consultorioJuridico');">Consultorio Jurídico</a> </li>
                <?php } if($tab=='investigacion'){  ?>
                  <li class="active"> <a href="#navpills-21" data-toggle="tab" aria-expanded="false">Investigación</a> </li>
                <?php } if($tab=='extensionProyeccion'){  ?>
                  <li class="active"> <a href="#navpills-22" data-toggle="tab" aria-expanded="false">Extensión y Proyección Social</a> </li>
                  <li > <a href="#navpills-17" data-toggle="tab" aria-expanded="false" onclick="cambiarPestania('escuelaFormacion');">Escuela de Formación</a> </li>
                <?php } ?>
              </ul>

              <!-- /inicio tabla row -->
              <?php if($tab=='planeacionInstitucional'){ ?>
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

        <?php } if($tab=='aseguramientoCalidad'){ ?>
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

      <?php } if($tab=='direccionamientoEstrategico'){ ?>
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

    <?php } if($tab=='calidadInstitucional'){ ?>
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
  </div>
  </div>
  <?php } if($tab=='admisionesRegistro'){ ?>
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
  </div>
  </div>
  <?php } if($tab=='recursosEducativos'){ ?>
    <div id="navpills-6" class="tab-pane active">
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
  </div>
  </div>
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
  </div>
  </div>
  <?php } if($tab=='bienesServicios'){ ?>
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
  </div>
  </div>
  <?php } if($tab=='comunicacionInstitucional'){ ?>
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
  </div>
  </div>
  <?php } if($tab=='recursosTecnologicos'){ ?>
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
  <!-- /.inicio modal -->
  </div>
  </div>
  <?php } if($tab=='laboratorioMetrologia'){ ?>
    <div id="navpills-11" class="tab-pane active">
      <div class="row">
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
  </div>
  </div>
  <?php } if($tab=='talentoHumano'){ ?>
    <div id="navpills-12" class="tab-pane active">
      <div class="row">
        <div class="col-md-12">
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
    </div>
    <!-- /FIN tabla row -->
  </div>
  </div>
  <?php } if($tab=='financiera'){ ?>
    <div id="navpills-13" class="tab-pane active">
      <div class="row">
        <div class="col-md-12">
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
    </div>
  </div>
  <?php } if($tab=='mercadeo'){ ?>
    <div id="navpills-14" class="tab-pane active">
      <div class="row">
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
  </div>
  </div>
  <?php } if($tab=='docencia'){ ?>
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
  </div>
  </div>
  <?php } if($tab=='investigacion'){ ?>
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
</div>
  </div>
  <?php } if($tab=='visibilidadNacionalInternacional'){ ?>
    <div id="navpills-25" class="tab-pane active">
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
  </div>
  </div>
  <?php } if($tab=='extensionProyeccion'){ ?>
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
  </div>
  </div>
  <?php } ?>
  </div>
  </div>
  </div>
  </div>
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
        $(document).on("ready", function(){
            listar();
        });
        var listar = function(){
            var table = $("#datatable1").DataTable({
                destroy:true,
                dom: '',
                buttons: ['csv', 'pdf', 'print'],
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
        var cambiarPaginaDocumentos=function(tbody,table){
            $(tbody).on("click","button.cambiar",function(){
                var data = table.row($(this).parents("tr")).data();
                var id_proceso = data['id'];
                console.log(data);
                location.href='documentos.php?id_proceso='+id_proceso;
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
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
