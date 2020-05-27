<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connection</title>
</head>

<body class="text-white bg-dark text-center bdbg">
    <?php
    require_once 'view/nav.php';
    ?>
    <div class="container d-flex w-100 p-3 mx-auto flex-column  align-content-center">
        <h1>eiTicky</h1>
        <h2>Outil de gestion de tickets informatique</h2>
        <?= $error ?>
        <div class="col-lg-6 mx-auto mt-2">
            <form class="" action="#" method="POST">
                <div class="form-group">
                    <label>
                        <h5>Email</h5>
                    </label>
                    <input class="form-control formInput" id="email" name="email" type="email">
                </div>
                <div class="form-group">
                    <label>
                        <h5>Mot de passe</h5>
                    </label>
                    <input class="form-control formInput" id="password" name="password" type="password">
                </div>
                <button class="btn btn-primary" name="submit" value="submited" type="submit">Connextion</button>
            </form>
        </div>
        <?php require_once "view/footer.html" ?>
    </div>
</body>

</html>