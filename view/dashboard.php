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
    <title>Dashboard</title>
</head>

<body class="text-white bg-dark text-center bdbg">
    <?php
    require_once 'view/nav.php';
    ?>
    <div class="container">
        <?= $error ?>
        <h2 class="mt-1">Dashboard</h2>
        <div class="mt-5">
            <span class="border rounded border-info row my-2 py-2 px-2 justify-content-center">
                <h3 class="col-12">Mes demandes non résolues</h3>
                <div class="card text-white bg-dark border-danger col-md-10 my-2">
                    <div class="card-header">
                        <h4>Demandes non assignées</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $unownedRequests ?></h3>
                    </div>
                </div>
                <div class="card text-white bg-dark border-danger col-md-3 my-2">
                    <div class="card-header">
                        <h4>Demandes urgentes ouvertes</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $emergencyOpen ?></h3>
                    </div>
                </div>

                <div class="card text-white bg-dark border-warning col-md-3 ml-md-3 my-2">
                    <div class="card-header">
                        <h4>Demandes modérées ouvertes</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $meduimOpen ?></h3>
                    </div>
                </div>
                <div class="card text-white bg-dark border-success col-md-3 ml-md-3 my-2">
                    <div class="card-header">
                        <h4>Demandes faibles ouvertes</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $lowOpen ?></h3>
                    </div>
                </div>
            </span>
            <span class="border rounded border-light row py-2 px-2 my-2 justify-content-center">
                <h3 class="col-12">Mes tâches</h3>
                <div class="card text-white bg-dark border-warning col-md-5 my-2">
                    <div class="card-header">
                        <h4>Tâches ouvertes</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $openTasks ?></h3>
                    </div>
                </div>
                <div class="card text-white bg-dark border-success col-md-5 ml-md-3 my-2">
                    <div class="card-header">
                        <h4>Tâches closes</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $closedTasks ?></h3>
                    </div>
                </div>
            </span>
            <span class="border rounded border-success row py-2 px-2 my-2 justify-content-center">
                <h3 class="col-12">Mes demandes résolues</h3>
                <div class="card text-white bg-dark border-grey col-md-3 my-2">
                    <div class="card-header">
                        <h4>Demandes urgentes</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $emergencyClosed ?></h3>
                    </div>
                </div>
                
                <div class="card text-white bg-dark border-grey col-md-3 ml-md-3 my-2">
                    <div class="card-header">
                        <h4>Demandes modérées</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $meduimClosed ?></h3>
                    </div>
                </div>
                <div class="card text-white bg-dark border-grey col-md-3 ml-md-3 my-2">
                    <div class="card-header">
                        <h4>Demandes faibles</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-text"><?= $lowClosed ?></h3>
                    </div>
                </div>
            </span>
            
        </div>
        <?php require_once "view/footer.html" ?>
    </body>

</html>