<?php
    $env = parse_ini_file('../.env');
    session_start();

    if (empty($_SESSION['user'])) header('Location: ' . $env['system_baseurl']);
    else if ($_SESSION['user']['admin'] == 'false') header('Location: ' . $env['system_baseurl']);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $env['api_baseurl'] . 'user.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('enabled' => 'true')
    ));

    $response = json_decode(curl_exec($curl), true);
    $_SESSION['userList'] = $response;
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
                    <a class="item" onclick="location.href='./report.php'">Relatório</a> |
                    <div class="dropdown">
                        <a class="dropbtn item">Colaborador</a>
                        <div class="dropdown-content">
                            <a class="subitem" onclick="location.href='./collaborator/list.php'">Listagem</a>
                            <a class="subitem" onclick="location.href='./collaborator/register.php'">Cadastrar</a>
                        </div>
                    </div> |
                    <a class="item" onclick="location.href='../request/logout.php'">Sair</a>
                </div>

                <div class="content">
                    <h1>RELATÓRIO</h1>
                    <h3 class="error_message"><?php echo(empty($_SESSION['error_message']) ? '&nbsp;' : $_SESSION['error_message']); unset($_SESSION['error_message']) ?></h3>
                    <form action="../request/report.php" method="post">
                        <div class="filter">
                            <div style="margin-right: 2%">
                                <select onchange="this.form.submit()" name="user_id">
                                    <option value="" <?= empty($_SESSION['timesheetData']) ? 'selected' : '' ?> hidden>Selecione um Usuário</option>
                                    <?php
                                        if (!empty($_SESSION['userList'])) {
                                            foreach ($_SESSION['userList'] as $key => $value) {
                                                echo "
                                                    <option ".(!empty(($_SESSION['timesheetData']['user_id']) && ($_SESSION['timesheetData']['user_id'] == $value['id'])) ? 'selected' : '')." value='".$value['id']."'>".$value['name']."</option>
                                                ";
                                            }
                                        }
                                    ?>
                                </select>
                                <hr>
                                <div>
                                    <label for="date_end"><b>Insira a data de entrada</b></label>
                                    <input <?= (empty($_SESSION['timesheetData']) ? 'disabled' : '') ?> value="<?= ((!empty($_SESSION['timesheetData']) && !empty($_SESSION['timesheetData']['date_start'])) ? $_SESSION['timesheetData']['date_start'] : '') ?>" onchange="this.form.submit()" type="date" name="date_start"/>
                                </div>
                            </div>

                            <div style="margin-left: 2%">
                                <select <?= (empty($_SESSION['timesheetData']) ? 'disabled' : '') ?> onchange="this.form.submit()" name="orderby">
                                    <option value="" <?= empty($_SESSION['timesheetData']) ? '' : '' ?>>Ordenar por</option>
                                    <option value="start_desc" <?= ((!empty($_SESSION['timesheetData']) && ($_SESSION['timesheetData']['orderby'] == 'start_desc')) ? 'selected' : '') ?>>Entrada Recente</option>
                                    <option value="start_asc" <?= ((!empty($_SESSION['timesheetData']) && ($_SESSION['timesheetData']['orderby'] == 'start_asc')) ? 'selected' : '') ?>>Entrada Antiga</option>
                                    <option value="end_desc" <?= ((!empty($_SESSION['timesheetData']) && ($_SESSION['timesheetData']['orderby'] == 'end_desc')) ? 'selected' : '') ?>>Saída Recente</option>
                                    <option value="end_asc" <?= ((!empty($_SESSION['timesheetData']) && ($_SESSION['timesheetData']['orderby'] == 'end_asc')) ? 'selected' : '') ?>>Saída Antiga</option>
                                </select>
                                <hr>
                                <div>
                                    <label for="date_end"><b>Insira a data de saída</b></label>
                                    <input <?= (empty($_SESSION['timesheetData']) ? 'disabled' : '') ?> value="<?= ((!empty($_SESSION['timesheetData']) && !empty($_SESSION['timesheetData']['date_end'])) ? $_SESSION['timesheetData']['date_end'] : '') ?>" onchange="this.form.submit()" type="date" name="date_end"/>
                                </div>
                            </div>
                        </div>

                        <table>
                            <tr>
                                <th>Entrada</th>
                                <th>Saída</th>
                            </tr>
                            <?php
                                $offset = 0;
                                if (!empty($_SESSION['timesheetData']['offset'])) $offset = $_SESSION['timesheetData']['offset'];
                                
                                for ($i=0; $i < 5; $i++) { 
                                    echo "
                                        <tr>
                                        <td>".(empty($_SESSION['timesheetUser'][$i]['start']) ? '&nbsp;' : date_format(date_create($_SESSION['timesheetUser'][$i]['start']), 'd/m/Y H:i:s'))."</td>
                                        <td>".(empty($_SESSION['timesheetUser'][$i]['start']) ? '&nbsp;' : (empty($_SESSION['timesheetUser'][$i]['end']) ? 'PENDENTE' : date_format(date_create($_SESSION['timesheetUser'][$i]['end']), 'd/m/Y H:i:s')))."</td>
                                        </tr>
                                    ";
                                }
                            ?>
                            <tr>
                                <?php if ($offset == 0) {?>
                                    <th class="icon disabled">&laquo; <a class="button_page disabled">Anterior</a></th>
                                <?php } else { ?>
                                    <th>&laquo; <button class="button_page" onclick="this.form.submit()" name="offset" value="<?php echo $i - 5 ?>">Anterior</button></th>
                                <?php }
                                if (!empty($_SESSION['timesheetUser']) && count($_SESSION['timesheetUser']) < 6) {?>
                                    <th class="icon disabled"><a class="button_page disabled">Próximo</a> &raquo;</th>
                                <?php } else { ?>
                                    <th><button class="button_page" onclick="this.form.submit()" name="offset" value="<?php echo $i ?>">Próximo</button> &raquo;</th>
                                <?php } unset($_SESSION['timesheetUser']); unset($_SESSION['timesheetData']) ?>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</html>