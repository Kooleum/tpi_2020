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
    <title>FAQ</title>
</head>

<body class="text-white bg-dark text-center ">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container">
        <h3>FAQ</h3>
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
                    <li class="list-group-item">Votre demande peut également avoir été supprimée si l'administrateur en charge de celle-ci la trouvait innapropriée.</li>
                </ul>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    Puis-je modifier une demande que j'ai postée ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">L'envoi de demande étant libre d'accès et ne nécéssitant pas de connextion, il est impossible de savoir si c'est bien vous qui avez posté une demande c'est pourquoi il n'est pas possible de la modifier.</li>
                    <li class="list-group-item">Toute fois les administrateur en ont la possibilité, si vous voulez apporter des modification à votre demande informez en l'administrateur qui s'en charge.</li>
                </ul>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    Comment supprimer une demande ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">En tant qu'utilisateur il vous est impossible de supprimer une demande une fois envoyée, de plus les demandes sont visibles par tout le monde. Faites donc attention à ne pas inclure des information sensibles.</li>
                    <li class="list-group-item">En tant qu'administrateur, il vous suffit d'aller dans les détails d'une demande et de cliquer sur le bouton supprimer, toute fois, vous ne pouvez supprimer que les demandes qui vous sont assigées (pensez également à envoyer un mail avant la suppression pour en informer l'utilisateur).</li>
                </ul>
            </div>
            <div class="card mt-2 ">
                <div class="card-header">
                    J'ai du mal à comprendre le tabelau ou la page de détails de demande
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Vous trouverez ci-dessous une image expliquant le tableau des demandes ouvertes.<div class="row"><img class="col-12" src="files/img/requestTable.png" alt="image d'explication du tableau"></div>
                    </li>
                    <li class="list-group-item">Vous trouverez ci-dessous une image expliquant la page de détail d'une demande.<div class="row"><img class="col-12" src="files/img/requestDetails.png" alt="image d'explication du tableau"></div>
                    </li>
                </ul>
            </div>
            <div class="card mt-2 ">
                <div class="card-header">
                    Que faire si je ne peux pas m'occuper d'une demande ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">En tant qu'administrateur responsable de la demande, il vous est possible de la transférer à un autre administrateur. A partir de ce moment vous ne pourrez plus faire la moindre modification.</li>
                </ul>
            </div>
            <div class="card mt-2 ">
                <div class="card-header">
                    Que faire des demandes non affectées ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">En tant qu'administrateur vous pouvez affecter les demandes qui ne sont gérées par personne à n'importe quel administrateur, vous pouvez également la gérér vous même.</li>
                </ul>
            </div>
            <div class="card mt-2 ">
                <div class="card-header">
                    Que faire quand j'ai terminé de m'occuper d'une demande ?
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">En tant qu'administrateur vous pouvez changer l'état d'avancement d'une demande à l'aide des boutons sur la page de détails de la demande, tout au long du traitement, n'oubliez pas de tenir le demandeur au courant par email en appuyant sur le bouton envoyer un mail. Toutefois, faites attention à ne pas trop en envoyer</li>
                </ul>
            </div>
        </div>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>