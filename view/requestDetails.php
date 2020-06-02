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
    <title>Détails de la demande</title>
</head>

<body class="text-white bg-dark text-center bdbg">
    <?php
    require_once 'nav.php';
    ?>

    <div class="container">
        <div class="row">

            <div class="card text-dark bg-light border-grey col-12">
                <div class="card-header text-left">
                    <h2><?= $titleRequest ?></h2>
                    <h5>Demande de type <?= $type . " - Urgence " . $emergency ?></h5>
                    <div class="mt-md-2">
                        <?= $buttons ?>
                    </div>
                </div>
                <div style="max-height:30vh; overflow:auto;" class="card-body text-left">
                    <h3 class="card-title">Description détalliée</h3>
                    <p class="card-text p-1"><?= $descriptionRequest ?></p>
                </div>
                <div class="card-body text-left">
                    <h3>Médias associés</h3>
                    <?= $medias ?>
                </div>
            </div>
            <table class="mt-2 table table-dark table-responsive-md col-12">
                <thead>
                    <tr>
                        <th colspan="6">Tâches</th>
                        <th colspan="2"><?= $createTaskButton ?></th>
                    </tr>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date de création</th>
                        <th>Date de fin estimée</th>
                        <th>Date de fin réelle</th>
                        <th>Status</th>
                        <th>Gérée par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $tasksTable ?>
                </tbody>
            </table>

            <div class="col-12 align-middle" hidden id="confirmBox">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header"><h2 class="text-danger">Attention</h2></div>
                    <div class="card-body">
                        <h4 class="card-text">Voulez vous vraiment supprimer la demande ?</h4>
                        <h4 class="card-text">Cela supprimera également <u>toutes les tâhces associées</u></h4>
                        <h4 class="card-text text-danger">&#9888; Cette action est irreversible !</h4>
                    </div>
                    <div class="card-body">
                    <button onclick="hide()" class="btn-success btn float-left">Annuler</button>    
                    <a href="?action=changeRequestStatus&idRequest=<?= $idRequest ?>&newStatus=remove"><button class="btn btn-danger float-right">Oui, supprimer la demande</button></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>