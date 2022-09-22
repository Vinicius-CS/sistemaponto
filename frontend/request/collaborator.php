<?php
    $env = parse_ini_file('../.env');

    $curl = curl_init();

    $postfield = ['user_id' => $_POST['user_id']];
    if (!empty($_POST['enabled']))  $postfield['enabled'] = $_POST['enabled'];
    else if (!empty($_POST['admin']))  $postfield['admin'] = $_POST['admin'];
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => $env['api_baseurl'] . 'collaborator.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postfield,
    ));

    $response = json_decode(curl_exec($curl), true);
    $info = curl_getinfo($curl);
    session_start();

    if ($info['http_code'] == 200) {
        $_SESSION['success_message'] = 'Dados alterados com sucesso';
        header('Location: ' . $env['system_baseurl'] . 'panel/collaborator/list.php');
    } else if (!empty($response['message'])) {
        $_SESSION['error_message'] = $response['message'];
        header('Location: ' . $env['system_baseurl'] . 'panel/collaborator/list.php');
    } else {
        $_SESSION['error_message'] = 'Ocorreu um erro inesperado';
        header('Location: ' . $env['system_baseurl'] . 'panel/collaborator/list.php');
    }
?>