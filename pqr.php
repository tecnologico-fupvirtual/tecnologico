<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
<title>PQR - Sistema de gestión de calidad</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="pqr-register">
  <div class="login-box login-sidebar">
    <div class="white-box">
      <form class="form-horizontal form-material" id="frmDatos" method="POST" enctype="multipart/form-data">
        <a href="javascript:void(0)" class="text-center db"><img src="plugins/images/eliteadmin-logo-darkfup.png" alt="Home" /><br/></a>   
        <h3 class="box-title m-t-40 m-b-0"><center>Formulario de registro de Peticiones, Quejas,<br>Reclamos, Solicitudes y Felicitaciones</center></h3><br><span class="descripcion"><small>En la Fundación Universitaria de Popayán estamos comprometidos con brindar un servicio de Educación Superior de excelente calidad con responsabilidad social.  
<br><br>Sus Peticiones, Quejas, Reclamos, Solicitudes y Felicitaciones nos permitirán identificar oportunidades para el mejoramiento continuo de la Institución.
</small></span> 
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="nombre" id="nombre" required placeholder="Nombre completo" oninput="validarInput(event)">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <select required class="form-control" name="tipoIde" id="tipoIde">
                <option value="">Tipo de Identificación</option>
                <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                <option value="NUIP -Número Único de Identificación Personal">NUIP -Número Único de Identificación Personal</option>
                <option value="Cédula de Extranjería">Cédula de Extranjería</option>
                <option value="NIT -Número de Identificación Tributaria">NIT -Número de Identificación Tributaria</option>
                <option value="Pasaporte">Pasaporte</option>
            </select>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="number" name="cedula" id="cedula" required placeholder="Número de identificación" max="999999999999">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="email" id="correo" name="correo" required placeholder="Correo electrónico">
          </div>
        </div>
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="direccion" id="direccion" required placeholder="Dirección de correspondencia">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="telefono" id="telefono" required placeholder="Teléfono | Celular" oninput="validarTelefono(event)">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <select required class="form-control" name="vinculacion" id="vinculacion" onChange="mostrarPrograma(this)">
                <option value="">Vinculación</option>
                <option value="Aspirante">Aspirante</option>
                <option value="Estudiante">Estudiante</option>
                <option value="Egresado">Egresado</option>
                <option value="Colaborador de la institución">Colaborador de la institución</option>
                <option value="Otro">Otro</option>
            </select>
          </div>
        </div>
        <div class="form-group " id="divPrograma" name="divPrograma" style="display:none;">
          <div class="col-xs-12">
            <select required class="form-control" name="programa" id="programa">
                <option value="">Programa</option>
                <option value="ADMINISTRACION DE EMPRESAS - MOD. VIRTUAL"> ADMINISTRACION DE EMPRESAS - MOD. VIRTUAL</option>
        		<option value="ADMINISTRACION EMPRESAS AGROPECUARIAS - MOD.VIRTUAL"> ADMINISTRACION EMPRESAS AGROPECUARIAS - MOD.VIRTUAL</option>
        		<option value="COMUNICACION SOCIAL - MOD. VIRTUAL"> COMUNICACION SOCIAL - MOD. VIRTUAL</option>
        		<option value="ADMINISTRACION DE EMPRESAS">ADMINISTRACION DE EMPRESAS</option>
        		<option value="ADMINISTRACION DE EMPRESAS AGROPECUARIAS">ADMINISTRACION DE EMPRESAS AGROPECUARIAS</option>
        		<option value="ARQUITECTURA">ARQUITECTURA</option>
        		<option value="COMUNICACION SOCIAL">COMUNICACION SOCIAL</option>
        		<option value="CONTADURIA PUBLICA">CONTADURIA PUBLICA</option>
        		<option value="DERECHO">DERECHO</option>
        		<option value="ECOLOGIA">ECOLOGIA</option>
        		<option value="ECONOMIA">ECONOMIA</option>
        		<option value="INGENIERIA AGROECOLÓGICA">INGENIERIA AGROECOLÓGICA</option>
        		<option value="INGENIERIA DE SISTEMAS">INGENIERIA DE SISTEMAS</option>
        		<option value="INGENIERIA INDUSTRIAL">INGENIERIA INDUSTRIAL</option>
        		<option value="LICENCIATURA EN EDUCACIÓN ARTÍSTICA Y CULTURAL">LICENCIATURA EN EDUCACIÓN ARTÍSTICA Y CULTURAL</option>
        		<option value="PSICOLOGIA">PSICOLOGIA</option>
        		<option value="TRABAJO SOCIAL">TRABAJO SOCIAL</option>
            </select>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <select required class="form-control" name="lugar" id="lugar" onChange="mostrarOtro(this)">
                <option value="">Ciudad sede</option>
                <option value="Popayán">Popayán</option>
                <option value="Santander de Quilichao">Santander de Quilichao</option>
                <option value="Otro">Otro</option>
            </select>
          </div>
        </div>
        <div class="form-group " id="divOtro" name="divOtro" style="display:none;">
            <div class="col-xs-12">
            <input class="form-control" type="text" name="otro" id="otro" required placeholder="Ingrese la ciudad o sede">
          </div>  
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <select required class="form-control" name="tipo" id="tipo">
                <option value="">Tipo</option>
                <option value="Peticion">Petición</option>
                <option value="Queja">Queja</option>
                <option value="Reclamo">Reclamo</option>
                <option value="Sugerencia">Sugerencia</option>
                <option value="Felicitacion">Felicitación</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <textarea class="form-control" rows="5" name="pqr" id="pqr" placeholder="Exprese a continuación su PQR correspondiente. Responderemos su P.Q.R.S. en el término de los 15 días hábiles siguientes a la fecha de registro." required></textarea>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            
            <input type="file" class="form-control" name="archivo" id="archivo">
            <span class="descripcion"><small>El tamaño máximo del archivo es de 4 Mb.
Solo puede adjuntar archivos de tipo y extensión indicado: Imágenes (jpg,png),
PDF's, Microsoft Office (Word .doc, .docx, Excel .xls, .xlsx)</small></span>
          </div>
        </div>
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <span class="descripcion"><small>La modalidad de recepción de la respuesta serán direccionadas al correo electrónico registrado.</small></span>  
          </div>
        </div>
        <div class="form-group">
          <script src='https://www.google.com/recaptcha/api.js?hl=es' async defer></script>
          <div class="col-xs-12">
            <div class="g-recaptcha" data-sitekey="6LfU2wkTAAAAAPxqa3O0Ju8vBnWqCkrVuEW54xs-" style="transform:scale(1);transform-origin:0;-webkit-transform:scale(1);transform:scale(1);-webkit-transform-origin:0 0;transform-origin:0 0; 0"></div>
          </div>
          <input type="hidden" id="accion" name="accion" value="1">
        </div>
        
        <div class="form-group form-check">
            <div class="col-md-12">
            <input type="checkbox" class="custom-control-input" id="confirmar" onchange="toggleButton()">
            <label class="custom-control-label" for="confirmar"><small>Acepta que ha leído y está de acuerdo con <a href="https://fup.edu.co/wp-content/uploads/POLITICA-DE-PROTECCION-DE-DATOS-PERSONALES.pdf" Target="_blank">Nuestra política de datos</a></small></label><br>
            <!--</div>
        </div>
        
        <div class="form-group form-check">
            <div class="col-md-12">-->
            <input type="checkbox" class="custom-control-input" id="confirmar1" onchange="toggleButton()">
            <label class="custom-control-label" for="confirmar1"><small>Autorizo el tratamiento de mis datos personales de acuerdo a nuestro <a href="https://fup.edu.co/aviso-de-privacidad/" Target="_blank">Aviso de privacidad</a></small></label>
            </div>
        </div>
        
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="guardar-registro" disabled>Enviar</button>
          </div>
        </div>
        
      </form>
    </div>
  </div>


</section>

<!-- Modal Aviso PQR -->
<div class="modal fade" id="pqrAvisoModal" tabindex="-1" role="dialog" aria-labelledby="pqrAvisoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="pqrAvisoModalLabel">Información importante sobre la atención de PQR</h4>
      </div>
      <div class="modal-body">
        <p>
          Estimado usuario, cordial saludo.
        </p><br>
        <p>
          Gracias por comunicarte con nosotros. Queremos informarte que puedes registrar tu PQRS en cualquier momento a través de nuestros canales oficiales. Sin embargo, te contamos que, de acuerdo con el cierre administrativo por vacaciones colectivas declarado por la Fundación Universitaria de Popayán, los términos para la atención y respuesta de las solicitudes se encuentran suspendidos durante este periodo.
        </p>
        <p>
            Esto significa que tu requerimiento será recibido y quedará debidamente registrado, pero el conteo del día hábil para su trámite iniciará el 14 de enero de 2026, fecha en la que la institución retoma oficialmente sus actividades administrativas.
        </p>
        <p>
            Esta medida se adopta conforme a lo establecido en el Código de Procedimiento Administrativo y de lo Contencioso Administrativo (CPACA), que permite suspender términos cuando existe un cierre institucional previamente comunicado y sin disponibilidad administrativa para la gestión de PQR.
        </p>
        <p>
          Agradecemos tu comprensión. Nuestro equipo estará disponible a partir de esa fecha para brindarte una atención adecuada y oportuna.
        </p><br>
        <p>
            Adjunto: <a href="https://fupvirtual.edu.co/isocalidad/documentos/RESOLUCIO%CC%81N_093_POR_LA_CUAL_SE_SUSPENDEN_TE%CC%81RMINOS_PARA_ACTUACIONES_ADMINSITRATIVAS.pdf" Target="_blank">Resolución 093</a>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

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
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!-- Sweet-Alert  -->
<script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script>
  $(document).on("ready", function(){
      $("#pqrAvisoModal").modal("show"); // Muestra el aviso al cargar
      guardar();
    });
    var guardar = function(){
      $("#frmDatos").on("submit",function(e){
        
        bloquear();
        e.preventDefault();
        var frm = new FormData($("#frmDatos")[0]);
        console.log(frm);
        $.ajax({
          method:"POST",
          url:"control_pqr.php",
          data:frm,
          contentType: false, //importante enviar este parametro en false
          processData: false,
              cache:false
        }).then(function(data) {
            console.log(JSON.stringify(data));
          if(JSON.stringify(data)=='"BIEN"'){
            desbloquear();
            swal("MUY BIEN","La PQR fué reportada exitosamente.","success");
            limpiarCampos();
            grecaptcha.reset();
          }
          else {
              if(JSON.stringify(data)=='"ERROR"'){
                desbloquear();
                swal("ERROR","Debes verificar que no eres un robot.","error"); 
              } else {
                desbloquear();
                swal("ERROR","Debes verificar el archivo adjunto.","error");   
              }
          }
        });
      });
    }
</script>
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
    
    function limpiarCampos(){
      document.getElementById("frmDatos").reset();
      divC = document.getElementById("divPrograma");
      divC.style.display="none";
      $('#programa').removeAttr("required");
      divO = document.getElementById("divOtro");
      divO.style.display="none";
      $('#otro').removeAttr("required");
      toggleButton();
    }
  
    function mostrarPrograma(sel) {
      if ((sel.value=="Estudiante")||(sel.value=="Egresado")){
           divC = document.getElementById("divPrograma");
           divC.style.display = "";
           $('#programa').prop("required", true);
      }else{
           divC = document.getElementById("divPrograma");
           divC.style.display="none";
           $('#programa').removeAttr("required");
      }
    }
    
    function mostrarOtro(sel) {
      if (sel.value=="Otro"){
           divO = document.getElementById("divOtro");
           divO.style.display = "";
           $('#otro').prop("required", true);
      }else{
           divO = document.getElementById("divOtro");
           divO.style.display="none";
           $('#otro').removeAttr("required");
      }
    }
    
    function validarInput(event) {
            const input = event.target;
            input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); // Incluye caracteres acentuados y ñ
        }
        
    function validarTelefono(event) {
            const input = event.target;
            input.value = input.value.replace(/[^0-9\- ]/g, '');
        }
        
    function toggleButton() {
            const checkbox = document.getElementById('confirmar');
            const checkbox1 = document.getElementById('confirmar1');
            const button = document.getElementById('guardar-registro');
            button.disabled = !(checkbox.checked && checkbox1.checked);
        }
</script>
</body>
</html>
