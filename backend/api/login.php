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

    } else if (empty($_POST['email']) || empty($_POST['password'])) {
        http_response_code(400);
        echo json_encode( [ 'success' => false , 'message' => 'Bad Request', 'body' => ['email', 'password'] ]);
        die();
    }
            
    $sql = "SELECT id, name, email, admin, enabled FROM user WHERE email = '$_POST[email]' AND password = MD5('$_POST[password]') AND enabled = 'true'";
    $result = $conn->query($sql);
        
    if ($result->num_rows > 0) {
        $res = mysqli_fetch_assoc($result);

        $jsons = json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo $jsons;
        die();
    } else {
        http_response_code(401);
        echo json_encode( [ 'success' => false , 'message' => 'Usuário ou senha inválidos' ]);
        die();
    }
?>