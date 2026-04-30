<?php

function dashboard_banner_defaults()
{
  return array(
    'enabled' => '0',
    'type' => 'text',
    'title' => '',
    'body' => '',
    'cta_text' => '',
    'cta_url' => '',
    'image' => '',
    'start_date' => '',
    'end_date' => '',
    'updated_at' => ''
  );
}

function dashboard_banner_dir()
{
  return dirname(__DIR__) . '/plugins/upload/dashboard_banner';
}

function dashboard_banner_file()
{
  return dashboard_banner_dir() . '/config.json';
}

function dashboard_banner_public_path($file)
{
  if (trim($file) == '') {
    return '';
  }

  return 'plugins/upload/dashboard_banner/' . basename($file);
}

function dashboard_banner_load()
{
  $banner = dashboard_banner_defaults();
  $file = dashboard_banner_file();

  if (is_file($file)) {
    $stored = json_decode(file_get_contents($file), true);
    if (is_array($stored)) {
      $banner = array_merge($banner, $stored);
    }
  }

  return $banner;
}

function dashboard_banner_save($banner)
{
  $dir = dashboard_banner_dir();
  if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
  }

  $banner = array_merge(dashboard_banner_defaults(), $banner);
  $banner['updated_at'] = date('Y-m-d H:i:s');

  return file_put_contents(dashboard_banner_file(), json_encode($banner, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

function dashboard_banner_is_active($banner)
{
  if (!isset($banner['enabled']) || $banner['enabled'] != '1') {
    return false;
  }

  $today = date('Y-m-d');
  if (trim($banner['start_date']) != '' && $today < $banner['start_date']) {
    return false;
  }

  if (trim($banner['end_date']) != '' && $today > $banner['end_date']) {
    return false;
  }

  if ($banner['type'] == 'image') {
    return trim($banner['image']) != '';
  }

  return trim($banner['title']) != '' || trim($banner['body']) != '';
}

function dashboard_banner_escape($value)
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
