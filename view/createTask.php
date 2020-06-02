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

<body class="text-white bg-dark text-center bdbg">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container d-flex w-100 p-3 mx-auto flex-column  align-content-center">
        <h2>Créer une tâche</h2>
        <?= $error ?>
        <div class="col-lg-6 mx-auto mt-2">
            <form class="" action="#" method="POST">
                <input id="idRequest" name="idRequest" type="hidden" value="<?= $idRequest ?>">
                <div class="form-group required">
                    <label for="titleTask" class="control-label">Titre de la tâche</label>
                    <input class="form-control formInput" id="titleTask" name="titleTask" type="text" value="<?= $titleTask ?>">
                </div>
                <div class="form-group required">
                    <label for="commentTask" class="control-label">Description de la tâche</label>
                    <textarea class="form-control" name="commentTask" id="commentTask"><?= $commentTask ?></textarea>
                </div>
                <div class="form-group required">
                <label for="managedBy" class="control-label">Tâche gérée par</label>
                <select id="managedBy" class="form-control" name="managedBy" required>
                    <?= getAdminsOption() ?>
                </select>
            </div>
                <div class="form-group required">
                    <label for="statusTask" class="control-label">Niveau d'avencement</label>
                    <select id="statusTask" class="form-control" name="statusTask" required>
                        <option value="waiting" <?= $statusTask=="waiting"?'selected':'' ?>>En Attente</option>
                        <option value="progress" <?= $statusTask=="progress"?'selected':'' ?>>En Cours</option>
                    </select>
                </div>
                <div class="form-group required">
                    <label for="endDateValued" class="control-label">Date de fin estimée</label>
                    <input class="form-control formInput" id="endDateValued" name="endDateValued" type="date" min="<?= $nowDate ?>" value="<?= $endDateValued ?>"">
                </div>
                <button class="btn btn-primary" name="submit" value="submited" type="submit">Créer la tâche</button>
            </form>
        </div>
    </div>
    <?php require_once "footer.html" ?>
</body>

</html>