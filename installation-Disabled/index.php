<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$error = "";
$errorF = "";

$submited = filter_input(INPUT_POST, 'submited', FILTER_SANITIZE_STRING);
$dbHost = filter_input(INPUT_POST, 'dbHost', FILTER_SANITIZE_STRING);
$dbName = filter_input(INPUT_POST, 'dbName', FILTER_SANITIZE_STRING);
$dbUsername = filter_input(INPUT_POST, 'dbUsername', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

$fileHeader = "<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */ 

//Identifiers for the DB connection";

const LINE_BREAK = "\r\n";

//if script can delete itself
if (!is_writable(".")) {
    $error = '<div class="alert alert-danger"><h3>Attention cette page (index.php) doit avoir des droits en écriture sur le serveur</h3></div>';
}

if ($submited) {
    //verifying form infos
    if (!empty($dbHost) && !empty($dbName) && !empty($dbUsername) && !empty($password)) {

        $host = "DEFINE('DB_HOST', '$dbHost');";
        $name = "DEFINE('DB_NAME', '$dbName');";
        $username = "DEFINE('DB_USER', '$dbUsername');";
        $pass = "DEFINE('DB_PASS', '$password');";

        $toWrite = $fileHeader . LINE_BREAK . $host . LINE_BREAK . $name . LINE_BREAK . $username . LINE_BREAK . $pass;

        $dbIdentifiersFile = fopen("config/dbIdentifiers.php", "w+");
        fwrite($dbIdentifiersFile, $toWrite, strlen($toWrite));
        fclose($dbIdentifiersFile);

        require_once 'model/crud.php';

        if (getConnexion()) {
            try {
                $_SESSION['install_step']=2;
                header("Refresh: 0");
                exit();
            } catch (Exception $e) {
                $error = '<div class="alert alert-danger"><h3>Une erreure est survenue</h3></div>';
            }
        } else {
            $error = '<div class="alert alert-danger"><h3>Une erreure est survenue. Veuillez verifier les informations</h3></div>';
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
    <title>Installation - 1/3</title>
</head>

<body class="container mt-2">
    <h1 class="text-center">eiTicky installation - Identifiants de la base de données</h1>
    <?= $error ?>
    <div class="alert alert-info">
        <p>Vous êtes sur la page d'installation du site. (1/3)<br />Veuillez remplir le formulaire ci-dessous avec les information de connexion à la base de données.</p>
        <p>Si par la suite elles venaient à changer vous pourriez les modifier dans le dossier de configuration du site (donfig/dbIdentifiers.php)</p>
    </div>
    <form action="#" method="post">
        <?= $errorF ?>
        <div class="form-group row">
            <label for="dbHost" class="col-md-3 col-form-label">Hôte de la base de donnée :</label>
            <div class="col-md-9">
                <input class="form-control" type="text" id="dbHost" name="dbHost" placeholder="e.g. 127.0.0.1" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="dbName" class="col-md-3 col-form-label">Nom de la base de données :</label>
            <div class="col-md-9">
                <input class="form-control" type="text" id="dbName" name="dbName" placeholder="e.g. eiticky_db" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="dbUsername" class="col-md-3 col-form-label">Nom de l'utilisateur de la base de donnée :</label>
            <div class="col-md-9">
                <input class="form-control" type="text" id="dbUsername" name="dbUsername" placeholder="e.g. eiticky_web" required />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="password">Mot de passe :</label>
            <div class="col-md-9">
                <input class="form-control" type="password" id="password" name="password" required />
            </div>
        </div>
        <button class="btn btn-primary" type="submit" value="submited" name="submited">Valider</button>
    </form>
</body>

</html>