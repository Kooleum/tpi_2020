<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$requests = getOpenRequests();
$status = ["waiting" => "En attente de traitement", "handling" => "Traitement en cours", "done" => "Terminé"];
$emergencyLevel = ["low" => "Faible", "medium" => "Modéré", "high" => "Haut"];
$emergencyLevelColors = ["low" => "bg-success", "medium" => "bg-warning", "high" => "bg-danger"];

$datas = "";
foreach ($requests as $request) {
    $userOpen = getUserInfoFromId($request['idUserFrom']);
    if (is_numeric($request['idUserTo'])) {
        $userHandling = getUserInfoFromId($request['idUserTo']);
    } else {
        $userHandling = "Aucun administrateur assigné";
    }

    $datas .= "<tr>";
    $datas .= "<td class=\"align-middle\">" . $request['titleRequest'] . "</td>";
    $datas .= "<td class=\"align-middle\"><div style='max-height:20vh;overflow:auto;'>" . $request['descriptionRequest'] . "</div></td>";
    $datas .= "<td class=\"align-middle\">" . $request['datetimeRequest'] . "</td>";
    $datas .= "<td class=\"align-middle\">" . $userOpen['lastName'] . " " . $userOpen['firstName'] . " - " . $userOpen['email'] . "</td>";
    if (is_numeric($request['idUserTo'])) {
        $datas .= "<td class=\"align-middle\">" . $userHandling['lastName'] . " " . $userHandling['firstName'] . " - " . $userHandling['email'] . "</td>";
    } else {
        $datas .= "<td class=\"align-middle\">" . $userHandling . "</td>";
    }
    $datas .= "<td class='" . $emergencyLevelColors[$request['levelRequest']] . " align-middle'>" . $emergencyLevel[$request['levelRequest']] . "</td>";
    $datas .= "<td class=\"align-middle\">" . $status[$request['statusRequest']] . "</td>";
    $datas .= "<td class=\"align-middle\"><a href='?action=requestDetails&idRequest=" . $request['idRequest'] . "'><button class='btn btn-success'>Voir les détails</button></a>";
    $datas .= "</tr>";
}
