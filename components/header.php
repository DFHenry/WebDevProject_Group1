<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', "1");
    error_reporting(E_ALL);

    session_start();

    if(!isset($pagetitle))
    {
        $pageTitle = "Three Dudes Bakery";
    }
    $db = new mysqli("localhost", "root", "root", "web-dev-project-group-assignment", 3306);

?>
<!DOCTYPE html>
    <html>
        <head>
            <title><?= $pageTitle ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
            <link rel="stylesheet" href="../assets/css/styles.css">
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