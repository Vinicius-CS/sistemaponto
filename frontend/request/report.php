<?php
  $env = parse_ini_file('../.env');
  $curl = curl_init();
  session_start();

  if (empty($_POST['offset'])) {
    $_POST['offset'] = 0;
  }

  $postfield = ['user_id' => $_POST['user_id'], 'type' => 'report'];
  if (!empty($_POST['date_start'])) $postfield['start_where'] = $_POST['date_start'];
  if (!empty($_POST['date_end'])) $postfield['end_where'] = $_POST['date_end'];

  if (!empty($_POST['orderby'])) {
    if ($_POST['orderby'] == 'start_desc') $postfield['start_orderby'] = 'DESC';
    if ($_POST['orderby'] == 'start_asc') $postfield['start_orderby'] = 'ASC';
    if ($_POST['orderby'] == 'end_desc') $postfield['end_orderby'] = 'DESC';
    if ($_POST['orderby'] == 'end_asc') $postfield['end_orderby'] = 'ASC';
  }
  print_r($_POST);

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $env['api_baseurl'] . 'timesheet.php?offset=' . $_POST['offset'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $postfield
  ));

  $response = json_decode(curl_exec($curl), true);
  $info = curl_getinfo($curl);

  $_SESSION['timesheetData']['offset'] = $_POST['offset'];
  $_SESSION['timesheetData']['user_id'] = $_POST['user_id'];
  $_SESSION['timesheetData']['orderby'] = $_POST['orderby'];
  $_SESSION['timesheetData']['date_start'] = $_POST['date_start'];
  $_SESSION['timesheetData']['date_end'] = $_POST['date_end'];

  if ($info['http_code'] == 200) {
    $_SESSION['timesheetUser'] = $response;
    header('Location: ' . $env['system_baseurl'] . 'panel/report.php');
  } else if (!empty($response['message'])) {
    $_SESSION['error_message'] = $response['message'];
    header('Location: ' . $env['system_baseurl'] . 'panel/report.php');
  } else {
    $_SESSION['error_message'] = 'Ocorreu um erro inesperado';
    header('Location: ' . $env['system_baseurl'] . 'panel/report.php');
  }
?>