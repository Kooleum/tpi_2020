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
    <title></title>
</head>

<body class="text-white bg-dark text-center ">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <th scope="col">Conserne</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Date d'ouverture</th>
                    <th scope="col">Date de fin prévue</th>
                    <th scope="col">détails</th>
                    <th scope="col">Status</th>
                </thead>
                <tbody>
                    <?= $datas ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>