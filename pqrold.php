<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    if (isset($_GET['referencia']))
    {
        $referencia = str_replace ("pqr/", "", $_GET['referencia']);
        $referencia = substr ($referencia,-(strlen($referencia) - strpos($referencia, "/") - 1));
        include('scripts/config.php');
        $con = mysql_connect($server,$user,$password);
        mysql_select_db($database, $con);  
        mysql_set_charset("utf8", $con);  
        $sql=mysql_query("SELECT corrective_preventive_actions.name, corrective_preventive_actions.sr_no, corrective_preventive_actions.created, employees.name, corrective_preventive_actions.closed_by, corrective_preventive_actions.lugar, corrective_preventive_actions.tipo, corrective_preventive_actions.observacion, corrective_preventive_actions.completion_remarks, corrective_preventive_actions.id, corrective_preventive_actions.archivo, corrective_preventive_actions.notificacion, corrective_preventive_actions.current_status FROM corrective_preventive_actions inner join employees on (corrective_preventive_actions.assigned_to = employees.id) where corrective_preventive_actions.name = '$referencia'",$con);
        $registro = mysql_fetch_row($sql);
        if(($registro[11] == 0)&&($registro[12] == 1)){
          $ip = $_SERVER['REMOTE_ADDR'];
          $sql1=mysql_query("UPDATE corrective_preventive_actions SET notificacion = 1, fecha_notificacion = now() where id = '$registro[9]'",$con);
          $sql2=mysql_query("INSERT INTO audit_pqr(pqr_id, pqr_sr_no, accion, estado, usuario, fecha, ip) VALUES ('$registro[9]', '$registro[1]', 'Vista por parte del usuario', 'Cerrada', '$registro[3]', now(), '$ip')",$con);
        }
        $activa=1;
    }
    else
    {
        $activa=0;
    }
?>
<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<base href="https://unividafup.edu.co/calidadv2/isocalidad/" />
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
<title>PQR - Sistema de gestión de calidad</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="plugins/bower_components/icheck/skins/all.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="css/colors/blue.css" id="theme"  rel="stylesheet">
<!--alerts CSS -->
<link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
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
  <nav class="navbar navbar-default navbar-static-top m-b-0" style="height: auto;">
    <center><div style="background-color: #0c4d8e; height: auto;"><img src="plugins/images/cabezote.png" style="width: 100%;
    height: auto; max-width: 1052px" /></div></center>
  </nav> 
  
  <!-- End Top Navigation -->
  <!-- Left navbar-header -->

  <!-- Left navbar-header end -->
  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box">
            <section>
              <div id="tabs" >
                  <ul class="nav nav-tabs" id="myTabs">
                    
                    <!-- <li><a href="#section-bar-1" ><span>Registrar PQR</span></a></li>
                    <li><a href="#section-bar-2" ><span>Consultar PQR</span></a></li> -->
                    <li role="presentation" <?php if ($activa==0) echo 'class="active"'; ?>><a href="#home6" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Registrar PQR</span></a></li>
                    <li role="presentation" <?php if ($activa==1) echo 'class="active"'; ?>><a href="#profile6" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Consultar PQR</span></a></li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" <?php if ($activa==0) echo 'class="tab-pane active in"'; else echo 'class="tab-pane fade"';?> id="home6" class="block">
                    
                    <h5>Queremos ofrecerle Educación de Calidad con Responsabilidad Social, es por ello que con sus solicitudes continuamos en el proceso de mejoramiento continuo.</h5><br>
                    <form class="form-horizontal" action="frmDatos" method="POST">
                      <div class="form-group">
                        <label class="col-md-1">Nombre:</label>
                        <div class="col-md-11">
                          <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-1" for="example-email">Correo electrónico:</label>
                        <div class="col-md-11">
                          <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-1">Teléfono | Celular:</label>
                        <div class="col-md-11">
                          <input type="text" class="form-control" name="telefono" id="telefono" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-1">Vinculación:</label>
                        <div class="col-md-5">
                          <select required class="form-control" name="vinculacion" id="vinculacion">
                            <option value="">Seleccione</option>
                            <option value="Aspirante">Aspirante</option>
                            <option value="Estudiante">Estudiante</option>
                            <option value="Egresado">Egresado</option>
                            <option value="Colaborador de la institución">Colaborador de la institución</option>
                            <option value="Otro">Otro</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-1">Lugar donde se originó:</label>
                          <div class="input-group col-md-5">
                             <ul class="icheck-list">
                                <li>
                                   <input type="radio" class="check" id="Los robles" name="lugar" data-radio="iradio_square-blue" value="Sede Los Robles" required>
                                   <label for="square-radio-1">Sede Los Robles</label>
                                </li>
                                <li>
                                   <input type="radio" class="check" id="square-radio-2" name="lugar" data-radio="iradio_square-blue" value="Sede San José" required>
                                   <label for="square-radio-2">Sede San José</label>
                                </li>
                                <li>
                                   <input type="radio" class="check" id="square-radio-3" name="lugar" data-radio="iradio_square-blue" value="Sede Arquitectura" required>
                                   <label for="square-radio-2">Sede Arquitectura</label>
                                </li>
                                <li>
                                   <input type="radio" class="check" id="square-radio-4" name="lugar" data-radio="iradio_square-blue" value="Sede Norte" required>
                                   <label for="square-radio-2">Sede Norte</label>
                                </li>
                                <li>
                                   <input type="radio" class="check" id="square-radio-5" name="lugar" data-radio="iradio_square-blue" value="Sede San Camilo" required>
                                   <label for="square-radio-2">Sede San Camilo</label>
                                </li>
                              </ul>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-md-1">Tipo:</label>
                          <div class="input-group col-md-5">
                             <ul class="icheck-list">
                                <li>
                                   <input type="radio" class="check" id="square-radio-6" name="tipo" data-radio="iradio_square-blue" value="Queja" required>
                                   <label for="square-radio-1">Queja</label>
                                </li>
                                <li>
                                   <input type="radio" class="check" id="square-radio-7" name="tipo" data-radio="iradio_square-blue" value="Solicitud" required>
                                   <label for="square-radio-2">Solicitud</label>
                                </li>
                              </ul>
                          </div>
                       </div>
                       <div class="form-group">
                        <label class="col-md-12">Exprese a continuación su PQR correspondiente:</label>
                        <div class="col-md-12">
                          <textarea class="form-control" rows="5" name="pqr" id="pqr"></textarea>
                        </div>
                      </div>
                      <script src='https://www.google.com/recaptcha/api.js?hl=es' async defer></script>
                      <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LfU2wkTAAAAAPxqa3O0Ju8vBnWqCkrVuEW54xs-" style="transform:scale(1);transform-origin:0;-webkit-transform:scale(1);transform:scale(1);-webkit-transform-origin:0 0;transform-origin:0 0; 0"></div>
                      </div>
                      <input type="hidden" id="accion" name="accion" value="1">
                      <div class="form-group">
                        <div class="col-md-2">
                          <button type="submit" id="guardar-registro" class="btn btn-info btn-block waves-effect waves-light">Enviar</button>
                        </div>
                        <div class="col-md-2">
                          <button type="button" onclick="limpiarCampos();" class="btn btn-danger btn-block waves-effect waves-light">Cancelar</button>
                        </div>
                      </div>
                    </form>
                    
                  
                    </div>
                    <div role="tabpanel" <?php if ($activa==1) echo 'class="tab-pane active in"'; else echo 'class="tab-pane fade"';?>  id="profile6">
                      <h5>Queremos ofrecerle Educación de Calidad con Responsabilidad Social, es por ello que con sus solicitudes continuamos en el proceso de mejoramiento continuo.</h5><br>
                      <form class="form-horizontal" action="control_pqr.php" method="post" enctype="multipart/form-data" name="frm_pqrs_buscar" id="frm_pqrs_buscar">
                        <div class="form-group">
                          <label class="col-md-1">Referencia:</label>
                          <div class="col-md-11">
                            <input type="text" class="form-control" name="referencia" id="referencia" onkeyup = "if(event.keyCode == 13) buscar()" required>
                          </div>
                        </div>
                        <input type="hidden" id="accion" name="accion" value="2">
                        <div class="form-group">
                          <div class="col-md-2">
                            <button type="button" id="guardar-registro" class="btn btn-info btn-block waves-effect waves-light" onclick="buscar();">Buscar</button>
                          </div>
                        </div>
                      </form>

                      <?php if ($activa == 1) { ?>
                        <center>
                        <?php if ($registro[0]<>'') { ?>
                        <table style="width:60%" border="1" bordercolor="#999999" cellpadding="10">
                            <tr bgcolor="#CCCCCC">
                                <th colspan="2"><center><strong>SOLICITUD <?php echo $registro[0]; ?></strong></center></th>
                            </tr>
                            <tr>
                                <td width="50%"><label>CONSECUTIVO:</label><?php echo $registro[1]; ?></td>
                                <td width="50%"><label>FECHA DE CREACION:</label><?php echo $registro[2]; ?></td>
                            </tr>
                            <tr>
                                <td><label>RESPONSABLE:</label><?php echo $registro[3]; ?></td>
                                <td><label>ESTADO ACTUAL:</label><?php if ($registro[4] == -1) {echo 'ABIERTO';} else {echo 'CERRADO';}?></td>
                            </tr>
                            <tr>
                                <td><label>LUGAR:</label><?php echo $registro[5]; ?></td>
                                <td><label>TIPO:</label><?php echo $registro[6]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label>DESCRIPCION:</label><?php echo $registro[7]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label>RESPUESTA:</label><?php echo $registro[8]; ?></td>
                            </tr>
                            <?php if(trim($registro[10]) <> ''){ ?>
                            <tr bgcolor="#CCCCCC">
                                <td colspan="2"><strong><center>DOCUMENTO</center></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><center><a href="<?php echo $registro[10]; ?>" target="_blank">
                                 <img src="plugins/images/archivo.png" alt="Ver Documento" width="42" height="42" border="0">Ver Documento
                                </a></center>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                        <?php } else { ?>
                            <div id="flashMessage" class="alert alert-danger  fade in message">Referencia no disponible<button aria-hidden="true" data-dismiss="alert" class="close" type="button" onclick="ocultar()">x</button></div>
                        <?php } ?>
                        </center>
                    <?php } ?> 

                    </div>                   
                    
                  </div>
                  
                
              </div><!-- /tabs -->
            </section>
          </div>
        </div>
      </div>
      <!-- .row -->
      
      <!-- /.row -->
      <!-- .row -->
      
      <!-- /.row -->
      <!-- .row -->
      
      <!-- /.row -->
      
      <!-- .right-sidebar -->
      
      <!-- /.right-sidebar -->
    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center"> 2018 &copy; Fundación Universitaria de Popayán </footer>
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
<!-- icheck -->
<script src="plugins/bower_components/icheck/icheck.min.js"></script>
<script src="plugins/bower_components/icheck/icheck.init.js"></script>
<!--slimscroll JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="js/toastr.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/custom.min.js"></script>
<script src="js/cbpFWTabs.js"></script>

<script>
  function limpiarCampos(){
    $("#nombre").val("");
    $("#correo").val("");
    $("#telefono").val("");
    $("#vinculacion").val("Ninguno");
    $("#lugar").val(-1);
    $("#tipo").val(-1);
    $("#pqr").val("");
  }
  function buscar(){
  	var valor = document.getElementById("referencia").value;
  	window.location.href = "http://unividafup.edu.co/calidadv2/isocalidad/pqr/"+valor+".html";
  }
</script>
<script type="text/javascript">
  (function() {

    [].slice.call( document.querySelectorAll( '.sttabs' ) ).forEach( function( el ) {
      new CBPFWTabs( el );
    });

  })();
</script>
<script src="js/jasny-bootstrap.js"></script>
<!-- Sweet-Alert  -->
<script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script>
  $(document).on("ready", function(){
      guardar();
    });
    var guardar = function(){
      $("form").on("submit",function(e){
        bloquear();
        e.preventDefault();
        var frm = $(this).serialize();
        $.ajax({
          method:"POST",
          url:"control_pqr.php",
          data:frm
        }).then(function(data) {
            //console.log(JSON.stringify(data));
          if(JSON.stringify(data)=='"BIEN"'){
            desbloquear();
            swal("MUY BIEN","La PQR fué reportada exitosamente.","success");
            limpiarCampos();
          }
          else {
            desbloquear();
            swal("ERROR","Debes verificar que no eres un robot.","error");      
          }
        });
      });
      //window.location.assign("http://unividafup.edu.co/calidadv2/isocalidad/pqr")
    }
</script>
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!--BlockUI Script -->
<script src="plugins/bower_components/blockUI/jquery.blockUI.js"></script>   
<script type="application/javascript">
    function bloquear(){
        $('div.block').block({
                message: '<p style="margin:0;padding:8px;font-size:24px;">Just a moment...</p>'
                , css: {
                    color: '#fff'
                    , border: '1px solid #fb9678'
                    , backgroundColor: '#fb9678'
                }
            });
    }
    
    function desbloquear(){
        $('div.block').unblock();
    }
</script>
</body>
</html>
