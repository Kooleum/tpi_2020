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
        <div class="text-dark text-left">
            <div class="card mt-2">
                <div class="card-header">
                    Qui peut envoyer des demandes ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"> Ce site est destiné à tout les enseignants du CFPT, ils peuvent ainsi en selectionant leur nom dans le <a href="?action=createRequest">formulaire de création de demande</a> présiser que la demande vient d'eux pour assurer un suivis optimal de la part des administrateurs.</li>
                </ul>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    Une page de login est disponible mais je ne peux pas me connecter ni créer de compte, pourquoi?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"> La page de <a href="?action=login">login</a> n'est destinée qu'au administrateurs, elle leur permet de se connecter, de gérer toutes les demandes et effectuer les actions nécessaires relatives à celles-ci.</li>
                    <li class="list-group-item"> Vous pouvez malgré le fait que vous ne puissiez pas vous connecter envoyer des demandes depuis le <a href="?action=createRequest">formulaire de création de demande</a> et y sélectionner votre mail dans la liste déroulante dans le champs "demande de".</li>
                </ul>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    Comment être informé de l'avancement de ma demande ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"> Vous pouvez accéder à l'avancement de votre demande et voir les tâches qui y sont associées depuis la page <a href="?action=viewOpenRequests">demandes ouvertes</a> en cliquant sur le "bouton voir les détails" à coté de votre demande.</li>
                    <li class="list-group-item"> L'administrateur en charge de votre demande peut également vous envoyer un mail au fur et à mesure de son avancement dans le traitement de votre demande.</li>
                </ul>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    Je ne trouve plus ma demande dans les <a href="?action=viewOpenRequests">"demandes ouvrtes"</a>, où est-elle passée ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Votre demande a peut-être été traitée et donc indiquée comme "Terminée", dans ce cas votre demande se trouve sur la page <a href="?action=viewClosedRequests">demandes résolues</a>.</li>
                    <li class="list-group-item">Votre demande peut également avoir été supprimée si l'administrateur en charge de celle-ci la trouvait innapropriée</li>
                </ul>
            </div>
        </div>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>