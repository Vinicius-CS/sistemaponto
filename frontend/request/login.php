<?php
    $env = parse_ini_file('../.env');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $env['api_baseurl'] . 'login.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('email' => $_POST['email'], 'password' => $_POST['password']),
      ));

    $response = json_decode(curl_exec($curl), true);
    $info = curl_getinfo($curl);
    session_start();

    if ($info['http_code'] == 200) {
        $_SESSION['userId'] = $response['id'];
        $_SESSION['userName'] = $response['name'];
        $_SESSION['userEmail'] = $response['email'];
        $_SESSION['userAdmin'] = $response['admin'];
        $_SESSION['userEnabled'] = $response['enabled'];
        $_SESSION['userCompanyId'] = $response['company_id'];

        header('Location: ' . $env['system_baseurl'] . 'panel');
    } else if (!empty($response['message'])) {
        $_SESSION['error_message'] = $response['message'];
        header('Location: ' . $env['system_baseurl']);
    } else {
        $_SESSION['error_message'] = 'Ocorreu um erro inesperado';
        header('Location: ' . $env['system_baseurl']);
    }
?>