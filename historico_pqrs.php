<?php
session_start();
if(!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}
$pqr = $_GET['pqr']; 

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
          <h4 class="page-title">PQR - <?php echo $pqr;?></h4>
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
                  <th>Acción</th>
                  <th>Estado</th>
                  <th>Asignado a</th>
                  <th>Fecha</th>
                  <th>IP</th>
                  
                </tr>
              </thead>
            </table>
            </div>
          </div>
        </div>
       <!-- /.modal -->
       
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
    listar(14);
         
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

          "url":"registro_pqr.php",

          "data": {"accion":accion,"pqr":<?php echo $pqr; ?>}

        },

        "columns":[

          {"data":"accion"},

          {"data":"estado"},

          {"data":"usuario"},

          {"data":"fecha"},

          {"data":"ip"}
        ],

        "language": {

          "url": "plugins/bower_components/datatables/spanish.json"

        }

      });
      table.order( [ 3, 'asc' ] );
      
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
