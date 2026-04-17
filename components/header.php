<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', "1");
    error_reporting(E_ALL);


    session_start();

    if(!isset($pagetitle))
    {
        $pageTitle = "Restaurant - Login";
    }
    $db = new mysqli("localhost", "root", "root", "web-dev-project-group-assignment", 3306);

?>
<DOCTYPE html>
    <html>
        <head>
            <title><?= $pageTitle ?></title>
        </head>
        <body>
            <div class="container mt-3">

            <?php if(isset($_SESSION['success'])) : ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                </div>
            <?php
                endif;
                unset($_SESSION['success']);
            ?>