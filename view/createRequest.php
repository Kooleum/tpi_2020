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
    <title>Créer une demande</title>
</head>

<body class="text-white  text-center bg-dark ">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container mt-2">
        <h2 class="text-center">Formuler une demande</h2>
        <?= $error ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="titleRequest">Titre de la demande <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="titleRequest" id="titleRequest" class="form-control" required value="<?= $descriptionRequest ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="titleRequest">Description détaillée de la demande <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <textarea name="descriptionRequest" id="descriptionRequest" class="form-control"><?= $descriptionRequest ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="type">Type de demande <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <select id="type" class="form-control" name="type" required>
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="emergencyLevel">Niveau d'urgence <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <select id="emergencyLevel" class="form-control" name="emergencyLevel" required>
                        <option value="low">Faible</option>
                        <option value="medium">moyen</option>
                        <option value="high">Haut</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="userTo">Demande à destination de</label>
                <div class="col-sm-10">
                    <select id="userTo" class="form-control" name="userTo" required>
                        <option value="null">N'importe quel administrateur</option>
                        <?= getAdminsOption() ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="userFrom">Demande de <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <select id="userFrom" class="form-control" name="userFrom" required>
                        <option></option>
                        <?= getUsersOption() ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="location">Emplacement</label>
                <div class="col-sm-10">

                    <select id="location" class="form-control" name="location" required>
                        <option value="null">Ne s'applique pas</option>
                        <?= getLocationsOption() ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="medias">Medias <small class="text-info"><b>(image ou pdf)</b></small> <small class="text-warning"><b>(Max 30 Mo)</b></small></label>
                <div class="col-sm-10">
                    <div class='alert alert-danger' hidden id="sizeTooBig">La taille totale des fichiers est trop importante (>30 Mo) votre demande ne seras pas envoyée</div>
                    <input type="file" id="medias" name="medias[]" onchange="loadFile(event)" accept="image/*, application/pdf" multiple class="form-control-file">
                </div>
            </div>

            <button class="btn btn-primary" name="submit" value="submited" type="submit">Envoyer la demande</button>
        </form>
    </div>
    <?php require_once "footer.html" ?>
    <script src="js/fileSizeWarning.js"></script>

</body>

</html>