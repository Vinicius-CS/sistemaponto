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

    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_GET['user_id'])) {
        http_response_code(400);
        echo json_encode( [ 'success' => false , 'message' => 'Bad Request', 'params' => ['user_id'] ]);
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (empty($_GET['offset'])) $_GET['offset'] = 0;
        if (empty($_GET['user_id'])) $sql = "SELECT * FROM time_sheet ORDER BY start DESC, end DESC LIMIT 6 OFFSET $_GET[offset]";
        else $sql = "SELECT * FROM time_sheet WHERE user_id = '$_GET[user_id]' ORDER BY start DESC, end DESC LIMIT 6 OFFSET $_GET[offset]";

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
        date_default_timezone_set('America/Sao_Paulo');
        $datetime = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM time_sheet WHERE user_id = '$_GET[user_id]' AND end is null";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            try {
                $sql = "INSERT INTO time_sheet(start, user_id) VALUES ('$datetime','$_GET[user_id]')";
                $result = $conn->query($sql);
            } catch (\Throwable $th) {
                echo json_encode( [ 'success' => false , 'message' => $conn->error, 'error_code' => $conn->errno ]);
                die();
            }
                
            if ($result) {
                echo json_encode( [ 'success' => true , 'message' => 'Entrada registrada com sucesso' ]);
                die();
            } else {
                http_response_code(401);
                echo json_encode( [ 'success' => false , 'message' => 'Ocorreu um erro ao registrar a entrada' ]);
                die();
            }
        } else if ($result->num_rows > 0) {
            try {
                $sql = "UPDATE time_sheet SET end = '$datetime' WHERE user_id = '$_GET[user_id]' AND end is null";
                $result = $conn->query($sql);
            } catch (\Throwable $th) {
                echo json_encode( [ 'success' => false , 'message' => $conn->error, 'error_code' => $conn->errno ]);
                die();
            }
                
            if ($result) {
                echo json_encode( [ 'success' => true , 'message' => 'Saída registrada com sucesso' ]);
                die();
            } else {
                http_response_code(401);
                echo json_encode( [ 'success' => false , 'message' => 'Ocorreu um erro ao registrar a saída' ]);
                die();
            }
        }
    }
?>