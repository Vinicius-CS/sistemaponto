<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('Content-Type: application/json');
    require_once("../connection.php");

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(405);
        echo json_encode( [ 'success' => false , 'message' => 'Method Not Allowed', 'method_allowed' => ['POST'] ]);
        die();

    } else if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
        http_response_code(400);
        echo json_encode( [ 'success' => false , 'message' => 'Bad Request', 'body' => ['name', 'email', 'password'] ]);
        die();
    }

    if (empty($_POST['enabled'])) {
        $sql = "SELECT * FROM user LIMIT 1";
        $result = $conn->query($sql);

        if (empty($_POST['admin']) && $result->num_rows == 0) {
            $_POST['admin'] = 'true';
            $_POST['enabled'] = 'true';
        }
    }

    if (empty($_POST['admin'])) {
        $_POST['admin'] = 'false';
    }

    if (empty($_POST['enabled'])) {
        $_POST['enabled'] = 'false';
    }

    try {
        $sql = "INSERT INTO user(name, email, password, admin, enabled) VALUES ('$_POST[name]', '$_POST[email]', MD5('$_POST[password]'), '$_POST[admin]', '$_POST[enabled]')";
        $result = $conn->query($sql);
    } catch (\Throwable $th) {
        echo json_encode( [ 'success' => false , 'message' => $conn->error, 'error_code' => $conn->errno ]);
        die();
    }
        
    if ($result) {
        echo json_encode( [ 'success' => true , 'message' => 'Registrado com sucesso' ]);
        die();
    } else {
        http_response_code(401);
        echo json_encode( [ 'success' => false , 'message' => 'Ocorreu um erro ao se registrar' ]);
        die();
    }
?>