<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'model/crud.php';

$error = "";
$errorF = "";

$submitedForm2 = filter_input(INPUT_POST, 'submitedForm2', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
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

if ($submitedForm2) {
    //verifying form infos
    if (!empty($email) && !empty($password)) {

        $username = "DEFINE('MAIL_ADRESS', '$email');";
        $pass = "DEFINE('MAIL_PASSWORD', '$password');";

        $toWrite = $fileHeader . LINE_BREAK . $username . LINE_BREAK . $pass;

        $dbIdentifiersFile = fopen("config/mailIdentifiers.php", "w+");
        fwrite($dbIdentifiersFile, $toWrite, strlen($toWrite));
        fclose($dbIdentifiersFile);

        require 'PHPMailer-6.1.6/src/Exception.php';
        require 'PHPMailer-6.1.6/src/PHPMailer.php';
        require 'PHPMailer-6.1.6/src/SMTP.php';

        require_once("config/mailIdentifiers.php");

        $mail = new PHPMailer(true);

        //Using PHPMailer lib
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = MAIL_ADRESS;                     // SMTP username
            $mail->Password   = MAIL_PASSWORD;                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->charSet    = 'UTF-8';
            $mail->Encoding   = 'base64';

            //Recipients
            $mail->setFrom(MAIL_ADRESS, 'Mailer');
            $mail->addAddress(MAIL_ADRESS);     // Add a recipient

            // Content
            $text = "Cet email n'est envoyé que pour valider les identifiants mails que vous avez fournis dans le processus d'installation de eiTicky aucune action n'est requise de votre part.";
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Email de test - eiTicky';
            $mail->Body    = $text;
            $mail->AltBody = $text;
            $mail->send();
            $_SESSION['install_step']=3;
            header("Refresh: 0");
            exit();
        } catch (Exception $e) {
            $error = '<div class="alert alert-danger"><h3>Une erreure est survenue. Veuillez verifier les informations.</h3></div>';
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
    <h1 class="text-center">eiTicky installation - 2/3</h1>
    <?= $error ?>
    <div class="alert alert-info"><p>Vous êtes sur la page d'installation du site.<br />Veuillez remplir le formulaire ci-dessous avec les identifiants mails que vous souhaitez utiliser pour l'envoi de mail depuis l'application (identique à tout les administrateurs) </p><p>Si par la suite elles venaient à changer vous pourriez les modifier dans le dossier de configuration du site (donfig/dbIdentifiers.php)</p></div>
    <form action="#" method="post">
        <?= $errorF ?>
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
        <button class="btn btn-primary" type="submit" value="submited" name="submitedForm2">Valider</button>
    </form>
</body>

</html>