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
$errorM = filter_input(INPUT_GET, "error", FILTER_SANITIZE_STRING);

$statusT = ["waiting" => "En attente de traitement", "handling" => "Traitement en cours", "done" => "Terminé"];
$statusTR = ["waiting" => "En attente de traitement", "progress" => "Traitement en cours", "completed" => "Terminé", "canceled" => "Annulée"];
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
$confirmRemove = "";
$mailBox = "";

$request = getRequestById($idRequest);

//leaving page if request does not exist
if (!$request) {
    header("Location: ?action=viewMyRequests");
    exit();
}

$requestCreator = getUserInfoFromId($request['idUserFrom']);
$nameReciver = $requestCreator['email'];

if ($errorM != "ok" && !empty($errorM)) {
    $error = "<div class='alert alert-danger'>Une erreure est survenue</div>";
}

$locationRequest = "Non applicable";

//showing request location if specified 
if ($request['idLocation']) {
    $location = getLocationById($request['idLocation']);
    $locationRequest = $location['building'] . " - " . $location['room'];
}

//if email has benn sent showing last send datetime
$lastMail = $request['dateLastEmail'];
if ($request['dateLastEmail'] == null) {
    $lastMail = "jamais";
}

$titleRequest = $request['titleRequest'];
$descriptionRequest = $request['descriptionRequest'];
$type = $typeT[$request['typeRequest']];
$emergency = "<span class='text-" . $emergencyLevelColors[$request['levelRequest']] . "'>" . $emergencyLevelT[$request['levelRequest']] . "</span>";

//displaying action buttons if auth user if owner of request
if ($request['idUserTo'] == $_SESSION['id'] && $_SESSION['id'] != null) {

    if ($request['statusRequest'] == "waiting") {
        $buttons = "<button class='btn btn-secondary text-light active mx-1 my-1'>En attente</button>";
    } else {
        $buttons = "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=waiting'><button class='btn btn-warning text-light mx-1 my-1'>En attente</button></a>";
    }
    if ($request['statusRequest'] == "handling") {
        $buttons .= "<button class='btn btn-secondary mx-1 my-1'>Traitement</button>";
    } else {
        $buttons .= "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=handling'><button class='btn btn-primary mx-1 my-1'>Traitement</button></a>";
    }
    if ($request['statusRequest'] == "done") {
        $buttons .= "<button class='btn btn-secondary mx-1 my-1'>Terminée</button>";
    } else {
        $buttons .= "<a href='?action=changeRequestStatus&idRequest=" . $idRequest . "&newStatus=done'><button class='btn btn-success mx-1 my-1'>Terminée</button></a>";
    }
    $buttons .= "<button class='btn btn-info mx-1 my-1' onclick=\"confirm('Mail')\">Envoyer un mail</button><small>Dernier mail envoyé : $lastMail </small>";
    $buttons .= "<button class='btn btn-danger float-md-right mx-1 my-1' onclick=\"confirm('Remove')\">Supprimer</button>";
    $buttons .= "<a href='?action=editRequest&idRequest=" . $idRequest . "'><button class='btn btn-outline-primary float-md-right mx-1 my-1'>Modifier</button></a>";

    $createTaskButton = '<a class="float-right" href="?action=createTask&idRequest=' . $idRequest . '>"><button class="btn btn-primary">Ajouter une tâche</button></a>';
} elseif (!empty($_SESSION['id']) && $request['idUserTo'] == null) {
    //displaying remove and edit button if owner is set to null and user is logged
    $buttons .= "<button class='btn btn-danger float-md-right mx-1 my-1' onclick=\"confirm('Remove')\">Supprimer</button>";
    $buttons .= "<a href='?action=editRequest&idRequest=" . $idRequest . "'><button class='btn btn-outline-primary float-md-right mx-1 my-1'>Modifier</button></a>";
}



$tasksTable = "";

$tasks = getRequestTasks($idRequest);

//creating table for tasks
foreach ($tasks as $task) {
    $owner = getUserInfoFromId($task['managedBy']);

    $tasksTable .= "<tr>";
    $tasksTable .= "<td><div style='max-height:20vh;overflow:auto;'>" . $task['titleTask'] . "</div></td>";
    $tasksTable .= "<td><div style='max-height:20vh;overflow:auto;'>" . $task['commentTask'] . "</div></td>";
    $tasksTable .= "<td>" . $task['datetimeTask'] . "</td>";
    if ($task['endDateValued'] <= date("Y-m-d") && ($task['statusTask'] == 'waiting' || $task['statusTask'] == 'progress')) {
        $tasksTable .= "<td class='bg-danger'>" . $task['endDateValued'] . "</td>";
    } else {
        $tasksTable .= "<td>" . $task['endDateValued'] . "</td>";
    }
    $tasksTable .= "<td>" . $task['realEndDate'] . "</td>";
    $tasksTable .= "<td>" . $statusTR[$task['statusTask']] . "</td>";
    $tasksTable .= "<td>" . $owner['lastName'] . " " . $owner['firstName'] . " - " . $owner['email'] . "</td>";
    if ($task['managedBy'] == $_SESSION['id']) {
        $tasksTable .= "<td><a href='?action=editTask&idTask=" . $task['idTask'] . "'><button class='btn btn-success'>Modifier</button></a>";
    }
    $tasksTable .= "</tr>";
}

$medias = "Aucun média";

$rMedias = getRequestMedias($idRequest);

if (count($rMedias) > 0) {
    $medias = "";
}
//adding medias display
foreach ($rMedias as $m) {
    $typeM = explode('/', $m['mime']);
    if ($typeM[0] == 'image') {
        $medias .= "<a href='?action=viewMedia&idMedia=" . $m['idMedia'] . "&a=view' target='_blank'><div class='maxSize'><img src='" . $m['pathMedia'] . "' class='imgPreview'<figcaption>" . $m['originalFileName'] . "</figcaption></div></a>";
    } else {
        $medias .= "<a href='?action=viewMedia&idMedia=" . $m['idMedia'] . "&a=view' target='_blank'><div class='maxSize'><img src='files/img/pdfIcon.png' class='pdfPreview'><figcaption>" . $m['originalFileName'] . "</figcaption></div></a>";
    }
}

//box for deletion confirmation 


if ($request['idUserTo'] == $_SESSION['id'] || ($_SESSION['id'] != null && $request['idUserTo'] == null)) {

    $confirmRemove = <<<CONFIRMATION_REMOVE
    
    <div class="col-12 align-middle confirmBox" hidden id="confirmBoxRemove">
    <div class="card text-white bg-warning mb-3">
    <div class="card-header">
    <h2 class="text-danger">Attention</h2>
    </div>
    <div class="card-body">
    <h4 class="card-text">Voulez vous vraiment supprimer la demande ?</h4>
    <h4 class="card-text">Cela supprimera également <u>toutes les tâches associées</u></h4>
    <h4 class="card-text text-danger">&#9888; Cette action est irreversible !</h4>
    </div>
    <div class="card-body">
    <button onclick="hide('Remove')" class="btn-success btn float-left">Annuler</button>
    <a href="?action=changeRequestStatus&idRequest=$idRequest&newStatus=remove"><button class="btn btn-danger float-right">Oui, supprimer la demande</button></a>
    </div>
    </div>
    </div>
    
    </div>
    CONFIRMATION_REMOVE;
}

//box for mail writing
$mailBox = <<<MAIL_BOX
    
    <div class="col-12 align-middle confirmBox" hidden id="confirmBoxMail">
    <div class="card text-dark bg-white mb-3">
    <div class="card-header">
    <h2 class="text-primary">Contenu du mail :</h2>
    <h5 class="text-info text-left">Destinataire : $nameReciver</h5>
    </div>
    <div class="card-body">
    <form action="?action=sendMail" method="post">
    <input type="hidden" name="idRequest" value="$idRequest">
    <textarea class="form-control" rows="8" id="mailText" name="textMail" oninput="textChanged()" placeholder="Bonjour, \r\n\r\n..."></textarea>
    <input type="submit" name="submit" id="submitButton" hidden>
    </form>
    </div>
    <div class="card-body">
    <button onclick="hide('Mail')" class="btn-success btn float-left">Annuler</button>
    <button class="btn btn-primary float-right" id="validationButton" onclick="sendMail()" disabled>Envoyer le mail</button>
    </div>
    </div>
    </div>
    
    </div>
MAIL_BOX;
