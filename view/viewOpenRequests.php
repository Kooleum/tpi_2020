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
    <title>Demandes ouvertes</title>
</head>

<body class="text-white bg-dark text-center ">
    <?php
    require_once 'nav.php';
    ?>
    <h3>Demandes ouvertes</h3>
    <div class="container table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date d'ouverture</th>
                    <th scope="col">Ouverte par</th>
                    <th scope="col">Administrateur en charge</th>
                    <th scope="col">Importance</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Détails</th>
                </tr>
            </thead>
            <tbody>
                <?= $datas ?>
            </tbody>
        </table>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>