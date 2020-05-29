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
    <title>Créer une demande</title>
</head>

<body class="text-white bg-dark text-center bdbg">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container d-flex w-100 p-3 mx-auto flex-column  align-content-center">
        <h2>Formuler une demande</h2>
        <?= $error ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titleRequest">Titre de la demande</label>
                <input type="text" name="titleRequest" id="titleRequest" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="titleRequest">Description détalilée de la demande</label>
                <textarea name="descriptionRequest" id="descriptionRequest" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="type">Type de demande</label>
                <select id="type" class="form-control" name="type" required>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="emergencyLevel">Niveau d'urgence</label>
                <select id="emergencyLevel" class="form-control" name="emergencyLevel" required>
                    <option value="low">Failbe</option>
                    <option value="medium">moyen</option>
                    <option value="high">Haut</option>
                </select>
            </div>
            <div class="form-group">
                <label for="userTo">Demande à destination de</label>
                <select id="userTo" class="form-control" name="userTo" required>
                    <option value="null">N'importe quel administrateur</option>
                    <?= getAdminsOption() ?>
                </select>
            </div>
            <div class="form-group">
                <label for="userFrom">Demande de</label>
                <select id="userFrom" class="form-control" name="userFrom" required>
                    <option></option>
                    <?= getNonAdminsOption() ?>
                </select>
            </div>
            <div class="form-group">
                <label for="location">Emplacement</label>
                <select id="location" class="form-control" name="location" required>
                    <option value="null">Ne s'applique pas</option>
                    <?= getLocationsOption() ?>
                </select>
            </div>
            <div class="form-group">
                <label for="userTo">En cours - Medias</label>
                <input type="file" name="medias" class="form-control-file">
            </div>


            <button class="btn btn-primary" name="submit" value="submited" type="submit">Envoyer la requette</button>
        </form>
    </div>
    <?php require_once "footer.html" ?>
    </div>
</body>

</html>