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
  <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">



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

            <li> <a href="escritorio.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu"> ESCRITORIO <span class="fa arrow"></span> </span></a>



            </li>

            <li> <a href="#" class="waves-effect active"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span></a>
              <ul class="nav nav-second-level">
                <li> <a href="procesos">Procesos</a> </li>
                <li> <a href="categorias">Categorias</a> </li>
                <li> <a href="cargos">Cargos</a> </li>
                <li> <a href="empleados">Empleados</a> </li>
                <li> <a href="usuarios">Usuarios</a> </li>
              </ul>
            </li>
            <li> <a href="mapadeprocesos" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span></a>
            </li>

            <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADO DE MAESTROS<span class="fa arrow"></span></span></a>

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

              <h4 class="page-title">USUARIOS</h4>

            </div>



          </div>



          <!-- /row -->

          <div class="row">



            <div class="col-sm-12">

              <div class="white-box">

                <button type="button" class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="top" data-original-title="Total" onclick="listar(1);"><i id="ct"></i></button>&nbsp;&nbsp;&nbsp;

                <button type="button" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="top" data-original-title="Publicados" onclick="listar(2);"><i id="cp"></i></button>&nbsp;&nbsp;&nbsp;

                <button type="button" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" data-original-title="No publicados" onclick="listar(6);"><i id="cnp"></i></button>&nbsp;&nbsp;&nbsp;

                <button class="fcbtn btn btn-info btn-outline btn-1e" data-toggle='modal' data-target='#responsive-modal' onclick="nuevo();">Nuevo</button>

                <h3 class="box-title m-b-0">Exportar datos</h3>

                <div class="table-responsive">

                  <table id='datatable' class='display nowrap' cellspacing='0' width='100%'>

                    <thead>

                      <tr>

                        <th>Nombre</th>
                        <th>Administrador</th>
                        <th>Correo</th>
                        <th>Publicar</th>
                        <th>Acciones</th>

                      </tr>

                    </thead>

                  </table>

                </div>

              </div>

            </div>

          </div>

          <!-- /.row -->



          <!-- /row -->

          <div class="row">

            <!-- /.modal -->

            <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

              <div class="modal-dialog">

                <div class="modal-content">

                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                  <h4 class="modal-title">Usuario</h4>
                  </div>
                  <form action="frmDatos" method="POST">
                    <div class="modal-body">
                      <input type="hidden" id="accion" name="accion" value="3">
                      <div class="form-group">
                        <label for="message-text" id=mensaje_empleado name=mensaje_empleado class="control-label">Empleado:</label>
                        <div class="combo">
                          <select class="form-control selectpicker" id="empleado" name="empleado" data-live-search="true" data-size="10" data-width="100%" title="Seleccione un empleado">
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="message-text" id=mensaje_contrasena name=mensaje_contrasena class="control-label">Contraseña: </label>
                        <input type="password" class="form-control" placeholder=" &#128272; Digite aquí su contraseña" id="contrasena" name="contrasena" required="true">
                      </div>
                      <div class="form-group">
                        <label for="message-text" id=mensaje_cambio_contrasena name=mensaje_cambio_contrasena class="control-label">Cambio de contraseña:</label>
                        <input type="password" class="form-control" placeholder=" &#128272; Digite aquí su nueva contraseña" id="edit_password" name="edit_password">
                      </div>
                      <div class="form-group bt-switch" id="activo" name="activo">
                        <label for="message-text" class="control-label">Activo: </label>
                        <input type="checkbox" data-on-color="success" data-off-color="warning" data-on-text="Si" data-off-text="No" id="estado" name="estado" onchange="cambiar_estado();">
                        <input type="hidden" id="valor" name="valor">
                      </div>
                      <!-- Campo Administrador-->
                      <div class="form-group bt-switch" id="administrador" name="administrador">
                        <label for="message-text" class="control-label">Administrador: </label>
                        <input type="checkbox" data-on-color="success" data-off-color="warning" data-on-text="Si" data-off-text="No" id="estado_Admin" name="estado_Admin" onchange="cambiar_estado_Admin();">
                        <input type="hidden" id="valorAdmin" name="valorAdmin">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                      <button type="submit" id="guardar-registro" class="btn btn-danger waves-effect waves-light">Guardar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>





          <div class="row">
            <!-- /.modal -->

            <form id="frmEliminar" action="" method="POST">

              <div id="msgeliminar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                  <div class="modal-content">

                    <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                      <h4 class="modal-title">Eliminar Usuario</h4>

                    </div>

                    <div class="modal-body">

                      <div class="form-group">

                        <label for="recipient-name" class="control-label">¿Está seguro de eliminar el Usuario?</label>

                        <input type="hidden" id="id" name="id">

                        <input type="hidden" id="accion" name="accion" value="4">

                      </div>

                    </div>

                    <div class="modal-footer">

                      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>

                      <button type="button" id="eliminar-registro" class="btn btn-info waves-effect waves-light" data-dismiss="modal">Aceptar</button>

                    </div>

                  </div>

                </div>

              </div>

            </form>

          </div>

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

        <footer class="footer text-center"> <?php echo $anio ?> &copy; UNIVIDA </footer>

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
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js"></script>



    <script>



    $(document).on("ready", function(){

      listar(1);

      guardar();

      eliminarRegistro();

      inicializarBuscadorEmpleado();

    });

    var inicializarBuscadorEmpleado = function(){
      $('#empleado').selectpicker({
        liveSearch: true,
        noneResultsText: 'No se encontraron resultados para {0}'
      });
    }

    var refrescarComboEmpleados = function(datos){
      $('.combo select').html(datos);
      $('#empleado').selectpicker('refresh');
    }



    var guardar = function(){

      $("form").on("submit",function(e){

        e.preventDefault();

        var frm = $(this).serialize();
        console.log(frm);

        $.ajax({

          method:"POST",

          url:"registro_usuarios.php",

          data:frm

        }).done(function(info){

          var json_info = JSON.parse(info);

          mostrar_mensaje(json_info);

          listar(1);

        });

      });
    }



    var eliminarRegistro = function(){

      $("#eliminar-registro").on("click",function(){

        var id = $("#frmEliminar #id").val(),

        accion = $("#frmEliminar #accion").val();

        $.ajax({

          method:"POST",

          url:"registro_usuarios.php",

          data:{"id":id,"accion":accion}

        }).done(function(info){

          var json_info = JSON.parse(info);

          mostrar_mensaje(json_info);

          listar(1);

        });

      });

    }



    var mostrar_mensaje = function(informacion){
      console.log(informacion.respuesta);
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



    var nuevo = function(){
      limpiar_cajas();
      $("#mensaje_contrasena").css("display", "block");
      $("#contrasena").css("display", "block");
      $("#contrasena").prop('required',true);
      $("#activo").css("display", "none");
      $("#administrador").css("display","none");
      $("#mensaje_empleado").css("display", "none");
      $("#edit_password").css("display", "none");
      $("#empleado").css("display", "block");
      $("#mensaje_empleado").css("display", "block");
      $("#mensaje_cambio_contrasena").css("display", "none");

      $.ajax({
        type: "POST",
        url: "registro_usuarios.php",
        data:{"accion":9,"seleccionado":"-1000","tabla":"employees","condicion":"where employees.soft_delete = 0 and employees.publish = 1"},
        success: function(datos)
        {
          refrescarComboEmpleados(datos);
        }
      });
    }

    var mostrar_activo = function(){
      $("#mensaje_contrasena").css("display", "none");
      $("#contrasena").css("display", "none");
      $("#contrasena").prop('required',false);
      $("#activo").css("display", "block");
      $("#administrador").css("display","block");
      $("#edit_password").css("display", "none");
      $("#empleado").css("display", "block");
      $("#mensaje_cambio_contrasena").css("display", "none");
    }

    var editar_contrasena = function(){
      $("#mensaje_contrasena").css("display", "none");
      $("#contrasena").css("display", "none");
      $("#contrasena").prop('required',false);
      $("#activo").css("display", "none");
      $("#administrador").css("display","none");
      $("#mensaje_empleado").css("display", "none");
      $("#edit_password").css("display", "block");
      $("#empleado").css("display", "none");
      $("#mensaje_cambio_contrasena").css("display", "block");

    }

    var limpiar_cajas = function(){

      $("#accion").val("5");

      //$("#nombre").val("").focus();

      $("#contrasena").val("");

    }



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

          "url":"registro_usuarios.php",

          "data": {"accion":accion}

        },

        "columns":[

          {"data":"name"},

          {"data":"view_all"},

          {"data":"username"},

          {"data":"publish"},

          {"defaultContent":"<button type='button' class='editar btn btn-success btn-circle' data-toggle='modal' data-target='#responsive-modal' data-toggle='tooltip' data-placement='top' data-original-title='Editar' onclick='mostrar_activo()'><i class='fa fa-edit'></i> </button>&nbsp;&nbsp;<button type='button' class='editar_contrasena btn btn-info btn-circle' data-toggle='modal' data-target='#responsive-modal' data-toggle='tooltip' data-placement='top' data-original-title='Editar_contrasena' onclick='editar_contrasena()'><i class='fa fa-key'></i> </button>&nbsp; <button type='button' class='eliminar btn btn-danger btn-circle' data-toggle='modal' data-target='#msgeliminar' data-toggle='tooltip' data-placement='top' data-original-title='Eliminar'> <i class='fa  fa-trash-o'></i>"}

        ],

        "language": {

          "url": "plugins/bower_components/datatables/spanish.json"

        }

      });

      obtener_data_editar("#datatable tbody",table);

      obtener_id_eliminar("#datatable tbody",table);

      obtener_cambio_contrasena("#datatable tbody",table);

      cargar_totales();

    }



    var cargar_totales = function(){

      $.ajax({

        type: "POST",

        url:"registro_usuarios.php",

        data:{"accion":8,"tabla":"users","condicion":""},

        success: function(datos){

          $('#ct').html(datos);

        }

      });

      $.ajax({

        type: "POST",

        url:"registro_usuarios.php",

        data:{"accion":8,"tabla":"users","condicion":"where users.soft_delete = 0 and users.publish = 1"},

        success: function(datos){

          $('#cp').html(datos);

        }

      });

      $.ajax({

        type: "POST",

        url:"registro_usuarios.php",

        data:{"accion":8,"tabla":"users","condicion":"where users.soft_delete = 0 and users.publish = 0"},

        success: function(datos){

          $('#cnp').html(datos);

        }

      });

    }


    var cambiar_estado = function(){

      if($('#estado').bootstrapSwitch('state')==true)

      $("#valor").val("1");

      else

      $("#valor").val("0");

    }
    var cambiar_estado_Admin = function(){

      if($('#estado_Admin').bootstrapSwitch('state')==true)

      $("#valorAdmin").val("1");

      else

      $("#valorAdmin").val("0");

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

    var obtener_data_editar = function(tbody,table){

      $(tbody).on("click","button.editar",function(){

        var data = table.row($(this).parents("tr")).data();

        if (data.estado == 1) {

          $('#estado').bootstrapSwitch('state', true);

        }else{

          $('#estado').bootstrapSwitch('state', false);
        }

        if (data.is_view_all == 1) {

          $('#estado_Admin').bootstrapSwitch('state', true);

        }else{

          $('#estado_Admin').bootstrapSwitch('state', false);
        }

        $.ajax({

          type: "POST",

          url: "registro_usuarios.php",

          data:{"accion":9,"seleccionado":data.id_empleado,"tabla":"employees","condicion":"where employees.soft_delete = 0 and employees.publish = 1"},
          success: function(datos)

          {

            refrescarComboEmpleados(datos);

          }

        });

        var idproceso = $("#id").val(data.id),
        nombre = $("#nombre").val(data.name),
        contrasena = $("#email").val(data.username),
        accion = $("#accion").val("3")

      });

    }

    var obtener_id_eliminar = function(tbody,table){

      $(tbody).on("click","button.eliminar",function(){

        var data = table.row($(this).parents("tr")).data();

        var idproceso = $("#frmEliminar #id").val(data.id)

      });

    }

    var obtener_cambio_contrasena = function(tbody,table){
      $(tbody).on("click","button.editar_contrasena",function(){
        var data = table.row($(this).parents("tr")).data();
        $.ajax({
          type: "POST",
          url: "registro_usuarios.php",
          data:{"accion":9,"seleccionado":data.id_empleado,"tabla":"employees","condicion":"where employees.soft_delete = 0 and employees.publish = 1"},
          success: function(datos)
          {
            refrescarComboEmpleados(datos);
          }
        });
        var empleado = $("#empleado").val(data.id_empleado),
        accion = $("#accion").val("10")
      });
    }

    </script>

    <!-- bt-switch -->

    <script src="plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js"></script>

    <script type="text/javascript">

    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();

    var radioswitch = function() {

      var bt = function() {

        $(".radio-switch").on("switch-change", function() {

          $(".radio-switch").bootstrapSwitch("toggleRadioState")

        }),

        $(".radio-switch").on("switch-change", function() {

          $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")

        }),

        $(".radio-switch").on("switch-change", function() {

          $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)

        })

      };

      return {

        init: function() {

          bt()

        }

      }

    }();

    $(document).ready(function() {

      radioswitch.init()

    });

    </script>

    <!--Style Switcher -->

    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

  </body>

  </html>
