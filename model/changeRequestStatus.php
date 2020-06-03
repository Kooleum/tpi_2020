<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$idRequest = filter_input(INPUT_GET, "idRequest", FILTER_SANITIZE_NUMBER_INT);
$newStatus = filter_input(INPUT_GET, "newStatus", FILTER_SANITIZE_STRING);

$status = ['waiting', 'handling', 'done'];

$error = "";

//leave page if invsalid request id or status
if (!is_numeric($idRequest) || empty($newStatus)) {
    header("Location: ?action=requestDetails&idRequest=" . $idRequest . "&error=error");
    exit();
}

$request = getRequestById($idRequest);

//remove request if admin is logeed
if ($newStatus == "remove" && !empty($_SESSION['id'])) {
    startTransaction();
    if (removeRequestTasks($idRequest)) {
        $medias = getRequestMedias($idRequest);
        foreach ($medias as $media) {
            unlink($media['pathMedia']);
            removeMedia($media['idMedia']);
        }
        if (removeRequest($idRequest)) {
            header("Location: ?action=requestDetails&idRequest=" . $idRequest . "&error=ok");
            commitTransaction();
        }
    }
    rollBackTransaction();
    header("Location: ?action=requestDetails&idRequest=" . $idRequest . "&error=error");
    exit();
}

//return to request if not admin
if ($request['idUserTo'] != $_SESSION['id']) {
    header("Location: ?action=requestDetails&idRequest=" . $idRequest . "&error=error");
    exit();
}

//change request status
if (in_array($newStatus, $status)) {
    changeRequestStatus($idRequest, $newStatus);
    header("Location: ?action=requestDetails&idRequest=" . $idRequest . "&error=ok");
    exit();
} else {
    header("Location: ?action=requestDetails&idRequest=" . $idRequest . "&error=error");
    exit();
}
