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

if(!is_numeric($idRequest)||empty($newStatus)){
    header("Location: ?action=requestDetails&idRequest=".$idRequest."&error=error");
    exit();
}

$request = getRequestById($idRequest);

if($request['idUserTo'] != $_SESSION['id']){
    header("Location: ?action=requestDetails&idRequest=".$idRequest."&error=error");
    exit();
}

if(in_array($newStatus, $status)){
    changeRequestStatus($idRequest, $newStatus);
    header("Location: ?action=requestDetails&idRequest=".$idRequest."&error=ok");
    exit();
}elseif($newStatus == "sendEmail"){
    echo "TODO";
    // header("Location: ?action=requestDetails&idRequest=".$idRequest."&error=ok");
    exit();
}else{
    header("Location: ?action=requestDetails&idRequest=".$idRequest."&error=error");
    exit();
}