<?php
  session_start();
  if(!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
  }
  include 'scripts/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
  <title>Actas de reunión</title>
  <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
  <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
  <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/colors/blue.css" id="theme" rel="stylesheet">
  <style>
    .minutes-shell {
      background: #f5f9fd;
      border: 1px solid #dfeaf4;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 26px;
    }

    .minutes-toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 18px;
      gap: 12px;
    }

    .minutes-title {
      margin: 0;
      color: #17324d;
      font-weight: 700;
    }

    .minutes-tabs {
      margin-bottom: 18px;
    }

    .minute-form-section {
      background: #fff;
      border: 1px solid #e1edf6;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 16px;
    }

    .minute-form-section h4 {
      margin: 0 0 14px;
      color: #0b5ea8;
      font-size: 16px;
      font-weight: 700;
    }

    .dynamic-row {
      border: 1px solid #e1edf6;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 10px;
      background: #fbfdff;
    }

    .employee-results {
      position: absolute;
      z-index: 9999;
      left: 0;
      right: 0;
      top: 100%;
      background: #fff;
      border: 1px solid #ccd8e4;
      border-radius: 4px;
      max-height: 210px;
      overflow-y: auto;
      display: none;
      box-shadow: 0 8px 20px rgba(18, 52, 82, 0.12);
    }

    .employee-results button {
      display: block;
      width: 100%;
      border: 0;
      background: #fff;
      text-align: left;
      padding: 8px 10px;
      color: #2d4358;
    }

    .employee-results button:hover {
      background: #eef6fd;
    }

    .status-pill {
      display: inline-block;
      padding: 5px 9px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
    }

    .status-pending { background: #fff4d8; color: #9a6a00; }
    .status-in_progress { background: #dcefff; color: #0b5ea8; }
    .status-done { background: #dff5e8; color: #167349; }
    .status-cancelled { background: #f0f1f4; color: #6d7680; }

    .table-actions .btn {
      margin-right: 4px;
      margin-bottom: 4px;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<!-- Left navbar-header end -->

<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row bg-title">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h4 class="page-title">ACTAS DE REUNIÓN</h4>
      </div>
    </div>

    <div class="minutes-shell">
      <div class="minutes-toolbar">
        <div>
          <h3 class="minutes-title">Gestión de actas y compromisos</h3>
          <p class="text-muted m-b-0">Registre reuniones institucionales y convierta los compromisos en tareas asignadas.</p>
        </div>
        <button class="btn btn-info waves-effect waves-light" type="button" onclick="nuevaActa();">
          Nueva acta
        </button>
      </div>

      <ul class="nav nav-tabs minutes-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab-actas" aria-controls="tab-actas" role="tab" data-toggle="tab">Actas</a></li>
        <li role="presentation"><a href="#tab-compromisos" aria-controls="tab-compromisos" role="tab" data-toggle="tab">Compromisos</a></li>
      </ul>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab-actas">
          <div class="table-responsive">
            <table id="tablaActas" class="display nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Consecutivo</th>
                  <th>Sitio</th>
                  <th>Estado</th>
                  <th>Asistentes</th>
                  <th>Compromisos</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-compromisos">
          <div class="table-responsive">
            <table id="tablaCompromisos" class="display nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Fecha límite</th>
                  <th>Actividad</th>
                  <th>Responsable</th>
                  <th>Estado</th>
                  <th>Prioridad</th>
                  <th>Acta</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div id="modalActa" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form id="formActa">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Acta de reunión institucional</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id" name="id">
              <input type="hidden" name="accion" value="save_minute">

              <div class="minute-form-section">
                <h4>Generalidades de la sesión</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Fecha del acta</label>
                      <input type="date" class="form-control" id="meeting_date" name="meeting_date" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Hora inicio</label>
                      <input type="time" class="form-control" id="start_time" name="start_time">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Hora final</label>
                      <input type="time" class="form-control" id="end_time" name="end_time">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Sitio</label>
                      <input type="text" class="form-control" id="location" name="location">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Consecutivo</label>
                      <input type="text" class="form-control" id="consecutive" name="consecutive">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Temas a tratar</label>
                  <textarea class="form-control" id="topics" name="topics" rows="2"></textarea>
                </div>
              </div>

              <div class="minute-form-section">
                <div class="minutes-toolbar">
                  <h4>Control de asistencia</h4>
                  <button type="button" class="btn btn-default btn-sm" onclick="agregarAsistente();">Agregar asistente</button>
                </div>
                <div id="asistentesContainer"></div>
              </div>

              <div class="minute-form-section">
                <h4>Orden y desarrollo</h4>
                <div class="form-group">
                  <label>Orden de la sesión</label>
                  <textarea class="form-control" id="agenda" name="agenda" rows="3">1. Verificación de asistencia
2. Revisión de compromisos de la sesión anterior
3. Puntos del orden del día
4. Proposiciones y varios</textarea>
                </div>
                <div class="form-group">
                  <label>Desarrollo de la sesión</label>
                  <textarea class="form-control" id="development" name="development" rows="5"></textarea>
                </div>
              </div>

              <div class="minute-form-section">
                <div class="minutes-toolbar">
                  <h4>Compromisos de la sesión</h4>
                  <button type="button" class="btn btn-default btn-sm" onclick="agregarCompromiso();">Agregar compromiso</button>
                </div>
                <div id="compromisosContainer"></div>
              </div>

              <div class="minute-form-section">
                <h4>Cierre</h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Fecha siguiente sesión o revisión</label>
                      <input type="date" class="form-control" id="next_session_date" name="next_session_date">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Estado del acta</label>
                      <select class="form-control" id="status" name="status">
                        <option value="draft">Borrador</option>
                        <option value="approved">Aprobada</option>
                        <option value="closed">Cerrada</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-info">Guardar acta</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="modalTarea" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="formTarea">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Actualizar compromiso</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="task_update_id" name="id">
              <input type="hidden" name="accion" value="update_task">
              <div class="form-group">
                <label>Estado</label>
                <select class="form-control" id="task_update_status" name="status">
                  <option value="pending">Pendiente</option>
                  <option value="in_progress">En proceso</option>
                  <option value="done">Cumplida</option>
                  <option value="cancelled">Cancelada</option>
                </select>
              </div>
              <div class="form-group">
                <label>Comentario</label>
                <textarea class="form-control" id="task_update_comment" name="comment" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-info">Guardar cambio</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
  <?php include 'footer.php'; ?>
</div>
</div>

<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/waves.js"></script>
<script src="js/custom.min.js"></script>
<script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script>
  var tablaActas;
  var tablaCompromisos;

  function estadoLabel(status) {
    var labels = {
      draft: 'Borrador',
      approved: 'Aprobada',
      closed: 'Cerrada',
      pending: 'Pendiente',
      in_progress: 'En proceso',
      done: 'Cumplida',
      cancelled: 'Cancelada'
    };
    return labels[status] || status;
  }

  function estadoPill(status) {
    return '<span class="status-pill status-' + status + '">' + estadoLabel(status) + '</span>';
  }

  function toastInfo(text, icon) {
    $.toast({
      heading: icon === 'error' ? 'Atención' : 'Listo',
      text: text,
      position: 'top-right',
      loaderBg: '#ff6849',
      icon: icon || 'success',
      hideAfter: 3000,
      stack: 6
    });
  }

  $(document).ready(function() {
    tablaActas = $('#tablaActas').DataTable({
      ajax: { url: 'registro_actas.php', type: 'POST', data: { accion: 'list_minutes' } },
      columns: [
        { data: 'meeting_date' },
        { data: 'consecutive', defaultContent: '' },
        { data: 'location', defaultContent: '' },
        { data: 'status', render: function(data) { return estadoPill(data); } },
        { data: 'attendees' },
        { data: 'tasks' },
        { data: null, orderable: false, render: function(data) {
          return '<div class="table-actions">' +
            '<button class="btn btn-info btn-xs" onclick="editarActa(\'' + data.id + '\')">Editar</button>' +
            '<button class="btn btn-default btn-xs" onclick="imprimirActa(\'' + data.id + '\')">Imprimir</button>' +
            '</div>';
        }}
      ],
      order: [[0, 'desc']],
      language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
    });

    tablaCompromisos = $('#tablaCompromisos').DataTable({
      ajax: { url: 'registro_actas.php', type: 'POST', data: { accion: 'list_tasks' } },
      columns: [
        { data: 'due_date' },
        { data: 'activity' },
        { data: 'responsible_name' },
        { data: 'status', render: function(data) { return estadoPill(data); } },
        { data: 'priority', render: function(data) { return data === 'high' ? 'Alta' : (data === 'low' ? 'Baja' : 'Normal'); } },
        { data: null, render: function(data) { return (data.consecutive || '') + ' - ' + data.meeting_date; } },
        { data: null, orderable: false, render: function(data) {
          return '<button class="btn btn-info btn-xs" onclick="abrirTarea(\'' + data.id + '\', \'' + data.status + '\')">Actualizar</button>';
        }}
      ],
      order: [[0, 'asc']],
      language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
    });

    $('#formActa').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'registro_actas.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(resp) {
          if (resp.respuesta === 'BIEN') {
            $('#modalActa').modal('hide');
            tablaActas.ajax.reload();
            tablaCompromisos.ajax.reload();
            toastInfo('Acta guardada correctamente.');
          } else {
            toastInfo(resp.mensaje || 'No fue posible guardar el acta.', 'error');
          }
        }
      });
    });

    $('#formTarea').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'registro_actas.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(resp) {
          if (resp.respuesta === 'BIEN') {
            $('#modalTarea').modal('hide');
            tablaCompromisos.ajax.reload();
            toastInfo('Compromiso actualizado correctamente.');
          } else {
            toastInfo(resp.mensaje || 'No fue posible actualizar el compromiso.', 'error');
          }
        }
      });
    });
  });

  function nuevaActa() {
    $('#formActa')[0].reset();
    $('#id').val('');
    $('#asistentesContainer').empty();
    $('#compromisosContainer').empty();
    agregarAsistente();
    agregarCompromiso();
    $('#modalActa').modal('show');
  }

  function editarActa(id) {
    $.post('registro_actas.php', { accion: 'get_minute', id: id }, function(resp) {
      if (resp.respuesta !== 'BIEN') {
        toastInfo(resp.mensaje || 'No fue posible cargar el acta.', 'error');
        return;
      }
      var m = resp.minute;
      $('#id').val(m.id);
      $('#consecutive').val(m.consecutive);
      $('#meeting_date').val(m.meeting_date);
      $('#start_time').val(m.start_time);
      $('#end_time').val(m.end_time);
      $('#location').val(m.location);
      $('#topics').val(m.topics);
      $('#agenda').val(m.agenda);
      $('#development').val(m.development);
      $('#next_session_date').val(m.next_session_date);
      $('#status').val(m.status);

      $('#asistentesContainer').empty();
      resp.attendees.forEach(function(a) { agregarAsistente(a); });
      if (resp.attendees.length === 0) agregarAsistente();

      $('#compromisosContainer').empty();
      resp.tasks.forEach(function(t) { agregarCompromiso(t); });
      if (resp.tasks.length === 0) agregarCompromiso();

      $('#modalActa').modal('show');
    }, 'json');
  }

  function agregarAsistente(data) {
    data = data || {};
    var row = $('<div class="dynamic-row attendee-row"></div>');
    row.html(
      '<div class="row">' +
        '<div class="col-md-5"><div class="form-group" style="position:relative;">' +
          '<label>Asistente</label>' +
          '<input type="hidden" name="attendee_employee_id[]" class="employee-id" value="' + (data.employee_id || '') + '">' +
          '<input type="text" name="attendee_name[]" class="form-control employee-search" autocomplete="off" value="' + escapeHtml(data.employee_name || '') + '" required>' +
          '<div class="employee-results"></div>' +
        '</div></div>' +
        '<div class="col-md-4"><div class="form-group">' +
          '<label>Cargo</label>' +
          '<input type="text" name="attendee_position[]" class="form-control employee-position" value="' + escapeHtml(data.position_name || '') + '">' +
        '</div></div>' +
        '<div class="col-md-2"><div class="form-group">' +
          '<label>Asistió</label>' +
          '<select name="attendee_attended[]" class="form-control"><option value="1">Sí</option><option value="0">No</option></select>' +
        '</div></div>' +
        '<div class="col-md-1"><label>&nbsp;</label><button type="button" class="btn btn-danger btn-block" onclick="$(this).closest(\'.dynamic-row\').remove();">×</button></div>' +
      '</div>'
    );
    row.find('select').val(data.attended === '0' ? '0' : '1');
    $('#asistentesContainer').append(row);
  }

  function agregarCompromiso(data) {
    data = data || {};
    var row = $('<div class="dynamic-row task-row"></div>');
    row.html(
      '<input type="hidden" name="task_id[]" value="' + (data.id || '') + '">' +
      '<div class="row">' +
        '<div class="col-md-5"><div class="form-group">' +
          '<label>Actividad</label>' +
          '<textarea name="task_activity[]" class="form-control" rows="2" required>' + escapeHtml(data.activity || '') + '</textarea>' +
        '</div></div>' +
        '<div class="col-md-3"><div class="form-group" style="position:relative;">' +
          '<label>Responsable</label>' +
          '<input type="hidden" name="task_responsible_id[]" class="employee-id" value="' + (data.responsible_employee_id || '') + '">' +
          '<input type="text" name="task_responsible_name[]" class="form-control employee-search" autocomplete="off" value="' + escapeHtml(data.responsible_name || '') + '" required>' +
          '<div class="employee-results"></div>' +
        '</div></div>' +
        '<div class="col-md-2"><div class="form-group">' +
          '<label>Fecha</label>' +
          '<input type="date" name="task_due_date[]" class="form-control" value="' + (data.due_date || '') + '" required>' +
        '</div></div>' +
        '<div class="col-md-1"><div class="form-group">' +
          '<label>Prioridad</label>' +
          '<select name="task_priority[]" class="form-control"><option value="normal">Normal</option><option value="high">Alta</option><option value="low">Baja</option></select>' +
        '</div></div>' +
        '<div class="col-md-1"><label>&nbsp;</label><button type="button" class="btn btn-danger btn-block" onclick="$(this).closest(\'.dynamic-row\').remove();">×</button></div>' +
      '</div>' +
      '<input type="hidden" name="task_status[]" value="' + (data.status || 'pending') + '">'
    );
    row.find('select[name="task_priority[]"]').val(data.priority || 'normal');
    $('#compromisosContainer').append(row);
  }

  $(document).on('input', '.employee-search', function() {
    var input = $(this);
    var q = input.val();
    var box = input.siblings('.employee-results');
    input.siblings('.employee-id').val('');
    if (q.length < 2) {
      box.hide();
      return;
    }
    $.getJSON('registro_actas.php', { accion: 'search_employees', q: q }, function(resp) {
      box.empty();
      resp.results.forEach(function(item) {
        var label = item.name + (item.office_email ? ' - ' + item.office_email : '');
        var btn = $('<button type="button"></button>').text(label);
        btn.data('item', item);
        box.append(btn);
      });
      box.toggle(resp.results.length > 0);
    });
  });

  $(document).on('click', '.employee-results button', function() {
    var item = $(this).data('item');
    var wrap = $(this).closest('.form-group');
    wrap.find('.employee-id').val(item.id);
    wrap.find('.employee-search').val(item.name);
    wrap.closest('.dynamic-row').find('.employee-position').val(item.position_name || '');
    wrap.find('.employee-results').hide();
  });

  $(document).on('click', function(e) {
    if (!$(e.target).closest('.employee-search, .employee-results').length) {
      $('.employee-results').hide();
    }
  });

  function abrirTarea(id, status) {
    $('#task_update_id').val(id);
    $('#task_update_status').val(status);
    $('#task_update_comment').val('');
    $('#modalTarea').modal('show');
  }

  function imprimirActa(id) {
    window.open('acta_imprimir.php?id=' + encodeURIComponent(id), '_blank');
  }

  function escapeHtml(str) {
    return String(str || '').replace(/[&<>"']/g, function(m) {
      return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[m];
    });
  }
</script>
</body>
</html>
