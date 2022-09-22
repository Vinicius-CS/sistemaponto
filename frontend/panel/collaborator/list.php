<?php
    $env = parse_ini_file('../../.env');
    session_start();
    if (empty($_SESSION['user'])) header('Location: ' . $env['system_baseurl']);

    $offset = 0;
    if (isset($_GET['offset'])) {
        $offset = $_GET['offset'];
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $env['api_baseurl'] . 'collaborator.php?offset=' . $offset,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ));

    $response = json_decode(curl_exec($curl), true);
    $_SESSION['collaborator'] = $response;
?>

<html lang="pt_Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../../css/panel.css">
        <title>Sistema Ponto - Painel</title>
    </head>

    <div class="panel">
        <div class="container">
            <div class="header">
                <h1>PAINEL</h1>

                <div class="menu">
                    <a class="item" onclick="location.href='../index.php'">Início</a> |
                    <?php if($_SESSION['user']['admin'] == 'true') { ?>
                        <a class="item" onclick="location.href=''">Relatório</a> |
                        <div class="dropdown">
                            <a class="dropbtn item">Colaborador</a>
                            <div class="dropdown-content">
                                <a class="subitem" onclick="location.href='./list.php'">Listagem</a>
                                <a class="subitem" onclick="location.href='./register.php'">Cadastrar</a>
                            </div>
                        </div> |
                    <?php } ?>
                    <a class="item" onclick="location.href='../request/logout.php'">Sair</a>
                </div>

                <div class="content">
                    <h1>LISTAGEM DE COLABORADORES</h1>
                    <?php if (!empty($_SESSION['success_message'])) { ?>
                        <h3 class="success_message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']) ?></h3>
                    <?php } else { ?>
                        <h3 class="error_message"><?php echo(empty($_SESSION['error_message']) ? '&nbsp;' : $_SESSION['error_message']); unset($_SESSION['error_message']) ?></h3>
                    <?php } ?>
                    <table>
                        <tr>
                            <th>Nome</th>
                            <th>E-Mail</th>
                        </tr>
                        <?php
                            if (!empty($_SESSION['collaborator'])) {
                                for ($i=0; $i < 5; $i++) { 
                                    echo "
                                        <tr>
                                            <td>".(empty($_SESSION['collaborator'][$i]['name']) ? '&nbsp;' : $_SESSION['collaborator'][$i]['name'])."</td>
                                            <td>".(empty($_SESSION['collaborator'][$i]['email']) ? '&nbsp;' : $_SESSION['collaborator'][$i]['email'])."</td>
                                        </tr>
                                    ";
                                }
                            }
                        ?>
                        <tr>
                            <?php if ($offset == 0) {?>
                                <th class="icon disabled">&laquo; <a class="button_page disabled">Anterior</a></th>
                            <?php } else { ?>
                                <th>&laquo; <a class="button_page" href="?offset=<?php echo $i - 5 ?>">Anterior</a></th>
                            <?php }
                            if (count($_SESSION['collaborator']) < 6) {?>
                                <th class="icon disabled"><a class="button_page disabled">Próximo</a> &raquo;</th>
                            <?php } else { ?>
                                <th><a class="button_page" href="?offset=<?php echo $i ?>">Próximo</a> &raquo;</th>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</html>