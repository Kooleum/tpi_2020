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

$nowDate = date("Y-m-d");

$idRequest = filter_input(INPUT_GET, "idRequest", FILTER_SANITIZE_NUMBER_INT);

$idRequestSubmited = filter_input(INPUT_POST, "idRequest", FILTER_SANITIZE_NUMBER_INT);
$titleTask = filter_input(INPUT_POST, "titleTask", FILTER_SANITIZE_STRING);
$commentTask = filter_input(INPUT_POST, "commentTask", FILTER_SANITIZE_STRING);
$managedBy = filter_input(INPUT_POST, "managedBy", FILTER_SANITIZE_NUMBER_INT);
$statusTask = filter_input(INPUT_POST, "statusTask", FILTER_SANITIZE_STRING);
$endDateValued = filter_input(INPUT_POST, "endDateValued", FILTER_SANITIZE_STRING);

//if a no request is specified going back to request list 
if (!is_numeric($idRequest) && !is_numeric($idRequestSubmited)) {
    header("Location: ?action=viewMyRequests");
    exit();
}
if (is_numeric($idRequestSubmited)) {
    if (!empty($titleTask) && !empty($commentTask) && !empty($managedBy) && !empty($statusTask) && !empty($endDateValued)) {
        echo 1;
    } else {
        $error = "<div class='alert alert-success'>La demande à été soumise</div>";
        $error = "<div class='alert alert-danger'>Une erreure est survenue</div>";
        $error = "<div class='alert alert-danger'>Un ou plusieurs champs obligatoires n'ont pas été renseignés</div>";
    }
}
/**
 * Create options for select form with all admins (select options) but the first one is the one who is logged
 * @return string all the options 
 */
function getAdminsOption()
{
    global $managedBy;
    $actualAdmin = $_SESSION['id'];
    $admins = getAdmins();

    $firstone = "";

    $options = "";
    foreach ($admins as $admin) {
        $name = $admin['lastName'] . " " . $admin['firstName'] . " - " . $admin['email'];
        $value = $admin['idUser'];
        //if admin is selected adding selected to keep selection
        $selected = $managedBy==$value?'selected':'';
        //if this is the logged admin storing the option to make it first later
        if ($value == $actualAdmin) {
            $firstone = "<option value='$value' $selected>$name</option>";
        } else {
            $options .= "<option value='$value' $selected>$name</option>";
        }
    }
    //adding logged admin in first in the options list;
    $options = $firstone . $options;
    return $options;
}
