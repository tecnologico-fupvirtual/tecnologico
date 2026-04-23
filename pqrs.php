<?php
session_start();
if(!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}
if(isset($_GET['accion'])) 
  $accion=$_GET['accion'];
else
  $accion=9;

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
  <!-- Date picker plugins css -->
  <link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
  <!-- Daterange picker plugins css -->
  <link href="plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- color CSS -->
  <link href="css/colors/blue.css" id="theme"  rel="stylesheet">
  <link rel="stylesheet" href="plugins/bower_components/dropify/dist/css/dropify.min.css">
  
  <!-- Se agrega esta nueva linea de codigo  -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 
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
  <div class="preloader">

    <div class="cssload-speeding-wheel"></div>

  </div>

  <div id="wrapper">

    <!-- Navigation -->

    <nav class="navbar navbar-default navbar-static-top m-b-0">

      <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>

        <div class="top-left-part"><a class="logo" href="https://fup.edu.co" target="_blank">&emsp;<b><img src="plugins/images/eliteadmin-logo.png" alt="home" /></b></a></div>

        <ul class="nav navbar-top-links navbar-left hidden-xs">

          <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>

          <!--<li>

            <form role="search" class="app-search hidden-xs">

              <input type="text" placeholder="Search..." class="form-control">

              <a href=""><i class="fa fa-search"></i></a>

            </form>

          </li>-->

        </ul>

        <ul class="nav navbar-top-links navbar-right pull-right">



          <!-- /.dropdown -->



          <!-- /.dropdown -->

          <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['nombre']; ?></b> </a>

           <ul class="dropdown-menu dropdown-user animated flipInY">

            <li><a href="#"><i class="ti-user"></i> Mi perfil</a></li>



            <li><a href="configuracionCuenta"><i class="ti-settings"></i> Configuración de cuenta</a></li>

            <li role="separator" class="divider"></li>

            <li><a href="scripts/admin.php?action=2"><i class="fa fa-power-off"></i> Cerrar sesion</a></li>

          </ul>

          <!-- /.dropdown-user -->

        </li>



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
        <li> <a href="#" class="waves-effect active"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">DATOS DE ENTRADA<span class="fa arrow"></span></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="procesos.php">Procesos</a> </li>
            <li> <a href="cargos.php">Cargos</a> </li>
            <li> <a href="empleados.php">Empleados</a> </li>
            <li> <a href="usuarios.php">Usuarios</a> </li>
          </ul>
        </li>
        <li> <a href="mapadeprocesos.php" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">MAPA DE PROCESOS<span class="fa arrow"></span></span></a>          
        </li>
        <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LISTADOS MAESTROS<span class="fa arrow"></span></span></a>
          <ul class="nav nav-second-level">
            <li> <a href="listadomaestro.php?r=1">Listado maestro de registro</a> </li>
            <li> <a href="listadomaestro.php?r=0">Listado maestro de documentos</a> </li>
          </ul>
        </li>

        <li> <a href="#" class="waves-effect"><i class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">CONFIGURACIÓN<span class="fa arrow"></span></span></a>

        <ul class="nav nav-second-level">

         <li> <a href="form-img-cropper.php">Mapa de procesos</a> </li>

          </ul>

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
          <h4 class="page-title">PQRS<?php if($accion == 10) echo ' Cerradas'; if($accion == 11) echo ' Abiertas';?></h4>
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
                  <th>No.</th>
                  <th>Nombre solicitante</th>
                  <th>Asignado a</th>
                  <th>Reporte</th>
                  <th>Vencimiento</th>
                  <th>Cierre</th>
                  <th>Confirmación Lectura</th>
                  <th>Responder</th>
                </tr>
              </thead>
            </table>
          </div>
          </div>
        </div>
       <!-- /.modal -->
        <div class="row">
        <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

          <div class="modal-dialog" style="width: 80%">

            <div class="modal-content" >

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title">Estado de PQRS</h4>

              </div>

              <form id="frmDatos" method="POST" enctype="multipart/form-data">

                <div class="modal-body">                

                  <div class="form-group">

                    <label for="message-text" class="control-label">PQRS:</label>

                    <textarea class="form-control" style="height: 200px" id="descripcionpqr" name="descripcionpqr" readonly="readonly"></textarea>

                  </div>  
                  
                  <div class="form-group" id="divAnexo">

                    <label for="message-text" class="control-label">Documento anexo:</label>

                    <a id="anexo" name="anexo" href="#" target="_blank">Enlace</a>


                  </div>

                  <div class="form-group">

                    <label for="message-text" class="control-label">Respuesta a la PQRS:</label>

                    <textarea class="form-control" style="height: 100px" id="accioninmediata" name="accioninmediata"></textarea>

                  </div> 

                  <div class="form-group">
                    <div id="contenedorAgregar" onclick="seleccionarArchivo();">
                      <img src="plugins/images/addfile.png" alt="Agregar Archivo" width="42" height="42" border="0" id="addfile">Agregar Archivo
                    </div>

                    <input type="file" id="archivo" name="archivo" data-max-file-size="10M" style="display: none;" onchange="ver();" />
                    <div id="contenedorVer">
                      <a id="enlace" target="_blank">
                       <img src="plugins/images/archivo.png" alt="Ver Archivo" width="42" height="42" border="0">Ver Archivo
                      </a>
                      <div onclick="eliminarArchivo();">
                        <img src="plugins/images/deletefile.png" alt="Eliminar Archivo" width="42" height="42" border="0">Eliminar Archivo
                      </div>
                     </div>
                     <label for="message-text" class="control-label" id="rutaArchivo"></label>
                  </div>
                 
                <!-- Se modifico esta linea de codigo para agregar la caja de busqueda, para el encargado de las pqrs  -->
                  <div class="form-group">
                        <label for="message-text" class="control-label">Encargado:</label>
                        
                        <div style="position: relative;">
                            <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 20px; padding: 6px 12px; background: white;">
                                <input 
                                    type="text" 
                                    id="buscadorEncargado" 
                                    placeholder="Buscar Encargado" 
                                    autocomplete="off"
                                    style="border: none; outline: none; width: 100%; font-size: 14px;"
                                />
                                <i class="fa fa-search" style="color: #aaa;"></i>
                                <i class="fa fa-chevron-down" id="flechaEncargado" style="color: #aaa; cursor: pointer; margin-left: 8px;"></i>
                            </div>
                            <ul id="listaEncargados" style="
                                display: none;
                                position: absolute;
                                top: 100%;
                                left: 0; right: 0;
                                background: white;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                list-style: none;
                                margin: 4px 0 0 0;
                                padding: 0;
                                z-index: 9999;
                                max-height: 200px;
                                overflow-y: auto;
                                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                            "></ul>
                            <input type="hidden" id="cargo" name="cargo" />
                        </div>

                        <br>
                        <label for="message-text" class="control-label">Fecha vencimiento:</label>
                        <div>
                            <input type="text" class="form-control" id="fechacierre" name="fechacierre" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
                        </div>
                    </div>
                                      
                  
                  <div class="form-group bt-switch" id="activo" name="activo">
                    <label for="message-text" class="control-label">Cerrar PQRS:</label>
                    <input type="checkbox" data-on-color="success" data-off-color="warning" data-on-text="Si" data-off-text="No" id="estado" name="estado" onchange="cambiar_estado();">
                    <input type="hidden" id="valor" name="valor">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="enlaceArchivo" name="enlaceArchivo">

                    <input type="hidden" id="numero" name="numero">

                    <input type="hidden" id="solicitante" name="solicitante">

                    <input type="hidden" id="correoSolicitante" name="correoSolicitante">

                    <input type="hidden" id="codigo" name="codigo">
                    
                    <input type="hidden" id="llave" name="llave">

                    <input type="hidden" id="accion" name="accion" value="3">
                  </div>


                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                  <button type="submit" id="guardar-registro" class="btn btn-info waves-effect waves-light">Guardar</button> 
                </div> 

              </form>

            </div>

          </div>

        </div>        

      </div>
      </div>
      
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
    var valor = '<?php echo $accion;?>'
    listar(valor);
    //sobreescribimos el metodo submit para que envie la solicitud por ajax
      $("#frmDatos").submit(function (e) {

          //esto evita que se haga la petición común, es decir evita que se refresque la pagina
          e.preventDefault();

          //ruta la cual recibira nuestro archivo
          url="registro_pqr.php"

          //FormData es necesario para el envio de archivo,
          //y de la siguiente manera capturamos todos los elementos del formulario
          var parametros=new FormData($(this)[0])

          //realizamos la petición ajax con la función de jquery
          $.ajax({
              type: "POST",
              url: url,
              data: parametros,
              contentType: false, //importante enviar este parametro en false
              processData: false, //importante enviar este parametro en false
              cache:false,
              success: function (data) {

                 var json_info = JSON.parse(data);

                mostrar_mensaje(json_info);
                 listar(valor);
              },
              error: function (r) {

                  alert("Error del servidor");
              }
          });

      })

  });

  $('#responsive-modal').on('shown.bs.modal', function () {
    // Limpiar al abrir
    $('#buscadorEncargado').val('');
    $('#cargo').val('');
    $('#listaEncargados').hide();
});

$('#responsive-modal').on('hidden.bs.modal', function () {
    // Limpiar al cerrar
    $('#buscadorEncargado').val('');
    $('#cargo').val('');
    $('#listaEncargados').hide();
});

// Lógica de búsqueda
var timeoutBusqueda;
$(document).on('input', '#buscadorEncargado', function () {
    var query = $(this).val().trim();
    $('#cargo').val(''); // limpiar selección previa

    clearTimeout(timeoutBusqueda);

    if (query.length < 1) {
        $('#listaEncargados').hide();
        return;
    }

    timeoutBusqueda = setTimeout(function () {
        // Filtra las opciones que ya fueron cargadas en el select original
        // Reutilizamos el mismo ajax que ya usa tu sistema
        $.ajax({
            type: "POST",
            url: "registro_pqr.php",
            data: {
                "accion": 12,
                "seleccionado": "",
                "tabla": "employees",
                "condicion": "where employees.soft_delete = 0 and employees.publish = 1"
            },
            success: function (datos) {
                // Parsear las opciones del HTML recibido
                var opciones = $(datos).filter('option').add($(datos).find('option'));
                var lista = $('#listaEncargados');
                lista.empty();

                var encontrados = 0;
                opciones.each(function () {
                    var texto = $(this).text();
                    var valor = $(this).val();
                    if (texto.toLowerCase().includes(query.toLowerCase())) {
                        var item = $('<li></li>').text(texto).css({
                            padding: '8px 12px',
                            cursor: 'pointer',
                            fontSize: '14px'
                        }).attr('data-id', valor);

                        item.on('mouseenter', function () { $(this).css('background', '#f0f0f0'); });
                        item.on('mouseleave', function () { $(this).css('background', 'white'); });
                        item.on('click', function () {
                            $('#buscadorEncargado').val(texto);
                            $('#cargo').val(valor); // guarda el ID para el formulario
                            lista.hide();
                        });

                        lista.append(item);
                        encontrados++;
                    }
                });

                if (encontrados === 0) {
                    lista.append('<li style="padding:8px 12px; color:#999;">No se encontraron resultados</li>');
                }

                lista.show();
            }
        });
    }, 300);
});

// Cerrar lista al hacer clic fuera
$(document).on('click', function (e) {
    if (!$(e.target).closest('#buscadorEncargado, #listaEncargados').length) {
        $('#listaEncargados').hide();
    }
});

  var guardar = function(){
      $("form").on("submit",function(e){
        e.preventDefault();
        var valor = '<?php echo $accion; ?>';
        var frm = $(this).serialize();
        $.ajax({
          method:"POST",
          url:"registro_pqr.php",
          data:frm,
          contentType: false, //importante enviar este parametro en false
              processData: false,
              cache:false

        }).done(function(info){
          var json_info = JSON.parse(info);
          mostrar_mensaje(json_info);
          listar(valor);
        });
      });
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
        "url":"registro_pqr.php",
        "data": {"accion":accion}
      },
      "columns":[
      {"data":"sr_no"},
      {"data":"solicitante"},
      {"data":"empleado"},
      {"data":"created"},
      {"data":"target_date"},
      {"data":"closed_on_date"},
      {"data":"fecha_notificacion"},
      {"defaultContent":"<button type='button' class='editar btn btn-success btn-circle' data-toggle='modal' data-target='#responsive-modal' data-toggle='tooltip' data-placement='top' data-original-title='Editar' onclick='mostrar_activo()'><i class='fa fa-edit'></i> </button>&nbsp;&nbsp;<button type='button' class='historico btn btn-info btn-circle' data-toggle='tooltip' data-placement='top' data-original-title='Historico'><i class='fa fa-history'></i> </button>"}
      ],
      "language": {
        "url": "plugins/bower_components/datatables/spanish.json"
      }
    });
    obtener_data_editar("#datatable tbody",table);
    obtener_data_historico("#datatable tbody",table);
      
    } 

    var cambiar_estado = function(){
      if($('#estado').bootstrapSwitch('state')==true)
        $("#valor").val("1");
      else
        $("#valor").val("0");
    }

    var obtener_data_editar = function(tbody,table){
    	$(tbody).on("click","button.editar",function(){
    		var data = table.row($(this).parents("tr")).data();
    		//console.log(data);
    		if (data.estado == 1)
    			$('#estado').bootstrapSwitch('state', true);
    		else
    			$('#estado').bootstrapSwitch('state', false);
    		document.getElementById("enlace").setAttribute("href", data.archivo);
    		//console.log(data.archivo);console.log(4321);
              if(data.archivo.trim() == ""){
              	document.getElementById("contenedorVer").style.display = "none";
              	document.getElementById("contenedorAgregar").style.display = "block";
              }else{
              	document.getElementById("contenedorAgregar").style.display = "none";
              	document.getElementById("contenedorVer").style.display = "block";
              }
    		$.ajax({
    			type: "POST",
    			url: "registro_pqr.php",
    			data:{"accion":12,"seleccionado":data.asignado,"tabla":"employees","condicion":"where employees.soft_delete = 0 and employees.publish = 1"},
    			success: function(datos)
    			{
    				$('.combo select').html(datos);
    			}
    		});
            document.getElementById("rutaArchivo").innerHTML = data.archivo.trim();
            
            //document.getElementById("anexo").href = data.archivoSolicitud;
            
            var enlaceAnexo = document.getElementById("anexo");
            var divAnexo = document.getElementById("divAnexo");

            // Asigna la URL al enlace y oculta el div si la URL está vacía
            if (!data.archivoSolicitud) {
                divAnexo.classList.add("hidden");
            } else {
                enlaceAnexo.href = data.archivoSolicitud;
                divAnexo.classList.remove("hidden");
            }
            console.log(data.archivoSolicitud);
            
            $("#enlaceArchivo").val(data.archivo.trim());
    		$("#id").val(data.id),
    		$("#descripcionpqr").val(data.initial_remarks),
    		$("#accioninmediata").val(data.completion_remarks),
    		$("#fechacierre").val(data.target_date),
    		$("#numero").val(data.sr_no),
            $("#solicitante").val(data.solicitante),
            $("#correoSolicitante").val(data.correo),
            $("#codigo").val(data.sr_no),
            $("#llave").val(data.llave),
            $("#accion").val("3")      
    	});
    }  
    
    var obtener_data_historico = function(tbody,table){
    	$(tbody).on("click","button.historico",function(){
    		var data = table.row($(this).parents("tr")).data();
    		var pqr = data['id'];
    		location.href='historico_pqrs.php?pqr='+data['sr_no'];
    	});
    }  

    var obtener_id_eliminar = function(tbody,table){
      $(tbody).on("click","button.eliminar",function(){
        var data = table.row($(this).parents("tr")).data();
        var idproceso = $("#frmEliminar #id").val(data.id)
      });
    } 

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
     
    var mostrar_activo = function(){
      $("#activo").css("display", "block");
    }
  </script>
  
  <script type="text/javascript">

    function seleccionarArchivo(){
      $("input[id='archivo']").click();
    }

    function ver(){
      document.getElementById("rutaArchivo").innerHTML = document.getElementById("archivo").value;
      $("#enlaceArchivo").val(document.getElementById("archivo").value);
    }

    function eliminarArchivo(){
      document.getElementById("rutaArchivo").innerHTML = '';
      document.getElementById("contenedorVer").style.display = "none";
      document.getElementById("contenedorAgregar").style.display = "block";
      $("#enlaceArchivo").val("");
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
<!-- Date Picker Plugin JavaScript -->
<script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>

// Date Picker
    jQuery('#fechacierre').datepicker({
        autoclose: true,
        todayHighlight: true
      });

</script>
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<script src="plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
<!-- Se agrega et¡sta linea de codigo -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
        var listaAbierta = false;

        $('#flechaEncargado').on('click', function () {
            if (listaAbierta) {
                $('#listaEncargados').hide();
                $('#flechaEncargado').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                listaAbierta = false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "registro_pqr.php",
                    data: {
                        "accion": 12,
                        "seleccionado": "",
                        "tabla": "employees",
                        "condicion": "where employees.soft_delete = 0 and employees.publish = 1"
                    },
                    success: function (datos) {
                        var lista = $('#listaEncargados');
                        lista.empty();

                        var temporal = $('<select>' + datos + '</select>');
                        var opciones = temporal.find('option');

                        if (opciones.length === 0) {
                            lista.append('<li style="padding:8px 12px; color:#999;">No se encontraron encargados</li>');
                        } else {
                            opciones.each(function () {
                                var texto = $(this).text().trim();
                                var valor = $(this).val();

                                if (texto === '' || valor === '') return;

                                var item = $('<li></li>').text(texto).css({
                                    padding: '8px 12px',
                                    cursor: 'pointer',
                                    fontSize: '14px',
                                    borderBottom: '1px solid #f0f0f0'
                                }).attr('data-id', valor);

                                item.on('mouseenter', function () { $(this).css('background', '#f0f0f0'); });
                                item.on('mouseleave', function () { $(this).css('background', 'white'); });
                                item.on('click', function () {
                                    $('#buscadorEncargado').val(texto);
                                    $('#cargo').val(valor);
                                    lista.hide();
                                    $('#flechaEncargado').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                                    listaAbierta = false;
                                });

                                lista.append(item);
                            });
                        }

                        lista.show();
                        $('#flechaEncargado').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                        listaAbierta = true;
                    },
                    error: function () {
                        alert('Error al cargar los encargados');
                    }
                });
            }
        });
    </script>


<script>
  $(document).ready(function(){
    $('.dropify').dropify();

                $('.dropify-fr').dropify({
                  messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove:  'Supprimer',
                    error:   'Désolé, le fichier trop volumineux'
                  }
                });

                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                  return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                  alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                  console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                  e.preventDefault();
                  if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                  } else {
                    drDestroy.init();
                  }
                })
              });
            </script>
</body>
</html>
