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
$htmlText = str_replace("\r\n", "<br>", $textMail);

$requestInfos = getRequestById($idRequest);
$userInfo = getUserInfoFromId($requestInfos['idUserFrom']);

$error = "";

$mail = new PHPMailer(true);

updateLastMail($idRequest);

//Using PHPMailer lib
try {
    //Server settings
    //   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
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
    $mail->addAddress($userInfo['email'], $userInfo['lastName'] . " " . $userInfo['firstName']);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Suivis de demande : ' . $requestInfos['titleRequest'];
    $mail->Body    = $htmlText;
    $mail->AltBody = $textMail;

    $mail->send();
    echo 'Message has been sent';

    header("Location: ?action=requestDetails&idRequest=".$idRequest);
    exit();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
