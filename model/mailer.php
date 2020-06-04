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

require 'PHPMailer-6.1.6/src/Exception.php';
require 'PHPMailer-6.1.6/src/PHPMailer.php';
require 'PHPMailer-6.1.6/src/SMTP.php';

require_once("model/mailIdentifiers.php");

$emergencyLevelT = ["low" => "Faible", "medium" => "Modérée", "high" => "Haute"];
$typeT = ["hardware" => "Matériel", "software" => "Logiciel", "other" => "Autre"];

$userInfoFrom = getUserInfoFromId($userFrom);

var_dump($userInfoFrom);

$baseText = "Une nouvelle demande à été crée :\r\n Importance : " . $emergencyLevelT[$emergencyLevel] . "\r\n Du type : " . $typeT[$type] . "\r\nDemande de : " . $userInfoFrom['lastName'] . " " . $userInfoFrom['firstName'] . " - " . $userInfoFrom['email']."\r\n\r\n";

$baseText .= $descriptionRequest;
$baseText .= "\r\n\r\n Consulter la demande : <a href=\"http://127.0.0.1/tpi/?action=requestDetails&idRequest=$idRequest\">$titleRequest</a>";


$htmlText = str_replace("\r\n", "<br>", $baseText);

$error = "";

$mail = new PHPMailer(true);


updateLastMail($idRequest);

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
    if (is_numeric($userTo)) {
        $userInfoTo = getUserInfoFromId($userTo);
        $mail->addAddress($userInfoTo['email'], $userInfoTo['lastName'] . " " . $userInfoTo['firstName']);     // Add a recipient
    } else {
        $admins = getAdmins();
        foreach ($admins as $admin) {
            $mail->addAddress($admin['email'], $admin['lastName'] . " " . $admin['firstName']);     // Add a recipient

        }
    }

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Nouvelle demande : ' . $titleRequest;
    $mail->Body    = $htmlText;
    $mail->AltBody = $baseText;
    var_dump($mail);
    // $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
