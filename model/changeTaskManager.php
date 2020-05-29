<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$idTask = filter_input(INPUT_GET, "idTask", FILTER_SANITIZE_NUMBER_INT);
$idTaskSubmited = filter_input(INPUT_POST, "idTaskSubmited", FILTER_SANITIZE_NUMBER_INT);
$adminTo = filter_input(INPUT_POST, "adminTo", FILTER_SANITIZE_NUMBER_INT);

//leaving page if idTask is empty or not a number
if (!is_numeric($idTask) && !is_numeric($idTaskSubmited)) {
    header("Location: ?action=viewMyRequests");
    exit();
}

$error = "";

$task = getTaskById($idTask);

//leaving page if task does not exist
if (empty($task)) {
    header("Location: ?action=viewMyRequests");
    exit();
}

//leaving pagew if task is not owned by logged user 
if ($task['managedBy'] != $_SESSION['id']) {
    header("Location: ?action=viewMyRequests");
    exit();
}

if(is_numeric($idTaskSubmited) && !empty($adminTo)){
    try{
        echo 1;
        changeTaskAdmin($idTaskSubmited, $adminTo);
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
    global $task;
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
        if ($value != $actualAdmin || $task['managedBy'] == null) {
            $options .= "<option value='$value' $selected>$name</option>";
        }
    }
    //adding logged admin in first in the options list;
    $options = $firstone . $options;
    return $options;
}
