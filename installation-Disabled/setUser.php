<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

require_once 'model/crud.php';

$error = "";
$errorF = "";

$submitedForm3 = filter_input(INPUT_POST, 'submitedForm3', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_STRING);

//if script can delete itself
if (!is_writable(".")) {
    $error = '<div class="alert alert-danger"><h3>Attention cette page (index.php) doit avoir des droits en écriture sur le serveur</h3></div>';
}


if ($submitedForm3) {
    //verifying form infos
    if (!empty($email) && !empty($password) && !empty($passwordConfirm) && !empty($lastName) && !empty($firstName)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($password == $passwordConfirm) {
                $passwordEncripted = password_hash($password, PASSWORD_DEFAULT);
                startTransaction();
                if (createAdmin($lastName, $firstName, $email, $passwordEncripted)) {
                    try {
                        unlink(__DIR__ . "/index.php");
                        unlink(__DIR__ . "/setMailer.php");
                        unlink(__DIR__ . "/setUser.php");
                        $dir = scandir(__DIR__);
                        foreach ($dir as $file) {
                            if (file_exists(__DIR__ . "/" . $file)) {
                                unlink(__DIR__ . "/" . $file);
                            }
                        }
                        rmdir(__DIR__);
                        commitTransaction();
                        $_SESSION['install_step'] = "done";

                        header("Refresh:0");
                        exit();
                    } catch (Exception $e) {
                        rollBackTransaction();
                        $error = '<div class="alert alert-danger"><h3>Une erreure est survenue</h3></div>';
                    }
                } else {
                    $error = '<div class="alert alert-danger"><h3>Une erreure est survenue</h3></div>';
                }
            } else {
                $errorF = '<div class="alert alert-danger"><h3>Attention les 2 mot de passe ne sont pas identiques</h3></div>';
            }
        } else {
            $errorF = '<div class="alert alert-danger"><h3>Attention l\'adresse email n\'est pas valide</h3></div>';
        }
    } else {
        $errorF = '<div class="alert alert-danger"><h3>Attention tout les champs doivent être remplis</h3></div>';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation</title>
</head>

<body class="container mt-2">
    <h1 class="text-center">eiTicky installation - 3/3</h1>
    <?= $error ?>
    <p class="alert alert-info">Vous êtes sur la page d'installation du site.<br />Veuillez remplir le formulaire ci-dessous avec des informations corrects et dont vous vous souviendrez, il ne sera <b>pas</b> possible de les modifier ou les récupérez si vous les oubliez! </p>
    <form action="#" method="post">
        <?= $errorF ?>
        <div class="form-group row">
            <label for="lastName" class="col-md-3 col-form-label">Nom :</label>
            <div class="col-md-9">
                <input class="form-control" type="text" id="lastName" name="lastName" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="firstName" class="col-md-3 col-form-label">Prenom :</label>
            <div class="col-md-9">
                <input class="form-control" type="text" id="firstName" name="firstName" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label">Adresse email :</label>
            <div class="col-md-9">
                <input class="form-control" type="email" id="email" name="email" required />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="password">Mot de passe :</label>
            <div class="col-md-9">
                <input class="form-control" type="password" id="password" name="password" required />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="passwordConfirm">Répétez le mot de passe :</label>
            <div class="col-md-9">
                <input class="form-control" type="password" id="passwordConfirm" name="passwordConfirm" required />
            </div>
        </div>
        <button class="btn btn-primary" type="submit" value="submited" name="submitedForm3">Valider</button>
    </form>
</body>

</html>