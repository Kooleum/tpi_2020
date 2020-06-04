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

$idRequest = filter_input(INPUT_POST, "idRequest", FILTER_SANITIZE_NUMBER_INT);
$textMail = filter_input(INPUT_POST, "textMail", FILTER_SANITIZE_STRING);
$textMail .= "\r\n\r\n Veuillez ne pas répondre à cet email";
// $textMail = utf8_encode($textMail);
$htmlText = str_replace("\r\n", "<br>", $textMail);
// $htmlText = utf8_encode($htmlText);

$requestInfos = getRequestById($idRequest);
$userInfo = getUserInfoFromId($requestInfos['idUserFrom']);

$error = "";

$mail = new PHPMailer(true);


//Using PHPMailer lib
try {
    //Server settings
    $mail->isSMTP();                                        // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                               // Enable SMTP authentication
    $mail->Username   = MAIL_ADRESS;                        // SMTP username
    $mail->Password   = MAIL_PASSWORD;                      // SMTP password
    $mail->SMTPSecure = 'tsl';                              // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->charSet    = 'utf-8';                            // Encoding mail in utf8
    $mail->Encoding   = 'base64';
    $mail->setLanguage('fr');

    //Recipients
    $mail->setFrom(MAIL_ADRESS, 'Mailer');
    $mail->addAddress($userInfo['email'], $userInfo['lastName'] . " " . $userInfo['firstName']);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Suivis de demande : ' . $requestInfos['titleRequest'];
    $mail->Body    = $htmlText;                             // html text
    $mail->AltBody = $textMail;                             // if mail browser does not support html mails

    $mail->send();

    updateLastMail($idRequest);
    header("Location: ?action=requestDetails&idRequest=" . $idRequest); //if everything ok go back to page
    exit();
} catch (Exception $e) {
    echo $mail->ErrorInfo;
    // header("Location: ?action=requestDetails&error=error&idRequest=".$idRequest); // if an error occure go back and display error message
    exit();
}
