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
$idRequestSubmited = filter_input(INPUT_POST, "idRequestSubmited", FILTER_SANITIZE_NUMBER_INT);
$adminTo = filter_input(INPUT_POST, "adminTo", FILTER_SANITIZE_NUMBER_INT);

//leaving page if idRequest is empty or not a number
if (!is_numeric($idRequest) && !is_numeric($idRequestSubmited)) {
    header("Location: ?action=viewMyRequests");
    exit();
}

$error = "";

$request = getRequestById($idRequest);

//leaving page if request does not exist
if (empty($request)) {
    header("Location: ?action=viewMyRequests");
    exit();
}

//leaving pagew if request has an owner and is not owned by logged user 
if ($request['idUserTo'] != $_SESSION['id'] && $request['idUserTo'] != null) {
    header("Location: ?action=viewMyRequests");
    exit();
}

if ($request['idUserTo'] == null) {
    $messageWarning = "Vous être sur le point d'assigner la tâche à un administrateur, si ce n'est pas vous, vous ne pourrez par la suite pas vous occuper de cette demande a moins que l'administrateur à qui vous l'assignez vous la transfere par la suite";
} else {
    $messageWarning = "Attention vous êtes sur le point de transferer la tâche à un autre administrateur, après cela vous ne pourrez plus vous en occuper à moins que l'administrateur à qui vous la transferez vous la retransmette par la suite";
}

if(is_numeric($idRequestSubmited) && !empty($adminTo)){
    try{
        changeRequestAdmin($idRequestSubmited, $adminTo);
        header("Location: ?action=viewMyRequests");
        exit();
    }catch(Exception $e){
        $error = "<div class='alert alert-danger'>Une erreure est survenue</div>";
    }
}

/**
 * Create options for select form with all admins (select options) but remove the request owner
 * @return string all the options 
 */
function getAdminsOption()
{
    global $managedBy;
    global $request;
    $actualAdmin = $_SESSION['id'];
    $admins = getAdmins();

    $firstone = "";

    $options = "";
    foreach ($admins as $admin) {
        $name = $admin['lastName'] . " " . $admin['firstName'] . " - " . $admin['email'];
        $value = $admin['idUser'];
        //if admin is selected adding selected to keep selection
        $selected = $managedBy == $value ? 'selected' : '';
        //Remove the actual owner from the list
        if ($value != $actualAdmin || $request['idUserTo'] == null) {
            $options .= "<option value='$value' $selected>$name</option>";
        }
    }
    //adding logged admin in first in the options list;
    $options = $firstone . $options;
    return $options;
}
