<?php
  session_start();
  if(!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
  }

  include('scripts/config.php');
  $conexion = mysqli_connect($server, $user, $password, $database);
  mysqli_set_charset($conexion, 'utf8');

  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $isAdmin = isset($_SESSION['administrador']) && $_SESSION['administrador'] == 1;
  $userId = $_SESSION['id'];
  $employeeId = isset($_SESSION['empleado']) ? $_SESSION['empleado'] : '';

  if (!$conexion || $id == '') {
    die('Acta no disponible.');
  }

  if ($isAdmin) {
    $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minutes WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $id);
  } else {
    $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minutes WHERE id = ? AND (
      created_by_user_id = ?
      OR created_by_employee_id = ?
      OR EXISTS (SELECT 1 FROM meeting_minute_attendees WHERE minute_id = meeting_minutes.id AND employee_id = ?)
      OR EXISTS (SELECT 1 FROM meeting_minute_tasks WHERE minute_id = meeting_minutes.id AND responsible_employee_id = ?)
    ) LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'sssss', $id, $userId, $employeeId, $employeeId, $employeeId);
  }
  mysqli_stmt_execute($stmt);
  $minute = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if (!$minute) {
    die('No tiene permiso para consultar esta acta.');
  }

  $attendees = array();
  $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minute_attendees WHERE minute_id = ? ORDER BY employee_name ASC");
  mysqli_stmt_bind_param($stmt, 's', $id);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($rs)) {
    $attendees[] = $row;
  }

  $tasks = array();
  $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minute_tasks WHERE minute_id = ? ORDER BY due_date ASC");
  mysqli_stmt_bind_param($stmt, 's', $id);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($rs)) {
    $tasks[] = $row;
  }

  function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  function date_part($date, $part) {
    if (!$date) return '';
    $ts = strtotime($date);
    if (!$ts) return '';
    if ($part == 'd') return date('d', $ts);
    if ($part == 'm') return date('m', $ts);
    return date('Y', $ts);
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acta de reunión institucional</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #000;
      margin: 28px;
      font-size: 13px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 16px;
    }

    td, th {
      border: 1px solid #222;
      padding: 7px;
      vertical-align: top;
    }

    .no-border td {
      border: 0;
    }

    .center { text-align: center; }
    .middle { vertical-align: middle; }
    .header-title { font-size: 20px; font-weight: 700; }
    .section { background: #dbe8f4; font-weight: 700; text-align: center; }
    .muted { background: #edf4fb; font-weight: 700; }
    .large-box { min-height: 220px; white-space: pre-wrap; }
    .medium-box { min-height: 90px; white-space: pre-wrap; }
    .signature { height: 42px; }

    @media print {
      body { margin: 12mm; }
      .no-print { display: none; }
    }
  </style>
</head>
<body>
  <div class="no-print" style="margin-bottom:16px;">
    <button onclick="window.print()">Imprimir / Guardar PDF</button>
  </div>

  <table>
    <tr>
      <td rowspan="3" class="center middle" style="width:18%;">FUP</td>
      <td class="center header-title">GESTIÓN DE CALIDAD</td>
      <td class="center header-title" style="width:24%;">Código: FO-GC-001</td>
    </tr>
    <tr>
      <td rowspan="2" class="center header-title middle">ACTA DE REUNIÓN INSTITUCIONAL</td>
      <td class="center header-title">Versión: 07</td>
    </tr>
    <tr>
      <td class="center header-title">Fecha: Noviembre 2022</td>
    </tr>
  </table>

  <table>
    <tr><td colspan="7" class="section">GENERALIDADES DE LA SESIÓN</td></tr>
    <tr>
      <td colspan="3" class="muted center">Fecha De Acta</td>
      <td class="muted center">Hora de Inicio</td>
      <td class="muted center">Hora de Final</td>
      <td class="muted center">Sitio de la Reunión</td>
      <td class="muted center">No. Consecutivo</td>
    </tr>
    <tr>
      <td class="center">dd<br><?php echo h(date_part($minute['meeting_date'], 'd')); ?></td>
      <td class="center">mm<br><?php echo h(date_part($minute['meeting_date'], 'm')); ?></td>
      <td class="center">aaaa<br><?php echo h(date_part($minute['meeting_date'], 'y')); ?></td>
      <td class="center"><?php echo h(substr($minute['start_time'], 0, 5)); ?></td>
      <td class="center"><?php echo h(substr($minute['end_time'], 0, 5)); ?></td>
      <td><?php echo h($minute['location']); ?></td>
      <td><?php echo h($minute['consecutive']); ?></td>
    </tr>
    <tr>
      <td class="muted center" colspan="2">TEMAS A TRATAR</td>
      <td colspan="5" class="medium-box"><?php echo nl2br(h($minute['topics'])); ?></td>
    </tr>
  </table>

  <table>
    <tr><td colspan="4" class="section">CONTROL DE ASISTENCIA A LA SESIÓN</td></tr>
    <tr>
      <td class="muted center">Asistente</td>
      <td class="muted center">Cargo</td>
      <td class="muted center">Asistió</td>
      <td class="muted center">Firma</td>
    </tr>
    <?php foreach ($attendees as $attendee) { ?>
      <tr>
        <td><?php echo h($attendee['employee_name']); ?></td>
        <td><?php echo h($attendee['position_name']); ?></td>
        <td class="center"><?php echo $attendee['attended'] == 1 ? 'Sí' : 'No'; ?></td>
        <td class="signature"></td>
      </tr>
    <?php } ?>
  </table>

  <table>
    <tr><td class="section">ORDEN DE LA SESIÓN</td></tr>
    <tr><td class="medium-box"><?php echo nl2br(h($minute['agenda'])); ?></td></tr>
  </table>

  <table>
    <tr><td class="section">DESARROLLO DE LA SESIÓN</td></tr>
    <tr><td class="large-box"><?php echo nl2br(h($minute['development'])); ?></td></tr>
  </table>

  <table>
    <tr><td colspan="4" class="section">COMPROMISOS DE LA SESIÓN</td></tr>
    <tr>
      <td class="muted center">Actividad</td>
      <td class="muted center">Responsable</td>
      <td class="muted center">Fecha</td>
      <td class="muted center">Estado</td>
    </tr>
    <?php foreach ($tasks as $task) { ?>
      <tr>
        <td><?php echo nl2br(h($task['activity'])); ?></td>
        <td><?php echo h($task['responsible_name']); ?></td>
        <td class="center"><?php echo h($task['due_date']); ?></td>
        <td class="center"><?php echo h($task['status']); ?></td>
      </tr>
    <?php } ?>
  </table>

  <table>
    <tr>
      <td class="muted">Fecha Siguiente Sesión y/o Revisión De Compromisos</td>
      <td><?php echo h($minute['next_session_date']); ?></td>
    </tr>
  </table>

  <table>
    <tr><td colspan="4" class="section">APROBACIÓN DEL ACTA</td></tr>
    <tr>
      <td class="muted center">Nombre</td>
      <td class="muted center">Firma</td>
      <td class="muted center">Nombre</td>
      <td class="muted center">Firma</td>
    </tr>
    <tr>
      <td class="signature"></td>
      <td class="signature"></td>
      <td class="signature"></td>
      <td class="signature"></td>
    </tr>
  </table>
</body>
</html>
