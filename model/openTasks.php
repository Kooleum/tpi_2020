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

$tasks = getAdminTasks($_SESSION['id'], "open");
$status = ["waiting" => "En attente de traitement", "progress" => "Traitement en cours", "completed" => "Terminée"];
$emergencyLevel = ["low" => "Faible", "medium" => "Modéré", "high" => "Haut"];
$emergencyLevelColors = ["low" => "bg-success", "medium" => "bg-warning", "high" => "bg-danger"];

$datas = "";
foreach ($tasks as $task) {
    $requestInfo = getRequestById($task['idRequest']);

    $requestTitle = $requestInfo['titleRequest'];

    $datas .= "<tr>";
    $datas .= "<td>" . $requestTitle . "</td>";
    $datas .= "<td>" . $task['titleTask'] . "</td>";
    $datas .= "<td>" . $task['datetimeTask'] . "</td>";
    if($task['endDateValued'] <= date("Y-m-d")){
        $datas .= "<td class='bg-danger'>" . $task['endDateValued'] . "</td>";
    }else{
        $datas .= "<td>" . $task['endDateValued'] . "</td>";
    }
    $datas .= "<td><div style='max-height:20vh;overflow:auto;'>" . $task['commentTask'] . "</div></td>";
    $datas .= "<td>" . $status[$task['statusTask']] . "</td>";
    $datas .= "<td><a href='?action=editTask&idTask=" . $task['idTask'] . "'><button class='btn btn-success'>Modifier</button></a>";
    $datas .= "</tr>";
}
