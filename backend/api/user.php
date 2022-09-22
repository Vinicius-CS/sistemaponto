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

    }

    $where = '';
    if (!empty($_POST['enabled'])) $where = " WHERE enabled='$_POST[enabled]'";
    
    $sql = "SELECT id, name, email, admin, enabled FROM user$where";
    $result = $conn->query($sql);
        
    if ($result->num_rows > 0) {
        $data = [];
        while ($res = mysqli_fetch_assoc($result)) {
            array_push($data, $res);
        }
        $jsons = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo $jsons;
        die();
    } else {
        http_response_code(401);
        echo json_encode( [ 'success' => false , 'message' => 'Usuário ou senha inválidos' ]);
        die();
    }
?>