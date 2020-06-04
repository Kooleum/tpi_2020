<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$idMedia = filter_input(INPUT_GET, "idMedia", FILTER_SANITIZE_NUMBER_INT);
$action = filter_input(INPUT_GET, "a", FILTER_SANITIZE_NUMBER_INT);

$error = "";

$media = getMediaById($idMedia);
$fileName = $media['originalFileName'];

//displaying medias on spoecific page
if($a="view"){
    if ($media['mime'] == "application/pdf") {
        header('Cache-Control: public');
        header('Content-Type: ' . $media['mime']);
        header('Content-Disposition: inline; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($media['pathMedia']));
        readfile($media['pathMedia']);
    } else {
        header('Cache-Control: public');
        header('Content-Type: ' . $media['mime']);
        header('Content-Disposition: inline; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($media['pathMedia']));
        readfile($media['pathMedia']);
    }
}
    