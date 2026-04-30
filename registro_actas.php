<?php
session_start();

if (!isset($_SESSION['id'])) {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(array('respuesta' => 'NO_SESSION'));
  exit();
}

include('scripts/config.php');

$conexion = mysqli_connect($server, $user, $password, $database);
mysqli_set_charset($conexion, 'utf8');

if (!$conexion) {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'No fue posible conectar con la base de datos.'));
  exit();
}

ensure_actas_schema($conexion);

$accion = isset($_POST['accion']) ? $_POST['accion'] : (isset($_GET['accion']) ? $_GET['accion'] : 'list_minutes');
$isAdmin = isset($_SESSION['administrador']) && $_SESSION['administrador'] == 1;
$userId = $_SESSION['id'];
$employeeId = isset($_SESSION['empleado']) ? $_SESSION['empleado'] : '';

header('Content-Type: application/json; charset=utf-8');

switch ($accion) {
  case 'list_minutes':
    list_minutes($conexion, $isAdmin, $userId, $employeeId);
    break;
  case 'get_minute':
    get_minute($conexion, $_POST['id'], $isAdmin, $userId, $employeeId);
    break;
  case 'save_minute':
    save_minute($conexion, $userId, $employeeId);
    break;
  case 'delete_minute':
    delete_minute($conexion, $_POST['id'], $isAdmin, $userId);
    break;
  case 'list_tasks':
    list_tasks($conexion, $isAdmin, $employeeId);
    break;
  case 'update_task':
    update_task($conexion, $_POST['id'], $_POST['status'], isset($_POST['comment']) ? $_POST['comment'] : '', $isAdmin, $userId, $employeeId);
    break;
  case 'search_employees':
    search_employees($conexion, isset($_GET['q']) ? $_GET['q'] : '');
    break;
  default:
    echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'Acción no válida.'));
    break;
}

mysqli_close($conexion);

function ensure_actas_schema($conexion)
{
  mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS meeting_minutes (
    id VARCHAR(80) NOT NULL PRIMARY KEY,
    consecutive VARCHAR(50) NULL,
    meeting_date DATE NOT NULL,
    start_time TIME NULL,
    end_time TIME NULL,
    location VARCHAR(255) NULL,
    topics TEXT NULL,
    agenda TEXT NULL,
    development MEDIUMTEXT NULL,
    next_session_date DATE NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    created_by_user_id VARCHAR(80) NOT NULL,
    created_by_employee_id VARCHAR(80) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_meeting_date (meeting_date),
    INDEX idx_status (status),
    INDEX idx_created_by_user (created_by_user_id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

  mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS meeting_minute_attendees (
    id VARCHAR(80) NOT NULL PRIMARY KEY,
    minute_id VARCHAR(80) NOT NULL,
    employee_id VARCHAR(80) NOT NULL,
    employee_name VARCHAR(255) NOT NULL,
    position_name VARCHAR(255) NULL,
    attended TINYINT(1) NOT NULL DEFAULT 1,
    INDEX idx_minute_attendee_minute (minute_id),
    INDEX idx_minute_attendee_employee (employee_id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

  mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS meeting_minute_tasks (
    id VARCHAR(80) NOT NULL PRIMARY KEY,
    minute_id VARCHAR(80) NOT NULL,
    activity TEXT NOT NULL,
    responsible_employee_id VARCHAR(80) NOT NULL,
    responsible_name VARCHAR(255) NOT NULL,
    due_date DATE NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    priority VARCHAR(20) NOT NULL DEFAULT 'normal',
    closed_at DATETIME NULL,
    created_by_user_id VARCHAR(80) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_task_minute (minute_id),
    INDEX idx_task_responsible (responsible_employee_id),
    INDEX idx_task_status (status),
    INDEX idx_task_due_date (due_date)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

  mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS meeting_minute_task_logs (
    id VARCHAR(80) NOT NULL PRIMARY KEY,
    task_id VARCHAR(80) NOT NULL,
    user_id VARCHAR(80) NOT NULL,
    old_status VARCHAR(30) NULL,
    new_status VARCHAR(30) NOT NULL,
    comment TEXT NULL,
    created_at DATETIME NOT NULL,
    INDEX idx_task_log_task (task_id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
}

function new_id($prefix)
{
  return $prefix . '-' . date('YmdHis') . '-' . mt_rand(10000, 99999);
}

function post_value($key, $default = '')
{
  return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function can_view_minute($conexion, $minuteId, $isAdmin, $userId, $employeeId)
{
  if ($isAdmin) {
    return true;
  }

  $sql = "SELECT id FROM meeting_minutes WHERE id = ? AND (
    created_by_user_id = ?
    OR created_by_employee_id = ?
    OR EXISTS (SELECT 1 FROM meeting_minute_attendees WHERE minute_id = meeting_minutes.id AND employee_id = ?)
    OR EXISTS (SELECT 1 FROM meeting_minute_tasks WHERE minute_id = meeting_minutes.id AND responsible_employee_id = ?)
  ) LIMIT 1";
  $stmt = mysqli_prepare($conexion, $sql);
  mysqli_stmt_bind_param($stmt, 'sssss', $minuteId, $userId, $employeeId, $employeeId, $employeeId);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  return mysqli_num_rows($rs) > 0;
}

function list_minutes($conexion, $isAdmin, $userId, $employeeId)
{
  if ($isAdmin) {
    $sql = "SELECT m.*, 
      (SELECT COUNT(*) FROM meeting_minute_attendees a WHERE a.minute_id = m.id) AS attendees,
      (SELECT COUNT(*) FROM meeting_minute_tasks t WHERE t.minute_id = m.id) AS tasks
      FROM meeting_minutes m ORDER BY m.meeting_date DESC, m.created_at DESC";
    $rs = mysqli_query($conexion, $sql);
  } else {
    $sql = "SELECT m.*, 
      (SELECT COUNT(*) FROM meeting_minute_attendees a WHERE a.minute_id = m.id) AS attendees,
      (SELECT COUNT(*) FROM meeting_minute_tasks t WHERE t.minute_id = m.id) AS tasks
      FROM meeting_minutes m
      WHERE m.created_by_user_id = ?
        OR m.created_by_employee_id = ?
        OR EXISTS (SELECT 1 FROM meeting_minute_attendees a WHERE a.minute_id = m.id AND a.employee_id = ?)
        OR EXISTS (SELECT 1 FROM meeting_minute_tasks t WHERE t.minute_id = m.id AND t.responsible_employee_id = ?)
      ORDER BY m.meeting_date DESC, m.created_at DESC";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 'ssss', $userId, $employeeId, $employeeId, $employeeId);
    mysqli_stmt_execute($stmt);
    $rs = mysqli_stmt_get_result($stmt);
  }

  $data = array();
  while ($row = mysqli_fetch_assoc($rs)) {
    $data[] = $row;
  }

  echo json_encode(array('data' => $data));
}

function get_minute($conexion, $minuteId, $isAdmin, $userId, $employeeId)
{
  if (!can_view_minute($conexion, $minuteId, $isAdmin, $userId, $employeeId)) {
    echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'No tiene permiso para consultar esta acta.'));
    return;
  }

  $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minutes WHERE id = ? LIMIT 1");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);
  $minute = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  $attendees = array();
  $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minute_attendees WHERE minute_id = ? ORDER BY employee_name ASC");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($rs)) {
    $attendees[] = $row;
  }

  $tasks = array();
  $stmt = mysqli_prepare($conexion, "SELECT * FROM meeting_minute_tasks WHERE minute_id = ? ORDER BY due_date ASC, created_at ASC");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($rs)) {
    $tasks[] = $row;
  }

  echo json_encode(array('respuesta' => 'BIEN', 'minute' => $minute, 'attendees' => $attendees, 'tasks' => $tasks));
}

function save_minute($conexion, $userId, $employeeId)
{
  $id = post_value('id');
  $isNew = $id == '';

  if ($isNew) {
    $id = new_id('acta');
    $stmt = mysqli_prepare($conexion, "INSERT INTO meeting_minutes
      (id, consecutive, meeting_date, start_time, end_time, location, topics, agenda, development, next_session_date, status, created_by_user_id, created_by_employee_id, created_at, updated_at)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
  } else {
    $stmt = mysqli_prepare($conexion, "UPDATE meeting_minutes SET
      consecutive = ?, meeting_date = ?, start_time = ?, end_time = ?, location = ?, topics = ?, agenda = ?, development = ?, next_session_date = ?, status = ?, updated_at = NOW()
      WHERE id = ?");
  }

  $consecutive = post_value('consecutive');
  $meetingDate = post_value('meeting_date');
  $startTime = post_value('start_time');
  $endTime = post_value('end_time');
  $location = post_value('location');
  $topics = post_value('topics');
  $agenda = post_value('agenda');
  $development = post_value('development');
  $nextDate = post_value('next_session_date');
  $status = post_value('status', 'draft');
  $validStatuses = array('draft', 'approved', 'closed');

  if ($meetingDate == '') {
    echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'La fecha del acta es obligatoria.'));
    return;
  }

  if (!in_array($status, $validStatuses)) {
    $status = 'draft';
  }

  $startTime = $startTime == '' ? null : $startTime;
  $endTime = $endTime == '' ? null : $endTime;
  $nextDate = $nextDate == '' ? null : $nextDate;

  if ($isNew) {
    mysqli_stmt_bind_param($stmt, 'sssssssssssss', $id, $consecutive, $meetingDate, $startTime, $endTime, $location, $topics, $agenda, $development, $nextDate, $status, $userId, $employeeId);
  } else {
    mysqli_stmt_bind_param($stmt, 'sssssssssss', $consecutive, $meetingDate, $startTime, $endTime, $location, $topics, $agenda, $development, $nextDate, $status, $id);
  }

  if (!mysqli_stmt_execute($stmt)) {
    echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'No fue posible guardar el acta.'));
    return;
  }

  replace_attendees($conexion, $id);
  replace_tasks($conexion, $id, $userId);

  echo json_encode(array('respuesta' => 'BIEN', 'id' => $id));
}

function replace_attendees($conexion, $minuteId)
{
  $stmt = mysqli_prepare($conexion, "DELETE FROM meeting_minute_attendees WHERE minute_id = ?");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);

  $employees = isset($_POST['attendee_employee_id']) ? $_POST['attendee_employee_id'] : array();
  $names = isset($_POST['attendee_name']) ? $_POST['attendee_name'] : array();
  $positions = isset($_POST['attendee_position']) ? $_POST['attendee_position'] : array();
  $attended = isset($_POST['attendee_attended']) ? $_POST['attendee_attended'] : array();

  for ($i = 0; $i < count($employees); $i++) {
    $employeeId = trim($employees[$i]);
    $name = trim($names[$i]);
    if ($employeeId == '' || $name == '') {
      continue;
    }
    $position = isset($positions[$i]) ? trim($positions[$i]) : '';
    $wasPresent = isset($attended[$i]) && $attended[$i] == '1' ? 1 : 0;
    $rowId = new_id('asistente');

    $stmt = mysqli_prepare($conexion, "INSERT INTO meeting_minute_attendees (id, minute_id, employee_id, employee_name, position_name, attended) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssssi', $rowId, $minuteId, $employeeId, $name, $position, $wasPresent);
    mysqli_stmt_execute($stmt);
  }
}

function replace_tasks($conexion, $minuteId, $userId)
{
  $existing = array();
  $stmt = mysqli_prepare($conexion, "SELECT id, status, closed_at FROM meeting_minute_tasks WHERE minute_id = ?");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($rs)) {
    $existing[$row['id']] = $row;
  }

  $ids = isset($_POST['task_id']) ? $_POST['task_id'] : array();
  $activities = isset($_POST['task_activity']) ? $_POST['task_activity'] : array();
  $responsibles = isset($_POST['task_responsible_id']) ? $_POST['task_responsible_id'] : array();
  $responsibleNames = isset($_POST['task_responsible_name']) ? $_POST['task_responsible_name'] : array();
  $dueDates = isset($_POST['task_due_date']) ? $_POST['task_due_date'] : array();
  $priorities = isset($_POST['task_priority']) ? $_POST['task_priority'] : array();
  $statuses = isset($_POST['task_status']) ? $_POST['task_status'] : array();
  $kept = array();

  for ($i = 0; $i < count($activities); $i++) {
    $activity = trim($activities[$i]);
    $responsibleId = isset($responsibles[$i]) ? trim($responsibles[$i]) : '';
    $responsibleName = isset($responsibleNames[$i]) ? trim($responsibleNames[$i]) : '';
    $dueDate = isset($dueDates[$i]) ? trim($dueDates[$i]) : '';

    if ($activity == '' || $responsibleId == '' || $dueDate == '') {
      continue;
    }

    $taskId = isset($ids[$i]) && trim($ids[$i]) != '' ? trim($ids[$i]) : new_id('tarea');
    $priority = isset($priorities[$i]) ? trim($priorities[$i]) : 'normal';
    $status = isset($statuses[$i]) ? trim($statuses[$i]) : 'pending';
    $closedAtSql = $status == 'done' ? 'IFNULL(closed_at, NOW())' : 'NULL';
    $kept[] = $taskId;

    if (isset($existing[$taskId])) {
      $sql = "UPDATE meeting_minute_tasks SET activity = ?, responsible_employee_id = ?, responsible_name = ?, due_date = ?, status = ?, priority = ?, closed_at = $closedAtSql, updated_at = NOW() WHERE id = ?";
      $stmt = mysqli_prepare($conexion, $sql);
      mysqli_stmt_bind_param($stmt, 'sssssss', $activity, $responsibleId, $responsibleName, $dueDate, $status, $priority, $taskId);
      mysqli_stmt_execute($stmt);
    } else {
      $stmt = mysqli_prepare($conexion, "INSERT INTO meeting_minute_tasks
        (id, minute_id, activity, responsible_employee_id, responsible_name, due_date, status, priority, closed_at, created_by_user_id, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, ?, NOW(), NOW())");
      mysqli_stmt_bind_param($stmt, 'sssssssss', $taskId, $minuteId, $activity, $responsibleId, $responsibleName, $dueDate, $status, $priority, $userId);
      mysqli_stmt_execute($stmt);
      add_task_log($conexion, $taskId, $userId, '', $status, 'Compromiso creado desde acta.');
    }
  }

  foreach ($existing as $taskId => $task) {
    if (!in_array($taskId, $kept)) {
      $stmt = mysqli_prepare($conexion, "DELETE FROM meeting_minute_tasks WHERE id = ?");
      mysqli_stmt_bind_param($stmt, 's', $taskId);
      mysqli_stmt_execute($stmt);
    }
  }
}

function delete_minute($conexion, $minuteId, $isAdmin, $userId)
{
  if (!$isAdmin) {
    $stmt = mysqli_prepare($conexion, "SELECT id FROM meeting_minutes WHERE id = ? AND created_by_user_id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'ss', $minuteId, $userId);
    mysqli_stmt_execute($stmt);
    if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
      echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'No tiene permiso para eliminar esta acta.'));
      return;
    }
  }

  $taskIds = array();
  $stmt = mysqli_prepare($conexion, "SELECT id FROM meeting_minute_tasks WHERE minute_id = ?");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($rs)) {
    $taskIds[] = $row['id'];
  }

  foreach ($taskIds as $taskId) {
    $stmt = mysqli_prepare($conexion, "DELETE FROM meeting_minute_task_logs WHERE task_id = ?");
    mysqli_stmt_bind_param($stmt, 's', $taskId);
    mysqli_stmt_execute($stmt);
  }

  foreach (array('meeting_minute_attendees', 'meeting_minute_tasks') as $table) {
    $stmt = mysqli_prepare($conexion, "DELETE FROM $table WHERE minute_id = ?");
    mysqli_stmt_bind_param($stmt, 's', $minuteId);
    mysqli_stmt_execute($stmt);
  }
  $stmt = mysqli_prepare($conexion, "DELETE FROM meeting_minutes WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 's', $minuteId);
  mysqli_stmt_execute($stmt);

  echo json_encode(array('respuesta' => 'BIEN'));
}

function list_tasks($conexion, $isAdmin, $employeeId)
{
  if ($isAdmin) {
    $sql = "SELECT t.*, m.consecutive, m.meeting_date, m.location FROM meeting_minute_tasks t INNER JOIN meeting_minutes m ON (m.id = t.minute_id) ORDER BY t.due_date ASC, t.status ASC";
    $rs = mysqli_query($conexion, $sql);
  } else {
    $sql = "SELECT t.*, m.consecutive, m.meeting_date, m.location FROM meeting_minute_tasks t INNER JOIN meeting_minutes m ON (m.id = t.minute_id) WHERE t.responsible_employee_id = ? ORDER BY t.due_date ASC, t.status ASC";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 's', $employeeId);
    mysqli_stmt_execute($stmt);
    $rs = mysqli_stmt_get_result($stmt);
  }

  $data = array();
  while ($row = mysqli_fetch_assoc($rs)) {
    $data[] = $row;
  }

  echo json_encode(array('data' => $data));
}

function update_task($conexion, $taskId, $status, $comment, $isAdmin, $userId, $employeeId)
{
  $allowed = array('pending', 'in_progress', 'done', 'cancelled');
  if (!in_array($status, $allowed)) {
    echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'Estado no válido.'));
    return;
  }

  if ($isAdmin) {
    $stmt = mysqli_prepare($conexion, "SELECT id, status FROM meeting_minute_tasks WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $taskId);
  } else {
    $stmt = mysqli_prepare($conexion, "SELECT id, status FROM meeting_minute_tasks WHERE id = ? AND responsible_employee_id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'ss', $taskId, $employeeId);
  }
  mysqli_stmt_execute($stmt);
  $task = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if (!$task) {
    echo json_encode(array('respuesta' => 'ERROR', 'mensaje' => 'No tiene permiso para actualizar esta tarea.'));
    return;
  }

  $closedAtSql = $status == 'done' ? 'IFNULL(closed_at, NOW())' : 'NULL';
  $stmt = mysqli_prepare($conexion, "UPDATE meeting_minute_tasks SET status = ?, closed_at = $closedAtSql, updated_at = NOW() WHERE id = ?");
  mysqli_stmt_bind_param($stmt, 'ss', $status, $taskId);
  mysqli_stmt_execute($stmt);
  add_task_log($conexion, $taskId, $userId, $task['status'], $status, $comment);

  echo json_encode(array('respuesta' => 'BIEN'));
}

function add_task_log($conexion, $taskId, $userId, $oldStatus, $newStatus, $comment)
{
  $id = new_id('log');
  $stmt = mysqli_prepare($conexion, "INSERT INTO meeting_minute_task_logs (id, task_id, user_id, old_status, new_status, comment, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
  mysqli_stmt_bind_param($stmt, 'ssssss', $id, $taskId, $userId, $oldStatus, $newStatus, $comment);
  mysqli_stmt_execute($stmt);
}

function search_employees($conexion, $q)
{
  $q = '%' . trim($q) . '%';
  $sql = "SELECT employees.id, employees.name, employees.office_email, designations.name AS position_name
    FROM employees
    LEFT JOIN designations ON (employees.designation_id = designations.id)
    WHERE employees.soft_delete = 0
      AND employees.publish = 1
      AND (employees.name LIKE ? OR employees.office_email LIKE ?)
    ORDER BY employees.name ASC
    LIMIT 25";
  $stmt = mysqli_prepare($conexion, $sql);
  mysqli_stmt_bind_param($stmt, 'ss', $q, $q);
  mysqli_stmt_execute($stmt);
  $rs = mysqli_stmt_get_result($stmt);

  $data = array();
  while ($row = mysqli_fetch_assoc($rs)) {
    $data[] = $row;
  }

  echo json_encode(array('results' => $data));
}
