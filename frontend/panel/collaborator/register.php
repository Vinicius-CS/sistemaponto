<?php
    $env = parse_ini_file('../../.env');
    session_start();
    if (empty($_SESSION['user'])) header('Location: ' . $env['system_baseurl']);
    else if ($_SESSION['user']['admin'] == 'false') header('Location: ' . $env['system_baseurl']);
?>

<html lang="pt_Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../../css/panel.css">
        <title>Sistema Ponto - Cadastrar Colaborador</title>
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
                    <div >
                        <form action="../../request/collaborator.php" method="post">
                            <div>
                                <h1>CADASTRAR COLABORADOR</h1>
                                <?php if (!empty($_SESSION['success_message'])) { ?>
                                    <h3 class="success_message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']) ?></h3>
                                <?php } else { ?>
                                    <h3 class="error_message"><?php echo(empty($_SESSION['error_message']) ? '&nbsp;' : $_SESSION['error_message']); unset($_SESSION['error_message']) ?></h3>
                                <?php } ?>

                                <label for="name"><b>Nome Completo</b></label>
                                <input type="text" placeholder="Insira o nome do colaborador" name="name" required>

                                <label for="email"><b>E-mail</b></label>
                                <input type="text" placeholder="Insira o e-mail do colaborador" name="email" required>

                                <label for="password"><b>Senha</b></label>
                                <input type="password" placeholder="Insira a senha do colaborador" name="password" required>

                                <button type="submit">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>