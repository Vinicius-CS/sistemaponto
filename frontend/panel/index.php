<?php
    $env = parse_ini_file('../.env');
    session_start();
    if (empty($_SESSION['userId'])) header('Location: ' . $env['system_baseurl']);
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
                    <?php if($_SESSION['userAdmin'] == 'true') { ?>
                        <a class="item" onclick="location.href=''">Relatório</a> |
                        <div class="dropdown">
                            <a class="dropbtn item">Colaborador</a>
                            <div class="dropdown-content">
                                <a onclick="location.href=''">Listagem</a>
                                <a onclick="location.href='./collaborator/register.php'">Cadastrar</a>
                            </div>
                        </div> |
                    <?php } ?>
                    <a class="item" onclick="location.href='../request/logout.php'">Sair</a>
                </div>

                <div class="content">
                    <table>
                        <tr>
                            <th>Entrada</th>
                            <th>Saída</th>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                        <tr>
                            <td>DD/MM/YYYY HH:SS:II</td>
                            <td>DD/MM/YYYY HH:SS:II</td>
                        </tr>
                    </table>
                    <button>Registrar Entrada</button>
                </div>
            </div>
        </div>
    </div>
</html>

<script>
    function alterPage(link) {
        document.getElementById("frame").src = link;
    }
</script>