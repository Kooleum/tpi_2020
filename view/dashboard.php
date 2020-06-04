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
    <title>Dashboard</title>
</head>

<body class="text-white bg-dark text-center ">
    <?php
    require_once 'view/nav.php';
    ?>
    <div class="container">
        <?= $error ?>
        <h2 class="mt-1">Dashboard</h2>
        <div class="mt-5">
            <span class="border rounded border-info row my-2 py-2 px-2 justify-content-center">
                <h3 class="col-12">Mes demandes non résolues</h3>
                <div class="col-md-10 my-2">
                    <div class="card text-white bg-dark border-danger">
                        <div class="card-header">
                            <h4>Demande<?= $unownedRequests > 1 ? 's' : '' ?> non assignée<?= $unownedRequests > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $unownedRequests ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-10 my-2">
                    <div class="card text-white bg-dark border-danger">
                        <div class="card-header">
                            <h4>Demande<?= $emergencyOpen > 1 ? 's' : '' ?> urgente<?= $emergencyOpen > 1 ? 's' : '' ?> ouverte<?= $emergencyOpen > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $emergencyOpen ?></h3>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-5 ml-md-3 my-2">
                    <div class="card text-white bg-dark border-warning">
                        <div class="card-header">
                            <h4>Demande<?= $meduimOpen > 1 ? 's' : '' ?> modérée<?= $meduimOpen > 1 ? 's' : '' ?> ouverte<?= $meduimOpen > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $meduimOpen ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 ml-md-3 my-2">
                    <div class="card text-white bg-dark border-success">
                        <div class="card-header">
                            <h4>Demande<?= $lowOpen > 1 ? 's' : '' ?> faible<?= $lowOpen > 1 ? 's' : '' ?> ouverte<?= $lowOpen > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $lowOpen ?></h3>
                        </div>
                    </div>
                </div>
            </span>
            <span class="border rounded border-light row py-2 px-2 my-2 justify-content-center">
                <h3 class="col-12">Mes tâches</h3>
                <div class=" col-md-10 my-2">
                    <div class="card text-white bg-dark border-danger">
                        <div class="card-header">
                            <h4>Tâche<?= $lateTasks > 1 ? 's' : '' ?> en retard</h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $lateTasks ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 my-2">
                    <div class="card text-white bg-dark border-warning">
                        <div class="card-header">
                            <h4>Tâche<?= $openTasks > 1 ? 's' : '' ?> ouverte<?= $openTasks > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $openTasks ?></h3>
                        </div>
                    </div>
                </div>
                <div class=" col-md-5 ml-md-3 my-2">
                    <div class="card text-white bg-dark border-success">
                        <div class="card-header">
                            <h4>Tâche<?= $closedTasks > 1 ? 's' : '' ?> close<?= $closedTasks > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $closedTasks ?></h3>
                        </div>
                    </div>
                </div>
            </span>
            <span class="border rounded border-success row py-2 px-2 my-2 justify-content-center">
                <h3 class="col-12">Mes demandes résolues</h3>
                <div class="col-lg-3 my-2">
                    <div class="card text-white bg-dark border-grey">
                        <div class="card-header">
                            <h4>Demande<?= $emergencyClosed > 1 ? 's' : '' ?> urgente<?= $emergencyClosed > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $emergencyClosed ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 ml-md-3 my-2">
                    <div class="card text-white bg-dark border-grey">
                        <div class="card-header">
                            <h4>Demande<?= $meduimClosed > 1 ? 's' : '' ?> modérée<?= $meduimClosed > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $meduimClosed ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 ml-md-3 my-2">
                    <div class="card text-white bg-dark border-grey">
                        <div class="card-header">
                            <h4>Demande<?= $meduimClosed > 1 ? 's' : '' ?> faible<?= $meduimClosed > 1 ? 's' : '' ?></h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text"><?= $lowClosed ?></h3>
                        </div>
                    </div>
            </span>
        </div>
    </div>
    <?php require_once "view/footer.html" ?>
</body>

</html>