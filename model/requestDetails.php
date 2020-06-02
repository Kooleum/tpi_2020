<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = null;
}

$idRequest = filter_input(INPUT_GET, "idRequest", FILTER_SANITIZE_NUMBER_INT);

$statusT = ["waiting" => "En attente de traitement", "handling" => "Traitement en cours", "done" => "Terminé"];
$statusTR = ["waiting" => "En attente de traitement", "progress" => "Traitemenr en cours", "completed" => "Terminé", "canceled" => "Annulée"];
$emergencyLevelColors = ["low" => "success", "medium" => "warning", "high" => "danger"];
$emergencyLevelT = ["low" => "Faible", "medium" => "Modérée", "high" => "Haute"];
$typeT = ["Hardware" => "Matériel", "Software" => "Logiciel", "Other" => "Autre"];


//leaving page if idRequest is empty or not a number
if (!is_numeric($idRequest)) {
    header("Location: ?action=viewMyRequests");
    exit();
}

$error = "";
$buttons = "";
$createTaskButton = "";

$request = getRequestById($idRequest);

//leaving page if request does not exist
if (empty($request)) {
    header("Location: ?action=viewMyRequests");
    exit();
}

$titleRequest = $request['titleRequest'];
$descriptionRequest = $request['descriptionRequest'];
$type = $typeT[$request['typeRequest']];
$emergency = "<span class='text-" . $emergencyLevelColors[$request['levelRequest']] . "'>" . $emergencyLevelT[$request['levelRequest']] . "</span>";

if ($request['idUserTo'] == $_SESSION['id'] && $_SESSION['id'] != null) {
    if ($request['statusRequest'] == "waiting") {
        $buttons = "<button class='btn btn-secondary text-light active'>En attente</button>";
    } else {
        $buttons = "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=waiting'><button class='btn btn-warning text-light'>En attente</button></a>";
    }
    if ($request['statusRequest'] == "handling") {
        $buttons .= "<button class='btn btn-secondary ml-md-1'>Traitement</button>";
    } else {
        $buttons .= "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=handling'><button class='btn btn-primary ml-md-1'>Traitement</button></a>";
    }
    if ($request['statusRequest'] == "done") {
        $buttons .= "<button class='btn btn-secondary ml-md-1'>Terminée</button>";
    } else {
        $buttons .= "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=done'><button class='btn btn-success ml-md-1'>Terminée</button></a>";
    }
    $buttons .= "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=sendEmail'><button class='btn btn-info ml-md-1'>Envoyer un mail</button></a>";
    $buttons .= "<button class='btn btn-danger ml-md-1 float-right' onclick='confirm()'>Supprimer</button>";

    $createTaskButton = '<a class="float-right" href="?action=createTask&idRequest=' . $idRequest . '>"><button class="btn btn-primary">Ajouter une tâche</button></a>';
} else {
    $createTaskButton = '<button class="btn btn-secondary float-right">Ajouter une tâche</button>';
}



$tasksTable = "";

$tasks = getRequestTasks($idRequest);

// if (!$_SESSION['id'] == null) {
foreach ($tasks as $task) {
    $owner = getUserInfoFromId($task['managedBy']);

    $tasksTable .= "<tr>";
    $tasksTable .= "<td><div style='max-height:20vh;overflow:auto;'>" . $task['titleTask'] . "</div></td>";
    $tasksTable .= "<td><div style='max-height:20vh;overflow:auto;'>" . $task['commentTask'] . "</div></td>";
    $tasksTable .= "<td>" . $task['datetimeTask'] . "</td>";
    $tasksTable .= "<td>" . $task['endDateValued'] . "</td>";
    $tasksTable .= "<td>" . $task['realEndDate'] . "</td>";
    $tasksTable .= "<td>" . $statusTR[$task['statusTask']] . "</td>";
    $tasksTable .= "<td>" . $owner['lastName'] . " " . $owner['firstName'] . " - " . $owner['email'] . "</td>";
    if ($task['managedBy'] == $_SESSION['id']) {
        $tasksTable .= "<td><a href='?action=changeTaskManager&idTask=" . $task['idTask'] . "'><button class='btn btn-primary mt-md-1'>Réassigner</button></a>";
        $tasksTable .= "<a href='?action=" . "'><button class='btn btn-info mt-md-1'>Modifier l'avancement</button></a></td>";
    }
    $tasksTable .= "</tr>";
}
// }
$medias = "Aucun média";

$rMedias = getRequestMedias($idRequest);

if (count($rMedias) > 0) {
    $medias = "";
}
foreach ($rMedias as $m) {
    $typeM = explode('/', $m['mime']);
    if ($typeM[0] == 'image') {
        $medias .= "<a href='?action=viewMedia&idMedia=" . $m['idMedia'] . "&a=view' target='_blank'><div class='maxSize'><img src='" . $m['pathMedia'] . "' class='imgPreview'<figcaption>" . $m['originalFileName'] . "</figcaption></div></a>";
    } else {
        $medias .= "<a href='?action=viewMedia&idMedia=" . $m['idMedia'] . "&a=view' target='_blank'><div class='maxSize'><img src='files/img/pdfIcon.png' class='pdfPreview'><figcaption>" . $m['originalFileName'] . "</figcaption></div></a>";
    }
}
