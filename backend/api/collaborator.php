<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('Content-Type: application/json');
    require_once("../connection.php");

    if ($_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(405);
        echo json_encode( [ 'success' => false , 'message' => 'Method Not Allowed', 'method_allowed' => ['GET', 'POST'] ]);
        die();
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['user_id']) && (empty($_POST['enabled']) && empty($_POST['admin']))) {
        http_response_code(400);
        echo json_encode( [ 'success' => false , 'message' => 'Bad Request', 'body' => ['user_id', 'enabled', 'admin'] ]);
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (empty($_GET['offset'])) $_GET['offset'] = 0;
        $sql = "SELECT * FROM user LIMIT 6 OFFSET $_GET[offset]";
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
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['enabled']))  $sql = "UPDATE user SET enabled = '$_POST[enabled]' WHERE id = $_POST[user_id]";
        else if (!empty($_POST['admin']))  $sql = "UPDATE user SET admin = '$_POST[admin]' WHERE id = $_POST[user_id]";
        
        try {
            $result = $conn->query($sql);
        } catch (\Throwable $th) {
            echo json_encode( [ 'success' => false , 'message' => $conn->error, 'error_code' => $conn->errno ]);
            die();
        }
            
        if ($result) {
            echo json_encode( [ 'success' => true , 'message' => 'Dados alterados com sucesso' ]);
            die();
        } else {
            http_response_code(401);
            echo json_encode( [ 'success' => false , 'message' => 'Ocorreu um erro ao alterar os dados' ]);
            die();
        }
    }
?>