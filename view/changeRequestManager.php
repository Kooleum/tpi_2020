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
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Changer le propiétaire de la demande</title>
</head>

<body class="text-white bg-dark text-center ">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container">
        <h2 class="text-warning mt-md-3">&#9888; </h2>
        <h3 class="text-warning mt-md-3"><?= $messageWarning ?></h3>
        <form action="#" method="post">
            <?= $error ?>
            <input id="idRequestSubmited" name="idRequestSubmited" type="hidden" value="<?= $idRequest ?>">
            <div class="form-group">
                <label for="adminTo">
                    <h4>Demande à destination de</h4>
                </label>
                <select id="adminTo" class="form-control" name="adminTo" required>
                    <?= getAdminsOption() ?>
                </select>
            </div>

            <button class="btn btn-warning" name="submit" value="submited" type="submit">Transferer la demande</button>
        </form>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>