<?php
    $env = parse_ini_file('./.env');
    session_start();
    if (!empty($_SESSION['user'])) header('Location: ' . $env['system_baseurl'] . 'panel');
?>

<html lang="pt_Br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link rel="stylesheet" type="text/css" href="./css/register.css">
        <title>Sistema Ponto - Registrar-se</title>
    </head>

    <div class="register">
        <form action="./request/register.php" method="post">
            <div class="container">
                <h1>REGISTRAR-SE</h1>
                <h3 class="error_message"><?php echo(empty($_SESSION['error_message']) ? '&nbsp;' : $_SESSION['error_message']); ?></h3>

                <div><label for="name"><b>Nome Completo</b></label></div>
                <input type="text" placeholder="Insira seu nome" name="name" required/>

                <div><label for="email"><b>E-mail</b></label></div>
                <input type="text" placeholder="Insira seu e-mail" name="email" required/>

                <div><label for="password"><b>Senha</b></label></div>
                <input type="password" placeholder="Insira sua senha" name="password" required/>

                <div class="grid">
                    <button type="submit">Registrar-se</button>
                    <button type="button" onclick="location.href='index.php'">Login</button>
                </div>
            </div>
        </form>
    </div>
</html>