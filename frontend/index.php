<?php
    $env = parse_ini_file('./.env');
    session_start();
    if (!empty($_SESSION['user'])) header('Location: ' . $env['system_baseurl'] . 'panel');
    if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])) session_destroy();
?>

<html lang="pt_Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link rel="stylesheet" type="text/css" href="./css/index.css">
        <title>Sistema Ponto - Entrar</title>
    </head>
    
    <div class="index">
        <form action="./request/login.php" method="post">
            <div class="container">
                <h1>ENTRAR</h1>
                <?php if (!empty($_SESSION['success_message'])) { ?>
                    <h3 class="success_message"><?php echo $_SESSION['success_message'] ?></h3>
                <?php } else { ?>
                    <h3 class="error_message"><?php echo(empty($_SESSION['error_message']) ? '&nbsp;' : $_SESSION['error_message']) ?></h3>
                <?php } ?>

                <label for="email"><b>E-mail</b></label>
                <input type="text" placeholder="Insira seu e-mail" name="email" required>

                <label for="password"><b>Senha</b></label>
                <input type="password" placeholder="Insira sua senha" name="password" required>

                <div class="grid">
                    <button type="submit">Login</button>
                    <button type="button" onclick="location.href='register.php'">Registrar-se</button>
                </div>
            </div>
        </form>
    </div>
</html>