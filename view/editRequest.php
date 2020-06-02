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
    <title>Modifier une demande</title>
</head>

<body class="text-white text-center bg-dark ">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container mt-2">
        <h2 class="text-center">Modifier une demande</h2>
        <?= $error ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="titleRequest">Titre de la demande</label>
                <div class="col-sm-10">
                    <input type="text" name="titleRequest" id="titleRequest" class="form-control" required value="<?= $titleRequest ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="titleRequest">Description détalilée de la demande</label>
                <div class="col-sm-10">
                    <textarea name="descriptionRequest" id="descriptionRequest" class="form-control"><?= $descriptionRequest ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="type">Type de demande</label>
                <div class="col-sm-10">
                    <select id="type" class="form-control" name="type" required>
                        <option value="hardware" <?= $type == "hardware" ? 'selected' : '' ?>>Hardware</option>
                        <option value="software" <?= $type == "software" ? 'selected' : '' ?>>Software</option>
                        <option value="other" <?= $type == "other" ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="emergencyLevel">Niveau d'urgence</label>
                <div class="col-sm-10">
                    <select id="emergencyLevel" class="form-control" name="emergencyLevel" required>
                        <option value="low" <?= $emergencyLevel == "low" ? 'selected' : '' ?>>Failbe</option>
                        <option value="medium" <?= $emergencyLevel == "medium" ? 'selected' : '' ?>>moyen</option>
                        <option value="high" <?= $emergencyLevel == "high" ? 'selected' : '' ?>>Haut</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="userTo">Demande à destination de</label>
                <div class="col-sm-10">
                    <select id="userTo" class="form-control" name="userTo" required>
                        <?= getAdminsOption() ?>
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
            <button class="btn btn-primary" name="submit" value="submited" type="submit">Modifier la demande</button>
        </form>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>