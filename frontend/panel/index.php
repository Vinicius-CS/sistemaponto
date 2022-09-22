<?php
    $env = parse_ini_file('../.env');
    session_start();
    if (empty($_SESSION['user'])) header('Location: ' . $env['system_baseurl']);

    if (empty($_GET['offset'])) {
        $_GET['offset'] = 0;
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $env['api_baseurl'] . 'timesheet.php?offset=' . $_GET['offset'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('user_id' => $_SESSION['user']['id'], 'type' => 'list')
    ));

    $response = json_decode(curl_exec($curl), true);
    $_SESSION['timesheet'] = $response;
?>

<html lang="pt_Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/panel.css">
        <title>Sistema Ponto - Painel</title>
    </head>

    <div class="panel">
        <div class="container">
            <div class="header">
                <h1>PAINEL</h1>

                <div class="menu">
                    <a class="item" onclick="location.href='../index.php'">Início</a> |
                    <?php if($_SESSION['user']['admin'] == 'true') { ?>
                        <a class="item" onclick="location.href='./report.php'">Relatório</a> |
                        <div class="dropdown">
                            <a class="dropbtn item">Colaborador</a>
                            <div class="dropdown-content">
                                <a class="subitem" onclick="location.href='./collaborator/list.php'">Listagem</a>
                                <a class="subitem" onclick="location.href='./collaborator/register.php'">Cadastrar</a>
                            </div>
                        </div> |
                    <?php } ?>
                    <a class="item" onclick="location.href='../request/logout.php'">Sair</a>
                </div>

                <div class="content">
                    <h1>INÍCIO</h1>
                    <?php if (!empty($_SESSION['success_message'])) { ?>
                        <h3 class="success_message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']) ?></h3>
                    <?php } else { ?>
                        <h3 class="error_message"><?php echo(empty($_SESSION['error_message']) ? '&nbsp;' : $_SESSION['error_message']); unset($_SESSION['error_message']) ?></h3>
                    <?php } ?>
                    <table>
                        <tr>
                            <th>Entrada</th>
                            <th>Saída</th>
                        </tr>
                        <?php
                            for ($i=0; $i < 5; $i++) { 
                                echo "
                                    <tr>
                                        <td>".(empty($_SESSION['timesheet'][$i]['start']) ? '&nbsp;' : date_format(date_create($_SESSION['timesheet'][$i]['start']), 'd/m/Y H:i:s'))."</td>
                                        <td>".(empty($_SESSION['timesheet'][$i]['start']) ? '&nbsp;' : (empty($_SESSION['timesheet'][$i]['end']) ? 'PENDENTE' : date_format(date_create($_SESSION['timesheet'][$i]['end']), 'd/m/Y H:i:s')))."</td>
                                    </tr>
                                ";
                            }
                        ?>
                        <tr>
                            <?php if ($_GET['offset'] == 0) {?>
                                <th class="icon disabled">&laquo; <a class="button_page disabled">Anterior</a></th>
                            <?php } else { ?>
                                <th>&laquo; <a class="button_page" href="?offset=<?php echo $i - 5 ?>">Anterior</a></th>
                            <?php }
                            if (!empty($_SESSION['timesheet']) && count($_SESSION['timesheet']) < 6) {?>
                                <th class="icon disabled"><a class="button_page disabled">Próximo</a> &raquo;</th>
                            <?php } else { ?>
                                <th><a class="button_page" href="?offset=<?php echo $i ?>">Próximo</a> &raquo;</th>
                            <?php } ?>
                        </tr>
                    </table>
                    <?php if (empty($_SESSION['timesheet'][0]['end'])) { ?>
                        <button onclick="location.href='../request/timesheet.php'">Registrar Saída</button>
                    <?php } else { ?>
                        <button onclick="location.href='../request/timesheet.php'">Registrar Entrada</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</html>