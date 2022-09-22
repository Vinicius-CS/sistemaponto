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

    } else if (empty($_GET['user_id']) && (empty($_POST['user_id']) || empty($_POST['type']))) {
        http_response_code(400);
        echo json_encode( [ 'success' => false , 'message' => 'Bad Request', 'body' => ['user_id', 'type'] ]);
        die();
    }

    if (!empty($_GET['user_id'])) {
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
    } else if ($_POST['type'] == 'report' || $_POST['type'] == 'list') {
        if (empty($_GET['offset'])) $_GET['offset'] = 0;
        
        $where = '';
        $orderby = '';

        if (!empty($_POST['start_orderby'])) $orderby = " ORDER BY start $_POST[start_orderby]";
        if (!empty($_POST['end_orderby'])) $orderby = " ORDER BY end $_POST[end_orderby]";
        if (!empty($_POST['start_where'])) $where = $where . " AND start LIKE '%" . date_format(date_create($_POST['start_where']), 'Y-m-d') . "%'";
        if (!empty($_POST['end_where'])) $where = $where . " AND end LIKE '%" . date_format(date_create($_POST['end_where']), 'Y-m-d') . "%'";

        if ($_POST['type'] == 'report') $sql = "SELECT * FROM time_sheet WHERE user_id = '$_POST[user_id]'$where$orderby LIMIT 6 OFFSET $_GET[offset]";
        else if ($_POST['type'] == 'list') $sql = "SELECT * FROM time_sheet WHERE user_id = '$_POST[user_id]' ORDER BY start DESC, end DESC LIMIT 6 OFFSET $_GET[offset]";

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
            echo json_encode( [ 'success' => false , 'message' => 'Nenhum registro encontrado' ]);
            die();
        }

    }
?>