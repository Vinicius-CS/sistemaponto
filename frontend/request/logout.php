<?php
    $env = parse_ini_file('../.env');
    session_start();
    session_destroy();
    header("Location: " . $env['system_baseurl']);
?>